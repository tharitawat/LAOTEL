<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/HOW-TO-CHECK-SCORE';
?>
<?php include "header.php" ?>

<div class="outer-box" style="padding: 0">

	<div class="top-bg">
		<img src="./images/bg-line-water-header.png" alt="" />
	</div>

  <div class="container">

    <div class="content">

      <?php include "sidebar-smart-reward.php" ?>

      <div class="right-content news-section">
        <div class="">
          <div class="right-header ">
            <div class="right-header-menu">
              <a href="#">Home</a>
              <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu">
              <a href="#">Smart Rewards</a>
              <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu active-header-right">
              <a href="#">How to Check Score</a>
            </div>
          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo">
                <img src="./images/How-to-Check-Score.svg" alt="">
              </div>
              <p>How to Check Score</p>
            </div>
            <p class="how-to-check-score-detail">Special privileges for SMEs, juristic personswho use Handset to support
              5G, get a 5G internet package</p>
            <p class="how-to-check-score-under-detail">Get a free 5G internet package for SME customers, juristic
              persons who use Handset to support 5G in order to get a good experience in using Lao Telecom 5G by making
              a special difference. Including building confidence for customers to use to meet business needs</p>
            <a href="#" class="Img-Mphone">
              <img src="./images/banner-how-to-check-score.svg" alt="">
            </a>
          </div>

          <div class="project-conditions">
            <p class="project-conditions-title">project conditions</p>
            <ul>
              <li>
                <p>For free packs of BIZ UP / Serenade members, after being a BIZ UP / Serenade member, you can start
                  receiving privileges the next day</p>
              </li>
              <li>
                <p>Internet package can use 5G/4G/3G which will be deducted before the main package.</p>
              </li>
              <li>
                <p>Internet pack can use 5G/4G/3G, which will be deducted before the main package.</p>
              </li>
              <li>
                <p>When you get the privilege and receive a confirmation SMS, it will take effect immediately.</p>
              </li>
              <li>
                <p>Excess service charge Think based on the main package you are using.</p>
              </li>
              <li>
                <p>Free license and the specified service rate For domestic use only</p>
              </li>
              <li>
                <p>In the event that use does not expire according to the specified period of use The rights granted
                  will be terminated immediately.</p>
              </li>
              <li>
                <p>1 number 1 privilege only</p>
              </li>
              <li>
                <p>The package received cannot be changed.</p>
              </li>
              <li>
                <p>When the package is successfully applied, there will be a confirmation SMS informing you.</p>
              </li>
              <li>
                <p>The licensee must not be in a suspended state, cancel or change the owner of the telephone number.
                </p>
              </li>
              <li>
                <p>Grantees cannot transfer or assign rights to other phone numbers.</p>
              </li>
              <li>
                <p>The privilege is valid from 1 June 2022 – 31 December 2022.</p>
              </li>
            </ul>
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
  setActiveDropdownSideMenu(1, 1)
</script>