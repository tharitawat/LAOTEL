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
$upload_path = DIR."img_roaming_item/";
$error_message = "";

$gettmp["parent_id"] = Utility::getParam("parent_id", 0);
$gettmp["id"] = Utility::getParam("id", 0);
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class roaming_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {	
	case "delete" :
		$item = new roaming_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
		
		$sql = "SELECT Count(id) AS amount FROM roaming_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE roaming_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		if($item->Delete()){
			Lang::saveSystemLog($gettmp["id"],'Delete Icon Tabel roaming_items',$_SESSION["login_admin"]["id"]);
		}
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "roaming-item-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM roaming_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        
	        $sql = "SELECT Count(id) AS amount FROM roaming_items WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence < $max) {
	            $sql = "UPDATE roaming_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
	            $stmt = $db->Prepare($sql);
	            $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
	        }
	        
			Lang::saveSystemLog($gettmp["id"],'Delete Item Tabel roaming_items',$_SESSION["login_admin"]["id"]);
        
	        $sql = "DELETE FROM roaming_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "roaming-item-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$gettmp["country_id"] = Utility::getParam("country_id");
			
		$sql = "SELECT * FROM country_items WHERE id = ? ";
		$stmt = $db->Prepare($sql);
		$row = $db->getRow($stmt, array($gettmp["country_id"]));
		$country_name = $row["title_la"];
		$country_code = $row["code"];
		
		$sql = "SELECT Count(id) AS sequence FROM roaming_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $max + 1;
		
		$item = new roaming_item();
		$item->parent_id = $gettmp["parent_id"];
		
		$item->country_id = $gettmp["country_id"] ;
		$item->country_name = $country_name;
		$item->country_code = $country_code;
		$item->type = Utility::getParam("type",'0');
		$item->operator_name = Utility::encodeToDB(Utility::getParam("operator_name"));
		$item->network_name = Utility::encodeToDB(Utility::getParam("network_name"));
		$item->local_call = Utility::encodeToDB(Utility::getParam("local_call"));
		$item->recevied_call = Utility::encodeToDB(Utility::getParam("recevied_call"));
		$item->call_back = Utility::encodeToDB(Utility::getParam("call_back"));
		$item->call_to_country = Utility::encodeToDB(Utility::getParam("call_to_country"));
		$item->sms_mo = Utility::encodeToDB(Utility::getParam("sms_mo"));
		$item->sms_mt = Utility::encodeToDB(Utility::getParam("sms_mt"));
		$item->data_value = Utility::encodeToDB(Utility::getParam("data_value"));
		$item->ira = Utility::encodeToDB(Utility::getParam("ira"));		

		$item->created_date = date("Y-m-d H:i:s");
		$item->created_by = $_SESSION["login_admin"]["fullname"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];

		$item->status = Utility::getParam("status",'0');

		
		if ($item->Save()) {
			unset($_SESSION["item_form"]);
			$update = false;

   		    Lang::saveSystemLog($gettmp["id"],'Add roaming_items',$_SESSION["login_admin"]["id"]);

			
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "roaming-item-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["operator_name"] = Utility::getParam("operator_name");
			$_SESSION["item_form"]["network_name"] = Utility::getParam("network_name");
			$_SESSION["item_form"]["local_call"] = Utility::getParam("local_call");
			$_SESSION["item_form"]["recevied_call"] = Utility::getParam("recevied_call");
			$_SESSION["item_form"]["call_back"] = Utility::getParam("call_back");
			$_SESSION["item_form"]["call_to_country"] = Utility::getParam("call_to_country");
			$_SESSION["item_form"]["sms_mo"] = Utility::getParam("sms_mo");
			$_SESSION["item_form"]["sms_mt"] = Utility::getParam("sms_mt");
			$_SESSION["item_form"]["data_value"] = Utility::getParam("data_value");
			$_SESSION["item_form"]["ira"] = Utility::getParam("ira");
			$_SESSION["item_form"]["country_id"] = Utility::getParam("country_id");

			$_SESSION["item_form"]["status"] = Utility::getParam("status");

			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "roaming-item-add.php?parent_id=".$gettmp['parent_id']."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		//$db->debug=1;
		
		$gettmp["country_id"] = Utility::getParam("country_id");
			
		$sql = "SELECT * FROM country_items WHERE id = ? ";
		$stmt = $db->Prepare($sql);
		$row = $db->getRow($stmt, array($gettmp["country_id"]));
		$country_name = $row["title_la"];
		$country_code = $row["code"];
		
		$item = new roaming_item();
		$item->load("id = ? ", array($gettmp["id"]));
		//$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
		
		$item->country_id = $gettmp["country_id"] ;
		$item->country_name = $country_name;
		$item->country_code = $country_code;
		$item->type = Utility::getParam("type",'0');
		$item->operator_name = Utility::encodeToDB(Utility::getParam("operator_name"));
		$item->network_name = Utility::encodeToDB(Utility::getParam("network_name"));
		$item->local_call = Utility::encodeToDB(Utility::getParam("local_call"));
		$item->recevied_call = Utility::encodeToDB(Utility::getParam("recevied_call"));
		$item->call_back = Utility::encodeToDB(Utility::getParam("call_back"));
		$item->call_to_country = Utility::encodeToDB(Utility::getParam("call_to_country"));
		$item->sms_mo = Utility::encodeToDB(Utility::getParam("sms_mo"));
		$item->sms_mt = Utility::encodeToDB(Utility::getParam("sms_mt"));
		$item->data_value = Utility::encodeToDB(Utility::getParam("data_value"));
		$item->ira = Utility::encodeToDB(Utility::getParam("ira"));		

		//$item->created_date = date("Y-m-d H:i:s");
		//$item->created_by = $_SESSION["login_admin"]["fullname"];
		$item->modified_date = date("Y-m-d H:i:s");
		$item->modified_by = $_SESSION["login_admin"]["fullname"];

		$item->status = Utility::getParam("status",'0');

		
		if ($item->Replace()) {
			unset($_SESSION["item_form"]);
			$update = false;

   		    Lang::saveSystemLog($gettmp["id"],'Update item roaming_items',$_SESSION["login_admin"]["id"]);

					
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "roaming-item-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		} else {
			$_SESSION["item_form"]["operator_name"] = Utility::getParam("operator_name");
			$_SESSION["item_form"]["network_name"] = Utility::getParam("network_name");
			$_SESSION["item_form"]["local_call"] = Utility::getParam("local_call");
			$_SESSION["item_form"]["recevied_call"] = Utility::getParam("recevied_call");
			$_SESSION["item_form"]["call_back"] = Utility::getParam("call_back");
			$_SESSION["item_form"]["call_to_country"] = Utility::getParam("call_to_country");
			$_SESSION["item_form"]["sms_mo"] = Utility::getParam("sms_mo");
			$_SESSION["item_form"]["sms_mt"] = Utility::getParam("sms_mt");
			$_SESSION["item_form"]["data_value"] = Utility::getParam("data_value");
			$_SESSION["item_form"]["ira"] = Utility::getParam("ira");
			$_SESSION["item_form"]["country_id"] = Utility::getParam("country_id");

			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "roaming-item-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "manual_sort" :
			
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE roaming_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE roaming_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'2': 
						$sql = "UPDATE roaming_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(2));

						$sql = "UPDATE roaming_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);
					break;		
					case'3': 
						$sql = "UPDATE roaming_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(3));

						$sql = "UPDATE roaming_items SET sort_by = 'DESC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);					
					break;
					case'4': 
						$sql = "UPDATE roaming_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE roaming_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						 Lang::saveSystemLog($gettmp["id"],'Update Sequence Tabel roaming_items',$_SESSION["login_admin"]["id"]);

						
						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM roaming_items WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM roaming_items i WHERE 1=1 ";
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
									$sql = "UPDATE roaming_items i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence));
									$sql = "UPDATE roaming_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE roaming_items i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"]));
									$sql = "UPDATE roaming_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "roaming-item-sequence.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;		
	default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>