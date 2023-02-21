<?php
//error_reporting(1);
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
//require_once DIR."library/config/checksessionlogin.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/utility.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/class/class.utility.php";
?>
<?php
//$db->debug = 1;

ADOdb_Active_Record::SetDatabaseAdapter($db);

unset($_SESSION["login"]);
unset($_SESSION["login_admin"]);
session_destroy();

Lang::saveSystemLog($_SESSION["login_admin"]["username"],'ออกจากระบบ',$_SESSION["login_admin"]["id"]);

die("<meta http-equiv=\"refresh\" content=\"0; URL=index.php\">");
?>