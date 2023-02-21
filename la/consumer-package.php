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

$gettmp["id"] = Utility::getParam("id",1);
$gettmp["parent_id"] = Utility::getParam("parent_id",1);
$gettmp["main"] = Utility::getParam("main",1);
$gettmp["menu"] = Utility::getParam("menu",1);
$gettmp["submenu"] = Utility::getParam("submenu",1);
$gettmp["submenu_id"] = Utility::getParam("submenu_id",1);

$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class consumer_category extends ADOdb_Active_Record{}
class menu_item extends ADOdb_Active_Record{}
class submenu_item extends ADOdb_Active_Record{}
class consumer_layer extends ADOdb_Active_Record{}
class consumer_group extends ADOdb_Active_Record{}

$txt_submenu = new submenu_item();
$txt_submenu->Load("id = ? ", array($gettmp["submenu_id"]));
$template->txt_submenu = $txt_submenu;

$txt_menu = new menu_item();
$txt_menu->Load("id = ? ", array($txt_submenu->parent_id));
$template->txt_menu = txt_menu;
	
$layer = new consumer_layer();
$layer->Load("id = ? ", array($gettmp["id"]));
$template->layer = $layer;	

$group = new consumer_group();
$group->Load("id = ? ", array($layer->parent_id));
$template->group = $group;

$category = new consumer_category();
$category->Load("id = ? ", array($category->parent_id));
$template->category = $category;

$sql = "SELECT * FROM consumer_layers i WHERE 1 = 1 AND i.parent_id = ? ORDER BY i.sequence ASC, i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($group->id));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();
$template->itemList = $itemList;
$template->itemListCount = $itemListCount;

$sql = "SELECT * FROM consumer_service_layers i WHERE 1=1 AND i.parent_id =  ".$db->qstr($gettmp["id"])." "; 
$stmt = $db->Prepare($sql);
$row = $db->getRow($stmt);
$sort_order = $row["sort_order"];
$sequence = $row["sequence"];
$sort_by = $row["sort_by"];

switch($sort_order){	
	case'1': $sql_sort = "i.modified_date DESC"; $sort_txt = "Date Last Modified "; break;	
	case'4': $sql_sort = "i.sequence ASC"; $sort_txt = " Manual Sort";  break;	
	default: $sql_sort = "i.sequence ASC"; break;		
}

$sql = "SELECT i.*, NULL AS dummy 
FROM consumer_service_layers as i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ".$db->qstr($gettmp["id"])." ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$layerList = $rs->GetAssoc();
$layerListCount = $rs->maxRecordCount();
$template->layerList = $layerList;
$template->layerListCount = $layerListCount;

$sql = "SELECT * FROM consumer_service_files i WHERE 1=1 AND i.parent_id =  ".$db->qstr($gettmp["id"])." "; 
$stmt = $db->Prepare($sql);
$row = $db->getRow($stmt);
$sort_order = $row["sort_order"];
$sequence = $row["sequence"];
$sort_by = $row["sort_by"];

switch($sort_order){	
	case'1': $sql_sort = "i.modified_date DESC"; $sort_txt = "Date Last Modified "; break;	
	case'4': $sql_sort = "i.sequence ASC"; $sort_txt = " Manual Sort";  break;	
	default: $sql_sort = "i.sequence ASC"; break;		
}

$sql = "SELECT i.*, NULL AS dummy 
FROM consumer_service_files as i WHERE 1 = 1 AND i.status = '1' AND i.parent_id = ".$db->qstr($gettmp["id"])." ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$fileList = $rs->GetAssoc();
$fileListCount = $rs->maxRecordCount();
$template->fileList = $fileList;
$template->fileListCount = $fileListCount;


$sql = "SELECT DISTINCT i.title_la,i.id, NULL AS dummy FROM package_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$packageList = $rs->GetAssoc();
$packageListCount = $rs->maxRecordCount();
$template->packageList = $packageList;
$template->packageListCount = $packageListCount;

 
$sql = "SELECT * FROM menu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$menuList = $rs->GetAssoc();
$menuListCount = $rs->maxRecordCount();
$template->menuList = $menuList;
$template->menuListCount = $menuListCount;

$template->main = $gettmp["main"];
$template->menu = $gettmp["menu"];
$template->submenu = $gettmp["submenu"];
$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->submenu_id = $gettmp["submenu_id"];
$template->display($render);
?>
