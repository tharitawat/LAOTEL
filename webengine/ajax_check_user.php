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

global $config;
global $db;

?>
<?php
#$db->debug=1;
$gettmp["email"] = ($_GET["email"] != null) ? $_GET["email"] : NULL;
$pattern = "^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$";
//$pattern = "^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$";
if ($gettmp["email"] != ""){
//  if (eregi($pattern, $gettmp["email"])) {
  if(filter_var($gettmp["email"], FILTER_VALIDATE_EMAIL)){	  
    $sql = "SELECT * FROM users WHERE users.email = ?  ";
    $stmt = $db->Prepare($sql);
    $rs = $db->Execute($stmt, array($gettmp["email"]));
    $list = $rs->GetAssoc();
    $listCount = $rs->maxRecordCount();
    if ($listCount == 1) {
      echo "<span style='color:#F00;'>อีเมลนี้ไม่สามารถใช้ซ้ำได้</span>";
      echo '<input type="hidden" name="conf_email" id="conf_email" value="false" />';
    } else {
      echo "<span style='color:#0C0;'>อีเมลนี้สามารถใช้งานได้</span>";
      echo '<input type="hidden" name="conf_email" id="conf_email" value="true" />';
    }
 
} else {
    echo "<span style='color:#F00;'>อีเมล์ที่ระบุไม่ตรงรูปแบบ</span>";
    echo '<input type="hidden" name="conf_email" id="conf_email" value="false" />';
  }
} else{
  echo "<span style='color:#F00;'>กรุณาระบุอีเมล์</span>";
    echo '<input type="hidden" name="conf_email" id="conf_email" value="false" />';
}
?>