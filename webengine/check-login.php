<?php
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
//require_once DIR."library/config/checksessionlogin.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/utility.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/class/class.utility.php";
require_once DIR."library/extension/extension.php";
require_once DIR."library/Savant3.php";
?>
<?php
//$db->debug = 1;
$render = "login.php";
//print_r($_POST);
//exit();

ADOdb_Active_Record::SetDatabaseAdapter($db);

if (!empty($_REQUEST["do"])) {
	$gettmp["email"] = Utility::getParam("email");
	$gettmp["password"] = Utility::getParam("password");
	$gettmp["password"] = Utility::hash($gettmp["password"]);
	$gettmp["secure_code"] = Utility::getParam("secure_code");
	
	class user extends ADOdb_Active_Record{}
	$user = new user();
	$user->load("email = ? ", array($gettmp["email"]));
	
    if (false) { // if ($gettmp["secure_code"] != $_SESSION["captcha_code"]) {
	    unset($_SESSION["login"]);
	    unset($_SESSION["login_admin"]);
	    
	    $msg = urlsafe_b64encode("ท่านกรอกรหัสรูปภาพไม่ถูกต้อง");
	    $render = "login.php";
    } elseif ($user->id == null) {
	    unset($_SESSION["login"]);
	    unset($_SESSION["login_admin"]);
	    
		Lang::saveSystemLog($gettmp["email"],'ไม่พบ email นี้ในระบบ',$_SESSION["login_admin"]["id"]);

		
	    $msg = urlsafe_b64encode("ไม่พบ email นี้ในระบบ");
	    $render = "login.php";
    } elseif ($user->status != 1) {
	    unset($_SESSION["login"]);
	    unset($_SESSION["login_admin"]);
	 
		Lang::saveSystemLog($gettmp["email"],'email นี้ถูกระงับการใช้งาน',$_SESSION["login_admin"]["id"]);
		
	    $msg = urlsafe_b64encode("Username นี้ถูกระงับการใช้งาน");
	    $render = "login.php";
    } elseif (($user->id != 1) && ($user->expired_date != null) && ($user->expired_date <= date("Y-m-d"))) {
	    unset($_SESSION["login"]);
	    unset($_SESSION["login_admin"]);
	    
	    $msg = urlsafe_b64encode("email นี้หมดอายุการใช้งาน");
	    $render = "login.php";
    } elseif ($user->password != $gettmp["password"]) {
	    unset($_SESSION["login"]);
	    unset($_SESSION["login_admin"]);
	    
		Lang::saveSystemLog($gettmp["email"],'Password ไม่ถูกต้อง',$_SESSION["login_admin"]["id"]);
		
		
	    $msg = urlsafe_b64encode("Password ไม่ถูกต้อง");
	    $render = "login.php";
    } else {
	    $_SESSION["login"] = true;
	    $_SESSION["login_admin"]["id"] = $user->id;
	    $_SESSION["login_admin"]["username"] = $user->username;
	    $_SESSION["login_admin"]["fullname"] = $user->fullname;
	    $_SESSION["login_admin"]["email"] = $user->email;
	    $_SESSION["login_admin"]["phone"] = $user->phone;
	    $_SESSION["login_admin"]["lastlogin_date"] = $user->lastlogin_date;
	    $_SESSION["login_admin"]["type"] = $user->type;
		
		$sql = "SELECT * FROM user_role_menus urm WHERE urm.user_id = ? ";
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($user->id));
		$list = $rs->GetAssoc();
		$roleMenuList = array();
		foreach ($list AS $val) {
			$roleMenuList[] = $val['menu_id'];
		}
		$_SESSION["login_admin"]["roleMenuList"] = $roleMenuList;
		
		$sql = "SELECT * FROM user_role_subs urs WHERE urs.user_id = ? ";
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt, array($user->id));
		$list = $rs->GetAssoc();
		$roleSubList = array();
		foreach ($list AS $val) {
			$roleSubList[] = $val['menu_id'];
		}
		$_SESSION["login_admin"]["roleSubList"] = $roleSubList;
	    
	    $user->lastlogin_date = date("Y-m-d H:i:s");
	    $user->Replace();

		Lang::saveSystemLog($gettmp["username"],'เข้าสู่ระบบ',$_SESSION["login_admin"]["id"]);
		
		
	    $render = "dashboard.php";
	}
}

die("<meta http-equiv=\"refresh\" content=\"0; URL=$render?msg=$msg\">");
?>