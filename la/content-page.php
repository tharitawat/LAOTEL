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
//$db->debug = 1;
#print_r($_SESSION);
///exit();

$gettmp["id"] = Utility::getParam("id",1);
$gettmp["parent_id"] = Utility::getParam("parent_id",1);

$gettmp["main"] = Utility::getParam("main",1);
$gettmp["menu"] = Utility::getParam("menu",1);
$gettmp["submenu"] = Utility::getParam("submenu",1);

$gettmp["iddcall_key"] = Utility::getParam("iddcall_key");
$gettmp["brand_id"] = Utility::getParam("brand_id");
$gettmp["type"] = Utility::getParam("type",0);
$gettmp["country_id"] = Utility::getParam("country_id",0);

$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class consumer_category extends ADOdb_Active_Record{}
class consumer_layer extends ADOdb_Active_Record{}
class consumer_group extends ADOdb_Active_Record{}

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
	default: $sql_sort = "i.id ASC"; break;		
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
	default: $sql_sort = "i.id ASC"; break;		
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


$sql = "SELECT i.*, NULL AS dummy FROM datacloud_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$cloudList = $rs->GetAssoc();
$cloudListCount = $rs->maxRecordCount();
$template->cloudList = $cloudList;
$template->cloudListCount = $cloudListCount;

$sql = "SELECT DISTINCT i.title_la,i.id, NULL AS dummy FROM leaseline_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$leaselineList = $rs->GetAssoc();
$leaselineCount = $rs->maxRecordCount();
$template->leaselineList = $leaselineList;
$template->leaselineCount = $leaselineCount;


$sql = "SELECT i.*, NULL AS dummy FROM gpspackage_items i WHERE 1 = 1 AND i.status = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$gpsList = $rs->GetAssoc();
$gpsListCount = $rs->maxRecordCount();
$template->gpsList = $gpsList;
$template->gpsListCount = $gpsListCount;


$sql = "SELECT COUNT(i.id) AS roamingCount FROM roaming_items i WHERE 1=1 AND i.parent_id =  ".$db->qstr($gettmp["id"])." "; 
$stmt = $db->Prepare($sql);
$row = $db->getRow($stmt);
$template->roamingCount = $row["roamingCount"];

$sql = "SELECT i.*, NULL AS dummy FROM roaming_items i WHERE 1 = 1 AND i.status = '1' AND i.parent_id = ? AND i.type = ? AND i.country_id = ? ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id'],$gettmp['type'],$gettmp['country_id']));
$roamingList = $rs->GetAssoc();
$roamingListCount = $rs->maxRecordCount();
$template->roamingList = $roamingList;
$template->roamingListCount = $roamingListCount;

$sql = "SELECT i.*, NULL AS dummy FROM country_items i WHERE 1 = 1 ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$countryList = $rs->GetAssoc();
$countryListCount = $rs->maxRecordCount();
$template->countryList = $countryList;
$template->countryListCount = $countryListCount;

$sql = "SELECT i.*, NULL AS dummy FROM brand_items i WHERE 1 = 1 ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$brandList = $rs->GetAssoc();
$brandListCount = $rs->maxRecordCount();
$template->brandList = $brandList;
$template->brandListCount = $brandListCount;


$sql_iddcall = "";
if ($gettmp["iddcall_key"] != null) {
	$sql_iddcall = "AND CONCAT_WS('', i.country_name, i.country_code, i.country_value) LIKE ".$db->qstr("%".Utility::encodeToDB($gettmp["iddcall_key"])."%")." ";
	
}

$sql = "SELECT i.*, NULL AS dummy FROM iddcall_items i WHERE 1 = 1 AND i.status = '1' AND i.parent_id = ? ".$sql_iddcall." ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$iddcallList = $rs->GetAssoc();
$iddcallListCount = $rs->maxRecordCount();
$template->iddcallList = $iddcallList;
$template->iddcallListCount = $iddcallListCount;


$sql = "SELECT i.*, NULL AS dummy FROM wifiarea_items i WHERE 1 = 1 AND i.status = '1' AND i.parent_id = ? ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$wifiareaList = $rs->GetAssoc();
$wifiareaListCount = $rs->maxRecordCount();
$template->wifiareaList = $wifiareaList;
$template->wifiareaListCount = $wifiareaListCount;


$sql_brand = "";
if ($gettmp["brand_id"] != null) {
	$sql_brand = "AND  i.brand_id = ".$db->qstr($gettmp["brand_id"])." ";	
}

$sql = "SELECT i.*, NULL AS dummy FROM esim_items i WHERE 1 = 1 AND i.status = '1' AND i.type ='1' AND i.parent_id = ? ".$sql_brand." ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$esimList = $rs->GetAssoc();
$esimListCount = $rs->maxRecordCount();
$template->esimList1 = $esimList;
$template->esimListCount1 = $esimListCount;

$sql = "SELECT i.*, NULL AS dummy FROM esim_items i WHERE 1 = 1 AND i.status = '1' AND i.type ='2' AND i.parent_id = ? ".$sql_brand." ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$esimList = $rs->GetAssoc();
$esimListCount = $rs->maxRecordCount();
$template->esimList2 = $esimList;
$template->esimListCount2 = $esimListCount;

$sql = "SELECT i.*, NULL AS dummy FROM esim_items i WHERE 1 = 1 AND i.status = '1' AND i.parent_id = ? ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['id']));
$esimList = $rs->GetAssoc();
$esimListCount = $rs->maxRecordCount();
$template->esimList = $esimList;
$template->esimListCount = $esimListCount;


$sql = "SELECT i.*, NULL AS dummy FROM province_items i WHERE 1 = 1 ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$provinceList = $rs->GetAssoc();
$provinceListCount = $rs->maxRecordCount();
$template->provinceList = $provinceList;
$template->provinceListCount = $provinceListCount;

 
$sql = "SELECT i.* FROM menu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array('1'));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();

$id_main[] = array();
$menu_main[] = array();
foreach ($itemList as $val) {
	$id_main[] = $val['id'];
	$menu_main[] = $val['title_la'];
}
//print_r($id_main);
//print_r($menu_main);

$sql = "SELECT i.* FROM submenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($id_main[$gettmp["main"]]));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();

$id_sub[] = array();
$menu_sub[] = array();
foreach ($itemList as $sub) {
	$id_sub[] = $sub['id'];
	$menu_sub[] = $sub['title_la'];
}
//print_r($id_sub);
//print_r($menu_sub);


$sql = "SELECT i.* FROM groupmenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($id_sub[$gettmp["menu"]]));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();

$id_group[] = array();
$menu_group[] = array();
foreach ($itemList as $group) {
	$id_group[] = $group['id'];
	$menu_group[] = $group['title_la'];
}
//print_r($menu_group);

$template->menu_main = $menu_main;
$template->menu_sub = $menu_sub;
$template->menu_group = $menu_group;

$template->main = $gettmp["main"];
$template->menu = $gettmp["menu"];
$template->submenu = $gettmp["submenu"];
$template->id = $gettmp["id"];
$template->parent_id = $gettmp["parent_id"];
$template->iddcall_key = $gettmp["iddcall_key"];
$template->brand_id = $gettmp["brand_id"];
$template->display($render);
?>
