<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/Board-of-Directors';
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
              <a href="#">Board of Directors</a>
            </div>
          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo">
                <img src="./images/Board-of-Directors.svg" alt="">
              </div>
              <p>Board of Directors</p>
            </div>
          </div>

          <div class="board-directors">
            <h1 class="board-title">LAO TELECOM BOARD OF DIRECTORS (25 YEARS)</h1>
            <div class="list-board">
              <div class="any-img-directors">
                <img src="./images/director-25-years-1.svg" alt="">
                <p class="name-in-board" >name surname</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/director-25-years-2.svg" alt="">
                <p class="name-in-board" >name surname</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/director-25-years-3.svg" alt="">
                <p class="name-in-board" >name surname</p>
              </div>
            </div>

            <div class="list-board mt-50">
              <div class="any-img-directors">
                <img src="./images/director-25-years-4.svg" alt="">
                <p class="name-in-board" >name surname</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/director-25-years-5.svg" alt="">
                <p class="name-in-board" >name surname</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/director-25-years-6.svg" alt="">
                <p class="name-in-board" >name surname</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/director-25-years-7.svg" alt="">
                <p class="name-in-board" >name surname</p>
              </div>
            </div>

          </div>

          <div class="new-consumer-line mY-30 "></div>

          <div class="board-directors">
            <h1 class="board-title">DIRECTORS (1996 – PRESENT)</h1>
            <div class="list-board">
              <div class="any-img-directors">
                <img src="./images/dirctors-1996up-1.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>1994 - 1996</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/dirctors-1996up-2.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>1996 - 2008</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/dirctors-1996up-3.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>Foreign Shareholders' Council</p>
                <p>1997 - 1999</p>
              </div>
            </div>

            <div class="list-board mt-50">
              <div class="any-img-directors">
                <img src="./images/dirctors-1996up-4.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>2008 - 2010</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/dirctors-1996up-5.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>2010 - 2014</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/dirctors-1996up-6.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>2014 - 2019</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/dirctors-1996up-7.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>2019 - Present</p>
              </div>
            </div>

          </div>

          <div class="new-consumer-line mY-30 "></div>

          <div class="board-directors">
            <h1 class="board-title">MANAGEMENT TEAM (2020 ONWARD)</h1>
            <div class="list-board">
              <div class="any-img-directors">
                <img src="./images/MANAGEMENT-TEAM-1.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>Director General</p>
              </div>
            </div>

            <div class="list-board mt-50">
              <div class="any-img-directors">
                <img src="./images/MANAGEMENT-TEAM-2.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>Deputy Director General</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/MANAGEMENT-TEAM-3.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>Deputy Director General</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/MANAGEMENT-TEAM-4.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>Deputy Director General</p>
              </div>
              <div class="any-img-directors">
                <img src="./images/MANAGEMENT-TEAM-5.svg" alt="">
                <p class="name-in-board" >name surname</p>
                <p>Deputy Director General</p>
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
  setActiveDropdownSideMenu(5, 3)
  MainMenuActive(1)
</script>