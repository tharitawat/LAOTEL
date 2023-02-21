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

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class career_vacancy_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {	
	case "delete" :
		$item = new career_vacancy_item();
		$item->load("id = ? ", array($gettmp["id"]));
		$gettmp["parent_id"] = $item->parent_id;
		$sequence = $item->sequence;
	
		
		$sql = "SELECT Count(id) AS amount FROM career_vacancy_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		
		if ($sequence < $max) {
		    $sql =  "UPDATE career_vacancy_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
		    $stmt = $db->Prepare($sql);
		    $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
		}
		
		if($item->Delete()){
			Lang::saveSystemLog($gettmp["id"],'Delete Jobs Tabel career_vacancy_items',$_SESSION["login_admin"]["id"]);
		}
		
		$msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msgsuc);
		$render = "career-application-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
		die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		break;

	
	case "listdelete" :
	    foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
	        $gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
	        
	        $sql = "SELECT * FROM career_vacancy_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $row = $db->getRow($stmt, array($gettmp["id"]));
	        $sequence = $row["sequence"];
	        
	        $sql = "SELECT Count(id) AS amount FROM career_vacancy_items WHERE parent_id = ? ";
	        $stmt = $db->Prepare($sql);
	        $max = $db->getOne($stmt, array($gettmp["parent_id"]));
	        
	        if ($sequence < $max) {
	            $sql = "UPDATE career_vacancy_items SET sequence = sequence - 1 WHERE sequence > ? AND parent_id = ? ";
	            $stmt = $db->Prepare($sql);
	            $rs = $db->Execute($stmt, array($sequence, $gettmp["parent_id"]));
	        }
	        

			Lang::saveSystemLog($gettmp["id"],'Delete Jobs Tabel career_vacancy_items',$_SESSION["login_admin"]["id"]);
        
	        $sql = "DELETE FROM career_vacancy_items WHERE id = ? ";
	        $stmt = $db->Prepare($sql);
	        $rs = $db->Execute($stmt, array($gettmp["id"]));
	    }
		
	    $msgsuc = "ลบข้อมูลเรียบร้อย";
		$msgsuc = urlsafe_b64encode($msg);
		$render = "career-application-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
	    die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
	    break;
	case "insert" :
		$sql = "SELECT Count(id) AS sequence FROM career_vacancy_items WHERE parent_id = ? ";
		$stmt = $db->Prepare($sql);
		$max = $db->getOne($stmt, array($gettmp["parent_id"]));
		$gettmp["sequence"] = $max + 1;
		
		$item = new career_vacancy_item();
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
		$item->job_description_la = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_la")));
		$item->job_description_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_en")));
		$item->job_description_cn = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_cn")));
		$item->job_description_vi = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_vi")));
		$item->qualifications_la = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_la")));
		$item->qualifications_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_en")));
		$item->qualifications_cn = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_cn")));
		$item->qualifications_vi = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_vi")));
		
		$item->amount = Utility::getParam("amount");
		
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

   		    Lang::saveSystemLog($gettmp["id"],'Add Jobs Tabel career_vacancy_items',$_SESSION["login_admin"]["id"]);

			
			
			
			// SET Sequence
			$gettmp["sequence"] = Utility::getParam("sequence");
			if ($item->sequence != $gettmp["sequence"]) {
			    $update = true;
			    $sql = "SELECT Count(id) AS amount FROM career_vacancy_items WHERE parent_id = ? ";
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
			            $sql = "UPDATE career_vacancy_items SET sequence = sequence + 1 WHERE sequence >= ? AND sequence < ? AND parent_id = ? ";
			            $stmt = $db->Prepare($sql);
			            $rs = $db->Execute($stmt, array($gettmp["sequence"], $item->sequence, $item->parent_id));
			            $item->sequence = $gettmp["sequence"];
			        }  else {
			            $sql = "UPDATE career_vacancy_items SET sequence = sequence - 1 WHERE sequence > ? AND sequence <= ? AND parent_id = ? ";
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
			$render = "career-application-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
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
			$_SESSION["item_form"]["qualifications_la"] = Utility::getParam("qualifications_la");
			$_SESSION["item_form"]["qualifications_en"] = Utility::getParam("qualifications_en");
			$_SESSION["item_form"]["qualifications_cn"] = Utility::getParam("qualifications_cn");
			$_SESSION["item_form"]["qualifications_vi"] = Utility::getParam("qualifications_vi");
			$_SESSION["item_form"]["job_description_la"] = Utility::getParam("job_description_la");
			$_SESSION["item_form"]["job_description_en"] = Utility::getParam("job_description_en");
			$_SESSION["item_form"]["job_description_cn"] = Utility::getParam("job_description_cn");
			$_SESSION["item_form"]["job_description_vi"] = Utility::getParam("job_description_vi");
			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");

			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "career-application-add.php?parent_id=".$gettmp['parent_id']."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "update" :
		//$db->debug=1;
		$item = new career_vacancy_item();
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
		$item->job_description_la = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_la")));
		$item->job_description_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_en")));
		$item->job_description_cn = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_cn")));
		$item->job_description_vi = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("job_description_vi")));
		$item->qualifications_la = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_la")));
		$item->qualifications_en = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_en")));
		$item->qualifications_cn = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_cn")));
		$item->qualifications_vi = Utility::encodeToDB(Utility::convTextToDB(Utility::getParam("qualifications_vi")));
		
		$item->amount = Utility::getParam("amount");
		
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

   		    Lang::saveSystemLog($gettmp["id"],'Update Jobs Tabel career_vacancy_items',$_SESSION["login_admin"]["id"]);
	
		
			$msgsuc = "บันทึกข้อมูลเรียบร้อย";
			$msgsuc = urlsafe_b64encode($msgsuc);
			$render = "career-application-list.php?parent_id=".$gettmp['parent_id']."&msgsuc=".$msgsuc;
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
			$_SESSION["item_form"]["qualifications_la"] = Utility::getParam("qualifications_la");
			$_SESSION["item_form"]["qualifications_en"] = Utility::getParam("qualifications_en");
			$_SESSION["item_form"]["qualifications_cn"] = Utility::getParam("qualifications_cn");
			$_SESSION["item_form"]["qualifications_vi"] = Utility::getParam("qualifications_vi");
			$_SESSION["item_form"]["job_description_la"] = Utility::getParam("job_description_la");
			$_SESSION["item_form"]["job_description_en"] = Utility::getParam("job_description_en");
			$_SESSION["item_form"]["job_description_cn"] = Utility::getParam("job_description_cn");
			$_SESSION["item_form"]["job_description_vi"] = Utility::getParam("job_description_vi");
			$_SESSION["item_form"]["status_la"] = Utility::getParam("status_la");
			$_SESSION["item_form"]["status_en"] = Utility::getParam("status_en");
			$_SESSION["item_form"]["status_cn"] = Utility::getParam("status_cn");
			$_SESSION["item_form"]["status_vi"] = Utility::getParam("status_vi");
			$_SESSION["item_form"]["status"] = Utility::getParam("status");
			
			$msgerr = "ไม่สามารถบันทึกข้อมูลได้ กรุณาทำรายการใหม่อีกครั้ง";
			$msgerr = urlsafe_b64encode($msgerr);
			$render = "career-application-edit.php?id=".$item->id."&msgerr=".$msgerr;
			die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");
		}
		
		break;
	case "manual_sort" :
			
				switch($gettmp['sequence']){
					case'1': 
						$sql = "UPDATE career_vacancy_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(1));
						
						$sql = "UPDATE career_vacancy_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	
					break;
					case'2': 
						$sql = "UPDATE career_vacancy_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(2));

						$sql = "UPDATE career_vacancy_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);
					break;		
					case'3': 
						$sql = "UPDATE career_vacancy_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(3));

						$sql = "UPDATE career_vacancy_items SET sort_by = 'DESC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);					
					break;
					case'4': 
						$sql = "UPDATE career_vacancy_items SET sort_order = ? ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt, array(4));

						$sql = "UPDATE career_vacancy_items SET sort_by = 'ASC' ";
						$stmt = $db->Prepare($sql);
						$row = $db->getRow($stmt);	

						 Lang::saveSystemLog($gettmp["id"],'Update Sequence Banner Tabel career_vacancy_items',$_SESSION["login_admin"]["id"]);

						
						foreach (Utility::getParam("chkbox") as $row => $gettmp["no"]) {
							$gettmp["id"] = $_POST["id"][$gettmp["no"] - 1];
							$gettmp["to"] = $_POST["sequence_new"][$gettmp["no"] - 1];
							
							$sql = "SELECT * FROM career_vacancy_items WHERE id = ? ";
							$stmt = $db->Prepare($sql);
							$row = $db->getRow($stmt, array($gettmp["id"]));
							$sequence = $row["sequence"];
						
				
							$sql = "SELECT Count(i.id) AS amount FROM career_vacancy_items i WHERE 1=1 ";
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
									$sql = "UPDATE career_vacancy_items i SET i.sequence = i.sequence + 1 WHERE i.sequence >= ? AND i.sequence < ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $sequence));
									$sql = "UPDATE career_vacancy_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								} else {
									$sql = "UPDATE career_vacancy_items i SET i.sequence = i.sequence - 1 WHERE i.sequence > ? AND i.sequence <= ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($sequence, $gettmp["to"]));
									$sql = "UPDATE career_vacancy_items i SET i.sequence = ? WHERE i.id = ? ";
									$stmt = $db->Prepare($sql);
									$rs = $db->Execute($stmt, array($gettmp["to"], $gettmp["id"]));
								}
							}	
						}
					break;
				}
					$msgsuc = "บันทึกข้อมูลเรียบร้อย";
					$msgsuc = urlsafe_b64encode($msgsuc);
					$render = "career-application-sequence.php?msgsuc=".$msgsuc;
					die("<meta http-equiv=\"refresh\" content=\"0; URL=$render\">");		

					break;		
	default :
}

$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->do = $gettmp["do"];

//$template->display($render);
?>