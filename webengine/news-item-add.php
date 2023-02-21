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

$gettmp["parent_id"] = Utility::getParam("parent_id");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class news_item extends ADOdb_Active_Record{}

$sql = "SELECT Count(id) AS amount FROM news_items WHERE parent_id = ? ";
$stmt = $db->Prepare($sql);
$val = $db->GetOne($stmt, array($gettmp["parent_id"]));
$gettmp["sequence"] = $val + 1;

$item = new news_item();
$item->parent_id = $gettmp["parent_id"];
$item->sequence = $gettmp["sequence"];
$item->published_date = date('Y/m/d');
$item->status = 0;
$template->item = $item;

$sql = "SELECT * FROM news_categories i WHERE 1=1 ";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$categoryList = $rs->GetAssoc();
$categoryListCount = $rs->maxRecordCount();
$template->categoryList = $categoryList;
$template->categoryListCount = $categoryListCount;

$template->parent_id = $gettmp["parent_id"];
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];
$template->display($render);
?>