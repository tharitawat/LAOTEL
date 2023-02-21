<?php
//error_reporting(1);
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
require_once DIR."library/config/checksessionlogin.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/extension.php";
require_once DIR."library/extension/utility.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/class/class.utility.php";
require_once DIR."library/class/class.upload.php";
require_once DIR."library/Savant3.php";
?>
<div id="loadingpage" style="height: 400px;">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <div align="center" style="margin-top: 120px; font-family:tahoma;">
		<br /><img src="images/pre-loader/loader-01.svg" /><br /><br />
	</div>
</div>
<?php
//$db->debug = 1;
//print_r($_FILES);
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$upload_max_size = $config["image_max_size"];
$upload_max_size2 = $config["file_max_size"];
$upload_temp_path = DIR."uploads/temp/";
$upload_path = DIR."img_news/";
$error_message = "";

$gettmp["parent_id"] = Utility::getParam("parent_id");
$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["group_id"] = Utility::getParam("group_id");
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");


$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class news_gallery extends ADOdb_Active_Record{}
class news_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {
	case "delete" :
		$item = new news_gallery();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		
		$news = new news_item();
		$news->Load("id = ? ", array($item->parent_id));
		$template->news = $news;
		
		
		if ($item->image != null) {
			Utility::deleteFile($upload_path."gallery/", $item->image);
			Utility::deleteFile($upload_path."thumbnail/", $item->image);
		}
				
		
		$sql = "SELECT Count(id) AS amount FROM news_galleries WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE news_galleries SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		$item->Delete();
	   Lang::saveSystemLog($gettmp["id"],'Delete Product Gallery Tabel news_galleries ',$_SESSION["login_admin"]["id"]);
		
		
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "news-gallery-list.php?parent_id=".$gettmp["parent_id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image" :
		$item = new news_gallery();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."gallery/", $item->image);
		Utility::deleteFile($upload_path."thumbnail/", $item->image);
		$item->image = null;
		$item->Replace();
	   Lang::saveSystemLog($gettmp["id"],'Delete Image Product Gallery Tabel news_galleries ',$_SESSION["login_admin"]["id"]);

		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "news-gallery-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;		
	case "insert" :
	
		$sql = "SELECT Count(id) AS amount FROM news_galleries WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$val = $db->GetOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $val + 1;

		$item = new news_gallery();		
		$item->parent_id = $gettmp["parent_id"];
		$item->sequence = $gettmp["sequence"];		
		$item->title = Utility::encodeToDB(Utility::getParam("title"));
		$item->image_alt = Utility::encodeToDB(Utility::getParam("image_alt"));
		$item->youtube_url = Utility::encodeToDB(Utility::getParam("youtube_url"));
		
		$item->created_date = date("Y-m-d H:i:s");
		$item->created_by = $_SESSION["login_admin"]["id"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];		
		$item->status = Utility::getParam("status", 0);
		
		if ($item->Save()) {
			unset($_SESSION["item_form"]);
			$update = false;
			
		   Lang::saveSystemLog($gettmp["id"],'Add Product Gallery Tabel news_galleries ',$_SESSION["login_admin"]["id"]);
		
			
			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 720 || $upload->image_src_y > 480) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1000;
				//	$upload->image_y = 1000;
					$upload->image_ratio = true;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."gallery/");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 300 || $upload->image_src_y > 200) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 300;
					//	$upload->image_y = 500;
						$upload->image_ratio = true;
					//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image = $upload->file_dst_name;
						Utility::deleteFile($upload_path."", $file_temp);
						Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
						
			if ($update) {
				$item->Replace();
			}
			
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "news-gallery-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title"] = Utility::getParam("title");
			$_SESSION["item_form"]["image_alt"] = Utility::getParam("image_alt");
			$_SESSION["item_form"]["sequence"] = Utility::getParam("sequence");
			$_SESSION["item_form"]["youtube_url"] = Utility::getParam("youtube_url");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "news-gallery-add.php?parent_id=".$gettmp['parent_id']."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		$item = new news_gallery();
		$item->load("id = ? ", array($gettmp["id"]));
		//$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
				
		
		$item->title = Utility::encodeToDB(Utility::getParam("title"));
		$item->image_alt = Utility::encodeToDB(Utility::getParam("image_alt"));
		$item->youtube_url = Utility::encodeToDB(Utility::getParam("youtube_url"));
		
		//$item->created_date = date("Y-m-d H:i:s");
		//$item->created_by = $_SESSION["login_admin"]["id"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];
		
		$item->status = Utility::getParam("status", 0);
		
		if ($item->Replace()) {
			unset($_SESSION["item_form"]);
			$update = false;
			
		   Lang::saveSystemLog($gettmp["id"],'Update Product Gallery Tabel news_galleries ',$_SESSION["login_admin"]["id"]);
		
			
			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);				
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 720 || $upload->image_src_y > 480) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1000;
				//	$upload->image_y = 1000;
					$upload->image_ratio = true;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."gallery/");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 300 || $upload->image_src_y > 200) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 500;
					//	$upload->image_y = 500;
						$upload->image_ratio = true;
					//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image = $upload->file_dst_name;
						Utility::deleteFile($upload_path."", $file_temp);
						Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
						
			if ($update) {
				$item->Replace();
			}
			
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "news-gallery-list.php?parent_id=".$item->parent_id."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title"] = Utility::getParam("title");
			$_SESSION["item_form"]["image_alt"] = Utility::getParam("image_alt");
			$_SESSION["item_form"]["sequence"] = Utility::getParam("sequence");
			$_SESSION["item_form"]["youtube_url"] = Utility::getParam("youtube_url");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "news-gallery-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
		case "manual_sort" :		
	
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE news_galleries SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE news_galleries SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'4': 
						$sql = "UPDATE news_galleries SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE news_galleries SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM news_galleries WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM news_galleries i WHERE 1=1 AND i.parent_id = ? ";
							$stmt = $db->Prepare($sql);
							$max = $db->getOne($stmt,array($gettmp["parent_id"]));
							
							if ($sequence != $gettmp["to"]) {
								if ($gettmp["to"] < 1) {
									$gettmp["to"] = 1;
								}
								if ($gettmp["to"] > $max) {
									$gettmp["to"] = $max;
								}
								if ($sequence > $gettmp["to"]) {
									$sql = "UPDATE news_galleries i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? AND i.parent_id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence, $gettmp["parent_id"]));
									$sql = "UPDATE news_galleries i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE news_galleries i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ?  AND i.parent_id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"], $gettmp["parent_id"]));
									$sql = "UPDATE news_galleries i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "news-gallery-list.php?parent_id=".$gettmp["parent_id"]."&msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;			
				default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>