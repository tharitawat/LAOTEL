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
require_once DIR."library/class/class.zebrapagination.php";
require_once DIR."library/Savant3.php";
?>
<?php
//$db->debug = 1;
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$gettmp["page"] = Utility::getParam("page", 1);
$gettmp["perpage"] = Utility::getParam("perpage", 20);
$gettmp["keyword"] = Utility::getParam("keyword");
$gettmp["date_begin"] = Utility::getParam("date_begin");
$gettmp["date_end"] = Utility::getParam("date_end");
$gettmp["msgsuc"] = Utility::getParam("msgsuc");
$gettmp["msgsuc"] = urlsafe_b64decode($gettmp["msgsuc"]);
$gettmp["msgerr"] = Utility::getParam("msgerr");
$gettmp["msgerr"] = urlsafe_b64decode($gettmp["msgerr"]);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);

$sql_keyword = "";
if ($gettmp["keyword"] != null) {
	$sql_keyword = "AND CONCAT_WS('', u.fullname, t.title, u.username, u.email, u.phone, u.code) LIKE ".$db->qstr("%".Utility::encodeToDB($gettmp["keyword"])."%")." ";
}

$date = $gettmp["date_begin"];
$sql_date_begin = "";
if ($date != null) {
	list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
	$date_str = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
	$sql_date_begin = "AND i.created_date >= ".$db->qstr($date_str." 00:00:00")." ";
}

$date = $gettmp["date_end"];
$sql_date_end = "";
if ($date != null) {
	list($gettmp["year"], $gettmp["month"], $gettmp["day"],) = explode("/", $date);
	$date_str = date("Y-m-d", strtotime($gettmp["year"]."-".$gettmp["month"]."-".$gettmp["day"]));
	$sql_date_end = "AND i.created_date <= ".$db->qstr($date_str." 23:59:59")." ";
}

$sql = "
SELECT u.*, t.title AS type_title
FROM users u 
LEFT JOIN user_types t ON t.id = u.type
WHERE 1 = 1 
".$sql_keyword."
".$sql_date_begin."
".$sql_date_end."
ORDER BY u.id ASC 
";
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

$template->page = $gettmp["page"];
$template->perpage = $gettmp["perpage"];
$template->keyword = $gettmp["keyword"];
$template->date_begin = $gettmp["date_begin"];
$template->date_end = $gettmp["date_end"];
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];

$template->display($render);
?>