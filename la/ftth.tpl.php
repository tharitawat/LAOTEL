<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/Package';
?>
<?php include "header.php" ?>

<div class="outer-box" style="padding: 0">

  <div class="top-bg">
    <img src="./images/bg-line-water-header.png" alt="" />
  </div>

  <div class="container">

    <div class="content">

      <?php include "sidebar-wired-internet.php" ?>

      <div class="right-content news-section">
        <div class="right-header">
            <div class="right-header-menu">
                <a href="#">Home</a>
                <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu">
                <a href="#">Consumer</a>
                <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu">
                <a href="#"><?=$this->menu->title_la?></a>
                <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
			<div class="right-header-menu">
                <a href="#"><?=$this->submenu->title_la?></a>
                <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu active-header-right">
                <a href="#"><?=$this->layer->title_la?></a>
            </div>
        </div>

        <div class="banner-Mphone">
          <div class="banner-Mphone-title">
            <div class="banner-Mphone-logo" style="padding: 12px">
              <img src="./images/ftth.svg" alt="">
            </div>
            <p>Fiber to the Home (FTTH)</p>
          </div>
          <div class="ftth-banner-row">
            <a href="#" class="Img-Mphone">
              <img src="./images/banner-ftth.svg" alt="">
            </a>
            <div class="video-section">
              <div class="video-overlay"></div>

              <a class="btn-play-video" onclick="openVideo()">
                  <img src="images/polygon.svg" alt="">
              </a>
            </div>
          </div>

          <div class="package-Mphone" style="margin-top: 0">
            <p class="package-Mphone-title" 
              style="margin-top: 40px;line-height: 1.2;">
              High speed broadband internet service in the home through fiber optic cable installed in the customer's home
            </p>
            <ul class="service-channel equipment-detail-list2 equipment-detail-list" style="color: #4E4E4E">
              <li>Service is available in major cities only</li>
              <li>The system can be used in combination with a home telephone number</li>
              <li>Customers can choose service speeds from 3 Mbps up to 100 Mbps</li>
            </ul>
          </div>
        </div>

		    
 		<?php if($this->layerListCount > 0){ ?>
		<!-- Layer -->
		<?php foreach($this->layerList as $layer){ ?>
		<?php if($layer['title_la'] != ''){ ?> 
		<div class="package-Mphone">
          <p class="package-Mphone-title"><?=$layer['title_la']?></p>
        </div>  
		 <?php } ?>
		  
		  <?php if($layer['image_la'] != ''){ ?> 
		<div class="package-Mphone">
            <div class="Img-Mphone">
				<img src="<?=$config['website']?>/img_consumer_service_layer/<?=$layer['image_la']?>" alt="<?=$layer['image_alt_la']?>">
			</div>
			<div style="padding: 20px;"></div>	
        </div>  
		 <?php } ?>
		 
		  
		 <?=$layer['description_la']?> 
		  <?php if($ture){ ?>
		 <div class="package-Mphone">
          <p class="package-Mphone-title">Service fees</p>
          <div class="roaming-box service-fees">

            <!-- Header -->
            <div class="roaming-box-header">
              <!-- Country -->
              <div class="roaming-box-country roaming-box-border-right">Service</div>

              <!-- Country code -->
              <div class="roaming-box-country-code roaming-box-border-right">Fees</div>
            </div>

            <!-- Body -->
            <div class="roaming-box-body">
              <!-- Country -->
              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">Calling within LTC network</div>

              <!-- Country code -->
              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">800 Kips / Minute</div>
            </div>
            <div class="roaming-box-body">
              <!-- Country -->
              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">Call outside LTC network</div>

              <!-- Country code -->
              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">800 Kips / Minute</div>
            </div>
            <div class="roaming-box-body">
              <!-- Country -->
              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">International Calls</div>

              <!-- Country code -->
              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">Depends on each country's rate</div>
            </div>
            <div class="roaming-box-body">
              <!-- Country -->
              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">SMS within LTC network</div>

              <!-- Country code -->
              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">100 Kips / time</div>
            </div>
            <div class="roaming-box-body">
              <!-- Country -->
              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">SMS outside LTC network</div>

              <!-- Country code -->
              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">200 Kips / time</div>
            </div>
            <div class="roaming-box-body">
              <!-- Country -->
              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">SMS internationally</div>

              <!-- Country code -->
              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">500 Kips / time</div>
            </div>
            <div class="roaming-box-body">
              <!-- Country -->
              <div class="roaming-box-body-country roaming-box-border-right">Internet usage rate</div>

              <!-- Country code -->
              <div class="roaming-box-body-country-code roaming-box-border-right">300 Kips / MB</div>
            </div>
          </div>
        </div> 
		  <?php } ?>
		 <?php } //foreach ?>
		  
		 <?php } //IF ?>

		<?php $i=0; ?>
		<?php foreach($this->packageList as $name){ ?>
		<?php $i++; ?>  
		  
        <div class="package-Mphone">		  	
          <p class="package-Mphone-title"><?=$name['title_la']?></p>
          <div class="any-package-Mphone">
			<?php
			   $sql = "SELECT * FROM package_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.title_la = ? ORDER BY i.sequence ASC";
			   $stmt = $db->Prepare($sql);
			   $rs = $db->Execute($stmt,array($name['title_la']));
			   $itemList = $rs->GetAssoc();
			   $itemListCount = $rs->maxRecordCount();
												   
			  ?>
		  <?php $x=0; ?>
		  <?php foreach($itemList as $val){ ?>
		  <?php $x++; ?>  	
          <!-- Item -->
            <div class="details-Mphone">
              <div class="box-package-Mphone">
                <div class="pd-of-line-box-package">
                  <h1 class="box-package-Mphone-code">Code <?=$val['packageKey']?></h1>
                </div>
                <div class="data-Mphone">
                  <p>Data Volume</p>
                  <h1><?=$val['specialValue']?></h1>
                </div>
                <div class="data-Mphone">
                  <p>Age of use</p>
                  <h1><?=$val['qtaDay']?> Day</h1>
                </div>
                <div class="font-in-bg-under">
                  <p class="cost-package-Mphone"><?=number_format($val['qtaBalance'])?> kip</p>
                  <div class="password-package-Mphone">
                    <p>Dial</p>
                    <button><?=$val['ussdCode']?></button>
                    <a href="#" class="button-tel-package">
                      <img src="./images/tel-package.svg" alt="">
                    </a>
                  </div>
                </div>
				  <!--
                <div class="bg-package-promotion">
                  <p>Popular</p>
                  <img src="./images/button-popular.svg" alt="">
                </div>
				
                <div class="leg-bg-package-promotion">
                  <img src="./images/double-triangle.svg" alt="">
                </div>
				    -->
              </div>

              <a href="#" class="shop-package">
                <div class="logo-shop-package">
                  <img src="./images/shop-package.svg" alt="">
                </div>
                <p>Shop now</p>
              </a>
            </div>
          <?php } ?>
            
            
          </div>
        </div>

        <?php } ?>

		  
		  
      </div>

    </div>

  </div>

  <div class="footer-bg" style="bottom: 0">
    <img src="./images/bg-line-water-footer.png" alt="" />
  </div>

</div>

<!-- Video Popup -->
<div class="video-popup">
    <div class="video-inner">
        <button onclick="closeVideo()">
            Close
        </button>
        <iframe width="100%" height="500" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="video_iframe"></iframe>
    </div>
</div>

<?php include "footer.php" ?>

<script>
  setActiveSideMenu(1);
  MainMenuActive(1);

  const dropdownMenu = $(`#dropdown-left-1`);
  if (dropdownMenu) {
    dropdownMenu.slideToggle("fast");
  }

  function openVideo() {
      const videoPopup = document.querySelector(".video-popup");
      const videoIframe = document.getElementById("video_iframe");
      if (videoPopup) {
          videoPopup.classList.add("video-popup-active");
          videoIframe.src = "https://www.youtube.com/embed/YGMEQJXA8yo";
      }
  }

  function closeVideo() {
      const videoPopup = document.querySelector(".video-popup");
      const videoIframe = document.getElementById("video_iframe");
      if (videoPopup) {
          videoPopup.classList.remove("video-popup-active");
          videoIframe.src = "";
      }
  }
</script>