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
<?php
$menu_main = ['','Mobile','Wired Internet','Landline Desk And Winphone Service','Additional Services & Applications'];	
$sub_menu = ['','Monthly','Prepaid'];
?>
<div class="outer-box" style="padding: 0">

  <div class="top-bg">
    <img src="./images/bg-line-water-header.png" alt="" />
  </div>

  <div class="container">

    <div class="content">

      <?php include "main-sidebar.php" ?>

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
                <a href="#"><?=$menu_main[$this->main]?></a>
                <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
			<!--
			<div class="right-header-menu">
                <a href="#"><?=$sub_menu[$this->menu]?></a>
                <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
			-->
            <div class="right-header-menu active-header-right">
                <a href="#"><?=$this->layer->title_la?></a>
            </div>
			<!--
          <div class="right-header-menu active-header-right">
            <a href="#">M Phone</a>
          </div>-->
        </div>

        <div class="banner-Mphone">
          <div class="banner-Mphone-title">
            <div class="banner-Mphone-logo" style="padding: 12px">
              <img src="<?=$config['website']?>/img_service/group/<?=$this->layer->image_icon?>" alt="">
            </div>
            <p><?=$this->layer->title_la?></p>
          </div>
        </div>

        <div class="news-catagory owl-theme owl-carousel page-no-title" id="news-owl-carousel">
			<?php $i=0; ?>
			<?php foreach($this->itemList as $val){ ?>
			<?php $i++; ?>	
          <a href="<?=$config['website']?>/la/consumer-package.php?id=<?=$val['id']?>&parent_id=<?=$this->parent_id?>&main=<?=$this->main?>&menu=<?=$this->menu?>&submenu=<?=$this->submenu?>">
            <div class="news-any-catagory<?=($val['id'] == $this->id)? ' active-news':''?>">
              <div class="flex-in-news-catagory-button">
				  <?php if($val['image_icon'] != ''){ ?>
                <div class="logo-in-news-any-catagory">
                  <img src="<?=$config['website']?>/img_service/group/<?=$val['image_icon']?>" alt="" class="bright-white">
                </div>
				  <?php } ?>
                <p><?=$val['title_la']?></p>
              </div>
            </div>
          </a>
			<?php } ?>
			
        </div>

        <div class="banner-Mphone">
		  <?php if($this->group->image_la != ''){ ?>	
			 <a href="#" class="Img-Mphone">
            <img src="<?=$config['website']?>/img_consumer_group/<?=$this->group->image_la?>" alt="">
             </a>
		  <?php } ?>	 
			

          <div class="banner-home-digital" style="margin-top: 30px">
			  
			<?php if($this->layer->image != ''){ ?>
			<div class="left-banner-home-digital flex relative">              
              <img src="<?=$config['website']?>/img_service/group/<?=$this->layer->image?>" alt="<?=$this->layer->image_alt?>">            
			</div>	
 	 	    <?php } ?>

            <?php if($this->layer->youtube != ''){ ?>
            <div class="right-banner-home-digital flex relative">
              <img src="./images/vdo-home-digital.svg" alt="">
              <a class="btn-play-video" onclick="openVideo()">
                <img src="images/polygon.svg" alt="">
              </a>
            </div>
			 <?php } ?>  
          </div>
		  <?php if($this->layer->description_la != ''){ ?>
          <p class="under-banner-Mphone mt-100"><?=$this->layer->description_la?></p>
		  <?php } ?>	
        </div>
		 <?php if($this->layer->subject_la != ''){ ?>
        <div class="package-Mphone">
          <p class="package-Mphone-title"><?=$this->layer->subject_la?></p>
        </div>
		 <?php } ?> 

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
			<div style="padding: 10px;"></div>	
        </div>  
		 <?php } ?>
		 <?=$layer['description_la']?> 		 
		 <?php } //foreach ?>
		  
		 <?php } //IF ?>
		  
		<?php if($this->fileListCount > 0){ ?>	
		<div class="package-Mphone" style="margin-top: 0">
            <p class="package-Mphone-title" 
              style="margin-top: 40px;line-height: 1.2;">
              application form
            </p>
            <?php $i=0; ?>
			
			<?php foreach($this->fileList as $file){ ?>
			<?php $i++; ?>  
            <div class="download-button flex al-item-center" style="margin-bottom: <?=($this->fileListCount == $i) ? '40px':'10px'?>">
              <div class="download-button-left flex al-item-center">
                <div class="file-download-img flex">
                  <img src="./images/file-doc.svg" alt="">
                </div>
                <p><?=$file['title']?></p>
              </div>
              <div class="download-button-right flex al-item-center">
                <p class="storage-download"><?=number_format($file['filesize'])?></p>
                <a href="<?=$config['website']?>/img_download/<?=$file['filename']?>" class="for-download flex al-item-center">
                  <p>Download</p>
                  <div class="download-img">
                    <img src="./images/Download.svg" alt="">
                  </div>
                </a>
              </div>
            </div>
			<?php } ?>
			
            <div class="new-consumer-line"></div>
            <div class="any-package-Mphone" style="margin-top: 40px"></div>
          </div>
		  <?php } // IF?>
		  
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

  <div class="footer-bg">
    <img src="./images/bg-line-water-footer.png" alt="" />
  </div>

</div>

<!-- Video Popup -->
<div class="video-popup">
  <div class="video-inner">
    <button onclick="closeVideo()">
      Close
    </button>
    <iframe width="100%" height="500" src="" title="YouTube video player" frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
      id="video_iframe"></iframe>
  </div>
</div>

<?php include "footer.php" ?>



<script>
  setActiveSideMenu(<?=$this->main?>);
  setActiveDropdownHaveDropdownInsideSideMenu(<?=$this->main?>);
  MainMenuActive(1)
  setActiveDropdownInSideMenu(<?=$this->main?>, <?=$this->menu?>);
  setActiveSecondDropdown(<?=$this->main?>, <?=$this->menu?>, <?=$this->submenu?>);



  $(document).ready(function ($) {
    const owl = $("#news-owl-carousel");
    owl.owlCarousel({
      items: 5,
      dots: false,
      autoWidth: true,
      margin: 10
    });
  });

    function openVideo() {
      const videoPopup = document.querySelector(".video-popup");
      const videoIframe = document.getElementById("video_iframe");
      if (videoPopup) {
          videoPopup.classList.add("video-popup-active");
          videoIframe.src = "<?=$this->layer->youtube?>";
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