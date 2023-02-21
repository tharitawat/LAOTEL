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
$upload_path = DIR."img_product/";
$error_message = "";

$gettmp["parent_id"] = Utility::getParam("parent_id");
$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["group_id"] = Utility::getParam("group_id");
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");


$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class consumer_service_file extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {
	case "delete" :
		$item = new consumer_service_file();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		
		if ($item->file_name_la != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_la);
		}
		if ($item->file_name_en != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_en);
		}
		if ($item->file_name_cn != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_cn);
		}
		if ($item->file_name_vi != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_vi);
		}
		
		$sql = "SELECT Count(id) AS amount FROM consumer_service_files WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE consumer_service_files SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		$item->Delete();
		
		
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "download-item-list.php?parent_id=".$gettmp["parent_id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "delete_file_la" :
		$item = new consumer_service_file();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		
		if ($item->file_name_la != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_la);
		}
		
		
		$item->file_name_la = null;		
		$item->file_size_la = null;		
		$item->Replace();	
		
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "download-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;	
	case "delete_file_en" :
		$item = new consumer_service_file();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		
		if ($item->file_name_en != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_en);
		}
		
		
		$item->file_name_en = null;		
		$item->file_size_en = null;		
		$item->Replace();	
		
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "download-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;		
	case "delete_file_cn" :
		$item = new consumer_service_file();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		
		if ($item->file_name_cn != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_cn);
		}
		
		
		$item->file_name_cn = null;		
		$item->file_size_cn = null;		
		$item->Replace();	
		
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "download-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;		
	case "delete_file_vi" :
		$item = new consumer_service_file();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		
		if ($item->file_name_vi != null) {
			Utility::deleteFile($upload_path."file/", $item->file_name_vi);
		}
		
		
		$item->file_name_vi = null;		
		$item->file_size_vi = null;		
		$item->Replace();	
		
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "download-item-edit.php?id=".$gettmp["id"]."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;		
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM consumer_service_files WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        $gettmp["file_name_la"] = $row["file_name_la"];
	        $gettmp["file_name_en"] = $row["file_name_en"];
	        $gettmp["file_name_cn"] = $row["file_name_cn"];
	        $gettmp["file_name_vi"] = $row["file_name_vi"];
	        
	        $sql = "SELECT Count(id) AS amount FROM consumer_service_files WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence < $max) {
	            $sql = "UPDATE consumer_service_files SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
	            $stmt = $db->Prepare($sql);
	            $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
	        }
	        
			
			if ($gettmp["file_name_la"] != null) {
				Utility::deleteFile($upload_path."file/", $gettmp["file_name_la"]);
			}
			if ($gettmp["file_name_en"] != null) {
				Utility::deleteFile($upload_path."file/", $gettmp["file_name_en"]);
			}
			if ($gettmp["file_name_cn"] != null) {
				Utility::deleteFile($upload_path."file/", $gettmp["file_name_cn"]);
			}
			if ($gettmp["file_name_vi"] != null) {
				Utility::deleteFile($upload_path."file/", $gettmp["file_name_vi"]);
			}
	        
	        $sql = "DELETE FROM consumer_service_files WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));			
			
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "download-item-list.php?parent_id=".$gettmp["parent_id"];
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;		
	case "insert" :
	
		$sql = "SELECT Count(id) AS amount FROM consumer_service_files WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$val = $db->GetOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $val + 1;

		$item = new consumer_service_file();		
		$item->parent_id = $gettmp["parent_id"];
		$item->sequence = $gettmp["sequence"];		
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		
		$item->created_date = date("Y-m-d H:i:s");
		$item->created_by = $_SESSION["login_admin"]["id"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];		
		$item->status = Utility::getParam("status", 0);
		
		if ($item->Save()) {
			unset($_SESSION["item_form"]);
			$update = false;
			
		   Lang::saveSystemLog($item->id,'Add File consumer_service_files ',$_SESSION["login_admin"]["id"]);
		
			
			if ($_FILES["file_name_la"] != null) {
				$file_temp = $item->file_name_la;
				$upload = new upload($_FILES["file_name_la"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_la"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_la = $upload->file_dst_name;
						$item->file_size_la = $_FILES["file_name_la"]["size"];
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			if ($_FILES["file_name_en"] != null) {
				$file_temp = $item->file_name_en;
				$upload = new upload($_FILES["file_name_en"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_en"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_en = $upload->file_dst_name;
						$item->file_size_th = $_FILES["file_name_en"]["size"];
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			if ($_FILES["file_name_cn"] != null) {
				$file_temp = $item->file_name_cn;
				$upload = new upload($_FILES["file_name_cn"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_cn"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_cn = $upload->file_dst_name;
						$item->file_size_cn = $_FILES["file_name_cn"]["size"];
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			if ($_FILES["file_name_vi"] != null) {
				$file_temp = $item->file_name_vi;
				$upload = new upload($_FILES["file_name_vi"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_vi"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_vi = $upload->file_dst_name;
						$item->file_size_vi = $_FILES["file_name_vi"]["size"];
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
			$render = "download-item-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_th"] = Utility::getParam("title_th");
			$_SESSION["item_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "download-item-add.php?parent_id=".$gettmp['parent_id']."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		$item = new consumer_service_file();
		$item->load("id = ? ", array($gettmp["id"]));
		//$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		
		
		//$item->created_date = date("Y-m-d H:i:s");
		//$item->created_by = $_SESSION["login_admin"]["id"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];
		
		$item->status = Utility::getParam("status", 0);
		
		if ($item->Replace()) {
			unset($_SESSION["item_form"]);
			$update = false;
			
		   Lang::saveSystemLog($item->id,'Update File consumer_service_files ',$_SESSION["login_admin"]["id"]);
		
			
			if ($_FILES["file_name_la"] != null) {
				$file_temp = $item->file_name_la;
				$upload = new upload($_FILES["file_name_la"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_la"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_la = $upload->file_dst_name;
						$item->file_size_la = $_FILES["file_name_la"]["size"];
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			
			if ($_FILES["file_name_en"] != null) {
				$file_temp = $item->file_name_en;
				$upload = new upload($_FILES["file_name_en"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_en"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_en = $upload->file_dst_name;
						$item->file_size_th = $_FILES["file_name_en"]["size"];
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			if ($_FILES["file_name_cn"] != null) {
				$file_temp = $item->file_name_cn;
				$upload = new upload($_FILES["file_name_cn"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_cn"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_cn = $upload->file_dst_name;
						$item->file_size_cn = $_FILES["file_name_cn"]["size"];
					}
					
				} else {
					$error_message = $error_message.$upload->error."<br />";
				}
			}
			if ($_FILES["file_name_vi"] != null) {
				$file_temp = $item->file_name_vi;
				$upload = new upload($_FILES["file_name_vi"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["file_name_vi"]["name"]);
					$file_new_name_body = $image_name[0]."-".$item->id."-".rand(1000, 9999);					
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					
					$upload->file_new_name_body = $file_new_name_body;
					$upload->Process($upload_path."file/");
					if ($upload->processed) {											
						$upload->clean();
						
						$update = true;
						$item->file_name_vi = $upload->file_dst_name;
						$item->file_size_vi = $_FILES["file_name_vi"]["size"];
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
			$render = "download-item-list.php?parent_id=".$item->parent_id."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_th"] = Utility::getParam("title_th");
			$_SESSION["item_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "download-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
		case "manual_sort" :		
	
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE consumer_service_files SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE consumer_service_files SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'4': 
						$sql = "UPDATE consumer_service_files SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE consumer_service_files SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM consumer_service_files WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM consumer_service_files i WHERE 1=1 AND i.parent_id = ? ";
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
									$sql = "UPDATE consumer_service_files i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? AND i.parent_id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence, $gettmp["parent_id"]));
									$sql = "UPDATE consumer_service_files i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE consumer_service_files i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ?  AND i.parent_id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"], $gettmp["parent_id"]));
									$sql = "UPDATE consumer_service_files i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "download-item-sequence.php?parent_id=".$gettmp["parent_id"]."&msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;			
				default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>