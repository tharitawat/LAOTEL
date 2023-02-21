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
require_once DIR."library/extension/lang.php";
require_once DIR."library/extension/utility.php";
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
#$db->debug = 1;
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$upload_max_size = $config["image_max_size"];
$upload_max_size2 = $config["file_max_size"];
$upload_temp_path = DIR."uploads/temp/";
$upload_path = DIR."img_section/";
$error_message = "";

$gettmp["parent_id"] = 0; // Fix no parent.
$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class section_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {	
	case "delete" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		if ($item->image_la != null) {
			Utility::deleteFile($upload_path."", $item->image_la);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_la);
		}
		if ($item->image_en != null) {
			Utility::deleteFile($upload_path."", $item->image_en);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_en);
		}

		if ($item->image_cn != null) {
			Utility::deleteFile($upload_path."", $item->image_cn);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_cn);
		}
		if ($item->image_vi != null) {
			Utility::deleteFile($upload_path."", $item->image_vi);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_vi);
		}

		if ($item->imagem_la != null) {
			Utility::deleteFile($upload_path."", $item->imagem_la);
			Utility::deleteFile($upload_path."thumbnail/", $item->imagem_la);
		}
		if ($item->imagem_en != null) {
			Utility::deleteFile($upload_path."", $item->imagem_en);
			Utility::deleteFile($upload_path."thumbnail/", $item->imagem_en);
		}

		if ($item->imagem_cn != null) {
			Utility::deleteFile($upload_path."", $item->imagem_cn);
			Utility::deleteFile($upload_path."thumbnail/", $item->imagem_cn);
		}
		if ($item->imagem_vi != null) {
			Utility::deleteFile($upload_path."", $item->imagem_vi);
			Utility::deleteFile($upload_path."thumbnail/", $item->imagem_vi);
		}

		
		$sql = "SELECT Count(id) AS amount FROM section_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE section_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		if($item->Delete()){
			Lang::saveSystemLog($gettmp["id"],'Delete Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		}
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-list.php?msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image_la" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image_la);
		Utility::deleteFile($upload_path."thumbnail/", $item->image_la);
		$item->image_la = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image_en" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image_en);
		Utility::deleteFile($upload_path."thumbnail/", $item->image_en);
		$item->image_en = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image_cn" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image_cn);
		Utility::deleteFile($upload_path."thumbnail/", $item->image_cn);
		$item->image_cn = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;	
	case "delete_image_vi" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image_vi);
		Utility::deleteFile($upload_path."thumbnail/", $item->image_vi);
		$item->image_vi = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;	
	case "delete_imagem_la" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->imagem_la);
		Utility::deleteFile($upload_path."thumbnail/", $item->imagem_la);
		$item->imagem_la = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_imagem_en" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->imagem_en);
		Utility::deleteFile($upload_path."thumbnail/", $item->imagem_en);
		$item->imagem_en = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_imagem_cn" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->imagem_cn);
		Utility::deleteFile($upload_path."thumbnail/", $item->imagem_cn);
		$item->imagem_cn = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_imagem_vi" :
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->imagem_vi);
		Utility::deleteFile($upload_path."thumbnail/", $item->imagem_vi);
		$item->imagem_vi = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "section-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;	
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM section_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        $gettmp["image_la"] = $row["image_la"];
	        $gettmp["image_en"] = $row["image_en"];
	        $gettmp["image_cn"] = $row["image_cn"];
	        $gettmp["image_vi"] = $row["image_vi"];
	        $gettmp["imagem_la"] = $row["imagem_la"];
	        $gettmp["imagem_en"] = $row["imagem_en"];
			$gettmp["imagem_cn"] = $row["imagem_cn"];
	        $gettmp["imagem_vi"] = $row["imagem_vi"];
	        
	        $sql = "SELECT Count(id) AS amount FROM section_items WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence < $max) {
	            $sql = "UPDATE section_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
	            $stmt = $db->Prepare($sql);
	            $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
	        }
	        
			if ($gettmp["image_la"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_la"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_la"]);
			}
			if ($gettmp["image_en"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_en"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_en"]);
			}
			if ($gettmp["image_cn"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_cn"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_cn"]);
			}
			if ($gettmp["image_vi"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_vi"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_vi"]);
			}
			if ($gettmp["imagem_la"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["imagem_la"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["imagem_la"]);
			}
			if ($gettmp["imagem_en"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["imagem_en"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["imagem_en"]);
			}
			if ($gettmp["imagem_cn"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["imagem_cn"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["imagem_cn"]);
			}
			if ($gettmp["imagem_vi"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["imagem_vi"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["imagem_vi"]);
			}

			Lang::saveSystemLog($gettmp["id"],'Delete Banner Tabel section_items',$_SESSION["login_admin"]["id"]);
        
	        $sql = "DELETE FROM section_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "section-item-list.php?msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$sql = "SELECT Count(id) AS sequence FROM section_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $max + 1;
		
		$item = new section_item();
		$item->parent_id = $gettmp["parent_id"];
		$item->sequence = $gettmp["sequence"];
		
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		$item->subject_la = Utility::encodeToDB(Utility::getParam("subject_la"));
		$item->subject_en = Utility::encodeToDB(Utility::getParam("subject_en"));
		$item->subject_cn = Utility::encodeToDB(Utility::getParam("subject_cn"));
		$item->subject_vi = Utility::encodeToDB(Utility::getParam("subject_vi"));

		$item->url_la = Utility::encodeToDB(Utility::getParam("url_la"));
		$item->url_en = Utility::encodeToDB(Utility::getParam("url_en"));
		$item->url_cn = Utility::encodeToDB(Utility::getParam("url_cn"));
		$item->url_vi = Utility::encodeToDB(Utility::getParam("url_vi"));
		$item->image_alt_la = Utility::encodeToDB(Utility::getParam("image_alt_la"));
		$item->image_alt_en = Utility::encodeToDB(Utility::getParam("image_alt_en"));
		$item->image_alt_cn = Utility::encodeToDB(Utility::getParam("image_alt_cn"));
		$item->image_alt_vi = Utility::encodeToDB(Utility::getParam("image_alt_vi"));
		
		$item->position_index = Utility::getParam("position_index");
		$item->clicks = 0;
		
		$date = Utility::getParam("begin_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->begin_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->begin_date = NULL;
		}	
		
		$date = Utility::getParam("end_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->end_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->end_date = NULL;
		}
		
		$date = Utility::getParam("published_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->published_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->published_date = NULL;
		}
		
		$item->created_date = date("Y-m-d H:i:s");
		$item->created_by = $_SESSION["login_admin"]["fullname"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];
		
		$item->status_la = Utility::getParam("status_la",'0');
		$item->status_en = Utility::getParam("status_en",'0');
		$item->status_cn = Utility::getParam("status_cn",'0');
		$item->status_vi = Utility::getParam("status_vi",'0');
		$item->status = Utility::getParam("status",'0');

		
		if ($item->Save()) {
			unset($_SESSION["item_form"]);
			$update = false;

   		    Lang::saveSystemLog($gettmp["id"],'Add Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);

			// Set image_la
			if ($_FILES["image_la"] != null) {
				$file_temp = $item->image_la;
				$upload = new upload($_FILES["image_la"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_la"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_la = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set image_en
			if ($_FILES["image_en"] != null) {
				$file_temp = $item->image_en;
				$upload = new upload($_FILES["image_en"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_en"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_en = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			
			// Set Image CN
			if ($_FILES["image_cn"] != null) {
				$file_temp = $item->image_cn;
				$upload = new upload($_FILES["image_cn"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_cn"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_cn = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}


			// Set Image VI
			if ($_FILES["image_vi"] != null) {
				$file_temp = $item->image_vi;
				$upload = new upload($_FILES["image_vi"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_vi"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_vi = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}

			// Set imagem_th
			if ($_FILES["imagem_la"] != null) {
				$file_temp = $item->imagem_la;
				$upload = new upload($_FILES["imagem_la"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_th"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_la = $upload->file_dst_name;
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set imagem_en
			if ($_FILES["imagem_en"] != null) {
				$file_temp = $item->imagem_en;
				$upload = new upload($_FILES["imagem_en"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_en"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_en = $upload->file_dst_name;
					//	Utility::deleteFile($upload_path."", $file_temp);
					//	Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}

			// Set Image Mobile CN
			if ($_FILES["imagem_cn"] != null) {
				$file_temp = $item->imagem_cn;
				$upload = new upload($_FILES["imagem_cn"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_cn"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_cn = $upload->file_dst_name;
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set Image Mobile Vi
			if ($_FILES["imagem_vi"] != null) {
				$file_temp = $item->imagem_vi;
				$upload = new upload($_FILES["imagem_vi"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_vi"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_vi = $upload->file_dst_name;
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM section_items WHERE parent_id = ? ";
			    $stmt = $db->Prepare($sql);
			    $val = $db->GetOne($stmt, array($item->parent_id));
			    $max = $val;
			    
			    if ($item->sequence != $gettmp["sequence"]) {
			        if ($gettmp["sequence"] < 1) {
			            $gettmp["sequence"] = 1;
			        }
			        if ($gettmp["sequence"] > $max) {
			            $gettmp["sequence"] = $max;
			        }
			        if ($item->sequence > $gettmp["sequence"]) {
			            $sql = "UPDATE section_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE section_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($item->sequence, $gettmp["sequence"], $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }
			    }
			}
			
			if ($update) {
				$item->Replace();
			}
			
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "section-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_la"] = Utility::getParam("title_la");
			$_SESSION["item_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["item_form"]["title_cn"] = Utility::getParam("title_cn");
			$_SESSION["item_form"]["title_vi"] = Utility::getParam("title_vi");

			$_SESSION["item_form"]["subject_la"] = Utility::getParam("subject_la");
			$_SESSION["item_form"]["subject_en"] = Utility::getParam("subject_en");
			$_SESSION["item_form"]["subject_cn"] = Utility::getParam("subject_cn");
			$_SESSION["item_form"]["subject_vi"] = Utility::getParam("subject_vi");
			$_SESSION["item_form"]["url_la"] = Utility::getParam("url_la");
			$_SESSION["item_form"]["url_en"] = Utility::getParam("url_en");
			$_SESSION["item_form"]["url_cn"] = Utility::getParam("url_cn");
			$_SESSION["item_form"]["url_vi"] = Utility::getParam("url_vi");
			$_SESSION["item_form"]["image_alt_la"] = Utility::getParam("image_alt_la");
			$_SESSION["item_form"]["image_alt_en"] = Utility::getParam("image_alt_en");
			$_SESSION["item_form"]["image_alt_cn"] = Utility::getParam("image_alt_cn");
			$_SESSION["item_form"]["image_alt_vi"] = Utility::getParam("image_alt_vi");
			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["item_form"]["begin_date"] = Utility::getParam("begin_date");
			$_SESSION["item_form"]["end_date"] = Utility::getParam("end_date");
			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");

			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "section-item-add.php?msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		//$db->debug=1;
		$item = new section_item();
		$item->load("id = ? ", array($gettmp["id"]));
		//$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
		
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		$item->subject_la = Utility::encodeToDB(Utility::getParam("subject_la"));
		$item->subject_en = Utility::encodeToDB(Utility::getParam("subject_en"));
		$item->subject_cn = Utility::encodeToDB(Utility::getParam("subject_cn"));
		$item->subject_vi = Utility::encodeToDB(Utility::getParam("subject_vi"));

		$item->url_la = Utility::encodeToDB(Utility::getParam("url_la"));
		$item->url_en = Utility::encodeToDB(Utility::getParam("url_en"));
		$item->url_cn = Utility::encodeToDB(Utility::getParam("url_cn"));
		$item->url_vi = Utility::encodeToDB(Utility::getParam("url_vi"));
		$item->image_alt_la = Utility::encodeToDB(Utility::getParam("image_alt_la"));
		$item->image_alt_en = Utility::encodeToDB(Utility::getParam("image_alt_en"));
		$item->image_alt_cn = Utility::encodeToDB(Utility::getParam("image_alt_cn"));
		$item->image_alt_vi = Utility::encodeToDB(Utility::getParam("image_alt_vi"));
		
		$item->position_index = Utility::getParam("position_index");
	//	$item->clicks = 0;
		
		$date = Utility::getParam("begin_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->begin_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->begin_date = NULL;
		}	
		
		$date = Utility::getParam("end_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->end_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->end_date = NULL;
		}
		
		$date = Utility::getParam("published_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->published_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->published_date = NULL;
		}
		
	//	$item->created_date = date("Y-m-d H:i:s");
	//	$item->created_by = $_SESSION["login_admin"]["fullname"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];
		
		$item->status_la = Utility::getParam("status_la",'0');
		$item->status_en = Utility::getParam("status_en",'0');
		$item->status_cn = Utility::getParam("status_cn",'0');
		$item->status_vi = Utility::getParam("status_vi",'0');
		$item->status = Utility::getParam("status",'0');

		
		if ($item->Replace()) {
			unset($_SESSION["item_form"]);
			$update = false;

   		    Lang::saveSystemLog($gettmp["id"],'Add Image Banner Tabel section_items',$_SESSION["login_admin"]["id"]);

			// Set image_la
			if ($_FILES["image_la"] != null) {
				$file_temp = $item->image_la;
				$upload = new upload($_FILES["image_la"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_la"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_la = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set image_en
			if ($_FILES["image_en"] != null) {
				$file_temp = $item->image_en;
				$upload = new upload($_FILES["image_en"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_en"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_en = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			
			// Set Image CN
			if ($_FILES["image_cn"] != null) {
				$file_temp = $item->image_cn;
				$upload = new upload($_FILES["image_cn"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_cn"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_cn = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}


			// Set Image VI
			if ($_FILES["image_vi"] != null) {
				$file_temp = $item->image_vi;
				$upload = new upload($_FILES["image_vi"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_vi"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_vi = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}

			// Set imagem_th
			if ($_FILES["imagem_la"] != null) {
				$file_temp = $item->imagem_la;
				$upload = new upload($_FILES["imagem_la"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_th"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_la = $upload->file_dst_name;
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set imagem_en
			if ($_FILES["imagem_en"] != null) {
				$file_temp = $item->imagem_en;
				$upload = new upload($_FILES["imagem_en"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_en"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_en = $upload->file_dst_name;
					//	Utility::deleteFile($upload_path."", $file_temp);
					//	Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}

			// Set Image Mobile CN
			if ($_FILES["imagem_cn"] != null) {
				$file_temp = $item->imagem_cn;
				$upload = new upload($_FILES["imagem_cn"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_cn"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_cn = $upload->file_dst_name;
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set Image Mobile Vi
			if ($_FILES["imagem_vi"] != null) {
				$file_temp = $item->imagem_vi;
				$upload = new upload($_FILES["imagem_vi"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["imagem_vi"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1920;
					$upload->image_y = 778;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 500 || $upload->image_src_y > 889) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 322;
						$upload->image_y = 145;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->imagem_vi = $upload->file_dst_name;
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM section_items WHERE parent_id = ? ";
			    $stmt = $db->Prepare($sql);
			    $val = $db->GetOne($stmt, array($item->parent_id));
			    $max = $val;
			    
			    if ($item->sequence != $gettmp["sequence"]) {
			        if ($gettmp["sequence"] < 1) {
			            $gettmp["sequence"] = 1;
			        }
			        if ($gettmp["sequence"] > $max) {
			            $gettmp["sequence"] = $max;
			        }
			        if ($item->sequence > $gettmp["sequence"]) {
			            $sql = "UPDATE section_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE section_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($item->sequence, $gettmp["sequence"], $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }
			    }
			}
			
			if ($update) {
				$item->Replace();				
			}
			
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "section-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_la"] = Utility::getParam("title_la");
			$_SESSION["item_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["item_form"]["title_cn"] = Utility::getParam("title_cn");
			$_SESSION["item_form"]["title_vi"] = Utility::getParam("title_vi");

			$_SESSION["item_form"]["subject_la"] = Utility::getParam("subject_la");
			$_SESSION["item_form"]["subject_en"] = Utility::getParam("subject_en");
			$_SESSION["item_form"]["subject_cn"] = Utility::getParam("subject_cn");
			$_SESSION["item_form"]["subject_vi"] = Utility::getParam("subject_vi");
			$_SESSION["item_form"]["url_la"] = Utility::getParam("url_la");
			$_SESSION["item_form"]["url_en"] = Utility::getParam("url_en");
			$_SESSION["item_form"]["url_cn"] = Utility::getParam("url_cn");
			$_SESSION["item_form"]["url_vi"] = Utility::getParam("url_vi");
			$_SESSION["item_form"]["image_alt_la"] = Utility::getParam("image_alt_la");
			$_SESSION["item_form"]["image_alt_en"] = Utility::getParam("image_alt_en");
			$_SESSION["item_form"]["image_alt_cn"] = Utility::getParam("image_alt_cn");
			$_SESSION["item_form"]["image_alt_vi"] = Utility::getParam("image_alt_vi");
			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["item_form"]["begin_date"] = Utility::getParam("begin_date");
			$_SESSION["item_form"]["end_date"] = Utility::getParam("end_date");
			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "section-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "manual_sort" :
			
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE section_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE section_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'2': 
						$sql = "UPDATE section_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(2));

						$sql = "UPDATE section_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);
					break;		
					case'3': 
						$sql = "UPDATE section_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(3));

						$sql = "UPDATE section_items SET sort_by = 'DESC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);					
					break;
					case'4': 
						$sql = "UPDATE section_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE section_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						 Lang::saveSystemLog($gettmp["id"],'Update Sequence Banner Tabel section_items',$_SESSION["login_admin"]["id"]);

						
						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM section_items WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM section_items i WHERE 1=1 ";
							$stmt = $db->Prepare($sql);
							$max = $db->getOne($stmt);
							
							if ($sequence != $gettmp["to"]) {
								if ($gettmp["to"] < 1) {
									$gettmp["to"] = 1;
								}
								if ($gettmp["to"] > $max) {
									$gettmp["to"] = $max;
								}
								if ($sequence > $gettmp["to"]) {
									$sql = "UPDATE section_items i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence));
									$sql = "UPDATE section_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE section_items i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"]));
									$sql = "UPDATE section_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "section-item-sequence.php?msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;		
	default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>