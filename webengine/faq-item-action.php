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
$upload_path = DIR."img_faq/";
$error_message = "";

$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");
$gettmp["parent_id"] = Utility::getParam("parent_id");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class faq_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {	
	case "delete" :
		$item = new faq_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		if ($item->image != null) {
			Utility::deleteFile($upload_path."", $item->image);
			Utility::deleteFile($upload_path."thumbnail/", $item->image);
		}
		if ($item->thumbnail != null) {
			Utility::deleteFile($upload_path."", $item->thumbnail);
			Utility::deleteFile($upload_path."thumbnail/", $item->thumbnail);
		}
		
		$sql = "SELECT Count(id) AS amount FROM faq_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE faq_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		if($item->Delete()){
			Lang::saveSystemLog($gettmp["id"],'Delete FAQ Tabel faq_items',$_SESSION["login_admin"]["id"]);
		}
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "faq-item-list.php?msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image" :
		$item = new faq_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image);
		Utility::deleteFile($upload_path."thumbnail/", $item->image);
		$item->image = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Tabel faq_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "faq-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_thumbnail" :
		$item = new faq_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->thumbnail);
		Utility::deleteFile($upload_path."thumbnail/", $item->thumbnail);
		$item->thumbnail = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image thumbnail Tabel faq_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "faq-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM faq_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        $gettmp["image"] = $row["image"];
	        $gettmp["thumbnail"] = $row["thumbnail"];
	        
	        $sql = "SELECT Count(id) AS amount FROM faq_items WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence < $max) {
	            $sql = "UPDATE faq_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
	            $stmt = $db->Prepare($sql);
	            $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
	        }
	        
			if ($gettmp["image"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image"]);
			}
			if ($gettmp["thumbnail"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["thumbnail"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["thumbnail"]);
			}
			

			Lang::saveSystemLog($gettmp["id"],'Delete FAQ Tabel faq_items',$_SESSION["login_admin"]["id"]);
        
	        $sql = "DELETE FROM faq_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "faq-item-list.php?msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$sql = "SELECT Count(id) AS sequence FROM faq_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $max + 1;
		
		$item = new faq_item();
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

		$item->description_la = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_la")));
		$item->description_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_en")));
		$item->description_cn = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_cn")));
		$item->description_vi = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_vi")));
		$item->youtube = Utility::encodeToDB(Utility::getParam("youtube"));
		$item->image_alt = Utility::encodeToDB(Utility::getParam("image_alt"));
		$item->seo_rewrite = Utility::encodeToDB(Utility::getParam("seo_rewrite"));
		$item->seo_title = Utility::encodeToDB(Utility::getParam("seo_title"));
		$item->seo_keyword = Utility::encodeToDB(Utility::getParam("seo_keyword"));
		$item->seo_description = Utility::encodeToDB(Utility::getParam("seo_description"));
		
		$item->clicks = 0;
		
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

   		    Lang::saveSystemLog($gettmp["id"],'Add FAQ Tabel faq_items',$_SESSION["login_admin"]["id"]);

			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
				//	$upload->image_x = 1920;
				//	$upload->image_y = 778;
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
						$upload->image_x = 354;
						$upload->image_y = 216;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set image_en
			if ($_FILES["thumbnail"] != null) {
				$file_temp = $item->thumbnail;
				$upload = new upload($_FILES["thumbnail"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["thumbnail"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
				//	$upload->image_x = 1920;
				//	$upload->image_y = 778;
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
						$upload->image_x = 354;
						$upload->image_y = 216;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->thumbnail = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			
			
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM faq_items WHERE parent_id = ? ";
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
			            $sql = "UPDATE faq_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE faq_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
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
			$render = "faq-item-list.php?msgsuc=".$msgsuc;
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
			$_SESSION["item_form"]["description_la"] = Utility::getParam("description_la");
			$_SESSION["item_form"]["description_en"] = Utility::getParam("description_en");
			$_SESSION["item_form"]["description_cn"] = Utility::getParam("description_cn");
			$_SESSION["item_form"]["description_vi"] = Utility::getParam("description_vi");
			$_SESSION["item_form"]["image_alt"] = Utility::getParam("image_alt");
			$_SESSION["item_form"]["youtube"] = Utility::getParam("youtube");
			$_SESSION["item_form"]["seo_rewrite"] = Utility::getParam("seo_rewrite");
			$_SESSION["item_form"]["seo_title"] = Utility::getParam("seo_title");
			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["item_form"]["seo_keyword"] = Utility::getParam("seo_keyword");
			$_SESSION["item_form"]["seo_description"] = Utility::getParam("seo_description");
			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");

			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "faq-item-add.php?msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		//$db->debug=1;
		$item = new faq_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
		
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		$item->subject_la = Utility::encodeToDB(Utility::getParam("subject_la"));
		$item->subject_en = Utility::encodeToDB(Utility::getParam("subject_en"));
		$item->subject_cn = Utility::encodeToDB(Utility::getParam("subject_cn"));
		$item->subject_vi = Utility::encodeToDB(Utility::getParam("subject_vi"));

		$item->description_la = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_la")));
		$item->description_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_en")));
		$item->description_cn = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_cn")));
		$item->description_vi = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_vi")));
		$item->youtube = Utility::encodeToDB(Utility::getParam("youtube"));
		$item->image_alt = Utility::encodeToDB(Utility::getParam("image_alt"));
		$item->seo_rewrite = Utility::encodeToDB(Utility::getParam("seo_rewrite"));
		$item->seo_title = Utility::encodeToDB(Utility::getParam("seo_title"));
		$item->seo_keyword = Utility::encodeToDB(Utility::getParam("seo_keyword"));
		$item->seo_description = Utility::encodeToDB(Utility::getParam("seo_description"));
		
	//	$item->clicks = 0;		
			
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

   		    Lang::saveSystemLog($gettmp["id"],'Update FAQ Tabel faq_items',$_SESSION["login_admin"]["id"]);

			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
				//	$upload->image_x = 1920;
				//	$upload->image_y = 778;
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
						$upload->image_x = 354;
						$upload->image_y = 216;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// Set image_en
			if ($_FILES["thumbnail"] != null) {
				$file_temp = $item->thumbnail;
				$upload = new upload($_FILES["thumbnail"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["thumbnail"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
				//	$upload->image_x = 1920;
				//	$upload->image_y = 778;
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
						$upload->image_x = 354;
						$upload->image_y = 216;
						$upload->image_ratio = false;
						//	$upload->jpeg_quality = 100;
						$upload->image_convert = "webp";
						$upload->file_new_name_body = $file_new_name_body;
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->thumbnail = $upload->file_dst_name;
				 
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM faq_items WHERE parent_id = ? ";
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
			            $sql = "UPDATE faq_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE faq_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
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
			$render = "faq-item-list.php?msgsuc=".$msgsuc;
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
			$_SESSION["item_form"]["description_la"] = Utility::getParam("description_la");
			$_SESSION["item_form"]["description_en"] = Utility::getParam("description_en");
			$_SESSION["item_form"]["description_cn"] = Utility::getParam("description_cn");
			$_SESSION["item_form"]["description_vi"] = Utility::getParam("description_vi");
			$_SESSION["item_form"]["image_alt"] = Utility::getParam("image_alt");
			$_SESSION["item_form"]["youtube"] = Utility::getParam("youtube");
			$_SESSION["item_form"]["seo_rewrite"] = Utility::getParam("seo_rewrite");
			$_SESSION["item_form"]["seo_title"] = Utility::getParam("seo_title");
			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["item_form"]["seo_keyword"] = Utility::getParam("seo_keyword");
			$_SESSION["item_form"]["seo_description"] = Utility::getParam("seo_description");
			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "faq-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "manual_sort" :
			
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE faq_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE faq_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'2': 
						$sql = "UPDATE faq_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(2));

						$sql = "UPDATE faq_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);
					break;		
					case'3': 
						$sql = "UPDATE faq_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(3));

						$sql = "UPDATE faq_items SET sort_by = 'DESC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);					
					break;
					case'4': 
						$sql = "UPDATE faq_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE faq_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						 Lang::saveSystemLog($gettmp["id"],'Update Sequence Banner Tabel faq_items',$_SESSION["login_admin"]["id"]);

						
						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM faq_items WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM faq_items i WHERE 1=1 ";
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
									$sql = "UPDATE faq_items i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence));
									$sql = "UPDATE faq_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE faq_items i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"]));
									$sql = "UPDATE faq_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "faq-item-sequence.php?msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;		
	default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>