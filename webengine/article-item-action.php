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
#print_r($_FILES);
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$upload_max_size = $config["image_max_size"];
$upload_max_size2 = $config["file_max_size"];
$upload_temp_path = DIR."uploads/temp/";
$upload_path = DIR."img_article/";
$error_message = "";

$gettmp["parent_id"] = '0';
$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["do"] = Utility::getParam("do");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class article_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {
	case "delete" :
		$item = new article_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		if ($item->image != null) {
			Utility::deleteFile($upload_path."", $item->image);
			Utility::deleteFile($upload_path."thumbnail/", $item->image);
		}
		if ($item->image_th != null) {
			Utility::deleteFile($upload_path."", $item->image_th);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_th);
		}
		
		if ($item->image_en != null) {
			Utility::deleteFile($upload_path."", $item->image_en);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_en);
		}
		
		$sql = "SELECT Count(id) AS amount FROM article_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE article_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		$item->Delete();
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "article-item-list.php?parent_id=".$gettmp["parent_id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image" :
		$item = new article_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image);
		Utility::deleteFile($upload_path."thumbnail/", $item->image);
		$item->image = null;
		$item->Replace();
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "article-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image_th" :
		$item = new article_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image_th);
		Utility::deleteFile($upload_path."thumbnail/", $item->image_th);
		$item->image_th = null;
		$item->Replace();
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "article-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image_en" :
			$item = new article_item();
			$item->load("id = ? ", array($gettmp["id"]));
			
			Utility::deleteFile($upload_path."", $item->image_en);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_en);
			$item->image_en = null;
			$item->Replace();
			
			$msgsuc = "ลบข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "article-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;	
	case "listupdate" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        $gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM article_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        $gettmp["parent_id"] = $row["parent_id"];
	        
	        $sql = "SELECT Count(id) AS amount FROM article_items WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence != $gettmp["to"]) {
	            if ($gettmp["to"] < 1) {
	                $gettmp["to"] = 1;
	            }
	            if ($gettmp["to"] > $max) {
	                $gettmp["to"] = $max;
	            }
	            if ($sequence > $gettmp["to"]) {
	                $sql = "UPDATE article_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($gettmp["to"], $sequence, $gettmp["parent_id"]));
	                $sql = "UPDATE article_items SET sequence = ? WHERE id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
	            } else {
	                $sql = "UPDATE article_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($sequence, $gettmp["to"], $gettmp["parent_id"]));
	                $sql = "UPDATE article_items SET sequence = ? WHERE id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
	            }
	        }
	    }
	    
		$msgsuc = "บันทึกข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
	    $render = "article-item-list.php?parent_id=".$gettmp["parent_id"]."&msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM article_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        $gettmp["image"] = $row["image"];
	        $gettmp["image_th"] = $row["image_th"];
	        $gettmp["image_en"] = $row["image_en"];
			
	        $sql = "SELECT Count(id) AS amount FROM article_items WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence < $max) {
	            $sql = "UPDATE article_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
	            $stmt = $db->Prepare($sql);
	            $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
	        }
	        
	        if ($gettmp["image"] != null){
	            Utility::deleteFile($upload_path."", $gettmp["image"]);
	            Utility::deleteFile($upload_path."thumbnail/", $gettmp["image"]);
	        }
			if ($gettmp["image_th"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_th"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_th"]);
			}
			if ($gettmp["image_en"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_en"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_en"]);
			}	
	        
	        $sql = "DELETE FROM article_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "article-item-list.php?msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$sql = "SELECT Count(id) AS sequence FROM article_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $max + 1;
		
		$item = new article_item();
		$item->parent_id = $gettmp["parent_id"];
		$item->sequence = $gettmp["sequence"];
		
		$item->title_th = Utility::encodeToDB(Utility::getParam("title_th"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->subject_th = Utility::encodeToDB(Utility::getParam("subject_th"));
		$item->subject_en = Utility::encodeToDB(Utility::getParam("subject_en"));
		$item->description_th = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_th")));
		$item->description_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_en")));
		$item->image_alt_th = Utility::encodeToDB(Utility::getParam("image_alt_th"));
		$item->image_alt_en = Utility::encodeToDB(Utility::getParam("image_alt_en"));
		
		$item->seo_rewrite = Utility::encodeToDB(Utility::getParam("seo_rewrite"));
		$item->seo_title = Utility::encodeToDB(Utility::getParam("seo_title"));
		$item->seo_keyword = Utility::encodeToDB(Utility::getParam("seo_keyword"));
		$item->seo_description = Utility::encodeToDB(Utility::getParam("seo_description"));
		
		$date = Utility::getParam("published_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->published_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->published_date = NULL;
		}
		
		$item->created_date = date("Y-m-d H:i:s");
		$item->created_by = $_SESSION["login_admin"]["username"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["username"];
		
		$item->status_th = Utility::getParam("status_th");
		$item->status_en = Utility::getParam("status_en");
		$item->status = Utility::getParam("status");
		
		if ($item->Save()) {
			unset($_SESSION["item_form"]);
			$update = false;
			
			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
 					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 555 || $upload->image_src_y > 349) $upload->image_resize = true;
				//	$upload->image_resize = true;
				//	$upload->image_x = 555;
				//	$upload->image_y = 349;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->image_convert = "webp";
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 272 || $upload->image_src_y > 171) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 342;
						$upload->image_y = 218;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
						$upload->file_new_name_body = $file_new_name_body;
						$upload->image_convert = "webp";
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
					//	imagewebp(); 
						
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
			
			// Set image_th
			if ($_FILES["image_th"] != null) {
				$file_temp = $item->image_th;
				$upload = new upload($_FILES["image_th"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["image_th"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 555 || $upload->image_src_y > 349) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1200;
					$upload->image_y = 676;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->image_convert = "webp";
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 272 || $upload->image_src_y > 171) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 412;
						$upload->image_y = 296;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
						$upload->file_new_name_body = $file_new_name_body;
						$upload->image_convert = "webp";
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_th = $upload->file_dst_name;
						Utility::deleteFile($upload_path."", $file_temp);
						Utility::deleteFile($upload_path."thumbnail/", $file_temp);
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
					//if ($upload->image_src_x > 555 || $upload->image_src_y > 349) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1200;
					$upload->image_y = 676;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->image_convert = "webp";
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 272 || $upload->image_src_y > 171) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 412;
						$upload->image_y = 296;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
						$upload->file_new_name_body = $file_new_name_body;
						$upload->image_convert = "webp";
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_en = $upload->file_dst_name;
						Utility::deleteFile($upload_path."", $file_temp);
						Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM article_items WHERE parent_id = ? ";
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
			            $sql = "UPDATE article_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE article_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
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
			$render = "article-item-list.php?parent_id=".$item->parent_id."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_th"] = Utility::getParam("title_th");
			$_SESSION["item_form"]["subject_th"] = Utility::getParam("subject_th");
			$_SESSION["item_form"]["description_th"] = Utility::getParam("description_th");
			$_SESSION["item_form"]["image_alt_th"] = Utility::getParam("image_alt_th");
			$_SESSION["item_form"]["image_alt_en"] = Utility::getParam("image_alt_en");
			$_SESSION["item_form"]["seo_rewrite"] = Utility::getParam("seo_rewrite");
			$_SESSION["item_form"]["seo_title"] = Utility::getParam("seo_title");
			$_SESSION["item_form"]["seo_keyword"] = Utility::getParam("seo_keyword");
			$_SESSION["item_form"]["seo_description"] = Utility::getParam("seo_description");
			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
				
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "article-item-add.php?msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		$item = new article_item();
		$item->load("id = ? ", array($gettmp["id"]));
		//$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
		
		$item->title_th = Utility::encodeToDB(Utility::getParam("title_th"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->subject_th = Utility::encodeToDB(Utility::getParam("subject_th"));
		$item->subject_en = Utility::encodeToDB(Utility::getParam("subject_en"));
		$item->description_th = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_th")));
		$item->description_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("description_en")));
		$item->image_alt_th = Utility::encodeToDB(Utility::getParam("image_alt_th"));
		$item->image_alt_en = Utility::encodeToDB(Utility::getParam("image_alt_en"));
		
		$item->seo_rewrite = Utility::encodeToDB(Utility::getParam("seo_rewrite"));
		$item->seo_title = Utility::encodeToDB(Utility::getParam("seo_title"));
		$item->seo_keyword = Utility::encodeToDB(Utility::getParam("seo_keyword"));
		$item->seo_description = Utility::encodeToDB(Utility::getParam("seo_description"));
		
		$date = Utility::getParam("published_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->published_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->published_date = NULL;
		}
		

		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["username"];
		
		$item->status_th = Utility::getParam("status_th");
		$item->status_en = Utility::getParam("status_en");
		$item->status = Utility::getParam("status");
		
		if ($item->Replace()) {
			unset($_SESSION["item_form"]);
			$update = false;
			
			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["image"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 555 || $upload->image_src_y > 349) $upload->image_resize = true;
				//	$upload->image_resize = true;
				//	$upload->image_x = 555;
				//	$upload->image_y = 349;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->image_convert = "webp";
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 272 || $upload->image_src_y > 171) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 342;
						$upload->image_y = 218;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
						$upload->file_new_name_body = $file_new_name_body;
						$upload->image_convert = "webp";
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
					//	imagewebp(); 
						
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
			
			// Set image_th
			if ($_FILES["image_th"] != null) {
				$file_temp = $item->image_th;
				$upload = new upload($_FILES["image_th"]);
				if ($upload->uploaded) {
					$image_name = explode(".", $_FILES["image_th"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 555 || $upload->image_src_y > 349) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1200;
					$upload->image_y = 676;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->image_convert = "webp";
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 272 || $upload->image_src_y > 171) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 412;
						$upload->image_y = 296;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
						$upload->file_new_name_body = $file_new_name_body;
						$upload->image_convert = "webp";
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_th = $upload->file_dst_name;
						Utility::deleteFile($upload_path."", $file_temp);
						Utility::deleteFile($upload_path."thumbnail/", $file_temp);
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
					//if ($upload->image_src_x > 555 || $upload->image_src_y > 349) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 1200;
					$upload->image_y = 676;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->image_convert = "webp";
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						//if ($upload->image_src_x > 272 || $upload->image_src_y > 171) $upload->image_resize = true;
						$upload->image_resize = true;
						$upload->image_x = 412;
						$upload->image_y = 296;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
						$upload->file_new_name_body = $file_new_name_body;
						$upload->image_convert = "webp";
						$upload->Process($upload_path."thumbnail/");
						$upload->processed;
						
						$upload->clean();
						
						$update = true;
						$item->image_en = $upload->file_dst_name;
						Utility::deleteFile($upload_path."", $file_temp);
						Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}

		// SET Category
			$gettmp["parent_id"] = Utility::getParam("parent_id");
			if ($item->parent_id != $gettmp["parent_id"]) {
				$sequence = $item->sequence;
				
				// Clear old sequence
				$sql = "SELECT Count(id) AS amount FROM article_items WHERE parent_id = ? ";
				$stmt = $db->Prepare($sql);
				$max = $db->getOne($stmt, array($item->parent_id));
				
				if ($sequence < $max) {
					$sql =  "UPDATE article_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
					$stmt = $db->Prepare($sql);
					$rs = $db->Execute($stmt, array($sequence, $item->parent_id));
				}
				
				// Set new sequence
				$sql = "SELECT Count(id) AS amount FROM article_items WHERE parent_id = ? ";
				$stmt = $db->Prepare($sql);
				$max = $db->getOne($stmt, array($gettmp["parent_id"]));
				$gettmp["sequence"] = $max + 1;
				
				$item->sequence = $gettmp["sequence"];
				$item->parent_id = $gettmp["parent_id"];
				
				$item->Replace();
			}
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM article_items WHERE parent_id = ? ";
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
			            $sql = "UPDATE article_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE article_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
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
			$render = "article-item-list.php?parent_id=".$item->parent_id."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_th"] = Utility::getParam("title_th");
			$_SESSION["item_form"]["subject_th"] = Utility::getParam("subject_th");
			$_SESSION["item_form"]["description_th"] = Utility::getParam("description_th");
			$_SESSION["item_form"]["image_alt_th"] = Utility::getParam("image_alt_th");
			$_SESSION["item_form"]["seo_rewrite"] = Utility::getParam("seo_rewrite");
			$_SESSION["item_form"]["seo_title"] = Utility::getParam("seo_title");
			$_SESSION["item_form"]["seo_keyword"] = Utility::getParam("seo_keyword");
			$_SESSION["item_form"]["seo_description"] = Utility::getParam("seo_description");
			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "article-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>