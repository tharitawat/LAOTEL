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

$gettmp["parent_id"] = Utility::getParam("parent_id");

$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);

$sql = "SELECT * FROM news_categories i WHERE 1=1 "; 
$stmt = $db->Prepare($sql);
$row = $db->getRow($stmt);
$sort_order = $row["sort_order"];
$sequence = $row["sequence"];
$sort_by = $row["sort_by"];

switch($sort_order){	
	case'1': $sql_sort = "i.modified_date DESC"; $sort_txt = "Date Last Modified "; break;	
	case'4': $sql_sort = "i.sequence ASC"; $sort_txt = " Manual Sort";  break;	
	default: $sql_sort = "i.id  DESC"; break;		
}
$template->sort_order = $row["sort_order"];	
$template->sort_txt = $sort_txt;

$sql = "SELECT * FROM news_categories i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$newsList = $rs->GetAssoc();
$newsListCount = $rs->maxRecordCount();
$template->newsList = $newsList;
$template->newsListCount = $newsListCount;

$id[] = array();
foreach($newsList as $list){
	$id[] = $list['id'];
}

$gettmp["parent_id"] = ($gettmp["parent_id"] != '') ? $gettmp["parent_id"] : $id[1];

$sql = "SELECT i.*,i.id AS news_id FROM news_items i 
INNER JOIN news_category_relates r ON r.parent_id = i.id
WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND r.cate_id = ? ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp["parent_id"]));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();
$template->itemList = $itemList;
$template->itemListCount = $itemListCount;

$template->parent_id = $gettmp["parent_id"];
$template->display($render);
?>
