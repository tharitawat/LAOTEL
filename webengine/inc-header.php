<?php
//error_reporting(1);
require_once "common.inc.php";
require_once DIR."library/config/sessionstart.php";
require_once DIR."library/config/checksessionlogin.php";
require_once DIR."library/adodb5/adodb.inc.php";
require_once DIR."library/adodb5/adodb-active-record.inc.php";
require_once DIR."library/config/config.php";
require_once DIR."library/config/connect.php";
require_once DIR."library/extension/extension.php";
require_once DIR."library/extension/utility.php";
require_once DIR."library/extension/lang.php";
require_once DIR."library/config/rewrite.php";
require_once DIR."library/class/class.utility.php";

global $db;
global $config;

ADOdb_Active_Record::SetDatabaseAdapter($db);


class customer extends ADOdb_Active_Record{}
$item = new customer();
$item->Load("id = 1 AND status = 'Online' ");

?>
<div class="main-header side-header sticky nav nav-item">
					<div class=" main-container container-fluid">
						<div class="main-header-left ">
							<div class="responsive-logo">
								<a href="home.php" class="header-logo">
									<img src="assets/img/brand/logo.png" class="mobile-logo logo-1" alt="logo" height="55px">
									<!--<img src="assets/img/brand/logo-white.png" class="mobile-logo dark-logo-1" alt="logo">-->
								</a>
							</div>
							<div class="app-sidebar__toggle" data-bs-toggle="sidebar">
								<a class="open-toggle" href="javascript:void(0);"><i class="header-icon fe fe-align-left" ></i></a>
								<a class="close-toggle" href="javascript:void(0);"><i class="header-icon fe fe-x"></i></a>
							</div>
							<div class="logo-horizontal">
								<a href="home.php" class="header-logo">
									<img src="assets/img/brand/logo.png" class="mobile-logo logo-1" alt="logo" height="55px">
									<!--<img src="assets/img/brand/logo-white.png" class="mobile-logo dark-logo-1" alt="logo">-->
								</a>
							</div>
							 
						</div>
						<div class="main-header-right">
							 
							<div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0">
								<div class="collapse navbar-collapse" id="navbarSupportedContent-4">
									<ul class="nav nav-item header-icons navbar-nav-right ms-auto">
										
										<li class="dropdown nav-item main-header-notification d-flex">
											<a class="new nav-link"  data-bs-toggle="dropdown" href="javascript:void(0);">
												<svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" width="24" height="24" viewBox="0 0 24 24"><path d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z"/></svg><span class=" pulse"></span>
											</a>
											<div class="dropdown-menu">
												<div class="menu-header-content text-start border-bottom">
													<div class="d-flex">
														<h6 class="dropdown-title mb-1 tx-15 font-weight-semibold">Notifications</h6>
														<span class="badge badge-pill badge-warning ms-auto my-auto float-end">Mark All Read</span>
													</div>
													<p class="dropdown-title-text subtext mb-0 op-6 pb-0 tx-12 ">You have 0 unread Notifications</p>
												</div>
												<!--
												<div class="main-notification-list Notification-scroll">
													<a class="d-flex p-3 border-bottom" href="mail.html">
														<div class="notifyimg bg-pink">
															<i class="far fa-folder-open text-white"></i>
														</div>
														<div class="ms-3">
															<h5 class="notification-label mb-1">New files available</h5>
															<div class="notification-subtext">10 hour ago</div>
														</div>
														<div class="ms-auto" >
															<i class="las la-angle-right text-end text-muted"></i>
														</div>
													</a>
													<a class="d-flex p-3  border-bottom" href="mail.html">
														<div class="notifyimg bg-purple">
															<i class="fab fa-delicious text-white"></i>
														</div>
														<div class="ms-3">
															<h5 class="notification-label mb-1">Updates Available</h5>
															<div class="notification-subtext">2 days ago</div>
														</div>
														<div class="ms-auto" >
															<i class="las la-angle-right text-end text-muted"></i>
														</div>
													</a>
													<a class="d-flex p-3 border-bottom" href="mail.html">
														<div class="notifyimg bg-success">
															<i class="fa fa-cart-plus text-white"></i>
														</div>
														<div class="ms-3">
															<h5 class="notification-label mb-1">New Order Received</h5>
															<div class="notification-subtext">1 hour ago</div>
														</div>
														<div class="ms-auto" >
															<i class="las la-angle-right text-end text-muted"></i>
														</div>
													</a>
												</div>
												<div class="dropdown-footer">
													<a class="btn btn-primary btn-sm btn-block" href="mail.html">VIEW ALL</a>
												</div>
												-->
											</div>
										</li>									
										
										
										<li class="dropdown main-profile-menu nav nav-item nav-link ps-lg-2">
											<a class="new nav-link profile-user d-flex" href="" data-bs-toggle="dropdown">
												<?php $image = Lang::getUser($_SESSION['login_admin']['id'],'image')?> 
														  <?php if($image != ''){ ?>  
															<img src="<?= $config['website'] ?>/img_user/thumbnail/<?=$image?>" alt="avatar">  
															<?php }else{ ?>  
															<img alt="" src="assets/img/faces/2.jpg" class="">
															<?php } ?> 
											</a>
											<div class="dropdown-menu">
												<div class="menu-header-content p-3 border-bottom">
													<div class="d-flex wd-100p">
														<div class="main-img-user">
														  <?php if($image != ''){ ?>  
															<img src="<?= $config['website'] ?>/img_user/thumbnail/<?=$image?>" alt="avatar">  
															<?php }else{ ?>  
															<img alt="" src="assets/img/faces/2.jpg" class="">
															<?php } ?> 
														</div>
														<div class="ms-3 my-auto">
															<h6 class="tx-15 font-weight-semibold mb-0"><?=$_SESSION['login_admin']['fullname']?></h6><span class="dropdown-title-text subtext op-6  tx-12"><?=$_SESSION['login_admin']['type']?></span>
														</div>
													</div>
												</div>
												<a class="dropdown-item" href="user-item-edit.php?id=<?=$_SESSION['login_admin']['id']?>"><i class="far fa-user-circle"></i>Profile</a>												
												<a class="dropdown-item" href="logout.php"><i class="far fa-arrow-alt-circle-left"></i> Sign Out</a>
											</div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>