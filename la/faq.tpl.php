<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/FAQ';
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
              <a href="#">FAQ</a>
            </div>
          </div>
          <div class="banner-Mphone">
            <div class="banner-Mphone-title" style="padding-bottom: 10px">
              <div class="banner-Mphone-logo" style="padding: 7px">
                <img src="./images/FAQ.png" alt="">
              </div>
              <p>FAQ</p>
            </div>

            <div class="button-career-drop-down faq-list">
				<?php $i=0; ?>
				<?php foreach($this->itemList as $val){ ?>
				<?php $i++; ?>
              <div class="box-button-career">
                <div class="button-career" id="button-career-<?=$i?>" onclick="toggleCareerDropdown(<?=$i?>)">
                  <p><?=$val['title_la']?></p>
                  <div class="button-career-right">
                    <div class="arrow-drop">
                      <img id="arrow-drop-<?=$i?>" src="./images/undrop.svg" alt="arrow drop" />
                    </div>
                  </div>
                </div>
                <div class="button-career-d" id="career-box-<?=$i?>">
                  <div class="button-career-any-d">
                    <p class="faq-details"><?=$val['description_la']?></p>
                  </div>
                </div>
              </div>
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
  setActiveSideMenu(6)
  setActiveDropdownSideMenu(6, 3)
</script>