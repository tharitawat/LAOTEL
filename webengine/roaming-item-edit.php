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

$gettmp["id"] = Utility::getParam("id");

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
class roaming_item extends ADOdb_Active_Record{}
class consumer_category extends ADOdb_Active_Record{}
class consumer_group extends ADOdb_Active_Record{}
class consumer_layer extends ADOdb_Active_Record{}

$item = new roaming_item();
$item->Load("id = ? ", array($gettmp["id"]));
$template->item = $item;

$layer = new consumer_layer();
$layer->Load("id = ? ", array($item->parent_id));
$template->layer = $layer;

$group = new consumer_group();
$group->Load("id = ? ", array($layer->parent_id));
$template->group = $group;

$cate = new consumer_category();
$cate->Load("id = ? ", array($group->parent_id));
$template->cate = $cate;

$sql = "SELECT * FROM country_items b WHERE 1 = 1 ORDER BY b.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$countryList = $rs->GetAssoc();
$countryListCount = $rs->maxRecordCount();
$template->countryList = $countryList;
$template->countryListCount = $countryListCount;

$template->id = $gettmp["id"];
$template->parent_id = $item->parent_id;
$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];

$template->display($render);
?>