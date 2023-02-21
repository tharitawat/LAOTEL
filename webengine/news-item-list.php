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
require_once DIR."library/extension/lang.php";
require_once DIR."library/class/class.utility.php";
require_once DIR."library/class/class.zebrapagination.php";
require_once DIR."library/Savant3.php";
?>
<?php
//$db->debug = 1;
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$gettmp["page"] = Utility::getParam("page", 1);
$gettmp["perpage"] = Utility::getParam("perpage", 20);
$gettmp["search_key"] = Utility::getParam("search_key");
$gettmp["date_begin"] = Utility::getParam("date_begin");
$gettmp["date_end"] = Utility::getParam("date_end");
$gettmp["msgsuc"] = Utility::getParam("msgsuc");
$gettmp["msgsuc"] = urlsafe_b64decode($gettmp["msgsuc"]);
$gettmp["msgerr"] = Utility::getParam("msgerr");
$gettmp["msgerr"] = urlsafe_b64decode($gettmp["msgerr"]);

$gettmp["parent_id"] = Utility::getParam("parent_id");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);

$sql_keyword = "";
if ($gettmp["search_key"] != null) {
	$sql_keyword = "AND CONCAT_WS('', i.title_en, i.title_la, title_cn, title_vi) LIKE ".$db->qstr("%".Utility::encodeToDB($gettmp["search_key"])."%")." ";
}

$sql_parent = "";
if($getmp['parent_id'] != ''){
	$sql_parent = "AND i.parent_id = " . $db->qstr($gettmp['parent_id']) . " ";
}

$date = $gettmp["date_begin"];
$sql_date_begin = "";
if ($date != null) {
	list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
	$date_str = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
	$sql_date_begin = "AND i.published_date >= ".$db->qstr($date_str." 00:00:00")." ";
}

$date = $gettmp["date_end"];
$sql_date_end = "";
if ($date != null) {
	list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
	$date_str = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
	$sql_date_end = "AND i.published_date <= ".$db->qstr($date_str." 23:59:59")." ";
}

$sql = "SELECT i.*, (SELECT Count(id) FROM news_layers t WHERE t.parent_id = i.id) AS layer_amount,
(SELECT Count(g.id) FROM news_galleries g WHERE g.parent_id = i.id) AS gallery_amount 
FROM news_items i WHERE 1 = 1 
".$sql_parent." 
".$sql_keyword." 
".$sql_date_begin." 
".$sql_date_end." 
ORDER BY i.sequence ASC, i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->PageExecute($stmt, $gettmp["perpage"], $gettmp["page"]);
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();
$template->itemList = $itemList;
$template->itemListCount = $itemListCount;

// Set Pagination
$pagination = new Zebra_Pagination();
$pagination->records($itemListCount);
$pagination->records_per_page($gettmp["perpage"]);
$template->pagination = $pagination;

$template->parent_id = $gettmp["parent_id"];
$template->page = $gettmp["page"];
$template->perpage = $gettmp["perpage"];
$template->search_key = $gettmp["search_key"];
$template->date_begin = $gettmp["date_begin"];
$template->date_end = $gettmp["date_end"];
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];

$template->display($render);
?>