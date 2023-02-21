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

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);

class user extends ADOdb_Active_Record{}
$item = new user();
$item->created_date = date('Y/m/j');
$item->status = 0;
$template->item = $item;

$sql = "SELECT i.id, i.title, '' AS tmp FROM user_types i WHERE 1 = 1 ORDER BY i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$typeList = $rs->GetAssoc();
$typeListCount = $rs->maxRecordCount();
$template->typeList = $typeList;
$template->typeListCount = $typeListCount;



$sql = "SELECT * FROM module_items i WHERE 1=1 AND i.status = 'Online' ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$modulelist = $rs->GetAssoc();
$template->modulelist = $modulelist;


$sql = "SELECT * FROM user_role_menus urm WHERE urm.user_id = ? ";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt, array($item->id));
$list = $rs->GetAssoc();
$roleMenuList = array();
foreach ($list AS $val) {
	$roleMenuList[] = $val['menu_id'];
}
$template->roleMenuList = $roleMenuList;

$sql = "SELECT * FROM user_role_subs urs WHERE urs.user_id = ? ";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt, array($item->id));
$list = $rs->GetAssoc();
$roleSubList = array();
foreach ($list AS $val) {
	$roleSubList[] = $val['menu_id'];
}
$template->roleSubList = $roleSubList;

$template->msgsuc = $gettmp["msgsuc"];
$template->msgerr = $gettmp["msgerr"];

$template->display($render);
?>