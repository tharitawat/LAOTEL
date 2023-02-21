<?php
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

require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;
//$db->debug = 1;

$gettmp["id"] = Utility::getParam("id",1);
$gettmp["parent_id"] = Utility::getParam("parent_id",1);


 
$category = new consumer_category();
$category->Load("id = ? ", array($gettmp["parent_id"]));

$sql = "SELECT * FROM consumer_groups i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array($gettmp['parent_id']));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();

?>
<div class="left-menu-fix">
	<?php $i=0;?>
	<?php foreach($itemList as $menu){ ?>
	<?php $i++; ?>
	<?php
		$sql = "SELECT * FROM consumer_layers i WHERE 1 = 1 AND i.parent_id = '".$menu['id']."' ORDER BY i.sequence ASC, i.id ASC";
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt);
		$layerList = $rs->GetAssoc();
		$layerListCount = $rs->maxRecordCount();
	?>
  <div class="left-menu-title">

    <div class="bg-logo-title" id="sidebar-menu-main-<?=$i?>" onclick="toggleDropdownMenu(<?=$i?>)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-<?=$i?>" class="dropdown-logo">
			<img src="<?=$config['website']?>/img_consumer_group/<?=$menu['image']?>" alt="" class="bright-white">  
          </div>
          <p id="logo-title-active-<?=$i?>"><?=$menu['title_la']?></p>
        </div>
        <div class="arrow-drop">
          <img src="./images/undrop.svg" id="arrow-left-drop-1" alt="arrow drop" />
        </div>
      </div>
    </div>

    <div id="dropdown-left-<?=$i?>" class="dropdown-left">
	  <?php $x=0; ?>	
	  <?php foreach($layerList as $service){ ?>	
	  <?php $x++; ?>	
      <a href="consumer-package.php?id=<?=$service['id']?>&parent_id=2&submenu_id=2" class="left-menu-dropdown" id="left-menu-dropdown-<?=$i?>-<?=$x?>">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="<?=$config['website']?>/img_service/group/<?=$service['image_icon']?>" class="bright-white" alt="<?=$service['title_la']?>">
          </div>
          <p><?=$service['title_la']?></p>
        </div>
      </a>
      <?php } ?>      
    </div>
  </div>
	<?php } ?>
  <!--	
  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-2" onclick="toggleDropdownMenu(2)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-2" class="dropdown-logo">
            <img src="./images/promotion-inactive.svg" alt="open a new number" class="bright-white" />
          </div>
          <p id="logo-title-active-2">Promotion</p>
        </div>
        <div class="arrow-drop">
          <img src="./images/undrop.svg" alt="arrow drop" id="arrow-left-drop-2" />
        </div>
      </div>
    </div>
    <div id="dropdown-left-2" class="dropdown-left">
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-2-1">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/Promotion-Package-Internet.svg" alt="Promotion Package Internet" class="bright-white">
          </div>
          <p>Promotion Package Internet</p>
        </div>
      </a>
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-2-2">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/Activate-a-new-number.svg" alt="Net sim" class="bright-white">
          </div>
          <p>Activate a new number</p>
        </div>
      </a>
    </div>
  </div>

  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-3" onclick="toggleDropdownMenu(3)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-3" class="dropdown-logo">
            <img src="./images/top-up-inactive.svg" alt="open a new number" class="bright-white" />
          </div>
          <p id="logo-title-active-3">Top Up</p>
        </div>
        <div class="arrow-drop">
          <img id="arrow-left-drop-3" src="./images/undrop.svg" alt="arrow drop" />
        </div>
      </div>
    </div>
    <div class="dropdown-left" id="dropdown-left-3">
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-3-1">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/package-Great-value.svg" alt="package Great value" class="bright-white">
          </div>
          <p>package Great value</p>
        </div>
      </a>
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-3-2">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/package-social.svg" alt="package social" class="bright-white">
          </div>
          <p>package social</p>
        </div>
      </a>
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-3-3">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/package-IR.svg" alt="Tourist sim" class="bright-white">
          </div>
          <p>package IR</p>
        </div>
      </a>
    </div>
  </div>

  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-4" onclick="toggleDropdownMenu(4)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-4" class="dropdown-logo">
            <img src="./images/Prepaid-inactive.svg" alt="open a new number" class="bright-white" />
          </div>
          <p id="logo-title-active-4">Prepaid</p>
        </div>
        <div class="arrow-drop">
          <img id="arrow-left-drop-4" src="./images/undrop.svg" alt="arrow drop" />
        </div>
      </div>
    </div>
    <div class="dropdown-left" id="dropdown-left-4">
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-4-1">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/top-up-card.svg" alt="top up card" class="bright-white img-over-scale">
          </div>
          <p>top up card</p>
        </div>
      </a>
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-4-2">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/M-top-up.svg" alt="M top up" class="bright-white">
          </div>
          <p>M top up</p>
        </div>
      </a>
      <a href="#" class="left-menu-dropdown" id="left-menu-dropdown-4-3">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/m-money-icon-red.svg" alt="M money" class="img-over-scale bright-white">
          </div>
          <p>M money</p>
        </div>
      </a>
    </div>
  </div>
  -->	

</div>