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
$upload_path = DIR."img_customer/";
$error_message = "";

$gettmp["parent_id"] = 0; // Fix no parent.
$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class customer_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {	
	case "delete" :
		$item = new customer_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		if ($item->image_th != null) {
			Utility::deleteFile($upload_path."", $item->image_th);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_th);
		}
		if ($item->image_en != null) {
			Utility::deleteFile($upload_path."", $item->image_en);
			Utility::deleteFile($upload_path."thumbnail/", $item->image_en);
		}

		if ($item->imagem_th != null) {
			Utility::deleteFile($upload_path."", $item->imagem_th);
			Utility::deleteFile($upload_path."thumbnail/", $item->imagem_th);
		}
		if ($item->imagem_en != null) {
			Utility::deleteFile($upload_path."", $item->imagem_en);
			Utility::deleteFile($upload_path."thumbnail/", $item->imagem_en);
		}

		
		$sql = "SELECT Count(id) AS amount FROM customer_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE customer_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		if($item->Delete()){
			Lang::saveSystemLog($gettmp["id"],'Delete Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
		}
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "customer-item-list.php?msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image_th" :
		$item = new customer_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image_th);
		Utility::deleteFile($upload_path."thumbnail/", $item->image_th);
		$item->image_th = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "customer-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_image_en" :
		$item = new customer_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image_en);
		Utility::deleteFile($upload_path."thumbnail/", $item->image_en);
		$item->image_en = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "customer-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_imagem_th" :
		$item = new customer_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->imagem_th);
		Utility::deleteFile($upload_path."thumbnail/", $item->imagem_th);
		$item->imagem_th = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "customer-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_imagem_en" :
		$item = new customer_item();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->imagem_en);
		Utility::deleteFile($upload_path."thumbnail/", $item->imagem_en);
		$item->imagem_en = null;
		$item->Replace();
		Lang::saveSystemLog($gettmp["id"],'Update Image Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "customer-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "listupdate" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        $gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM customer_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        $gettmp["parent_id"] = $row["parent_id"];
	        
	        $sql = "SELECT Count(id) AS amount FROM customer_items WHERE parent_id = ? ";
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
	                $sql = "UPDATE customer_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($gettmp["to"], $sequence, $gettmp["parent_id"]));
	                $sql = "UPDATE customer_items SET sequence = ? WHERE id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
	            } else {
	                $sql = "UPDATE customer_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($sequence, $gettmp["to"], $gettmp["parent_id"]));
	                $sql = "UPDATE customer_items SET sequence = ? WHERE id = ? ";
	                $stmt = $db->Prepare($sql);
	                $rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
	            }
	        }
	    }
		Lang::saveSystemLog($gettmp["id"],'Update Sequence Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
	    
		$msgsuc = "บันทึกข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
	    $render = "customer-item-list.php?msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM customer_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        $gettmp["image_th"] = $row["image_th"];
	        $gettmp["image_en"] = $row["image_en"];
	        $gettmp["imagem_th"] = $row["imagem_th"];
	        $gettmp["imagem_en"] = $row["imagem_en"];
	        
	        $sql = "SELECT Count(id) AS amount FROM customer_items WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence < $max) {
	            $sql = "UPDATE customer_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
	            $stmt = $db->Prepare($sql);
	            $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
	        }
	        
			if ($gettmp["image_th"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_th"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_th"]);
			}
			if ($gettmp["image_en"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["image_en"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["image_en"]);
			}

			if ($gettmp["imagem_th"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["imagem_th"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["imagem_th"]);
			}
			if ($gettmp["imagem_en"] != null) {
				Utility::deleteFile($upload_path."", $gettmp["imagem_en"]);
				Utility::deleteFile($upload_path."thumbnail/", $gettmp["imagem_en"]);
			}

			Lang::saveSystemLog($gettmp["id"],'Delete Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
        
	        $sql = "DELETE FROM customer_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "customer-item-list.php?msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$sql = "SELECT Count(id) AS sequence FROM customer_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $max + 1;
		
		$item = new customer_item();
		$item->parent_id = $gettmp["parent_id"];
		$item->sequence = $gettmp["sequence"];
		
		$item->title_th = Utility::encodeToDB(Utility::getParam("title_th"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->subject_th = Utility::encodeToDB(Utility::getParam("subject_th"));
		$item->subject_en = Utility::encodeToDB(Utility::getParam("subject_en"));
		$item->url_th = Utility::encodeToDB(Utility::getParam("url_th"));
		$item->url_en = Utility::encodeToDB(Utility::getParam("url_en"));
		$item->image_alt_th = Utility::encodeToDB(Utility::getParam("image_alt_th"));
		$item->image_alt_en = Utility::encodeToDB(Utility::getParam("image_alt_en"));
		$item->imagem_alt_th = Utility::encodeToDB(Utility::getParam("imagem_alt_th"));
		$item->imagem_alt_en = Utility::encodeToDB(Utility::getParam("imagem_alt_en"));
		
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
		
		$item->status_th = Utility::getParam("status_th");
		$item->status_en = Utility::getParam("status_en");
		$item->status = Utility::getParam("status");

		
		if ($item->Save()) {
			unset($_SESSION["banner_form"]);
			$update = false;

   		    Lang::saveSystemLog($gettmp["id"],'Add Image Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);

			// Set image_th
			if ($_FILES["image_th"] != null) {
				$file_temp = $item->image_th;
				$upload = new upload($_FILES["image_th"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_th"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 320;
					$upload->image_y = 320;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {
						
						$upload->clean();
						
						$update = true;
						$item->image_th = $upload->file_dst_name;
				//		Utility::deleteFile($upload_path."", $file_temp);
				//		Utility::deleteFile($upload_path."thumbnail/", $file_temp);
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
					$upload->image_x = 320;
					$upload->image_y = 320;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;						
						
						$upload->clean();
						
						$update = true;
						$item->image_en = $upload->file_dst_name;
				//		Utility::deleteFile($upload_path."", $file_temp);
				//		Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
						
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM customer_items WHERE parent_id = ? ";
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
			            $sql = "UPDATE customer_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE customer_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
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
			$render = "customer-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["banner_form"]["title_th"] = Utility::getParam("title_th");
			$_SESSION["banner_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["banner_form"]["subject_th"] = Utility::getParam("subject_th");
			$_SESSION["banner_form"]["subject_en"] = Utility::getParam("subject_en");
			$_SESSION["banner_form"]["url_th"] = Utility::getParam("url_th");
			$_SESSION["banner_form"]["url_en"] = Utility::getParam("url_en");
			$_SESSION["banner_form"]["image_alt_th"] = Utility::getParam("image_alt_th");
			$_SESSION["banner_form"]["image_alt_en"] = Utility::getParam("image_alt_en");
			$_SESSION["banner_form"]["imagem_alt_th"] = Utility::getParam("imagem_alt_th");
			$_SESSION["banner_form"]["imagem_alt_en"] = Utility::getParam("imagem_alt_en");
			$_SESSION["banner_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["banner_form"]["begin_date"] = Utility::getParam("begin_date");
			$_SESSION["banner_form"]["end_date"] = Utility::getParam("end_date");
			$_SESSION["banner_form"]["status_th"] = Utility::getParam("status_th");
			$_SESSION["banner_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["banner_form"]["status"] = Utility::getParam("status");

			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "customer-item-add.php?msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		//$db->debug=1;
		$item = new customer_item();
		$item->load("id = ? ", array($gettmp["id"]));
		//$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
		
		$item->title_th = Utility::encodeToDB(Utility::getParam("title_th"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->subject_th = Utility::encodeToDB(Utility::getParam("subject_th"));
		$item->subject_en = Utility::encodeToDB(Utility::getParam("subject_en"));
		$item->url_th = Utility::encodeToDB(Utility::getParam("url_th"));
		$item->url_en = Utility::encodeToDB(Utility::getParam("url_en"));
		$item->image_alt_th = Utility::encodeToDB(Utility::getParam("image_alt_th"));
		$item->image_alt_en = Utility::encodeToDB(Utility::getParam("image_alt_en"));
		$item->imagem_alt_th = Utility::encodeToDB(Utility::getParam("imagem_alt_th"));
		$item->imagem_alt_en = Utility::encodeToDB(Utility::getParam("imagem_alt_en"));
		
		
 		
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
		
		$item->status_th = Utility::getParam("status_th");
		$item->status_en = Utility::getParam("status_en");
		$item->status = Utility::getParam("status");
		
		if ($item->Replace()) {
			
			    $sql = "INSERT INTO chk_logs (id,user_id ,sdate ,ip,detail,item_id ,computer ,port,systems,user_agent,referer) VALUES (NULL,'".$_SESSION["login_admin"]["id"]."' ,'".date("Y-m-d H:i:s")."' ,'".$_SERVER['REMOTE_ADDR']."' ,'Update Banner Tabel customer_items' ,'".$item->id."' ,'".$_SERVER['REMOTE_ADDR']."' ,'".$_SERVER["SERVER_PORT"]."' ,'".$gettmp['device_access']."' ,'".$_SERVER['HTTP_USER_AGENT']."' ,'".$_SERVER["REQUEST_URI"]."') ";
	$stmt = $db->Prepare($sql);
	$rs = $db->Execute($stmt);
			//exit();
			Lang::saveSystemLog($item->id,'Update Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);
		//	echo "SET OK 1";
			unset($_SESSION["banner_form"]);
			$update = false;
			
			// Set image_th
			if ($_FILES["image_th"] != null) {
				$file_temp = $item->image_th;
				$upload = new upload($_FILES["image_th"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image_th"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
					$upload->image_resize = true;
					$upload->image_x = 320;
					$upload->image_y = 320;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					
					$upload->Process($upload_path."");
					if ($upload->processed) {						
						
						$upload->clean();
						
						$update = true;
						$item->image_th = $upload->file_dst_name;
				//		Utility::deleteFile($upload_path."", $file_temp);
				//		Utility::deleteFile($upload_path."thumbnail/", $file_temp);
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
					$upload->image_x = 320;
					$upload->image_y = 320;
					$upload->image_ratio = false;
				//	$upload->jpeg_quality = 100;
					$upload->image_convert = "webp";
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
												
						$upload->clean();
						
						$update = true;
						$item->image_en = $upload->file_dst_name;
				//		Utility::deleteFile($upload_path."", $file_temp);
				//		Utility::deleteFile($upload_path."thumbnail/", $file_temp);
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM customer_items WHERE parent_id = ? ";
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
			            $sql = "UPDATE customer_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE customer_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
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
			$render = "customer-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["banner_form"]["title_th"] = Utility::getParam("title_th");
			$_SESSION["banner_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["banner_form"]["subject_th"] = Utility::getParam("subject_th");
			$_SESSION["banner_form"]["subject_en"] = Utility::getParam("subject_en");
			$_SESSION["banner_form"]["url_th"] = Utility::getParam("url_th");
			$_SESSION["banner_form"]["url_en"] = Utility::getParam("url_en");
			$_SESSION["banner_form"]["image_alt_th"] = Utility::getParam("image_alt_th");
			$_SESSION["banner_form"]["image_alt_en"] = Utility::getParam("image_alt_en");
			$_SESSION["banner_form"]["imagem_alt_th"] = Utility::getParam("imagem_alt_th");
			$_SESSION["banner_form"]["imagem_alt_en"] = Utility::getParam("imagem_alt_en");
			$_SESSION["banner_form"]["published_date"] = Utility::getParam("published_date");
			$_SESSION["banner_form"]["begin_date"] = Utility::getParam("begin_date");
			$_SESSION["banner_form"]["end_date"] = Utility::getParam("end_date");
			$_SESSION["banner_form"]["status_th"] = Utility::getParam("status_th");
			$_SESSION["banner_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["banner_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "customer-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "manual_sort" :
			
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE customer_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE customer_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'2': 
						$sql = "UPDATE customer_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(2));

						$sql = "UPDATE customer_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);
					break;		
					case'3': 
						$sql = "UPDATE customer_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(3));

						$sql = "UPDATE customer_items SET sort_by = 'DESC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);					
					break;
					case'4': 
						$sql = "UPDATE customer_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE customer_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						 Lang::saveSystemLog($gettmp["id"],'Update Sequence Banner Tabel customer_items',$_SESSION["login_admin"]["id"]);

						
						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM customer_items WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM customer_items i WHERE 1=1 ";
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
									$sql = "UPDATE customer_items i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence));
									$sql = "UPDATE customer_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE customer_items i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"]));
									$sql = "UPDATE customer_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "customer-item-sequence.php?msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;		
	default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>