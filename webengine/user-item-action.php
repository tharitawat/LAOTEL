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
//$db->debug = 1;
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$upload_max_size = $config['image_max_size'];
$upload_temp_path = DIR."uploads/temp/";
$upload_path = DIR."img_user/";
$error_message = "";

$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["do"] = Utility::getParam("do");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class user extends ADOdb_Active_Record{}
class user_role_menu extends ADOdb_Active_Record{}
class user_role_sub extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {
	case "status" :
		$status = Utility::getParam("status", 0);
		
		$item = new user();
		$item->load("id = ? ", array($gettmp["id"]));
		$item->status = $status;
		$item->Replace();
		
		echo $status;
		die();
		//$render = "user-item-list.php";
		//die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete" :
		$item = new user();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image);
		Utility::deleteFile($upload_path."thumbnail/", $item->image);
		
		$item->Delete();
	   Lang::saveSystemLog($gettmp["id"],'Delete User Account Tabel user ',$_SESSION["login_admin"]["id"]);
		
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "user-item-list.php?msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "deleteimage" :
		$item = new user();
		$item->load("id = ? ", array($gettmp["id"]));
		
		Utility::deleteFile($upload_path."", $item->image);
		Utility::deleteFile($upload_path."thumbnail/", $item->image);
		$item->image = null;
		$item->Replace();
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "user-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM users WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $gettmp["image"] = $row["image"];
	        
	        if ($gettmp["image"] != null){
	            Utility::deleteFile($upload_path."", $gettmp["image"]);
	            Utility::deleteFile($upload_path."thumbnail/", $gettmp["image"]);
	        }
	        
		   Lang::saveSystemLog($gettmp["id"],'Delete User Account Tabel user ',$_SESSION["login_admin"]["id"]);
		
	        $sql = "DELETE FROM users WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
	    
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "user-item-list.php?msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$item = new user();
		$item->username = Utility::encodeToDB(Utility::getParam("email"));
		$item->fullname = Utility::encodeToDB(Utility::getParam("fullname"));
		$item->type = Utility::getParam("type", 0);
		$item->email = Utility::encodeToDB(Utility::getParam("email"));
		$item->phone = Utility::encodeToDB(Utility::getParam("phone"));
		
		$password = Utility::encodeToDB(Utility::getParam("password"));
		$re_password = Utility::encodeToDB(Utility::getParam("re_password"));
		if (($item->password != $password) && ($password == $re_password)) {
		    $password = Utility::hash($password);
			$item->password = $password;
		}
		
		$date = Utility::getParam("created_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->created_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->created_date = NULL;
		}
		$date = Utility::getParam("expired_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->expired_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->expired_date = NULL;
		}
		$item->modified_date = date("Y-m-d H:i:s");
		
		$item->status = Utility::getParam("status", 0);
		
		if ($item->Save()) {
			unset($_SESSION['user']);
			$update = false;
			
			   Lang::saveSystemLog($item->id,'Insert User Account Tabel user ',$_SESSION["login_admin"]["id"]);
	
			// Set Role Menu
			$sql = "DELETE FROM user_role_menus WHERE 1 = 1 AND user_id = ? ";
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($item->id));
			$role_menus = Utility::getParam("role_menu", NULL);
			$size = sizeof($role_menus);
			$role_menu = new user_role_menu();
			for ($i = 0; $i < $size; $i++) {
				$role_menu->Reset();
				$role_menu->user_id = $item->id;
				$role_menu->menu_id = $role_menus[$i];
				$role_menu->Save();
			}
			
			// Set Role Sub
			$sql = "DELETE FROM user_role_subs WHERE 1 = 1 AND user_id = ? ";
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($item->id));
			$role_subs = Utility::getParam("role_sub", NULL);
			$size = sizeof($role_subs);
			$role_sub = new user_role_sub();
			for ($i = 0; $i < $size; $i++) {
				$role_sub->Reset();
				$role_sub->user_id = $item->id;
				$role_sub->menu_id = $role_subs[$i];
				$role_sub->Save();
			}
			
			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if (($upload->uploaded) && ($upload->file_is_image)) {
					$file_new_name_body = $item->id."-image-".rand(1000, 9999);
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					if ($upload->image_src_x > 521 || $upload->image_src_y > 580) $upload->image_resize = true;
					$upload->image_x = 521;
					$upload->image_y = 580;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						if ($upload->image_src_x > 521 || $upload->image_src_y > 580) $upload->image_resize = true;
						$upload->image_x = 521;
						$upload->image_y = 580;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
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
			$render = "user-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["user"]["fullname"] = Utility::getParam("fullname");
			$_SESSION["user"]["type"] = Utility::getParam("type");
			$_SESSION["user"]["email"] = Utility::getParam("email");
			$_SESSION["user"]["phone"] = Utility::getParam("phone");
			$_SESSION["user"]["created_date"] = Utility::getParam("created_date");
			$_SESSION["user"]["expired_date"] = Utility::getParam("expired_date");
			$_SESSION["user"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "user-item-add.php?msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		$item = new user();
		$item->load("id = ? ", array($gettmp["id"]));
		$item->fullname = Utility::encodeToDB(Utility::getParam("fullname"));
		$item->type = Utility::getParam("type", 0);
	//	$item->email = Utility::encodeToDB(Utility::getParam("email"));
		$item->phone = Utility::encodeToDB(Utility::getParam("phone"));
		
		
		$password = Utility::encodeToDB(Utility::getParam("password"));
		if($password != ''){
			$re_password = Utility::encodeToDB(Utility::getParam("re_password"));
			if (($item->password != $password) && ($password == $re_password)) {
				$password = Utility::hash($password);
				$item->password = $password;
			}
		}
		$date = Utility::getParam("created_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->created_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->created_date = NULL;
		}
		$date = Utility::getParam("expired_date");
		if ($date != null) {
			list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
			$item->expired_date = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
		} else {
			$item->expired_date = NULL;
		}
		$item->modified_date = date("Y-m-d H:i:s");
		
		$item->status = Utility::getParam("status", 0);
		
		if ($item->Replace()) {
			unset($_SESSION['user']);
			$update = false;
			
			Lang::saveSystemLog($gettmp["id"],'Update User Account Tabel user ',$_SESSION["login_admin"]["id"]);

			
			// Set Role Menu
			$sql = "DELETE FROM user_role_menus WHERE 1 = 1 AND user_id = ? ";
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($item->id));
			$role_menus = Utility::getParam("role_menu", NULL);
			$size = sizeof($role_menus);
			$role_menu = new user_role_menu();
			for ($i = 0; $i < $size; $i++) {
				$role_menu->Reset();
				$role_menu->user_id = $item->id;
				$role_menu->menu_id = $role_menus[$i];
				$role_menu->Save();
			}
			
			// Set Role Sub
			$sql = "DELETE FROM user_role_subs WHERE 1 = 1 AND user_id = ? ";
			$stmt = $db->Prepare($sql);
			$rs = $db->Execute($stmt, array($item->id));
			$role_subs = Utility::getParam("role_sub", NULL);
			$size = sizeof($role_subs);
			$role_sub = new user_role_sub();
			for ($i = 0; $i < $size; $i++) {
				$role_sub->Reset();
				$role_sub->user_id = $item->id;
				$role_sub->menu_id = $role_subs[$i];
				$role_sub->Save();
			}
			
			// Set image
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if (($upload->uploaded) && ($upload->file_is_image)) {
					$file_new_name_body = $item->id."-image-".rand(1000, 9999);
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					if ($upload->image_src_x > 521 || $upload->image_src_y > 580) $upload->image_resize = true;
					$upload->image_x = 521;
					$upload->image_y = 580;
					$upload->image_ratio = false;
					$upload->jpeg_quality = 100;
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."");
					if ($upload->processed) {
						// resize
						$upload->file_overwrite = true;
						if ($upload->image_src_x > 521 || $upload->image_src_y > 580) $upload->image_resize = true;
						$upload->image_x = 521;
						$upload->image_y = 580;
						$upload->image_ratio = false;
						$upload->jpeg_quality = 100;
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
			$render = "user-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["user"]["fullname"] = Utility::getParam("fullname");
			$_SESSION["user"]["type"] = Utility::getParam("type");
			$_SESSION["user"]["email"] = Utility::getParam("email");
			$_SESSION["user"]["phone"] = Utility::getParam("phone");
			$_SESSION["user"]["created_date"] = Utility::getParam("created_date");
			$_SESSION["user"]["expired_date"] = Utility::getParam("expired_date");
			$_SESSION["user"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "user-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
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