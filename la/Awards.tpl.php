<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/Awards';
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
              <a href="#">Awards</a>
            </div>
          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo">
                <img src="./images/Awards.svg" alt="">
              </div>
              <p>Awards</p>
            </div>
          </div>

          <div class="board-directors awards">
            <h1 class="board-title">awards LAO TELECOM on the world</h1>
            <div class="list-board">
              <div class="any-img-directors">
                <img src="./images/awards-world-1.svg" alt="">
              </div>
              <div class="any-img-directors">
                <img src="./images/awards-world-1.svg" alt="">
              </div>
            </div>

          </div>

          <div class="new-consumer-line mY-30 "></div>

          <div class="board-directors awards">
            <h1 class="board-title">awards LAO TELECOM on the world Business</h1>
            <div class="list-board">
              <div class="any-img-directors">
                <img src="./images/awards-world-business-1.svg" alt="">
              </div>
              <div class="any-img-directors">
                <img src="./images/awards-world-business-2.svg" alt="">
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
  setActiveDropdownSideMenu(5, 4)
  MainMenuActive(1)
</script>