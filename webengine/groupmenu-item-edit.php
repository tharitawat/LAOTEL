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
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$gettmp["msgsuc"] = Utility::getParam("msgsuc");
$gettmp["msgsuc"] = urlsafe_b64decode($gettmp["msgsuc"]);
$gettmp["msgerr"] = Utility::getParam("msgerr");
$gettmp["msgerr"] = urlsafe_b64decode($gettmp["msgerr"]);

$gettmp["id"] = Utility::getParam("id");
$gettmp["parent_id"] = Utility::getParam("parent_id",0);
$gettmp["menu_id"] = Utility::getParam("menu_id", 0);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class menu_item extends ADOdb_Active_Record{}
class submenu_item extends ADOdb_Active_Record{}
class groupmenu_item extends ADOdb_Active_Record{}


$item = new groupmenu_item();
$item->Load("id = ? ", array($gettmp["id"]));
$template->item = $item;

$submenu = new submenu_item();
$submenu->Load("id = ? ", array($item->parent_id));
$template->submenu = $submenu;

$menu = new menu_item();
$menu->Load("id = ? ", array($submenu->parent_id));
$template->menu = $menu;


$template->id = $gettmp["id"];
$template->menu_id = $gettmp["menu_id"];
$template->parent_id = $item->parent_id;
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];
$template->display($render);
?>