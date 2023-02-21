<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//error_reporting(1);
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
//require_once DIR."library/config/checksessionmember.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/extension.php";
require_once DIR."library/extension/utility.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/class/class.utility.php";
require_once DIR."library/phpmailer/src/Exception.php";
require_once DIR."library/phpmailer/src/PHPMailer.php";
require_once DIR."library/phpmailer/src/SMTP.php";
require_once DIR."library/Savant3.php";
?>
<?php
global $db;
#$db->debug=1;
#print_r($_POST);
#print_r($_SESSION);
//print_r($_GET);
//exit(0);
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);
	

$gettmp["do"] = Utility::getParam("do");
$gettmp["contact_name"] = Utility::getParam("contact_name");
$gettmp["contact_subject"] = Utility::getParam("contact_subject");
$gettmp["contact_tel"] = Utility::getParam("contact_tel");
$gettmp["contact_mail"] = Utility::getParam("contact_mail");
$gettmp["contact_message"] = Utility::getParam("contact_message");
$gettmp["accept_consent"] = Utility::getParam("accept_consent");
$gettmp["accept_policy"] = Utility::getParam("accept_policy",0);

$template = new Savant3();

ADOdb_Active_Record::SetDatabaseAdapter($db);
class contact_item extends ADOdb_Active_Record{}
class consent_item extends ADOdb_Active_Record{}


switch ($gettmp["do"]) {
  case "insert" :	
		$item = new contact_item();
		$item->contact_name = Utility::getParam("contact_name");
		$item->contact_subject = Utility::getParam("contact_subject");
		$item->contact_tel = Utility::getParam("contact_tel");
		$item->contact_mail = Utility::getParam("contact_mail");
		$item->contact_message = Utility::getParam("contact_message");
		$item->accept_consent = Utility::getParam("accept_consent",0);
		$item->accept_policy = Utility::getParam("accept_policy",0);

		$item->created_date = date("Y-m-d H:i:s");
		$item->modified_date = date("Y-m-d H:i:s");

		if ($item->save()) {
			$consent = new consent_item();
			$consent->accept_consent = Utility::getParam("accept_consent",0);
			$consent->accept_policy = Utility::getParam("accept_policy",0);
			$consent->email = Utility::getParam("contact_mail");
			$consent->member_id = NULL;
			$consent->created_date = date("Y-m-d H:i:s");	
			$consent->Save();
			
			session_destroy();
			unset($_SESSION);
			unset($_SESSION['register_frm']);
			unset($_SESSION['destroyed']);
			unset($_SESSION["session_invoice"]);
			unset($_SESSION["session_invoice"]["id"]);
			unset($_SESSION['order_item']);
			unset($_SESSION['session_login']);
			unset($_SESSION['session_guest']);
			$_SESSION['destroyed'] = time();     			 

			
			// Send mail activate
		if (true) { // Mail Process
			$mail = new PHPMailer();

			//$mail->IsSMTP();
			$mail->CharSet = "utf-8";	
			$mail->Host = $config["smtp_host"];
			$mail->Port = $config["smtp_port"];
			$mail->SMTPSecure = $config["smtp_secure"];
			$mail->SMTPAuth = $config["smtp_authen"];
			$mail->Username = $config["smtp_username"];
			$mail->Password = $config["smtp_password"];
		//	$mail->SMTPDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
			
			
			//$mail->SMTPAutoTLS = false;
			ob_start();
			$body = file_get_contents("tmpl-contact.htm");
			if ($body !== false) {
				$body = preg_replace("/&contact_name;/", $gettmp["contact_name"], $body);
				$body = preg_replace("/&contact_subject;/", $gettmp["contact_subject"], $body);
				$body = preg_replace("/&contact_tel;/", $gettmp["contact_tel"], $body);
				$body = preg_replace("/&contact_mail;/", $gettmp["contact_mail"], $body);
				$body = preg_replace("/&contact_message;/", $gettmp["contact_message"], $body);
				$body = preg_replace("/&post_date;/", date("d.m.Y H:i:s"), $body);
				$body = preg_replace("/&basesite;/", $config['website'], $body);
				$body = StripSlashes($body);
			}

			$mail->CharSet = "utf-8";
			$mail->From = $config["smtp_username"];
			$mail->FromName = "GHMLIB";
			$mail->Subject = "แจ้งการติดต่อผ่านเว็บไซต์ GHMLIB";

			$mail->IsHTML(true);
			$mail->MsgHTML($body);
			$mail->AddAddress("mr.katarwut@gmail.com");
			if (($config["mail_cc"] != null) && (sizeof($config["mail_cc"]) > 0)) {
				foreach ($config["mail_cc"] AS $email_temp) {
					$mail->AddCC($email_temp);
				}
			}
			if (($config["mail_bcc"] != null) && (sizeof($config["mail_bcc"]) > 0)) {
				foreach ($config["mail_bcc"] AS $email_temp) {
					$mail->AddBCC($email_temp);
				}
			}

			$mail->Send();
		}
			
			$msg = urlsafe_b64encode("Complete");
			$render = $config['website']."/la/enquiry-thank.php";
			echo "<meta http-equiv=\"refresh\" content=\"0;URL=$render?msg=$msg\" />";
			exit();
		} else {

		echo "<meta http-equiv=\"refresh\" content=\"0;URL=".$config['website']."/contact.php\" />";
		//echo "NOT SAVE";
		}

		//$template->member = $member;
		break;		
	default :
}

//$template->display($render);
?>