<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
#error_reporting(1);
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/extension.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/class/class.utility.php";
require_once DIR."library/class/class.upload.php";
require_once DIR."library/Savant3.php";
//require_once DIR."library/class/class.phpmailer.php";
require_once DIR."library/phpmailer/src/Exception.php";
require_once DIR."library/phpmailer/src/PHPMailer.php";
require_once DIR."library/phpmailer/src/SMTP.php";
?>
<?php
#$db->debug = 1;
#print_r($_SESSION);
///exit();


$render = explode("/", $_SERVER["PHP_SELF"]);
$render = str_replace(".php", ".tpl.php", end($render));

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);


$template->display($render);
?>
