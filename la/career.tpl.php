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

      <div class="right-content news-section">
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
            <div class="right-header-menu active-header-right">
              <a href="#">Career</a>
            </div>
          </div>
          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo">
                <img src="./images/career.svg" alt="">
              </div>
              <p>career</p>
            </div>
            <div class="career-category-img">
              <img src="./images/banner-career.svg" alt="">
              <div class="ab-banner">
                <h1>Come to work as a family with us.</h1>
                <p>Lao Telecom is like family, friendly, sharing knowledge like brothers and sisters</p>
              </div>
            </div>

            <div class="career-category-img-under-banner">
              <a href="life-at-lao-telecom.php"
                class="any-career-catagory">
                <div class="career-category-img">
                  <img src="./images/Life@lao-telecom.svg" alt="">
                </div>
                <p class="ab-subtitle-in-career-img">Life@lao telecom</p>
              </a>
              <a href="#" class="any-career-catagory">
                <div class="career-category-img">
                  <img src="./images/Job-vacancy.svg" alt="">
                </div>
                <p class="ab-subtitle-in-career-img">Job vacancy</p>
              </a>
              <a href="#" class="any-career-catagory">
                <div class="career-category-img">
                  <img src="./images/lao-telecom-welfare.svg" alt="">
                </div>
                <p class="ab-subtitle-in-career-img">lao telecom welfare</p>
              </a>
            </div>

            <div class="button-career-drop-down">
			<?php $i=0; ?>	
			<?php foreach($this->itemList as $val){ ?>	
			<?php $i++; ?>	
              <!-- Job <?=$i?> -->
              <div class="box-button-career">
                <div class="button-career" id="button-career-<?=$i?>" onclick="toggleCareerDropdown(<?=$i?>)">
                  <p><?=$val['title_la']?></p>
                  <div class="button-career-right">
                    <p><?=$val['amount']?> Position</p>
                    <div class="arrow-drop">
                      <img id="arrow-drop-<?=$i?>" src="./images/undrop.svg" alt="arrow drop" />
                    </div>
                  </div>
                </div>

                <div class="button-career-d" id="career-box-1">
                 <?php if($val['job_description_la'] != ''){ ?> 
				 <div class="button-career-any-d">
                    <p>Job Descriptions</p>
                    <?=$val['job_description_la']?>
                  </div>
				 <?php } ?>	

				  <?php if($val['qualifications_la'] != ''){ ?>	
                  <div class="button-career-any-d">
                    <p>Qualifications</p>
                    <?=$val['qualifications_la']?>
                  </div>
				  <?php } ?>
					
					<?php if($val['description_la'] != ''){ ?>
					<div class="button-career-any-d">
                    <?=$val['description_la']?>
                  	</div> 
					<?php } ?>
					

                </div>
              </div>
              <!-- End job <?=$i?> -->
			<?php } ?>	

             </div>
          </div>
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