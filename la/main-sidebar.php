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

$sql = "SELECT i.* FROM menu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt,array('1'));
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();
						
?>
<div class="left-menu-fix">
<?php $i = 0; ?>
<?php foreach ($itemList as $val) { ?>
<?php $i++;?>	
  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-<?=$i?>" onclick="toggleDropdownMenu(<?=$i?>)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-<?=$i?>" class="dropdown-logo">
            <img src="../img_menu/<?=$val['image']?>" alt="<?=$val['title_la']?>" class="bright-white" />
          </div>
          <p id="logo-title-active-<?=$i?>"><?=$val['title_la']?></p>
        </div>
        <div class="arrow-drop">
          <img src="./images/undrop.svg" id="arrow-left-drop-<?=$i?>" alt="arrow drop" />
        </div>
      </div>
    </div>
	<?php
		$sql = "SELECT i.* FROM submenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
		$stmt = $db->Prepare($sql);
		$rs = $db->Execute($stmt,array($val['id']));
		$subList = $rs->GetAssoc();
		$subListCount = $rs->maxRecordCount();

	?>		
	<?php if($subListCount > 0){ ?>	
	  <div id="dropdown-left-<?=$i?>" class="dropdown-left"> 
	 <?php $x = 0; ?>
	<?php foreach ($subList as $sub) { ?>
	<?php $x++;?>
	<?php
	$sql = "SELECT i.* FROM groupmenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
	$stmt = $db->Prepare($sql);
	$rs = $db->Execute($stmt,array($sub['id']));
	$groupList = $rs->GetAssoc();
	$groupListCount = $rs->maxRecordCount();

	?>	 
   
	   <?php if($groupListCount > 0){ ?>	
      <div class="secondDropdown">
		  <div id="sidebar-dropdown-menu-main-<?=$i?>-<?=$x?>" onclick="setActiveDropdownInSideMenu(<?=$i?>,<?=$x?>)">
          <div  class="left-menu-dropdown" id="left-menu-dropdown-<?=$i?>-<?=$x?>">
            <div class="dropdown-logo-title">
              <div class="dropdown-logo">
                <img src="../img_submenu/<?=$sub['image']?>" class="bright-white" alt="<?=$sub['title_la']?>">
              </div>
              <p class="dropdown-logo-title-active"><?=$sub['title_la']?></p>
            </div>
    		
            <div class="arrow-drop">
              <img src="./images/undrop.svg" id="arrow-left-dropdown-in-dropdown-<?=$i?>-<?=$x?>" alt="arrow drop" />
            </div>
    		
          </div>
          </div>  		 
			  
				 <div id="dropdown-in-dropdown-left-<?=$i?>-<?=$x?>" class="dropdown-left dropdown-left-in-dropdown">
					 <?php $y = 0; ?>
			  <?php foreach ($groupList as $group) { ?>
			  <?php $y++;?>
			  <?php 
					$list = explode('?',$group['url_la']); 
					if($group['url_la'] == ''){
						$gettmp['url_la'] = 'javascript:void(0);';				
					}else if($list[1] !=''){
						//echo $list[1];	
						$gettmp['url_la'] = $config['website']."/la/".$group['url_la']."&main=".$i."&menu=".$x."&submenu=".$y;
					}else{
						//echo $list[0];	
						$gettmp['url_la'] = $config['website'].'/la/'.$group['url_la'].'?main='.$i.'&menu='.$x."&submenu=".$y;
					}												
				?>  
					<a href="<?=$gettmp['url_la']?>" class="third-dropdown-left" >
					<!-- consumer-package.php?id=15&parent_id=5&main=1&menu=1&submenu=1 -->
						 <div id="left-menu-dropdown-in-dropdown-<?=$i?>-<?=$x?>-<?=$y?>" class="left-menu-dropdown">
						  <div class="dropdown-logo-title"  >
							<div class="dropdown-in-dropdown-logo">
							  <img src="../img_submenu/<?=$group['image']?>" class="bright-white" alt="<?=$group['title_la']?>">
							</div>
							<p class="dropdown-logo-title-active" ><?=$group['title_la']?></p>
						  </div>
						</div>
					  </a>          
				 <?php } ?>	 
				  </div>
			 
      </div>
	   <?php }else{ ?>
		   <?php 
			$list = explode('?',$sub['url_la']); 
			if($sub['url_la'] == ''){
				$gettmp['url_la'] = 'javascript:void(0);';				
			}else if($list[1] !=''){
				//echo $list[1];	
				$gettmp['url_la'] = $config['website']."/la/".$sub['url_la']."&main=".$i."&menu=".$x;
			}else{
				//echo $list[0];	
				$gettmp['url_la'] = $config['website'].'/la/'.$sub['url_la'].'?main='.$i.'&menu='.$x;
			}												
			?> 
		  
		  <a href="<?=$gettmp['url_la']?>" class="left-menu-dropdown" id="left-menu-dropdown-<?=$i?>-<?=$x?>">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
           <img src="../img_submenu/<?=$sub['image']?>" class="bright-white" alt="<?=$sub['title_la']?>">
          </div>
          <p><?=$sub['title_la']?></p>
        </div>
      </a>
	  <?php } ?>
		<?php }// for sub ?> 
    </div>
	  
	  
	<?php } ?>  
  </div>
<?php } ?>
  
<!--
  <div class="left-menu-title">

   <div class="bg-logo-title" id="sidebar-menu-main-2" onclick="toggleDropdownMenu(2)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-2" class="dropdown-logo">
            <img src="./images/Wired-Internet.svg" alt="Wired Internet" class="bright-white" />
          </div>
          <p id="logo-title-active-2">Wired Internet</p>
        </div>
        <div class="arrow-drop">
          <img src="./images/undrop.svg" alt="arrow drop" id="arrow-left-drop-2" />
        </div>
      </div>
    </div>
    
    <div id="dropdown-left-2" class="dropdown-left">
      <div class="secondDropdown">
    
        <div id="sidebar-dropdown-menu-main-2-1" onclick="setActiveDropdownInSideMenu(2,1)">
          <div class="left-menu-dropdown" id="left-menu-dropdown-2-1">
          <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/ftth.svg" alt="Home Digital Phone" class="bright-white">

          </div>
          <p class="dropdown-logo-title-active" >FIBER TO THE HOME<br>(FTTH)</p>
         </div>
    
            <div class="arrow-drop">
              <img src="./images/undrop.svg" id="arrow-left-dropdown-in-dropdown-2-1" alt="arrow drop" />
            </div>
    
          </div>
        </div>
    
          <div id="dropdown-in-dropdown-left-2-1" class="dropdown-left dropdown-left-in-dropdown">
            <a href="<?=$config['website']?>/la/consumer-package.php?id=32&parent_id=10&main=2&menu=1&submenu=1" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-1-1">
            <div class="dropdown-logo-title">
              <div class="dropdown-in-dropdown-logo">
                <img src="./images/ftth.svg" class="" alt="M phone">
              </div>
              <p>FTTH</p>
            </div>
            </a>

            <a href="<?=$config['website']?>/la/consumer-package.php?id=33&parent_id=11&main=2&menu=1&submenu=2" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-1-2">
              <div class="dropdown-logo-title">
                <div class="dropdown-logo">
                  <img src="./images/new-customer.svg" class="bright-white" alt="M phone">
                </div>
                <p>NEW CONSUMER</p>
              </div>
            </a>
        
            <a href="<?=$config['website']?>/la/consumer-package.php?id=34&parent_id=12&main=2&menu=1&submenu=3" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-1-3">
              <div class="dropdown-logo-title">
                <div class="dropdown-logo">
                  <img src="./images/person-icon.svg" alt="Net sim" class="bright-white">
                </div>
                <p>CURRENT CUSTOMER</p>
              </div>
            </a>
      
            <a href="<?=$config['website']?>/la/consumer-package.php?id=35&parent_id=13&main=2&menu=1&submenu=4" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-1-4">
              <div class="dropdown-logo-title">
                <div class="dropdown-logo">
                  <img src="./images/package.svg" alt="Tourist sim" class="bright-white">
                </div>
                <p>PACKAGES</p>
              </div>
            </a>

            <a href="<?=$config['website']?>/la/consumer-package.php?id=36&parent_id=14&main=2&menu=1&submenu=5" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-1-5">
              <div class="dropdown-logo-title">
                <div class="dropdown-logo">
                  <img src="./images/mobile-icon-red.svg" alt="auspicious number" class="bright-white">
                </div>
                <p>EQUIPMENT</p>
              </div>
            </a>
      


          </div>
         
      </div>
    
      <div class="secondDropdown">
        <div id="sidebar-dropdown-menu-main-2-2" onclick="setActiveDropdownInSideMenu(2,2)">
          <div class="left-menu-dropdown" id="left-menu-dropdown-2-1">
          <div class="dropdown-logo-title">
          <div id="dropdown-logo-inactive-2" class="dropdown-logo" style="padding: 10px">
            <img src="./images/wifi.svg" alt="open a new number" class="bright-white" />
          </div>
          <p id="logo-title-active-2" class="dropdown-logo-title-active">WIFI OFFLOAD</p>
         </div>
    
            <div class="arrow-drop">
              <img src="./images/undrop.svg" id="arrow-left-dropdown-in-dropdown-2-2" alt="arrow drop" />
            </div>
    
          </div>
        </div>
    
          <div id="dropdown-in-dropdown-left-2-2" class="dropdown-left dropdown-left-in-dropdown">
          <a href="<?=$config['website']?>/la/consumer-package.php?id=37&parent_id=15&main=2&menu=2&submenu=1" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-2-1">
            <div class="dropdown-logo-title">
              <div class="dropdown-logo">
                <img src="./images/service-area.svg" alt="Promotion Package Internet" class="bright-white">
              </div>
              <p>SERVICE AREAS</p>
            </div>
          </a>

          <a href="<?=$config['website']?>/la/consumer-package.php?id=38&parent_id=16&main=2&menu=2&submenu=2" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-2-2">
            <div class="dropdown-logo-title">
              <div class="dropdown-logo" style="padding: 8px">
                <img src="./images/package.svg" alt="Net sim" class="bright-white">
              </div>
              <p>PACKAGES</p>
            </div>
          </a>

          <a href="<?=$config['website']?>/la/consumer-package.php?id=39&parent_id=17&main=2&menu=2&submenu=3" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-2-3">
            <div class="dropdown-logo-title">
              <div class="dropdown-logo" style="padding: 9px">
                <img src="./images/how-to-use.svg" alt="Net sim" class="bright-white">
              </div>
              <p>HOW TO USE</p>
            </div>
          </a>
    
          <a href="<?=$config['website']?>/la/consumer-package.php?id=40&parent_id=18&main=2&menu=2&submenu=4" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-2-2-4">
            <div class="dropdown-logo-title">
              <div class="dropdown-logo">
                <img src="./images/change-password.svg" alt="Net sim" class="bright-white">
              </div>
              <p>CHANGE PASSWORD</p>
            </div>
          </a>
      

          </div>
      </div>
    
    
    
    
    
    
    </div>
  </div>

  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-3" onclick="toggleDropdownMenu(3)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-3" class="dropdown-logo">
            <img src="./images/Landline-desk-and-winphone-service.svg"
              class="bright-white" style="height: 70%" />

          </div>
          <p id="logo-title-active-3">Landline desk<br>and winphone service</p>
        </div>
        <div class="arrow-drop">
          <img id="arrow-left-drop-3" src="./images/undrop.svg" alt="arrow drop" />
        </div>
      </div>
    </div>
    <div id="dropdown-left-3" class="dropdown-left">
      <a href="<?=$config['website']?>/la/consumer-package.php?id=41&parent_id=19&main=3&menu=1" class="left-menu-dropdown" id="left-menu-dropdown-3-1">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/Home-Digital-Phone.svg" alt="Home Digital Phone" class="bright-white">

          </div>
          <p>Home Digital Phone</p>
        </div>
      </a>

      <a href="<?=$config['website']?>/la/consumer-package.php?id=43&parent_id=21&main=3&menu=2" class="left-menu-dropdown" id="left-menu-dropdown-3-2">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/Winphone-Service.svg" alt="Winphone Service" class="bright-white">

          </div>
          <p>Winphone Service</p>
        </div>
      </a>

    </div>
  </div>

  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-4" onclick="toggleDropdownMenu(4)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-4" class="dropdown-logo">
            <img src="./images/Additional-services-applications.svg" alt="Additional services applications"
              class="bright-white" />
          </div>
          <p id="logo-title-active-4">Additional services & <br>applications</p>
        </div>
        <div class="arrow-drop">
          <img id="arrow-left-drop-4" src="./images/undrop.svg" alt="arrow drop" />
        </div>
      </div>
    </div>

    <div id="dropdown-left-4" class="dropdown-left">
    
      <div class="secondDropdown">
        <div id="sidebar-dropdown-menu-main-4-1" onclick="setActiveDropdownInSideMenu(4,1)">
          <div  class="left-menu-dropdown" id="left-menu-dropdown-1-2">
            <div class="dropdown-logo-title">
                  <div class="dropdown-logo">
                    <img src="./images/Value-Added.svg" alt="top up card" class="bright-white" >
                  </div>
                  <p class="dropdown-logo-title-active" >Value Added Services</p>
            </div>
        
            <div class="arrow-drop">
              <img src="./images/undrop.svg" id="arrow-left-dropdown-in-dropdown-4-1" alt="arrow drop" />
            </div>
          </div>
        
        </div>
        <div class="third-dropdown">
          <div id="dropdown-in-dropdown-left-4-1" class="dropdown-left dropdown-left-in-dropdown"  >
            <a href="<?=$config['website']?>/la/consumer-package.php?id=27&parent_id=9&main=4&menu=1&submenu=1" class="third-dropdown-left" >
      
               <div id="left-menu-dropdown-in-dropdown-4-1-1" class="left-menu-dropdown">
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo">
                    <img src="./images/International-Roaming.svg" class="bright-white" alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >International Roaming</p>
                </div>
              </div>
            </a>
      
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=48&parent_id=26&main=4&menu=1&submenu=2" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-4-1-2" > 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo">
                    <img src="./images/International-Call-IDD.svg" class="bright-white" alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >International Call IDD</p>
                </div>
              </a>
            </div>
      
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=49&parent_id=27&main=4&menu=1&submenu=3" id="left-menu-dropdown-in-dropdown-4-1-3" class="left-menu-dropdown" > 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo">
                    <img src="./images/call-waiting-music-service.svg" class="bright-white" alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >Ring Back Tone</p>
                </div>
              </a>
            </div>
            
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=50&parent_id=28&main=4&menu=1&submenu=4" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-4-1-4"> 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo">
                    <img src="./images/Missed-call-notification.svg" class="bright-white" alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >Missed call</p>
                </div>
              </a>
            </div>
  
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=51&parent_id=29&main=4&menu=1&submenu=5" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-4-1-5"> 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo dropdown-logo ">
                    <img src="./images/coda-play.svg" class="bright-white img-over-scale " alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >Coda play</p>
                </div>
              </a>
            </div>
  
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=52&parent_id=30&main=4&menu=1&submenu=6" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-4-1-6"> 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo">
                    <img src="./images/VoLTE.svg" class="bright-white" alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >Volte</p>
                </div>
              </a>
            </div>
  
          </div>
        </div>
      </div>

      <div class="secondDropdown">
        <div id="sidebar-dropdown-menu-main-4-2" onclick="setActiveDropdownInSideMenu(4,2)">
          <div  class="left-menu-dropdown" id="left-menu-dropdown-1-2">
            <div class="dropdown-logo-title">
                  <div class="dropdown-logo">
                    <img src="./images/Application-logo.svg" alt="top up card" class="bright-white" >
                  </div>
                  <p class="dropdown-logo-title-active" >Application</p>
            </div>
        
            <div class="arrow-drop">
              <img src="./images/undrop.svg" id="arrow-left-dropdown-in-dropdown-4-2" alt="arrow drop" />
            </div>
          </div>
        
        </div>
        <div class="third-dropdown">
          <div id="dropdown-in-dropdown-left-4-2" class="dropdown-left dropdown-left-in-dropdown"  >
            <a href="<?=$config['website']?>/la/consumer-package.php?id=45&parent_id=23&main=4&menu=2&submenu=1" class="third-dropdown-left" >
      
               <div id="left-menu-dropdown-in-dropdown-4-2-1" class="left-menu-dropdown">
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo dropdown-logo">
                    <img src="./images/m-service-indropdown.svg" class="bright-white img-over-scale " alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >M Services</p>
                </div>
              </div>
            </a>
      
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=46&parent_id=24&main=4&menu=2&submenu=2" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-4-2-2" > 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo">
                    <img src="./images/M-top-up.svg" class="bright-white" alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >M Topup Plus</p>
                </div>
              </a>
            </div>
      
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=47&parent_id=25&main=4&menu=2&submenu=3" id="left-menu-dropdown-in-dropdown-4-2-3" class="left-menu-dropdown" > 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo dropdown-logo ">
                    <img src="./images/m-money-icon-red.svg" class="bright-white img-over-scale " alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >M Money</p>
                </div>
              </a>
            </div>
            
            <div class="third-dropdown-left" >
              <a href="<?=$config['website']?>/la/consumer-package.php?id=53&parent_id=31&main=4&menu=2&submenu=4" class="left-menu-dropdown" id="left-menu-dropdown-in-dropdown-4-2-4"> 
                <div class="dropdown-logo-title"  >
                  <div class="dropdown-in-dropdown-logo">
                    <img src="./images/LTC-Play.svg" class="bright-white" alt="M phone">
                  </div>
                  <p class="dropdown-logo-title-active" >LTC Play</p>
                </div>
              </a>
            </div>
  
          </div>
        </div>
      </div>

    </div>






  </div>

  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-5" onclick="toggleDropdownMenu(5)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-5" class="dropdown-logo">
            <img src="./images/About-Lao-Telecom-inactive.svg" class="bright-white" style="height: 80%" />
          </div>
          <p id="logo-title-active-5">About Lao Telecom</p>
        </div>
        <div class="arrow-drop">
          <img src="./images/undrop.svg" alt="arrow drop" id="arrow-left-drop-5" />
        </div>
      </div>
    </div>
    <div id="dropdown-left-5" class="dropdown-left">
      <a href="history.php" class="left-menu-dropdown" id="left-menu-dropdown-5-1">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/History.svg" alt="History" class="bright-white ">
          </div>
          <p>History</p>
        </div>
      </a>
      
      <a href="vision-mission.php" class="left-menu-dropdown" id="left-menu-dropdown-5-2">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/Vision-Mission.svg" alt="Vision-Mission" class="bright-white img-over-scale ">
          </div>
          <p>Vision and Mission</p>
        </div>
      </a>

      <a href="Board-of-Directors.php" class="left-menu-dropdown" id="left-menu-dropdown-5-3">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/Board-of-Directors.svg" alt="Board-of-Directors" class="bright-white">
          </div>
          <p>Board of Directors</p>
        </div>
      </a>

      <a href="Awards.php" class="left-menu-dropdown" id="left-menu-dropdown-5-4">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/Awards.svg" alt="Awards" class="bright-white">
          </div>
          <p>Awards</p>
        </div>
      </a>

      <a href="news-event.php" class="left-menu-dropdown" id="left-menu-dropdown-5-5">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/news&events.svg" alt="news & events" class="bright-white">
          </div>
          <p>news & events</p>
        </div>
      </a>
      <a href="career.php" class="left-menu-dropdown" id="left-menu-dropdown-5-6">
        <div class="dropdown-logo-title ">
          <div class="dropdown-logo" style="padding: 8px;">
            <img src="./images/career.svg" alt="career" class="bright-white">
          </div>
          <p>career</p>
        </div>
      </a>
    </div>
  </div>

  <div class="left-menu-title">
    <div class="bg-logo-title" id="sidebar-menu-main-6" onclick="toggleDropdownMenu(6)">
      <div class="left-menu-title-flex">
        <div class="logo-title">
          <div id="dropdown-logo-inactive-6" class="dropdown-logo">
            <img src="./images/Contact-us.svg" alt="Contact us" class="bright-white" />
          </div>
          <p id="logo-title-active-6">Contact us</p>
        </div>
        <div class="arrow-drop">
          <img src="./images/undrop.svg" alt="arrow drop" id="arrow-left-drop-6" />
        </div>
      </div>
    </div>
    <div id="dropdown-left-6" class="dropdown-left">
      <a href="customer-service-center.php" class="left-menu-dropdown " id="left-menu-dropdown-6-1">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/customer-service-center.png" alt="customer service  center" class="bright-white">
          </div>
          <p>customer service center</p>
        </div>
      </a>
      <a href="enquiry.php" class="left-menu-dropdown" id="left-menu-dropdown-6-2">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/enquiry.png" alt="enquiry" class="bright-white" style="height: 83%">
          </div>
          <p>enquiry</p>
        </div>
      </a>

      <a href="faq.php" class="left-menu-dropdown" id="left-menu-dropdown-6-3">
        <div class="dropdown-logo-title">
          <div class="dropdown-logo">
            <img src="./images/FAQ.png" alt="FAQ" class="bright-white">
          </div>
          <p>FAQ</p>
        </div>
      </a>
    </div>
  </div>
-->
</div>
