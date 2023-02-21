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
$gettmp["parent_id"] = Utility::getParam("parent_id");
$gettmp["province_id"] = Utility::getParam("province_id");

$gettmp["main"] = Utility::getParam("main",1);
$gettmp["menu"] = Utility::getParam("menu",1);
$gettmp["submenu"] = Utility::getParam("submenu",1);


$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);

$sql_zone = "";
if($gettmp['parent_id'] != ''){ 
$sql_zone = "AND i.zone_id = '".$gettmp['parent_id']."' ";
}

$sql_province = "";
if($gettmp['province_id'] != ''){ 
$sql_province = "AND i.province_id = '".$gettmp['province_id']."' ";
}


$sql = "SELECT * FROM province_items i WHERE 1 = 1 ".$sql_zone." ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$provinceList = $rs->GetAssoc();
$provinceListCount = $rs->maxRecordCount();
$template->provinceList = $provinceList;
$template->provinceListCount = $provinceListCount;

$sql = "SELECT * FROM branch_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' ".$sql_province." ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();
$template->itemList = $itemList;
$template->itemListCount = $itemListCount;


$template->main = $gettmp["main"];
$template->menu = $gettmp["menu"];
$template->submenu = $gettmp["submenu"];
$template->parent_id = $gettmp['parent_id'];
$template->province_id = $gettmp['province_id'];
$template->display($render);
?>
