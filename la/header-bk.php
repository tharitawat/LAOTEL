<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;
//$db->debug = 1;

$sql = "SELECT * FROM menu_items i WHERE 1 = 1 AND i.parent_id = 0 ORDER BY i.sequence ASC, i.id ASC";
$stmt = $db->Prepare($sql);
$rs = $db->Execute($stmt);
$itemList = $rs->GetAssoc();
$itemListCount = $rs->maxRecordCount();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/primary.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="images/logo.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="slider-pro-master/dist/css/slider-pro.min.css">
    <link rel="stylesheet" href="owl-carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="owl-carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/fancybox.css">
    <link rel="stylesheet" href="css/fixed.css">
    <title>Lao Telecom</title>
</head>

<body>
    <header>

        <div class="container-header">
            <a href="index.php" class="logo">
                <img src="./images/logo.svg" alt="">
            </a>

            <ul class="main-menu">
                <li>
                    <div class="menu-item">
                        <img src="./images/person-icon.svg" alt="" class="consumer-icon">
                        Consumer
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">

                        <!-- Dropdown -->
                        <ul class="menu-dropdown">
							<?php foreach($itemList as $menu){ ?>							
                            <li class="menu-dropdown-li">
                                <div class="menu-item menu-dropdown-item">
                                    <div>
                                        <img src="<?=$config['website']?>/img_menu/<?=$menu['image']?>" class="mobile-icon">
                                        <?=$menu['title_la']?>
                                    </div>
                                    <div>
                                        <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                    </div>
							<?php
								$sql = "SELECT * FROM submenu_items i WHERE 1 = 1 AND i.parent_id = '".$menu['id']."' ORDER BY i.sequence ASC, i.id ASC";
								$stmt = $db->Prepare($sql);
								$rs = $db->Execute($stmt);
								$sumList = $rs->GetAssoc();
								$sumListCount = $rs->maxRecordCount();
								
								 if($sumListCount > 0){ 
							?>
                                    <!-- Sub dropdown -->
                                    <ul class="menu-dropdown sub-menu-dropdown">
										<?php foreach($sumList as $submenu){ ?>		
                                        <li class="menu-dropdown-li">
                                            <a class="menu-item menu-dropdown-item" href="<?=($submenu['url_la'] != '')? $submenu['url_la'] : '#nologo'?>">
                                                <div>
                                                    <img src="<?=$config['website']?>/img_submenu/<?=$submenu['image']?>" class="mobile-icon">
                                                    <?=$submenu['title_la']?>
                                                </div>
                                            </a>
                                            <div class="menu-dropdown-item-line"></div>
                                        </li>
										<?php } ?>                                        
                                    </ul>
							<?php } ?>		
                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </li>
							<?php } ?>
							
						
                        </ul>
                    </div>
                </li>

                <li>
                    <div class="menu-item">
                        <img src="./images/business-icon.svg" alt="" class="business-icon">
                        Business
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon ">

                        <!-- Dropdown -->
                        <ul class="menu-dropdown">
                            <li class="menu-dropdown-li">
                                <a href="#nologo">
                                    <div class="menu-item menu-dropdown-item">
                                        <div>
                                            <img src="./images/Cloud-Computing.svg" class="mobile-icon" 
                                            style="width: 21px;margin-left: -2px">
                                            Cloud Computing
                                        </div>
                                    </div>
                                </a>
                                <div class="menu-dropdown-item-line"></div>
                            </li>

                            <li class="menu-dropdown-li">
                                <a href="#nogo">
                                    <div class="menu-item menu-dropdown-item">
                                        <div>
                                            <img src="./images/HR-Platform &Accounting-Salary.svg" class="mobile-icon wire-icon">
                                            HR Platform & Accounting Salary
                                        </div>
                                    </div>
                                </a>
                                <div class="menu-dropdown-item-line"></div>
                            </li>

                            <li class="menu-dropdown-li">
                                <a href="#nogo">
                                    <div class="menu-item menu-dropdown-item">
                                        <div>
                                            <img src="./images/ICT-Solution.svg" class="mobile-icon additional-icon" 
                                            style="width: 20px!important;margin-left: -2px">
                                            ICT Solution
                                        </div>
                                    </div>
                                </a>
                                <div class="menu-dropdown-item-line"></div>
                            </li>

                            <li class="menu-dropdown-li">
                                <a href="#nogo">
                                    <div class="menu-item menu-dropdown-item">
                                        <div>
                                            <img src="./images/Point-of-Sale -Program.svg" class="mobile-icon about-ltc-icon">
                                            Point of Sale Program
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="" class="menu-item">
                        <img src="./images/laotel-store-icon.svg" alt=""
                            class="laotel-store-icon">
                        Lao Telecom Store
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">
                    </a>
                </li>

                <li>
                    <div class="menu-item">
                        <img src="./images/smart-reward-icon.svg" alt=""
                            class="smart-reward-icon">
                        Smart Rewards
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">

                        <!-- Dropdown -->
                        <ul class="menu-dropdown">
                            <li class="menu-dropdown-li">
                                <a href="how-to-check-score.php">
                                    <div class="menu-item menu-dropdown-item">
                                        <div>
                                            <img src="./images/How-to-Check-Score.svg" class="mobile-icon">
                                            How to Check Score
                                        </div>
                                    </div>
                                </a>
                                <div class="menu-dropdown-item-line"></div>
                            </li>

                            <li class="menu-dropdown-li">
                                <a href="#nogo">
                                    <div class="menu-item menu-dropdown-item">
                                        <div>
                                            <img src="./images/How-to-Redeem-Rewards.svg" class="mobile-icon wire-icon">
                                            How to Redeem Rewards
                                        </div>
                                    </div>
                                </a>
                                <div class="menu-dropdown-item-line"></div>
                            </li>

                            <li class="menu-dropdown-li">
                                <a href="#nogo">
                                    <div class="menu-item menu-dropdown-item">
                                        <div>
                                            <img src="./images/Store-Discount.svg" class="mobile-icon about-ltc-icon" style="width: 18px!important">
                                            Store Discount
                                        </div>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="" class="menu-item">
                        <img src="./images/search-icon.svg" alt="" class="search-icon">
                        Search
                    </a>
                </li>

                <li>
                    <a href="" class="menu-item">
                        <img src="./images/profile-icon.svg" alt="" class="my-laotel-icon">
                        My Lao Telecom
                    </a>
                </li>

                <li>
                    <a href="" class="menu-item">
                        <img src="./images/en-icon.svg" alt="" class="flag">
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">
                    </a>
                </li>
            </ul>

        </div>
    </header>