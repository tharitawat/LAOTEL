<?php
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
//require_once DIR."library/class/class.GenericEasyPagination.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/extension.php";
require_once DIR."library/extension/utility.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/config/rewrite.php";
?>
<?php
//$db->debug = 1;
//print_r($_GET);
$gettmp["type"] = ($_GET["type"] != null) ? $_GET["type"] : null;
$gettmp["id"] = ($_GET["id"] != null) ? $_GET["id"] : null;
$gettmp["status"] = ($_GET["status"] != null) ? $_GET["status"] : null;

switch($gettmp['type']){
		

case 'Cover' : $table_name = "cover_items"; $item_status = "status"; $item_id = "id"; $item_user = "modified_by";  break;	
case 'HeroBanner' : $table_name = "banner_items"; $item_status = "status"; $item_id = "id"; $item_user = "modified_by";  break;	
case 'News' : $table_name = "news_items"; $item_status = "status"; $item_id = "id"; $item_user = "modified_by";  break;	
		
default:	
}

$sql = "UPDATE ".$table_name." as p SET p.".$item_status." = '".$gettmp['status']."' , p.".$item_user." = '".$_SESSION["login_admin"]["username"]."'  WHERE  p.".$item_id." = '".$gettmp["id"]."' ";	
$stmt = $db->Prepare($sql);
$row = $db->GetRow($stmt);

?>
