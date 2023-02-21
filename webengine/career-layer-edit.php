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
require_once DIR."library/class/class.utility.php";
require_once DIR."library/Savant3.php";
?>
<?php
//$db->debug = 1;
$render = explode("/", $_SERVER["PHP_SELF"]);
$render = str_replace(".php", ".tpl.php", end($render));

$gettmp["msgsuc"] = Utility::getParam("msgsuc");
$gettmp["msgsuc"] = urlsafe_b64decode($gettmp["msgsuc"]);
$gettmp["msgerr"] = Utility::getParam("msgerr");
$gettmp["msgerr"] = urlsafe_b64decode($gettmp["msgerr"]);

$gettmp["id"] = Utility::getParam("id");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class career_layer extends ADOdb_Active_Record{}
class career_item extends ADOdb_Active_Record{}
class career_category extends ADOdb_Active_Record{}

$item = new career_layer();
$item->Load("id = ? ", array($gettmp['id']));
$template->item = $item;

$career = new career_item();
$career->Load("id = ? ", array($item->parent_id));
$template->career = $career;

$cate = new career_category();
$cate->Load("id = ? ", array($career->parent_id));
$template->cate = $cate;

$template->id = $gettmp["id"];
$template->parent_id = $item->parent_id;
$template->cate_id = $cate->id;
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];
$template->display($render);
?>