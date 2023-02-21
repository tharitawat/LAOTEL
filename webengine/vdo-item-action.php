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
$upload_path = DIR."img_vdo/";
$error_message = "";

$gettmp["parent_id"] = 0; // Fix no parent.
$gettmp["id"] = Utility::getParam("id", 1);
$gettmp["do"] = Utility::getParam("do");
$gettmp["sequence"] = Utility::getParam("sequence");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class vdo_item extends ADOdb_Active_Record{}

switch ($gettmp["do"]) {		
	case "update" :
		//$db->debug=1;
		$item = new vdo_item();
		$item->load("id = ? ", array($gettmp["id"]));
		//$item->parent_id = $gettmp["parent_id"];
		//$item->sequence = $gettmp["sequence"];
		
		$item->title_la = Utility::encodeToDB(Utility::getParam("title_la"));
		$item->title_en = Utility::encodeToDB(Utility::getParam("title_en"));
		$item->title_cn = Utility::encodeToDB(Utility::getParam("title_cn"));
		$item->title_vi = Utility::encodeToDB(Utility::getParam("title_vi"));
		$item->vdo_la = Utility::encodeToDB(Utility::getParam("vdo_la"));
		$item->vdo_en = Utility::encodeToDB(Utility::getParam("vdo_en"));
		$item->vdo_cn = Utility::encodeToDB(Utility::getParam("vdo_cn"));
		$item->vdo_vi = Utility::encodeToDB(Utility::getParam("vdo_vi"));
		
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

   		    Lang::saveSystemLog($gettmp["id"],'Update VDO Tabel vdo_items',$_SESSION["login_admin"]["id"]);

			// Set image_la
			if ($_FILES["image"] != null) {
				$file_temp = $item->image;
				$upload = new upload($_FILES["image"]);
				if ($upload->uploaded) {
					
					$image_name = explode(".", $_FILES["image"]["name"]);
					$file_new_name_body = $image_name[0]; //$item->id."-cover-".rand(1000, 9999);
					
					$upload->file_max_size = $upload_max_size;
					$upload->file_overwrite = true;
					//if ($upload->image_src_x > 1366 || $upload->image_src_y > 570) $upload->image_resize = true;
				//	$upload->image_resize = true;
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
						$item->image = $upload->file_dst_name;
				 
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
			$render = "vdo-item-update.php?msgsuc=".$msgsuc;
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
			$render = "vdo-item-update.php?id=".$item->id."&msgerr=".$msgerr;
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