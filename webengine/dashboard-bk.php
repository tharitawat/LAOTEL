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
						<span class="main-content-title mg-b-0 mg-b-lg-1">DASHBOARD</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Dashboard</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

					<!-- row -->
					<div class="row">
						<div class="col-xxl-5 col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<div class="row">
								
								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
									<div class="card sales-card">
										<div class="row">
											<div class="col-8">
												<div class="ps-4 pt-4 pe-3 pb-4">
													<div class="">
														<h6 class="mb-2 tx-12 ">Today Orders</h6>
													</div>
													<div class="pb-0 mt-0">
														<div class="d-flex">
															<h4 class="tx-20 font-weight-semibold mb-2">55</h4>
														</div>														
													</div>
												</div>
											</div>
											<div class="col-4">
												<div class="circle-icon bg-primary-transparent text-center align-self-center overflow-hidden">
													<i class="fe fe-shopping-bag tx-16 text-primary"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
									<div class="card sales-card">
										<div class="row">
											<div class="col-8">
												<div class="ps-4 pt-4 pe-3 pb-4">
													<div class="">
														<h6 class="mb-2 tx-12">Today Paid</h6>
													</div>
													<div class="pb-0 mt-0">
														<div class="d-flex">
															<h4 class="tx-20 font-weight-semibold mb-2">฿ 555</h4>
														</div>														
													</div>
												</div>
											</div>
											<div class="col-4">
												<div class="circle-icon bg-info-transparent text-center align-self-center overflow-hidden">
													<i class="fa fa-bold tx-16 text-info"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
									<div class="card sales-card">
										<div class="row">
											<div class="col-8">
												<div class="ps-4 pt-4 pe-3 pb-4">
													<div class="">
														<h6 class="mb-2 tx-12">Total Orders</h6>
													</div>
													<div class="pb-0 mt-0">
														<div class="d-flex">
															<h4 class="tx-20 font-weight-semibold mb-2">5,555</h4>
														</div>
														
													</div>
												</div>
											</div>
											<div class="col-4">
												<div class="circle-icon bg-secondary-transparent text-center align-self-center overflow-hidden">
												<i class="fe fe-shopping-bag tx-16 text-primary"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-xs-12">
									<div class="card sales-card">
										<div class="row">
											<div class="col-8">
												<div class="ps-4 pt-4 pe-3 pb-4">
													<div class="">
														<h6 class="mb-2 tx-12">Total Paid</h6>
													</div>
													<div class="pb-0 mt-0">
														<div class="d-flex">
															<h4 class="tx-22 font-weight-semibold mb-2">฿ 555,555</h4>
														</div>
														
													</div>
												</div>
											</div>
											<div class="col-4">
												<div class="circle-icon bg-warning-transparent text-center align-self-center overflow-hidden">
												<i class="fa fa-bold tx-16 text-info"></i>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-xl-12 col-lg-12 col-md-12 col-xs-12">
									<div class="card">
										<div class="card-header pb-1">
											<h3 class="card-title mb-2">Product Top View</h3>
										</div>
										<div class="card-body p-0">
											<div class="browser-stats">
												<div class="d-flex align-items-center item  border-bottom my-2">
													<div class="d-flex">
														<img src="https://yushi.shoppinglao.com/assets/images/product/product-cover-2.webp" alt="img" class="ht-30 wd-30 me-2">
														<div class="">
															<h6 class="">พัดลมระบายอากาศแบบมีตะแกรง หน้า-หลัง</h6>
															<span class="text-muted tx-12">สินค้าเช่า</span>
														</div>
													</div>
													<div class="ms-auto my-auto">
														<div class="d-flex">
															<span class="me-4 mt-1 font-weight-semibold tx-16">1,500 ฿ - 3,500 ฿</span>
															<span class="text-danger"><i class="fas fa-eye"></i> 150</span>
														</div>
													</div>
												</div>
												<div class="d-flex align-items-center item  border-bottom my-2">
													<div class="d-flex">
														<img src="https://yushi.shoppinglao.com/assets/images/product/product-cover-1.webp" alt="img" class="ht-30 wd-30 me-2">
														<div class="">
															<h6 class="">พัดลมระบายอากาศแบบมีตะแกรง หน้า-หลัง</h6>
															<span class="text-muted tx-12">ผลิตภัณฑ์</span>
														</div>
													</div>
													<div class="ms-auto my-auto">
														<div class="d-flex">
															<span class="me-4 mt-1 font-weight-semibold tx-16">1,500 ฿ - 3,500 ฿</span>
															<span class="text-danger"><i class="fas fa-eye"></i> 145</span>
														</div>
													</div>
												</div>
												<div class="d-flex align-items-center item  border-bottom my-2">
													<div class="d-flex">
														<img src="https://yushi.shoppinglao.com/assets/images/product/product-cover-2.webp" alt="img" class="ht-30 wd-30 me-2">
														<div class="">
															<h6 class="">พัดลมระบายอากาศแบบมีตะแกรง หน้า-หลัง</h6>
															<span class="text-muted tx-12">สินค้าเช่า</span>
														</div>
													</div>
													<div class="ms-auto my-auto">
														<div class="d-flex">
															<span class="me-4 mt-1 font-weight-semibold tx-16">1,500 ฿ - 3,500 ฿</span>
															<span class="text-danger"><i class="fas fa-eye"></i> 130</span>
														</div>
													</div>
												</div>
												<div class="d-flex align-items-center item  border-bottom my-2">
													<div class="d-flex">
														<img src="https://yushi.shoppinglao.com/assets/images/product/product-cover-1.webp" alt="img" class="ht-30 wd-30 me-2">
														<div class="">
															<h6 class="">พัดลมระบายอากาศแบบมีตะแกรง หน้า-หลัง</h6>
															<span class="text-muted tx-12">ผลิตภัณฑ์</span>
														</div>
													</div>
													<div class="ms-auto my-auto">
														<div class="d-flex">
															<span class="me-4 mt-1 font-weight-semibold tx-16">1,500 ฿ - 3,500 ฿</span>
															<span class="text-danger"><i class="fas fa-eye"></i> 120</span>
														</div>
													</div>
												</div>
												<div class="d-flex align-items-center item  border-bottom my-2">
													<div class="d-flex">
														<img src="https://yushi.shoppinglao.com/assets/images/product/product-cover-1.webp" alt="img" class="ht-30 wd-30 me-2">
														<div class="">
															<h6 class="">พัดลมระบายอากาศแบบมีตะแกรง หน้า-หลัง</h6>
															<span class="text-muted tx-12">ผลิตภัณฑ์</span>
														</div>
													</div>
													<div class="ms-auto my-auto">
														<div class="d-flex">
															<span class="me-4 mt-1 font-weight-semibold tx-16">1,500 ฿ - 3,500 ฿</span>
															<span class="text-danger"><i class="fas fa-eye"></i> 100</span>
														</div>
													</div>
												</div>
												<div class="d-flex align-items-center item  border-bottom my-2">
													<div class="d-flex">
														<img src="https://yushi.shoppinglao.com/assets/images/product/product-cover-1.webp" alt="img" class="ht-30 wd-30 me-2">
														<div class="">
															<h6 class="">พัดลมระบายอากาศแบบมีตะแกรง หน้า-หลัง</h6>
															<span class="text-muted tx-12">สินค้าเช่า</span>
														</div>
													</div>
													<div class="ms-auto my-auto">
														<div class="d-flex">
															<span class="me-4 mt-1 font-weight-semibold tx-16">1,500 ฿ - 3,500 ฿</span>
															<span class="text-danger"><i class="fas fa-eye"></i> 90</span>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-xxl-7 col-xl-12 col-lg-12 col-md-12 col-sm-12">
							<!--
							<div class="card custom-card overflow-hidden">
								<div class="card-header border-bottom-0">
									<div>
										<h3 class="card-title mb-2 ">Product View</h3> <span class="d-block tx-12 mb-0 text-muted"></span>
									</div>
								</div>
								<div class="card-body">
									<div id="statistics1"></div>
								</div>
							</div>
							-->
							<div class="row">
								<div class="col-sm-12 col-lg-12 col-xl-6">
									<div class="card overflow-hidden">
										<div class="card-header pb-1">
											<h3 class="card-title mb-2">Request Quotations</h3>
										</div>
										<div class="card-body p-0 customers mt-1">
											<div class="list-group list-lg-group list-group-flush">
												<a href="javascript:void(0);" class="border-0">
												<div class="list-group-item list-group-item-action border-0">
													<div class="media mt-0">
														<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/2.jpg" alt="Image description">
														<div class="media-body">
															<div class="d-flex align-items-center">
																<div class="mt-0">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																</div>
																<span class="ms-auto wd-45p tx-14">
																	<span class="float-end badge badge-success-transparent">
																	<span class="op-7 text-success font-weight-semibold">New </span>
																</span>
																</span>
															</div>
														</div>
													</div>
												</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/1.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																	</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/5.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p  tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																	</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/7.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/9.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/11.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																	</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/11.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																	</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/11.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																	</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/11.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																	</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												<a href="javascript:void(0);" class="border-0">
													<div class="list-group-item list-group-item-action border-0" >
														<div class="media mt-0">
															<img class="avatar-lg rounded-circle me-3 my-auto shadow" src="assets/img/faces/11.jpg" alt="Image description">
															<div class="media-body">
																<div class="d-flex align-items-center">
																	<div class="mt-1">
																	<h5 class="mb-1 tx-13 font-weight-sembold text-dark">นายสมชาย ทดสอบ</h5>
																	<p class="mb-0 tx-12 text-muted">QO ID: #12345</p>
																	</div>
																	<span class="ms-auto wd-45p tx-14">
																		<span class="float-end badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">New </span>
																	</span>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</a>
												
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-12 col-xl-6">
									<div class="card">
										<div class="card-header pb-3">
											<h3 class="card-title mb-2">JOB TASKS</h3>
										</div>
										<div class="card-body p-0 customers mt-1">
											<div class="">
												<label class="p-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto">
														Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"><span class="badge badge-primary-transparent font-weight-semibold px-2 py-1 tx-11 me-2">Today</span></span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto">
													Order ID # 12345 : ติดตั้งพัดลมลาดกระบัง
													</span>
													<span class="ms-auto"><span class="badge badge-primary-transparent font-weight-semibold px-2 py-1 tx-11 me-2">Today</span></span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"><span class="badge badge-primary-transparent font-weight-semibold px-2 py-1 tx-11 me-2 float-end">22 hrs</span></span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> <span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">1 Day</span></span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
												<label class="p-2 mt-2 d-flex">
													<span class="check-box mb-0 ms-2">
														<span class="ckbox"><input type="checkbox"><span></span></span>
													</span>
													<span class="mx-3 my-auto mb-4">
													Order ID # 12345 : เก็บเต้นเช่า ฉะเชิงเทรา
													</span>
													<span class="ms-auto"> 
														<span class="badge badge-light-transparent font-weight-semibold px-2 py-1 tx-11 me-2">2 Days</span>
													</span>
												</label>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- </div> -->
					</div>
					<!-- row closed -->


					<!-- row  -->
					<div class="row">
						<div class="col-12 col-sm-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Order Summary</h4>
								</div>
								<div class="card-body pt-0 example1-table">
									<div class="table-responsive">
										<table class="table  table-bordered text-nowrap mb-0">
											<thead>
												<tr>
													<th class="text-center">Purchase Date</th>
													<th>Client Name</th>
													<th>Order ID</th>
													<th>Product</th>
													<th>Product Cost</th>
													<th>Payment Mode</th>
													<th>Status</th>
												</tr>
											</thead>
											<tbody>
												
												<tr>
													<td class="text-center">DD/MM/YY </td>
													<td>n/a </td>
													<td>n/a </td>
													<td>n/a</td>
													<td>n/a</td>
													<td>n/a</td>
													<td>n/a</td>
												</tr>
												<!--
												<tr>
													<td class="text-center">#02</td>
													<td>Evan Rees</td>
													<td>PRO8765</td>
													<td>Thomson R9 122cm (48 inch) Full HD LED TV </td>
													<td>$30,000</td>
													<td>Cash on delivered</td>
													<td><span class="badge badge-primary">Add Cart</span></td>
												</tr>
												<tr>
													<td class="text-center">#03</td>
													<td>David Wallace</td>
													<td>PRO54321</td>
													<td>Vu 80cm (32 inch) HD Ready LED TV</td>
													<td>$13,200</td>
													<td>Online Payment</td>
													<td><span class="badge badge-orange">Pending</span></td>
												</tr>
												<tr>
													<td class="text-center">#04</td>
													<td>Julia Bower</td>
													<td>PRO97654</td>
													<td>Micromax 81cm (32 inch) HD Ready LED TV</td>
													<td>$15,100</td>
													<td>Cash on delivered</td>
													<td><span class="badge badge-secondary">Delivering</span></td>
												</tr>
												<tr>
													<td class="text-center">#05</td>
													<td>Kevin James</td>
													<td>PRO4532</td>
													<td>HP 200 Mouse &amp; Wireless Laptop Keyboard </td>
													<td>$5,987</td>
													<td>Online Payment</td>
													<td><span class="badge badge-danger">Shipped</span></td>
												</tr>
												<tr>
													<td class="text-center">#06</td>
													<td>Theresa	Wright</td>
													<td>PRO6789</td>
													<td>Digisol DG-HR3400 Router </td>
													<td>$11,987</td>
													<td>Cash on delivered</td>
													<td><span class="badge badge-secondary">Delivering</span></td>
												</tr>
												<tr>
													<td class="text-center">#07</td>
													<td>Sebastian	Black</td>
													<td>PRO4567</td>
													<td>Dell WM118 Wireless Optical Mouse</td>
													<td>$4,700</td>
													<td>Online Payment</td>
													<td><span class="badge badge-info">Add to Cart</span></td>
												</tr>
												<tr>
													<td class="text-center">#08</td>
													<td>Kevin Glover</td>
													<td>PRO32156</td>
													<td>Dell 16 inch Laptop Backpack </td>
													<td>$678</td>
													<td>Cash On delivered</td>
													<td><span class="badge badge-pink">Delivered</span></td>
												</tr>
												-->
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /row closed -->

					<!-- row  -->
					<div class="row">
						<div class="col-12 col-sm-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Promotion Active</h4>
								</div>
								<div class="card-body pt-0 example1-table">
									<div class="table-responsive">
										<table class="table  table-bordered text-nowrap mb-0">
											<thead>
												<tr>
													<th class="text-center">Active Date</th>
													<th>Promotion Name</th>
													<th>Type</th>
													<th>Product Active</th>
													<th>Start Date</th>
													<th>End Date</th>
												</tr>
											</thead>
											<tbody>
												
												<tr>
													<td class="text-center">DD/MM/YY </td>
													<td>ฉลองเปิดเว็บใหม่ ลดสินค้าทุกรายการ ลด 3% </td>
													<td>Product Discount </td>
													<td class="text-center"><span class="ms-auto wd-45p tx-14">
																		<span class="badge badge-success-transparent ">
																		<span class="op-7 text-success font-weight-semibold">0 item </span>
																	</span></td>
													<td>DD/MM/YY</td>
													<td>DD/MM/YY</td>
												</tr>											
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- /row closed -->
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