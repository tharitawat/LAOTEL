<?php
//error_reporting(1);
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
?>
<?php
#$db->debug = 1;
#print_r($_SESSION);
///exit();

$gettmp["parent_id"] = Utility::getParam("parent_id",1);
$gettmp["submenu_id"] = Utility::getParam("submenu_id",1);

$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class consumer_category extends ADOdb_Active_Record{}
class menu_item extends ADOdb_Active_Record{}
class submenu_item extends ADOdb_Active_Record{}

$submenu = new submenu_item();
$submenu->Load("id = ? ", array($gettmp["submenu_id"]));
$template->submenu = $submenu;

$menu = new menu_item();
$menu->Load("id = ? ", array($submenu->parent_id));
$template->menu = $menu;
	
	
$category = new consumer_category();
$category->Load("id = ? ", array($gettmp["parent_id"]));
$template->category = $category;


$sql = "SELECT * FROM consumer_groups i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['parent_id']));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();
$template->itemList = $itemList;
$template->itemListCount = $itemListCount;

$template->parent_id = $gettmp["parent_id"];
$template->submenu_id = $gettmp["submenu_id"];
$template->display($render);
?>
