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
$upload_path = DIR."";
$error_message = "";

 
$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");
$gettmp["parent_id"] = Utility::getParam("parent_id");
$gettmp["province_title"] = Utility::getParam("province_title");
$gettmp["province_id"] = Utility::getParam("province_id");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class branch_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {	
	case "delete" :
		$item = new branch_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;

		if($item->Delete()){
			Lang::saveSystemLog($gettmp["id"],'Delete Branch Tabel branch_items',$_SESSION["login_admin"]["id"]);
		}
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "branch-item-list.php?msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];	        

			Lang::saveSystemLog($gettmp["id"],'Delete Branch Tabel branch_items',$_SESSION["login_admin"]["id"]);
        
	        $sql = "DELETE FROM branch_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "branch-item-list.php?msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$sql = "SELECT Count(id) AS sequence FROM branch_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $max + 1;
		
		$item = new branch_item();
		$item->parent_id = $gettmp["parent_id"];
		$item->province_id = $gettmp["province_id"];
		$item->province_title = $gettmp["province_title"];
		
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		$item->url_map = Utility::encodeToDB(Utility::getParam("url_map"));
		$item->phone = Utility::encodeToDB(Utility::getParam("phone"));
		$item->latitude = Utility::encodeToDB(Utility::getParam("latitude"));
		$item->longtitude = Utility::encodeToDB(Utility::getParam("longtitude"));

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

   		    Lang::saveSystemLog($gettmp["id"],'Add Image Branch Tabel branch_items',$_SESSION["login_admin"]["id"]);

					
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "branch-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_la"] = Utility::getParam("title_la");
			$_SESSION["item_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["item_form"]["title_cn"] = Utility::getParam("title_cn");
			$_SESSION["item_form"]["title_vi"] = Utility::getParam("title_vi");

			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");

			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");

			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "branch-item-add.php?msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		//$db->debug=1;
		$item = new branch_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$item->parent_id = $gettmp["parent_id"];
		$item->province_id = $gettmp["province_id"];
		$item->province_title = $gettmp["province_title"];
		
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		$item->url_map = Utility::encodeToDB(Utility::getParam("url_map"));
		$item->phone = Utility::encodeToDB(Utility::getParam("phone"));
		$item->latitude = Utility::encodeToDB(Utility::getParam("latitude"));
		$item->longtitude = Utility::encodeToDB(Utility::getParam("longtitude"));

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

   		    Lang::saveSystemLog($gettmp["id"],'Update Branch Tabel branch_items',$_SESSION["login_admin"]["id"]);

					
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "branch-item-list.php?msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["title_la"] = Utility::getParam("title_la");
			$_SESSION["item_form"]["title_en"] = Utility::getParam("title_en");
			$_SESSION["item_form"]["title_cn"] = Utility::getParam("title_cn");
			$_SESSION["item_form"]["title_vi"] = Utility::getParam("title_vi");

			$_SESSION["item_form"]["published_date"] = Utility::getParam("published_date");

			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "branch-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "manual_sort" :
			
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE branch_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE branch_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'2': 
						$sql = "UPDATE branch_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(2));

						$sql = "UPDATE branch_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);
					break;		
					case'3': 
						$sql = "UPDATE branch_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(3));

						$sql = "UPDATE branch_items SET sort_by = 'DESC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);					
					break;
					case'4': 
						$sql = "UPDATE branch_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE branch_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						 Lang::saveSystemLog($gettmp["id"],'Update Sequence Banner Tabel branch_items',$_SESSION["login_admin"]["id"]);

						
						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM branch_items WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM branch_items i WHERE 1=1 ";
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
									$sql = "UPDATE branch_items i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence));
									$sql = "UPDATE branch_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE branch_items i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"]));
									$sql = "UPDATE branch_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "branch-item-sequence.php?msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;		
	default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>