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
      <!-- <?php include "sidebar-about-us.php" ?> -->
      <?php include "main-sidebar.php" ?>

      <div class=" news-section relative ">
        <div class="container-right-content">
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
              <a href="#">History</a>
            </div>
          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo" style="padding: 11px">
                <img src="./images/History.svg" alt="">
              </div>
              <p>History</p>
            </div>

          </div>
        </div>

        <div class="flex-time-line">
          <div class="time-line">
            
            <p class="num-timeline" >2021 - 2024</p>
            <div class="timeline-ball"></div>
            <ul class="service-channel">
              <li>5G Commercial launch</li>
            </ul>
          </div>
          <div class="time-line relative ">
            <img src="./images/timeline-2019-2020.svg" alt="" class="img-in-timeline" >
            <p class="num-timeline" >2019 - 2020</p>
              <div class="timeline-ball"></div>
              <ul class="service-channel">
                <li>5G Trial phase in VTE</li>
                <li>ESIM eSports, New subsidiaries: TPLUS & M-MONEY</li>
              </ul>
          </div>
        </div>


        <div class="flex-time-line second-flex-time-line">
          <div class="time-line relative ">
            <img src="./images/timeline-2016.svg" alt="" class="img-in-timeline" >
            <p class="num-timeline" >2016</p>
            <div class="timeline-ball"></div>
            <ul class="service-channel">
              <li>Services: - LTC provides a superior digital lifestyle experience with special privileges and the latest mobile and fixed broadband technologies</li>
            </ul>
          </div>
          <div class="time-line">
            <p class="num-timeline" >2013 - 2015</p>
              <div class="timeline-ball"></div>
              <ul class="service-channel">
                <li>Voice Call Application services </li>
                <li>3G/4G Mobile services</li>
                <li>FTTH, LL, MPLS, PLC, IPLC services</li>
              </ul>
          </div>
        </div>

        <div class="flex-time-line third-flex-time-line">
          <div class="time-line">
            <p class="num-timeline" >1996 - 2007</p>
            <div class="timeline-ball"></div>
            <ul class="service-channel">
              <li>Voice services</li>
              <li>SMS services</li>
              <li>Internet ADSL/Dialing services</li>
              <li>PSTN/20 Mobile/ADSL services</li>
              <li>PSTN, M Phone, Win Phone services </li>
            </ul>
          </div>
          <div class="time-line relative ">
          <img src="./images/timeline-2008-2012.svg" alt="" class="img-in-timeline" >
            <p class="num-timeline" >2008 - 2012</p>
              <div class="timeline-ball"></div>
              <ul class="service-channel">
                <li>Voice Call services</li>
                <li>Application services</li>
                <li>3G Mobile internet services</li>
                <li>Internet ADSL/MPLS,PLC services</li>
                <li>Narrow Band ADSL 2 services</li>
              </ul>
          </div>
        </div>

        <div class="line-of-timeline"> 
          <div class="l-1"></div>
          <div class="l-2"></div>
          <div class="l-3"></div>
          <div class="l-4" ></div>
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
  setActiveDropdownSideMenu(5, 1)
  MainMenuActive(1)
</script>