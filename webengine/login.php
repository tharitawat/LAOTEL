<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;
 
?>
<!DOCTYPE html>
<html lang="en" style="--primary-bg-color:#fa0000; --primary-bg-hover:#fa000095; --primary-bg-border:#fa0000; --primary-transparentcolor:#fa000020; --primary01:rgba(250, 0, 0, 0.1); --primary02:rgba(250, 0, 0, 0.2); --primary03:rgba(250, 0, 0, 0.3); --primary06:rgba(250, 0, 0, 0.6); --primary09:rgba(250, 0, 0, 0.9); --primary05:rgba(250, 0, 0, 0.5);">
	<head>
		<style data-merge-styles="true"></style>
	

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="บริษัท ยูชิ กรุ๊ป จำกัด - YUSHI GROUP ศูนย์รวมสินค้าอุตสาหกรรมแบบครบวงจร และระบบระบายอากาศภายในโรงงาน พัดลมอุตสาหกรรม เครื่องทำลมเย็น พัดลมไอเย็น พัดลมยักษ์">
		<meta name="Author" content="บริษัท ยูชิ กรุ๊ป จำกัด - YUSHI GROUP">
		<meta name="Keywords" content="บริษัท ยูชิ กรุ๊ป จำกัด - YUSHI GROUP ศูนย์รวมสินค้าอุตสาหกรรมแบบครบวงจร และระบบระบายอากาศภายในโรงงาน พัดลมอุตสาหกรรม เครื่องทำลมเย็น พัดลมไอเย็น พัดลมยักษ์"/>

		<!-- Title -->
		<title>::: WEBENGINE ::: <?=$config['customer_name']?></title>

		<!-- Favicon -->
		<link rel="apple-touch-icon" sizes="57x57" href="favicon/apple-icon-57x57.png">
		<link rel="apple-touch-icon" sizes="60x60" href="favicon/apple-icon-60x60.png">
		<link rel="apple-touch-icon" sizes="72x72" href="favicon/apple-icon-72x72.png">
		<link rel="apple-touch-icon" sizes="76x76" href="favicon/apple-icon-76x76.png">
		<link rel="apple-touch-icon" sizes="114x114" href="favicon/apple-icon-114x114.png">
		<link rel="apple-touch-icon" sizes="120x120" href="favicon/apple-icon-120x120.png">
		<link rel="apple-touch-icon" sizes="144x144" href="favicon/apple-icon-144x144.png">
		<link rel="apple-touch-icon" sizes="152x152" href="favicon/apple-icon-152x152.png">
		<link rel="apple-touch-icon" sizes="180x180" href="favicon/apple-icon-180x180.png">
		<link rel="icon" type="image/png" sizes="192x192"  href="favicon/android-icon-192x192.png">
		<link rel="icon" type="image/png" sizes="32x32" href="favicon/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="favicon/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="favicon/favicon-16x16.png">
		<link rel="manifest" href="favicon/manifest.json">
		<meta name="msapplication-TileColor" content="#ffffff">
		<meta name="msapplication-TileImage" content="favicon/ms-icon-144x144.png">
		<meta name="theme-color" content="#ffffff">		
		<link rel="icon" href="favicon.ico" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="assets/css/icons.css" rel="stylesheet">

		<!--  bootstrap css-->
		<link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

		<!--- Style css --->
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/style-dark.css" rel="stylesheet">
		<link href="assets/css/style-transparent.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="assets/css/skin-modes.css" rel="stylesheet" />

		<!--- Animations css-->
		<link href="assets/css/animate.css" rel="stylesheet">
<style>
	.bg-login{ margin:140px 0 0 0; padding:0; background:url(assets/images/bg.jpg) no-repeat top center; background-size:cover }
</style>
	</head>
	<body class="ltr main-body app light-theme horizontal color-menu bg-login">

		<!-- Loader -->
		<div id="global-loader">
			<img src="assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		
		<div class="page" >
			<div class="page-single">
				<div class="container">
					<div class="row">
						<div class="col-xl-5 col-lg-6 col-md-8 col-sm-8 col-xs-10 card-sigin-main mx-auto my-auto py-4 justify-content-center">
							<div class="card-sigin">
								 <!-- Demo content-->
								 <div class="main-card-signin d-md-flex">
									 <div class="wd-100p">
										 <div class="d-flex" align="center">	 
										 <img src="assets/images/logo.png" alt="logo">
										 </div> 
										 <div class="">
											<div class="main-signup-header" style="color:#343896">
												<div align="center">
												<h3 style="color:#343896;">Webengine System</h3>
												<h6 class="font-weight-semibold mb-4">Please sign in to continue.</h6>
												</div>	
												<div class="panel panel-primary">											   
												   <div class="panel-body tabs-menu-body border-0 p-3">
													   <div class="tab-content">
														   <div class="tab-pane active" id="tab5">
															   <form action="check-login.php" method="post" enctype="multipart/form-data" name="formLogin" id="formLogin">
																   <div class="form-group">
																	   <label>Email</label> <input class="form-control" placeholder="Enter your email" type="text" name="email" id="email">
																   </div>
																   <div class="form-group">
																	   <label>Password</label> <input class="form-control" placeholder="Enter your password" type="password" name="password" id="password">
																   </div><button class="btn btn-block" style="background-color: #FF0000; border-color: #FF0000;color:white">Login</button>
																   <input type="hidden" name="do" id="do" value="login">
																</form>
														   </div>
														   
													   </div>
												   </div>
											   </div>

												<div class="main-signin-footer text-center mt-3">
													<p><a href="" class="mb-3">Forgot password?</a></p>
												</div>
											</div>
										 </div>
									 </div>
								 </div>
							 </div>
						 </div>
					</div>
				</div>
			</div>
		</div>

		<!-- JQuery min js -->
		<script src="assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap js -->
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- Moment js -->
		<script src="assets/plugins/moment/moment.js"></script>

		<!-- eva-icons js -->
		<script src="assets/js/eva-icons.min.js"></script>

		<!-- generate-otp js -->
		<script src="assets/js/generate-otp.js"></script>

		<!--Internal  Perfect-scrollbar js -->
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>

		<!-- Theme Color js -->
		<script src="assets/js/themecolor.js"></script>

		<!-- custom js -->
		<script src="assets/js/custom.js"></script>

	</body>
</html>