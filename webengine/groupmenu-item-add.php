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

$gettmp["parent_id"] = Utility::getParam("parent_id",0);
$gettmp["menu_id"] = Utility::getParam("menu_id", 0);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class menu_item extends ADOdb_Active_Record{}
class submenu_item extends ADOdb_Active_Record{}
class groupmenu_item extends ADOdb_Active_Record{}


$sql = "SELECT Count(id) AS amount FROM groupmenu_items WHERE parent_id = ? ";
$stmt = $db->Prepare($sql);
$val = $db->GetOne($stmt, array($gettmp["parent_id"]));
$gettmp["sequence"] = $val + 1;

$submenu = new submenu_item();
$submenu->Load("id = ? ", array($gettmp["parent_id"]));
$template->submenu = $submenu;

$menu = new menu_item();
$menu->Load("id = ? ", array($submenu->parent_id));
$template->menu = $menu;

$item = new groupmenu_item();
$item->parent_id = $gettmp["parent_id"];
$item->sequence = $gettmp["sequence"];
$item->published_date = date('Y/m/d');
$item->status = 0;
$template->item = $item;


$template->menu_id = $gettmp["menu_id"];
$template->parent_id = $gettmp["parent_id"];
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];
$template->display($render);
?>