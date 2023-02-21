<?php
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/extension.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/class/class.utility.php";
require_once DIR."library/class/class.upload.php";

require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="font-face/stylesheet.css">
    <link rel="stylesheet" href="css/primary.css">
    <link rel="stylesheet" href="css/second.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="icon" type="image/x-icon" href="images/logo.svg">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="slider-pro-master/dist/css/slider-pro.min.css">
    <link rel="stylesheet" href="owl-carousel/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="owl-carousel/dist/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="css/fancybox.css">
    <link rel="stylesheet" href="css/fixed.css">
    <link rel="stylesheet" href="css/responsive.css">
    

    <title>Lao Telecom</title>
</head>

<body>
    <header>

        <div class="container-header">
            <a href="index.php" class="logo">
                <img src="./images/logo.svg" alt="">
            </a>

            <ul class="main-menu">
				<?php
							$sql = "SELECT i.* FROM menu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
							$stmt = $db->Prepare($sql);
							$rs = $db->Execute($stmt,array('1'));
							$itemList = $rs->GetAssoc();
							$itemListCount = $rs->maxRecordCount();
						
				?>
                <li>
                   <div class="menu-item" id="active-main-menu-1">
                        <img src="./images/person-icon.svg" alt="" class="consumer-icon">
                        Consumer
						<?php if($itemListCount > 0){ ?>
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">				
                        <!-- Dropdown -->
                        <ul class="menu-dropdown">
							<?php $i = 0; ?>
							<?php foreach ($itemList as $val) { ?>
							<?php $i++;?>	
                            <li class="menu-dropdown-li">
                                <div class="menu-item menu-dropdown-item">
                                    <div>
										<?php if($val['image'] != ''){ ?><img src="../img_menu/<?=$val['image']?>" class="mobile-icon"><?php } ?>
                                        <?=$val['title_la']?>
                                    </div>
									<?php
										$sql = "SELECT i.* FROM submenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($val['id']));
										$subList = $rs->GetAssoc();
										$subListCount = $rs->maxRecordCount();

									?>		
									<?php if($subListCount > 0){ ?>	
									
                                    <div>
                                        <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                    </div>
																		
                                    <!-- Sub dropdown -->
                                    <ul class="menu-dropdown sub-menu-dropdown">
										<?php $x = 0; ?>
										<?php foreach ($subList as $sub) { ?>
										<?php $x++;?>
										<?php
										$sql = "SELECT i.* FROM groupmenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($sub['id']));
										$groupList = $rs->GetAssoc();
										$groupListCount = $rs->maxRecordCount();

										?>	
										<?php 
											$list = explode('?',$sub['url_la']); 
											if($sub['url_la'] == ''){
												$gettmp['url_la'] = 'javascript:void(0);';				
											}else if($list[1] !=''){
												//echo $list[1];	
												$gettmp['url_la'] = $config['website']."/la/".$sub['url_la']."&main=".$i."&menu=".$x;
											}else{
												//echo $list[0];	
												$gettmp['url_la'] = $config['website'].'/la/'.$sub['url_la'].'?main='.$i.'&menu='.$x;
											}												
										?> 
                                        <li class="menu-dropdown-li sub-hover">
                                            <a class="menu-item menu-dropdown-item second-menu-item" href="<?=$gettmp['url_la']?>">
                                                <div>
                                                   <?php if($sub['image'] != ''){ ?><img src="../img_submenu/<?=$sub['image']?>" class="mobile-icon"><?php } ?>
                                       			   <?=$sub['title_la']?>
                                                </div>
												<?php if($groupListCount > 0){ ?>
                                                <div>
                                                    <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                                </div>
												<?php } ?>

                                            </a>
                                            <div class="menu-dropdown-item-line"></div>
											
										
										<?php if($groupListCount > 0){ ?>	
											<ul class=" third-sub-menu-dropdown">	
										<?php $y = 0; ?>
										<?php foreach ($groupList as $group) { ?>
										<?php $y++;?>					
											<?php 
												$list = explode('?',$group['url_la']); 
												if($group['url_la'] == ''){
													$gettmp['url_la'] = 'javascript:void(0);';				
												}else if($list[1] !=''){
													//echo $list[1];	
													$gettmp['url_la'] = $config['website']."/la/".$group['url_la']."&main=".$i."&menu=".$x."&submenu=".$y;
												}else{
													//echo $list[0];	
													$gettmp['url_la'] = $config['website'].'/la/'.$group['url_la'].'?main='.$i.'&menu='.$x."&submenu=".$y;
												}												
											?>	
                                            <!-- Third dropdown -->                                            
                                                <a class="menu-item menu-dropdown-item" href="<?=$gettmp['url_la']?>">
                                                    <div>
														<?php if($sub['image'] != ''){ ?>
														<img src="../img_submenu/<?=$group['image']?>" class="mobile-icon head-menu-icon-mb-op-number">
														<?php } ?>
                                       			   		 <?=$group['title_la']?>
                                                    </div>
                                                </a>
                                                <div class="menu-dropdown-item-line"></div>
												<?php } // End for Groupmenu ?>
                                            </ul>
											
										<?php } ?>
                                        </li>    
										<?php } // End for Submenu ?>
                                    </ul>										
									<?php } ?>
                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </li>
							<?php } // End for menu ?>
                        </ul>
						<?php } ?>
                    </div>
                </li>
				<?php
							$sql = "SELECT i.* FROM menu_items i WHERE 1 = 1 AND i.parent_id = ? AND i.status = '1' AND i.status_la = '1' ORDER BY i.sequence ASC";
							$stmt = $db->Prepare($sql);
							$rs = $db->Execute($stmt,array('2'));
							$itemList = $rs->GetAssoc();
							$itemListCount = $rs->maxRecordCount();
						
				?>
                <li>
                    <div class="menu-item" id="active-main-menu-2">
                        <img src="./images/business-icon.svg" alt="" class="business-icon">
                        Corporate
                       <?php if($itemListCount > 0){ ?>
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">				
                        <!-- Dropdown -->
                        <ul class="menu-dropdown">
							<?php $i = 0; ?>
							<?php foreach ($itemList as $val) { ?>
							<?php $i++;?>	
                            <li class="menu-dropdown-li">
                                <div class="menu-item menu-dropdown-item">
                                    <div>
										<?php if($val['image'] != ''){ ?><img src="../img_menu/<?=$val['image']?>" class="mobile-icon"><?php } ?>
                                        <?=$val['title_la']?>
                                    </div>
									<?php
										$sql = "SELECT i.* FROM submenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($val['id']));
										$subList = $rs->GetAssoc();
										$subListCount = $rs->maxRecordCount();

									?>		
									<?php if($subListCount > 0){ ?>	
									
                                    <div>
                                        <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                    </div>
																		
                                    <!-- Sub dropdown -->
                                    <ul class="menu-dropdown sub-menu-dropdown">
										<?php $x = 0; ?>
										<?php foreach ($subList as $sub) { ?>
										<?php $x++;?>
										<?php
										$sql = "SELECT i.* FROM groupmenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($sub['id']));
										$groupList = $rs->GetAssoc();
										$groupListCount = $rs->maxRecordCount();

										?>	
										
                                        <li class="menu-dropdown-li sub-hover">
                                            <a class="menu-item menu-dropdown-item second-menu-item" href="<?=$config['website']?>/la/<?=$sub['url_la']?>">
                                                <div>
                                                   <?php if($sub['image'] != ''){ ?><img src="../img_submenu/<?=$sub['image']?>" class="mobile-icon"><?php } ?>
                                       			   <?=$sub['title_la']?>
                                                </div>
												<?php if($groupListCount > 0){ ?>
                                                <div>
                                                    <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                                </div>
												<?php } ?>

                                            </a>
                                            <div class="menu-dropdown-item-line"></div>
											
										
										<?php if($groupListCount > 0){ ?>	
											<ul class=" third-sub-menu-dropdown">	
										<?php $x = 0; ?>
										<?php foreach ($groupList as $group) { ?>
										<?php $x++;?>											
                                            <!-- Third dropdown -->                                            
                                                <a class="menu-item menu-dropdown-item" href="<?=$config['website']?>/la/<?=$group['url_la']?>">
                                                    <div>
														<?php if($sub['image'] != ''){ ?>
														<img src="../img_submenu/<?=$group['image']?>" class="mobile-icon head-menu-icon-mb-op-number">
														<?php } ?>
                                       			   		 <?=$group['title_la']?>
                                                    </div>
                                                </a>
                                                <div class="menu-dropdown-item-line"></div>
												<?php } // End for Groupmenu ?>
                                            </ul>
											
										<?php } ?>
                                        </li>    
										<?php } // End for Submenu ?>
                                    </ul>										
									<?php } ?>
                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </li>
							<?php } // End for menu ?>
                        </ul>
						<?php } ?>
                    </div>
                </li>
				<?php
							$sql = "SELECT i.* FROM menu_items i WHERE 1 = 1 AND i.parent_id = ? AND i.status = '1' AND i.status_la = '1' ORDER BY i.sequence ASC";
							$stmt = $db->Prepare($sql);
							$rs = $db->Execute($stmt,array('3'));
							$itemList = $rs->GetAssoc();
							$itemListCount = $rs->maxRecordCount();
						
				?>
                <li>
                    <a href="" class="menu-item" id="active-main-menu-3">
                        <img src="./images/laotel-store-icon.svg" alt="" class="laotel-store-icon">
                        Lao Telecom Store
                        <?php if($itemListCount > 0){ ?>
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">				
                        <!-- Dropdown -->
                        <ul class="menu-dropdown">
							<?php $i = 0; ?>
							<?php foreach ($itemList as $val) { ?>
							<?php $i++;?>	
                            <li class="menu-dropdown-li">
                                <div class="menu-item menu-dropdown-item">
                                    <div>
										<?php if($val['image'] != ''){ ?><img src="../img_menu/<?=$val['image']?>" class="mobile-icon"><?php } ?>
                                        <?=$val['title_la']?>
                                    </div>
									<?php
										$sql = "SELECT i.* FROM submenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($val['id']));
										$subList = $rs->GetAssoc();
										$subListCount = $rs->maxRecordCount();

									?>		
									<?php if($subListCount > 0){ ?>	
									
                                    <div>
                                        <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                    </div>
																		
                                    <!-- Sub dropdown -->
                                    <ul class="menu-dropdown sub-menu-dropdown">
										<?php $x = 0; ?>
										<?php foreach ($subList as $sub) { ?>
										<?php $x++;?>
										<?php
										$sql = "SELECT i.* FROM groupmenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($sub['id']));
										$groupList = $rs->GetAssoc();
										$groupListCount = $rs->maxRecordCount();

										?>	
										
                                        <li class="menu-dropdown-li sub-hover">
                                            <a class="menu-item menu-dropdown-item second-menu-item" href="<?=$config['website']?>/la/<?=$sub['url_la']?>">
                                                <div>
                                                   <?php if($sub['image'] != ''){ ?><img src="../img_submenu/<?=$sub['image']?>" class="mobile-icon"><?php } ?>
                                       			   <?=$sub['title_la']?>
                                                </div>
												<?php if($groupListCount > 0){ ?>
                                                <div>
                                                    <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                                </div>
												<?php } ?>

                                            </a>
                                            <div class="menu-dropdown-item-line"></div>
											
										
										<?php if($groupListCount > 0){ ?>	
											<ul class=" third-sub-menu-dropdown">	
										<?php $x = 0; ?>
										<?php foreach ($groupList as $group) { ?>
										<?php $x++;?>											
                                            <!-- Third dropdown -->                                            
                                                <a class="menu-item menu-dropdown-item" href="<?=$config['website']?>/la/<?=$group['url_la']?>">
                                                    <div>
														<?php if($sub['image'] != ''){ ?>
														<img src="../img_submenu/<?=$group['image']?>" class="mobile-icon head-menu-icon-mb-op-number">
														<?php } ?>
                                       			   		 <?=$group['title_la']?>
                                                    </div>
                                                </a>
                                                <div class="menu-dropdown-item-line"></div>
												<?php } // End for Groupmenu ?>
                                            </ul>
											
										<?php } ?>
                                        </li>    
										<?php } // End for Submenu ?>
                                    </ul>										
									<?php } ?>
                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </li>
							<?php } // End for menu ?>
                        </ul>
						<?php } ?>
                    </a>
                </li>

				<?php
							$sql = "SELECT i.* FROM menu_items i WHERE 1 = 1 AND i.parent_id = ? AND i.status = '1' AND i.status_la = '1' ORDER BY i.sequence ASC";
							$stmt = $db->Prepare($sql);
							$rs = $db->Execute($stmt,array('4'));
							$itemList = $rs->GetAssoc();
							$itemListCount = $rs->maxRecordCount();
						
				?>
                <li>
                    <div class="menu-item" id="active-main-menu-4">
                        <img src="./images/smart-reward-icon.svg" alt="" class="smart-reward-icon">
                        Smart Rewards
                       <?php if($itemListCount > 0){ ?>
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">				
                        <!-- Dropdown -->
                        <ul class="menu-dropdown">
							<?php $i = 0; ?>
							<?php foreach ($itemList as $val) { ?>
							<?php $i++;?>	
                            <li class="menu-dropdown-li">
                                <div class="menu-item menu-dropdown-item">
                                    <div>
										<?php if($val['image'] != ''){ ?><img src="../img_menu/<?=$val['image']?>" class="mobile-icon"><?php } ?>
                                        <?=$val['title_la']?>
                                    </div>
									<?php
										$sql = "SELECT i.* FROM submenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($val['id']));
										$subList = $rs->GetAssoc();
										$subListCount = $rs->maxRecordCount();

									?>		
									<?php if($subListCount > 0){ ?>	
									
                                    <div>
                                        <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                    </div>
																		
                                    <!-- Sub dropdown -->
                                    <ul class="menu-dropdown sub-menu-dropdown">
										<?php $x = 0; ?>
										<?php foreach ($subList as $sub) { ?>
										<?php $x++;?>
										<?php
										$sql = "SELECT i.* FROM groupmenu_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.parent_id = ? ORDER BY i.sequence ASC";
										$stmt = $db->Prepare($sql);
										$rs = $db->Execute($stmt,array($sub['id']));
										$groupList = $rs->GetAssoc();
										$groupListCount = $rs->maxRecordCount();

										?>	
										
                                        <li class="menu-dropdown-li sub-hover">
                                            <a class="menu-item menu-dropdown-item second-menu-item" href="<?=$config['website']?>/la/<?=$sub['url_la']?>">
                                                <div>
                                                   <?php if($sub['image'] != ''){ ?><img src="../img_submenu/<?=$sub['image']?>" class="mobile-icon"><?php } ?>
                                       			   <?=$sub['title_la']?>
                                                </div>
												<?php if($groupListCount > 0){ ?>
                                                <div>
                                                    <img src="./images/arrow-right-red.svg" class="arrow-right-icon">
                                                </div>
												<?php } ?>

                                            </a>
                                            <div class="menu-dropdown-item-line"></div>
											
										
										<?php if($groupListCount > 0){ ?>	
											<ul class=" third-sub-menu-dropdown">	
										<?php $x = 0; ?>
										<?php foreach ($groupList as $group) { ?>
										<?php $x++;?>											
                                            <!-- Third dropdown -->                                            
                                                <a class="menu-item menu-dropdown-item" href="<?=$config['website']?>/la/<?=$group['url_la']?>">
                                                    <div>
														<?php if($sub['image'] != ''){ ?>
														<img src="../img_submenu/<?=$group['image']?>" class="mobile-icon head-menu-icon-mb-op-number">
														<?php } ?>
                                       			   		 <?=$group['title_la']?>
                                                    </div>
                                                </a>
                                                <div class="menu-dropdown-item-line"></div>
												<?php } // End for Groupmenu ?>
                                            </ul>
											
										<?php } ?>
                                        </li>    
										<?php } // End for Submenu ?>
                                    </ul>										
									<?php } ?>
                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </li>
							<?php } // End for menu ?>
                        </ul>
						<?php } ?>
                    </div>
                </li>

                <li>
                    <a href="javascript:void();" class="menu-item" id="active-main-menu-5">
                        <img src="./images/search-icon.svg" alt="" class="search-icon">
                        Search
                    </a>
                </li>

                <li>
                    <a href="javascript:void();" class="menu-item" id="active-main-menu-6">
                        <img src="./images/profile-icon.svg" alt="" class="my-laotel-icon">
                        My Lao Telecom
                    </a>
                </li>

                <li>
                    <a href="javascript:void();" class="menu-item">
                        <img src="./images/en-icon.svg" alt="" class="flag">
                        <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">
                    </a>
                </li>
            </ul>

        </div>

        <!-- Responsive -->

        <div class="responsive-header-container">
            <div class="scroll-main-menu-responsive">
                <div class="header-sticky-responsive">
                    <div class="main-menu-responsive">
                        <a href="index.php" class="logo">
                            <img src="./images/logo.svg" alt="">
                        </a>

                        <div class="right-bars-menu">
                            <a href="" class="menu-item flex al-item-center">
                                <img src="./images/en-icon.svg" alt="" class="flag">
                                <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">
                            </a>

                            <div class="menu-bar-responsive" onclick="MainMenuBarDropdownResponsive()">
                                <div class="bars-responsive"></div>
                                <div class="bars-x-responsive"></div>
                            </div>
                        </div>
                    </div>

                    <div class="under-main-menu-responsive">

                        <div class="header-under-main-menu-responsive">
                            <a href="" class="menu-item" id="active-main-menu-5">
                                <img src="./images/search-icon.svg" alt="" class="search-icon">
                                Search
                            </a>


                            <a href="" class="menu-item" id="active-main-menu-6">
                                <img src="./images/profile-icon.svg" alt="" class="my-laotel-icon">
                                My Lao Telecom
                            </a>
                        </div>

                    </div>

                </div>

                <div class="drop-down-main-menu-responsive">
                    <div class="title-main-menu-responsive">
                        <div class="any-title-main-menu-responsive" id="title-main-menu-responsive-1"
                            onclick="MainMenuTitleDropdownResponsive(1)">
                            <div class="left-any-title-main-menu-responsive">
                                <img src="./images/person-icon.svg" alt="" class="consumer-icon">
                                <p id="title-main-menu-active-1">Consumer</p>
                            </div>
                            <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon"
                                id="arrow-title-main-menu-responsive-1">
                        </div>
                        <div class="all-subtitle-responsive" id="all-subtitle-responsive-1">
                            <div class="subtitle-main-menu-responsive">
                                <div class="any-subtitle-main-menu-responsive"
                                    id="any-subtitle-main-menu-responsive-1-1"
                                    onclick="MainMenuSubTitleDropdownResponsive(1,1)">
                                    <div class="left-any-subtitle-main-menu-responsive">
                                        <img src="./images/mobile-icon-red.svg" class="mobile-icon">
                                        <p>Mobile</p>
                                    </div>
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </div>

                                <div class="all-under-subtitle-responsive" id="all-under-subtitle-responsive-1-1">
                                    <a href="#nogo" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/monthly-red.svg" class="mobile-icon">
                                        <p>Monthly</p>
                                    </a>

                                    <a href="#nogo" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/mobile-prepaid-red.svg" class="mobile-icon">
                                        <p>Prepaid</p>
                                    </a>
                                </div>
                                <div class="menu-dropdown-item-line"></div>

                            </div>

                            <div class="subtitle-main-menu-responsive">
                                <div class="any-subtitle-main-menu-responsive"
                                    id="any-subtitle-main-menu-responsive-1-2"
                                    onclick="MainMenuSubTitleDropdownResponsive(1,2)">
                                    <div class="left-any-subtitle-main-menu-responsive">
                                        <img src="./images/wire-internet-red.svg" class="mobile-icon wire-icon">
                                        <p>Wired Internet</p>
                                    </div>
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </div>

                                <div id="all-under-subtitle-responsive-1-2" class="all-under-subtitle-responsive">
                                    <a href="Home-Digital-Phone.php"
                                        class="under-subtitle-main-menu-responsive">
                                        <img src="./images/Home-Digital-Phone.svg" class="mobile-icon">
                                        <p>Home Digital Phone</p>
                                    </a>

                                    <a href="#nogo" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/Winphone-Service.svg" class="mobile-icon">
                                        <p>Winphone Service</p>
                                    </a>

                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </div>

                            <div class="subtitle-main-menu-responsive">
                                <div class="any-subtitle-main-menu-responsive"
                                    id="any-subtitle-main-menu-responsive-1-3"
                                    onclick="MainMenuSubTitleDropdownResponsive(1,3)">
                                    <div class="left-any-subtitle-main-menu-responsive">
                                        <img src="./images/landline-red.svg" class="mobile-icon wire-icon">
                                        <p>Landline desk <br /> and Winphone Service</p>
                                    </div>
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </div>

                                <div class="all-under-subtitle-responsive" id="all-under-subtitle-responsive-1-3">
                                    <a href="nogo" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/monthly-red.svg" class="mobile-icon">
                                        <p>Coming Soon</p>
                                    </a>
                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </div>

                            <div class="subtitle-main-menu-responsive">
                                <div class="any-subtitle-main-menu-responsive"
                                    id="any-subtitle-main-menu-responsive-1-4"
                                    onclick="MainMenuSubTitleDropdownResponsive(1,4)">
                                    <div class="left-any-subtitle-main-menu-responsive">
                                        <img src="./images/additional-red.svg" class="mobile-icon additional-icon">
                                        <p>Additional Services <br /> Applications</p>
                                    </div>
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </div>

                                <div class="all-under-subtitle-responsive" id="all-under-subtitle-responsive-1-4">
                                    <a href="international-roaming.php" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/Service.svg" class="mobile-icon">
                                        <p>Service</p>
                                    </a>

                                    <a href="#nogo" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/top-up-inactive.svg" class="mobile-icon">
                                        <p>Top Up</p>
                                    </a>
                                </div>
                                <div class="menu-dropdown-item-line"></div>
                            </div>

                            <div class="subtitle-main-menu-responsive">
                                <div class="any-subtitle-main-menu-responsive"
                                    id="any-subtitle-main-menu-responsive-1-5"
                                    onclick="MainMenuSubTitleDropdownResponsive(1,5)">
                                    <div class="left-any-subtitle-main-menu-responsive">
                                        <img src="./images/about-ltc-red.svg" class="mobile-icon about-ltc-icon">
                                        <p>About Lao Telecom</p>
                                    </div>
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </div>

                                <div class="all-under-subtitle-responsive" id="all-under-subtitle-responsive-1-5">
                                    <a href="history.php" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/History.svg" class="mobile-icon">
                                        <p>History</p>
                                    </a>

                                    <a href="news-event.php" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/news&events.svg" class="mobile-icon">
                                        <p>News & Events</p>
                                    </a>

                                    <a href="career.php" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/career.svg" class="mobile-icon">
                                        <p>Career</p>
                                    </a>
                                </div>

                                <div class="menu-dropdown-item-line"></div>

                            </div>

                            <div class="subtitle-main-menu-responsive">
                                <div class="any-subtitle-main-menu-responsive"
                                    id="any-subtitle-main-menu-responsive-1-6"
                                    onclick="MainMenuSubTitleDropdownResponsive(1 ,6)">
                                    <div class="left-any-subtitle-main-menu-responsive">
                                        <img src="./images/contact-red.svg" class="mobile-icon">
                                        <p>Contact us</p>
                                    </div>
                                    <i class="fa-solid fa-plus"></i>
                                    <i class="fa-solid fa-minus"></i>
                                </div>

                                <div class="all-under-subtitle-responsive" id="all-under-subtitle-responsive-1-6">
                                    <a href="customer-service-center.php" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/customer-service-center.png" class="mobile-icon">
                                        <p>Customer Service Center</p>
                                    </a>

                                    <a href="enquiry.php" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/enquiry.png" class="mobile-icon">
                                        <p>Enquiry</p>
                                    </a>

                                    <a href="faq.php" class="under-subtitle-main-menu-responsive">
                                        <img src="./images/FAQ.png" class="mobile-icon">
                                        <p>FAQ</p>
                                    </a>
                                </div>

                                <div class="menu-dropdown-item-line"></div>

                            </div>
                        </div>

                    </div>

                    <div class="title-main-menu-responsive">
                        <div class="any-title-main-menu-responsive" id="title-main-menu-responsive-2"
                            onclick="MainMenuTitleDropdownResponsive(2)">
                            <div class="left-any-title-main-menu-responsive">
                                <img src="./images/business-icon.svg" alt="" class="business-icon">
                                <p>Business</p>
                            </div>
                            <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">
                        </div>

                        <div class="all-under-subtitle-responsive" id="all-subtitle-responsive-2">
                            <a href="cloud-computing.php" class="under-subtitle-main-menu-responsive">
                                <img src="./images/Cloud-Computing.svg" class="mobile-icon">
                                <p>Cloud Computing</p>
                            </a>
                            <div class="menu-dropdown-item-line"></div>

                            <a href="#nogo" class="under-subtitle-main-menu-responsive">
                                <img src="./images/HR-Platform &Accounting-Salary.svg" class="mobile-icon">
                                <p>HR Platform & Accounting Salary</p>
                            </a>
                            <div class="menu-dropdown-item-line"></div>

                            <a href="#nogo" class="under-subtitle-main-menu-responsive">
                                <img src="./images/ICT-Solution.svg" class="mobile-icon">
                                <p>ICT Solution</p>
                            </a>
                            <div class="menu-dropdown-item-line"></div>

                            <a href="#nogo" class="under-subtitle-main-menu-responsive">
                                <img src="./images/Point-of-Sale -Program.svg" class="mobile-icon">
                                <p>Point of Sale Program</p>
                            </a>
                            <div class="menu-dropdown-item-line"></div>
                        </div>

                    </div>

                    <div class="title-main-menu-responsive">
                        <div class="any-title-main-menu-responsive" id="title-main-menu-responsive-3"
                            onclick="MainMenuTitleDropdownResponsive(3)">
                            <div class="left-any-title-main-menu-responsive">
                                <img src="./images/laotel-store-icon.svg" alt="" class="laotel-store-icon">
                                <p>Lao Telecom Store</p>
                            </div>
                            <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">
                        </div>

                    </div>

                    <div class="title-main-menu-responsive">
                        <div class="any-title-main-menu-responsive" id="title-main-menu-responsive-4"
                            onclick="MainMenuTitleDropdownResponsive(4)">
                            <div class="left-any-title-main-menu-responsive">
                                <img src="./images/smart-reward-icon.svg" alt="" class="smart-reward-icon">
                                <p>Smart Rewards</p>
                            </div>
                            <img src="./images/arrow-down.svg" alt="" class="arrow-down-icon">
                        </div>

                        <div class="all-under-subtitle-responsive" id="all-subtitle-responsive-4">
                            <a href="how-to-check-score.php" class="under-subtitle-main-menu-responsive">
                                <img src="./images/How-to-Check-Score.svg" class="mobile-icon">
                                <p>How to Check Score</p>
                            </a>
                            <div class="menu-dropdown-item-line"></div>

                            <div class="under-subtitle-main-menu-responsive">
                                <img src="./images/How-to-Redeem-Rewards.svg" class="mobile-icon">
                                <p>How to Redeem Rewards</p>
                            </div>
                            <div class="menu-dropdown-item-line"></div>

                            <a href="#" class="under-subtitle-main-menu-responsive">
                                <img src="./images/Store-Discount.svg" class="mobile-icon">
                                <p>Store Discount</p>
                            </a>
                            <div class="menu-dropdown-item-line"></div>

                            <a href="#" class="under-subtitle-main-menu-responsive">
                                <img src="./images/Point-of-Sale -Program.svg" class="mobile-icon">
                                <p>Point of Sale Program</p>
                            </a>
                            <!-- <div class="menu-dropdown-item-line"></div> -->
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </header>