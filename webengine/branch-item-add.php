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
$gettmp["province_id"] = Utility::getParam("province_id");


$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class branch_item extends ADOdb_Active_Record{}

$sql = "SELECT Count(id) AS amount FROM branch_items WHERE province_id = ? ";
$stmt = $db->Prepare($sql);
$val = $db->GetOne($stmt, array($gettmp["province_id"]));
$gettmp["sequence"] = $val + 1;

$item = new branch_item();
$item->parent_id = $gettmp["parent_id"];
$item->sequence = $gettmp["sequence"];
$item->published_date = date('Y/m/d');
$item->status = 0;
$template->item = $item;

$sql_zone = "";
if($gettm['parent_id'] != ''){ 
$sql_zone = "AND i.parent_id = '".$gettmp['parent_id']."' ";
}

$sql = "SELECT * FROM province_items i WHERE 1 = 1 ".$sql_zone." ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$provinceList = $rs->GetAssoc();
$provinceListCount = $rs->maxRecordCount();
$template->provinceList = $provinceList;
$template->provinceListCount = $provinceListCount;

$template->province_id = $gettmp["province_id"];
$template->parent_id = $gettmp["parent_id"];
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];
$template->display($render);
?>