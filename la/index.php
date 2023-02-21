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
?>
<?php
#$db->debug = 1;
#print_r($_SESSION);
///exit();
$render = explode("/", $_SERVER["PHP_SELF"]);
foreach ($render as $val) if (strpos($val, ".php") !== false) $render = str_replace(".php", ".tpl.php", $val);

$template = new Savant3();
ADOdb_Active_Record::SetDatabaseAdapter($db);
 
$sql = "SELECT * FROM banner_items i WHERE 1=1 ";
$stmt = $db->Prepare($sql);
$row = $db->getRow($stmt);
$sort_order = $row["sort_order"];
$sequence = $row["sequence"];
$sort_by = $row["sort_by"];

switch($sort_order){	
	case'1': $sql_sort = "i.modified_date DESC"; $sort_txt = "Date Last Modified "; break;	
	case'4': $sql_sort = "i.sequence ASC"; $sort_txt = " Manual Sort";  break;	
	default: $sql_sort = "i.sequence ASC"; break;		
}

$sql = "SELECT * FROM banner_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$bannerList = $rs->GetAssoc();
$bannerListCount = $rs->maxRecordCount();
$template->bannerList = $bannerList;
$template->bannerListCount = $bannerListCount;

$sql = "SELECT * FROM pr_items i WHERE 1=1 ";
$stmt = $db->Prepare($sql);
$row = $db->getRow($stmt);
$sort_order = $row["sort_order"];
$sequence = $row["sequence"];
$sort_by = $row["sort_by"];

switch($sort_order){	
	case'1': $sql_sort = "i.modified_date DESC"; $sort_txt = "Date Last Modified "; break;	
	case'4': $sql_sort = "i.sequence ASC"; $sort_txt = " Manual Sort";  break;	
	default: $sql_sort = "i.id ASC"; break;		
}

$sql = "SELECT * FROM pr_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$prList = $rs->GetAssoc();
$prListCount = $rs->maxRecordCount();
$template->prList = $prList;
$template->prListCount = $prListCount;


$sql = "SELECT * FROM section_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' ORDER BY i.sequence ASC, i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$sectionList = $rs->GetAssoc();
$sectionListCount = $rs->maxRecordCount();
$template->sectionList = $sectionList;
$template->sectionListCount = $sectionListCount;

$sql = "SELECT * FROM vdo_items i WHERE 1 = 1 AND i.status = '1' AND i.id = '1' ";
$stmt = $db->Prepare($sql);
$row = $db->GetRow($stmt);
$template->vdo_title = $row['title_la'];
$template->vdo_url = $row['vdo_la'];
$template->vdo_image = $row['image'];

$sql = "SELECT * FROM special_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' ORDER BY i.sequence ASC, i.id ASC";
$stmt = $db->Prepare($sql);
$row = $db->GetRow($stmt);
$template->special_title = $row['title_la'];
$template->special_url = $row['url_la'];
$template->special_image = $row['image_la'];

$sql = "SELECT * FROM section_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.position_index = '1' ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$row = $db->GetRow($stmt);
$template->title_la1 = $row['title_la'];
$template->url_la1 = $row['url_la'];
$template->image_la1 = $row['image_la'];
$template->subject_la1 = $row['subject_la'];

$sql = "SELECT * FROM section_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.position_index = '2' ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$row = $db->GetRow($stmt);
$template->title_la2 = $row['title_la'];
$template->url_la2 = $row['url_la'];
$template->image_la2 = $row['image_la'];
$template->subject_la2 = $row['subject_la'];

$sql = "SELECT * FROM service_items i WHERE 1=1 ";
$stmt = $db->Prepare($sql);
$row = $db->getRow($stmt);
$sort_order = $row["sort_order"];
$sequence = $row["sequence"];
$sort_by = $row["sort_by"];

switch($sort_order){	
	case'1': $sql_sort = "i.modified_date DESC"; $sort_txt = "Date Last Modified "; break;	
	case'4': $sql_sort = "i.sequence ASC"; $sort_txt = " Manual Sort";  break;	
	default: $sql_sort = "i.sequence ASC"; break;		
}

$sql = "SELECT * FROM service_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = '1' ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$serviceList1 = $rs->GetAssoc();
$serviceListCount1 = $rs->maxRecordCount();
$template->serviceList1 = $serviceList1;
$template->serviceListCount1 = $serviceListCount1;

$sql = "SELECT * FROM service_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = '2' ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$serviceList2 = $rs->GetAssoc();
$serviceListCount2 = $rs->maxRecordCount();
$template->serviceList2 = $serviceList2;
$template->serviceListCount2 = $serviceListCount2;

$sql = "SELECT * FROM service_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = '3' ORDER BY ".$sql_sort;
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$serviceList3 = $rs->GetAssoc();
$serviceListCount3 = $rs->maxRecordCount();
$template->serviceList3 = $serviceList3;
$template->serviceListCount3 = $serviceListCount3;



$sql = "SELECT i.*,i.id as news_id  FROM news_items i 
INNER JOIN news_categories  c ON i.parent_id = c.id 
WHERE c.`status` = '1' AND c.`status_la` = '1' AND i.`status` = '1' AND i.`status_la` = '1' ORDER BY i.published_date DESC, i.id ASC Limit 2";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$newsList = $rs->GetAssoc();
$newsListCount = $rs->maxRecordCount();
$template->newsList = $newsList;
$template->newsListCount = $newsListCount;

$template->display($render);
?>
