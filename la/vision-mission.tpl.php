<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/History';
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
              <a href="#">Vision and Mission</a>
            </div>
          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo">
                <img src="./images/Vision-Mission.svg" alt="">
              </div>
              <p>Vision and Mission</p>
            </div>
            <div class="career-category-img career-banner-responsive">
              <img src="./images/banner-Vision-Mission.svg" alt="">
            </div>
          </div>

          <div class="vision-mission">
            <div class="left-vision-mission">
              <h1 class="title-vision-mission" >Vision</h1>
              <h1 class="subtitle-vision-mission" >LCT Group</h1>
            </div>

            <div class="right-vision-mission">
              <div class="right-vision-mission-detail">
                <div class="">
                  <img src="./images/LCT-Group-icon.svg" alt="">
                </div>
                <p>Lao Telecom Group will be a leader in building a digital economy for Lao society.</p>
              </div>
            </div>

          </div>

          <div class="new-consumer-line mY-30 "></div>

          <div class="vision-mission al-item-unset">
            <div class="left-vision-mission">
              <h1 class="title-vision-mission" >Mission</h1>
              <h1 class="subtitle-vision-mission" >LCT Group</h1>
            </div>

            <div class="right-vision-mission">
              <div class="right-vision-mission-detail">
                <div class="">
                  <img src="./images/Mission-1-icon.svg" alt="">
                </div>
                <p>To be a provider of Solutions & Platforms that bring modern technology and innovation. and international standards To enhance the lives of service users in the digital economy era</p>
              </div>

              <div class="right-vision-mission-detail">
                <div class="">
                  <img src="./images/Mission-2-icon.svg" alt="">
                </div>
                <p>Deliver quality services and build relationships with long experience</p>
              </div>

              <div class="right-vision-mission-detail">
                <div class="">
                  <img src="./images/Mission-3-icon.svg" alt="">
                </div>
                <p>Create and promote a good corporate culture. and develop the potential of personnel to be strong to get adjusted to business competition</p>
              </div>

              <div class="right-vision-mission-detail">
                <div class="">
                  <img src="./images/Mission-4-icon.svg" alt="">
                </div>
                <p>Focus on creating shared value for stakeholders to grow the business sustainably.</p>
              </div>

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
  setActiveDropdownSideMenu(5, 2)
  MainMenuActive(1)
</script>