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

$gettmp["parent_id"] = Utility::getParam("parent_id", 1);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);

$sql_keyword = "";
if ($gettmp["search_key"] != null) {
	$sql_keyword = "AND CONCAT_WS('', i.title_en, i.title_la, title_cn, title_vi) LIKE ".$db->qstr("%".Utility::encodeToDB($gettmp["search_key"])."%")." ";
}

$sql = "SELECT i.*, (SELECT Count(id) FROM submenu_items t WHERE t.parent_id = i.id) AS menu_amount FROM menu_items i WHERE 1 = 1 AND i.parent_id = ? 
".$sql_keyword."
ORDER BY i.sequence ASC, i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->PageExecute($stmt, $gettmp["perpage"], $gettmp["page"],array($gettmp["parent_id"]));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();
$template->itemList = $itemList;
$template->itemListCount = $itemListCount;

// Set Pagination
$pagination = new Zebra_Pagination();
$pagination->records($itemListCount);
$pagination->records_per_page($gettmp["perpage"]);
$template->pagination = $pagination;

$template->menu_id = $gettmp["parent_id"];
$template->parent_id = $gettmp["parent_id"];
$template->page = $gettmp["page"];
$template->perpage = $gettmp["perpage"];
$template->search_key = $gettmp["search_key"];
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];

$template->display($render);
?>