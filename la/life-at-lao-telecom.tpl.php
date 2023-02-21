<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/Career';
?>
<?php include "header.php" ?>

<div class="outer-box" style="padding: 0">

	<div class="top-bg">
		<img src="./images/bg-line-water-header.png" alt="" />
	</div>

  <div class="container">

    <div class="content">
      <?php include "main-sidebar.php" ?>

      <div class="right-content  news-section">
        <div class="">
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
              <a href="#">About Lao Telecom</a>
              <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu">
              <a href="#">Career</a>
              <img src="./images/right-header-menu-dot.svg" alt="">
            </div>

            <div class="right-header-menu active-header-right">
              <a href="#"><?=$this->item->title_la?></a>
            </div>
          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo">
                <img src="./images/career.svg" alt="">
              </div>
              <p><?=$this->item->title_la?></p>
            </div>
			  <?php if($this->item->image != ''){ ?>
            <div class="Img-Mphone">
              <img src="<?=$config['website']?>/img_career/<?=$this->item->image?>" alt="<?=$this->item->title_la?>">
            </div>
			  <?php } ?>
          </div>
		  <?php if($this->layerListCount > 0){ ?>	
          <div class="career-training">
			  
		<!-- Layer -->
			<?php $i=0; ?>
			<?php foreach($this->layerList as $layer){ ?>
			<?php $i++; ?>  
        	<?php if($i%2 == 1){ ?>
			  <div class="flex al-item-center">
              <div class="career-training-detail">
                <h1><?=$layer['title_la']?></h1>
                <p><?=$layer['description_la']?></p>
              </div>
			  <?php if($layer['image_la'] != ''){ ?>	  
              <div class="career-training-img">
                <img src="<?=$config['website']?>/img_career_layer/<?=$layer['image_la']?>" alt="<?=$layer['image_alt_la']?>">
              </div>
			  <?php } ?>	  
            </div>
			  <?php }else{ ?>			  
              <div class="flex al-item-center flex-row-reverse">
              <div class="career-training-detail">
                <h1><?=$layer['title_la']?></h1>
                <p><?=$layer['description_la']?></p>
              </div>
               <?php if($layer['image_la'] != ''){ ?>	  
              <div class="career-training-img">
                <img src="<?=$config['website']?>/img_career_layer/<?=$layer['image_la']?>" alt="<?=$layer['image_alt_la']?>">
              </div>
			  <?php } ?>
            </div>
			  <?php } ?>
		<?php } ?>	  
          </div>
		 <?php } ?>	
        </div>


      </div>

    </div>

  </div>

<div class="footer-bg">
		<img src="./images/bg-line-water-footer.png" alt="" />
	</div>

</div>

<?php include "footer.php" ?>

<script>
  setActiveSideMenu(5)
  setActiveDropdownSideMenu(5, 6)
  MainMenuActive(1)
</script>