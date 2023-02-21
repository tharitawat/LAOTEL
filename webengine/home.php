<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;
 
?>
<!DOCTYPE html>
<html lang="en" style="--primary-bg-color:#ff0000; --primary-bg-hover:#ff000095; --primary-bg-border:#ff0000; --primary-transparentcolor:#ff000020; --primary01:rgba(250, 0, 0, 0.1); --primary02:rgba(250, 0, 0, 0.2); --primary03:rgba(250, 0, 0, 0.3); --primary06:rgba(250, 0, 0, 0.6); --primary09:rgba(250, 0, 0, 0.9); --primary05:rgba(250, 0, 0, 0.5);">
	<head>
		<style data-merge-styles="true"></style>
	

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="">
		<meta name="Author" content="">
		<meta name="Keywords" content=""/>

		<!-- Title -->
		<title>::: WEBENGINE ::: <?=$config['customer_name']?></title>

		<!-- Favicon -->
		<link rel="icon" href="assets/img/brand/favicon.png" type="image/x-icon"/>

		<!-- Icons css -->
		<link href="assets/css/icons.css" rel="stylesheet">

		<!--  bootstrap css-->
		<link id="style" href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />

		<!-- style css -->
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/style-dark.css" rel="stylesheet">
		<link href="assets/css/style-transparent.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="assets/css/skin-modes.css" rel="stylesheet" />

	</head>

	<body class="ltr main-body app light-theme horizontal color-menu">

		<!-- Loader -->
		<div id="global-loader">
			<img src="assets/img/loader.svg" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->

		<!-- Page -->
		<div class="page">

			<div>
				<!-- main-header -->
				<?php require_once('inc-header.php'); ?>
				<!-- /main-header -->

				<!-- main-sidebar -->
				<?php require_once('inc-menu.php'); ?>				
				<!-- main-sidebar -->
			</div>

			<!-- main-content -->
			<div class="main-content app-content">

				<!-- container -->
				<div class="main-container container-fluid">

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content">
						<span class="main-content-title mg-b-0 mg-b-lg-1">HOME</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Menu</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

					<!-- Start Content -->
					<div class="row" style="display: none">
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fa fa-list-alt"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">ผลิตภัณฑ์ </p>
										<h6 class="card-title mb-1">PRODUCT</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">									
									
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fa fa-list-alt"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">การจัดการสินค้าเช่า</p>
										<h6 class="card-title mb-1">RENTAL</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fa fa-list-alt"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">งานบริการ</p>
										<h6 class="card-title mb-1">SERVICE</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fa fa-list-alt"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">งานติดตั้ง</p>
										<h6 class="card-title mb-1">INSTALLATION</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">สมาชิก</p>
										<h6 class="card-title mb-1">MEMBER</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">โปรโมชั่น</p>
										<h6 class="card-title mb-1">PROMOTION</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
						<a href="banner-item-list.php">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">แบนเนอร์</p>
										<h6 class="card-title mb-1">BANNER</h6>
									</div>
								</div>
							</div>
						</a>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">แนะนำสินค้า</p>
										<h6 class="card-title mb-1">REVIEW</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">รายการสั่งซื้อ</p>
										<h6 class="card-title mb-1">ORDER</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">ขอใบเสนอราคา</p>
										<h6 class="card-title mb-1">REQUEST QUOTATION</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">การจัดส่ง</p>
										<h6 class="card-title mb-1">SHIPPING</h6>
									</div>
								</div>
							</div>
						</div>
						<div class="col-sm-6 col-md-6 col-lg-4 col-xl-3">
							<a href="user-item-list.php">
							<div class="card custom-card text-center">
								<div class="card-body">
									<div class="btn ripple btn-info-gradient" id='swal-basic'>
										<i class="fas fa-globe-americas"></i>
									</div>
									<div>
										<p class="text-muted card-sub-title mb-1">เจ้าหน้าที่</p>
										<h6 class="card-title mb-1">USER</h6>
									</div>
								</div>
							</div>
							</a>	
						</div>
					</div>
					<!-- End Content -->

				</div>
				<!-- /Container -->
			</div>
			<!-- /main-content -->


			<!-- Footer opened -->
			<?php require_once('inc-footer.php'); ?>			
			<!-- Footer closed -->
		</div>
		<!-- End Page -->

		<!-- Back-to-top -->
		<a href="#top" id="back-to-top"><i class="las la-arrow-up"></i></a>

		<!-- JQuery min js -->
		<script src="assets/plugins/jquery/jquery.min.js"></script>

		<!-- Bootstrap js -->
		<script src="assets/plugins/bootstrap/js/popper.min.js"></script>
		<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>

		<!-- Internal Chart.Bundle js-->
		<script src="assets/plugins/chart.js/Chart.bundle.min.js"></script>

		<!-- Moment js -->
		<script src="assets/plugins/moment/moment.js"></script>

		<!-- INTERNAL Apexchart js -->
		<script src="assets/js/apexcharts.js"></script>

		<!--Internal Sparkline js -->
		<script src="assets/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>

		<!-- Moment js -->
		<script src="assets/plugins/raphael/raphael.min.js"></script>

		<!--Internal  Perfect-scrollbar js -->
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/p-scroll.js"></script>

		<!-- Eva-icons js -->
		<script src="assets/js/eva-icons.min.js"></script>

		<!-- right-sidebar js -->
		<script src="assets/plugins/sidebar/sidebar.js"></script>
		<script src="assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- Sidebar js -->
		<script src="assets/plugins/side-menu/sidemenu.js"></script>

		<!-- Sticky js -->
		<script src="assets/js/sticky.js"></script>

		<!--Internal  index js -->
		<script src="assets/js/index.js"></script>

		<!-- Chart-circle js -->
		<script src="assets/js/circle-progress.min.js"></script>

		<!-- Internal Data tables -->
		<script src="assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
		<script src="assets/plugins/datatable/js/dataTables.bootstrap5.js"></script>
		<script src="assets/plugins/datatable/dataTables.responsive.min.js"></script>
		<script src="assets/plugins/datatable/responsive.bootstrap5.min.js"></script>

		<!-- INTERNAL Select2 js -->
		<script src="assets/plugins/select2/js/select2.full.min.js"></script>
		<script src="assets/js/select2.js"></script>

		<!-- Theme Color js -->
		<script src="assets/js/themecolor.js"></script>

		<!-- custom js -->
		<script src="assets/js/custom.js"></script>

	</body>
</html>