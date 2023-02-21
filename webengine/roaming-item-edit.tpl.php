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

		<!--- Style css --->
		<link href="assets/css/style.css" rel="stylesheet">
		<link href="assets/css/style-dark.css" rel="stylesheet">
		<link href="assets/css/style-transparent.css" rel="stylesheet">

		<!---Skinmodes css-->
		<link href="assets/css/skin-modes.css" rel="stylesheet" />

		<!--- Animations css-->
		<link href="assets/css/animate.css" rel="stylesheet">

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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Roaming Service Rate</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
								<li class="breadcrumb-item" aria-current="page"><a href="service-category-list.php">Service & Package</a></li>
								<li class="breadcrumb-item" aria-current="page"><a href="service-group-list.php?parent_id=<?=$this->group->parent_id?>"><?=$this->cate->title_la?></a></li>
								<li class="breadcrumb-item" aria-current="page"><a href="service-layer-list.php?parent_id=<?=$this->layer->parent_id?>"><?=$this->group->title_la?></a></li>
								<li class="breadcrumb-item active" aria-current="page"><?=$this->layer->title_la?></li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

					<!-- row -->
					<div class="row">
						<div class="col-xl-12">
							<!-- div -->
							<form method="post" enctype="multipart/form-data" class="form-horizontal" role="form" data-toggle="validator" name="form1" id="form1" action="">
							<div class="card mg-b-20" id="tabs-style2">
								<div class="card-body">
									<div class="main-content-label mg-b-5">
										<h3>EDIT DATA</h3>
									</div>
									
									<div class="text-wrap">
										<div class="example">																						

											<div class="control-group form-group">
												<label class="form-label">Select Country</label>
												<select class="form-select border" name="country_id" id="country_id" required>
													<option value="">Select Country </option>
													<?php foreach ($this->countryList AS $var) { ?>
													 <option value="<?= $var['id'] ?>"<?=($this->item->country_id  == $var['country_id'])? ' selected':''?>><?= $var['title_la'] ?> </option>
													 <?php } // foreach ?>
												 </select>
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Type</label>
												<select class="form-select border" name="type" id="type" required>
													<option value="">Select Type </option>
													 <option value="1"<?=($this->item->type  == '1')? ' selected':''?>>Post Paid</option>
													 <option value="2"<?=($this->item->type  == '2')? ' selected':''?>>Pre Paid</option>
												 </select>
											</div>
											
											
											<div class="control-group form-group">
												<label class="form-label">Operator Name</label>
												<input type="text" class="form-control" placeholder="Operator Name" id="operator_name" name="operator_name" value="<?= ($_SESSION['item_form']['operator_name'] != null) ? $_SESSION['item_form']['operator_name'] : $this->item->operator_name ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Network Name/TD code</label>
												<input type="text" class="form-control" placeholder="Network Name" id="network_name" name="network_name" value="<?= ($_SESSION['item_form']['network_name'] != null) ? $_SESSION['item_form']['network_name'] : $this->item->network_name ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Local Call (Kip/Min)</label>
												<input type="text" class="form-control" placeholder="Local Call" id="local_call" name="local_call" value="<?= ($_SESSION['item_form']['local_call'] != null) ? $_SESSION['item_form']['local_call'] : $this->item->local_call ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Recevied Call (Kip/Min)</label>
												<input type="text" class="form-control" placeholder="Recevied Call" id="recevied_call" name="recevied_call" value="<?= ($_SESSION['item_form']['recevied_call'] != null) ? $_SESSION['item_form']['recevied_call'] : $this->item->recevied_call ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Call Back Home (Kip/Min)</label>
												<input type="text" class="form-control" placeholder="Call Back Home" id="call_back" name="call_back" value="<?= ($_SESSION['item_form']['call_back'] != null) ? $_SESSION['item_form']['call_back'] : $this->item->call_back ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Call Third Country  (Kip/Min)</label>
												<input type="text" class="form-control" placeholder="Call Third Country" id="call_to_country" name="call_to_country" value="<?= ($_SESSION['item_form']['call_to_country'] != null) ? $_SESSION['item_form']['call_to_country'] : $this->item->call_to_country ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label"> SMS MO (Kip/SMS)</label>
												<input type="text" class="form-control" placeholder="SMS MO" id="sms_mo" name="sms_mo" value="<?= ($_SESSION['item_form']['sms_mo'] != null) ? $_SESSION['item_form']['sms_mo'] : $this->item->sms_mo ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label"> SMS MT (Kip/SMS)</label>
												<input type="text" class="form-control" placeholder="SMS MT " id="sms_mt" name="sms_mt" value="<?= ($_SESSION['item_form']['sms_mt'] != null) ? $_SESSION['item_form']['sms_mt'] : $this->item->sms_mt ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Data Kip/Kb</label>
												<input type="text" class="form-control" placeholder="Data Kip/Kb" id="data_value" name="data_value" value="<?= ($_SESSION['item_form']['data_value'] != null) ? $_SESSION['item_form']['data_value'] : $this->item->data_value ?>">
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">IRA</label>
												<input type="text" class="form-control" placeholder="IRA" id="ira" name="ira" value="<?= ($_SESSION['item_form']['ira'] != null) ? $_SESSION['item_form']['ira'] : $this->item->ira ?>">
											</div>
											
												
											<div class="form-group">
											<label class="form-label">Enable (ALL)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status" id="status" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status'] != null) && ($_SESSION['item_form']['status'] == 1)) || (($_SESSION['item_form']['status'] == null) && ($this->item->status == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>
											
										</div>
										
									</div>
									
								</div>
								
							</div>
							<div class="row">						
											
							<div class="col-lg-12 col-md-12">
								<div class="form-group">
								<span class="text-danger">* Required.</span>
								</div>
			  
								<div class="form-group">
									<input type="hidden" name="do" id="do" value="update" />
									<input type="hidden" name="id" id="id" value="<?=$this->id?>" />
									<input type="hidden" name="parent_id" id="parent_id" value="<?=$this->parent_id?>" />
									<button type="button" onClick="return checkForm('save')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5">Save</button>
									<button type="reset" class="btn btn-warning pd-x-30 mg-t-5">Cancel</button>
									<a href="javascript:history.back();">
									<button type="button" class="btn btn-danger pd-x-30 mg-t-5" id="Reset">Back</button>	
									</a>
								</div>
							</div>
							</div>
							</form>
						</div>
					</div>
					
					<!-- row closed -->
				</div>
				<!-- Container closed -->
			</div>
			<!-- main-content closed -->

		
			<!-- Footer opened -->
			<?php require_once("inc-footer.php"); ?>
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

		<!--Internal  Datepicker js -->
		<script src="assets/plugins/jquery-ui/ui/widgets/datepicker.js"></script>

		<!-- Moment js -->
		<script src="assets/plugins/moment/moment.js"></script>

		<!--Internal  jquery.maskedinput js -->
		<script src="assets/plugins/jquery.maskedinput/jquery.maskedinput.js"></script>

		<!--Internal  spectrum-colorpicker js -->
		<script src="assets/plugins/spectrum-colorpicker/spectrum.js"></script>

		<!--Internal Ion.rangeSlider.min js -->
		<script src="assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js"></script>

		<!--Internal  jquery-simple-datetimepicker js -->
		<script src="assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js"></script>

		<!-- Ionicons js -->
		<script src="assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js"></script>

		<!--Internal  pickerjs js -->
		<script src="assets/plugins/pickerjs/picker.min.js"></script>

		<!--internal color picker js-->
		<script src="assets/plugins/colorpicker/pickr.es5.min.js"></script>
		<script src="assets/js/colorpicker.js"></script>

		<!--Bootstrap-datepicker js-->
		<script src="assets/plugins/bootstrap-datepicker/bootstrap-datepicker.js"></script>

		<!-- Internal Select2.min js -->
		<script src="assets/plugins/select2/js/select2.min.js"></script>

		<!-- P-scroll js -->
		<script src="assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="assets/plugins/perfect-scrollbar/p-scroll.js"></script>

		<!-- Sidebar js -->
		<script src="assets/plugins/side-menu/sidemenu.js"></script>

		<!-- Sticky js -->
		<script src="assets/js/sticky.js"></script>

		<!-- Right-sidebar js -->
		<script src="assets/plugins/sidebar/sidebar.js"></script>
		<script src="assets/plugins/sidebar/sidebar-custom.js"></script>

		<!-- Internal Summernote js-->
		<script src="assets/plugins/summernote/summernote-bs4.js"></script>
		
		<!-- eva-icons js -->
		<script src="assets/js/eva-icons.min.js"></script>

		<!-- Internal form-elements js -->
		<script src="assets/js/form-elements.js"></script>

		<!-- Internal Jquery.steps js -->
		<script src="assets/plugins/jquery-steps/jquery.steps.min.js"></script>
		<script src="assets/plugins/parsleyjs/parsley.min.js"></script>

		<!--Internal  Form-wizard js -->
		<script src="assets/js/form-wizard.js"></script>

		<!--Internal Fileuploads js-->
		<script src="assets/plugins/fileuploads/js/fileupload.js"></script>
        <script src="assets/plugins/fileuploads/js/file-upload.js"></script>

		<!--Internal Fancy uploader js-->
		<script src="assets/plugins/fancyuploder/jquery.ui.widget.js"></script>
        <script src="assets/plugins/fancyuploder/jquery.fileupload.js"></script>
        <script src="assets/plugins/fancyuploder/jquery.iframe-transport.js"></script>
        <script src="assets/plugins/fancyuploder/jquery.fancy-fileupload.js"></script>
        <script src="assets/plugins/fancyuploder/fancy-uploader.js"></script>	
		
		<!--Internal  Sweet-Alert js-->
		<script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>

		<!-- Sweet-alert js  -->
		<script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="assets/js/sweet-alert.js"></script>
		
		<!-- Theme Color js -->
		<script src="assets/js/themecolor.js"></script>

		<!-- custom js -->
		<script src="assets/js/custom.js"></script>
		
		
		<script language="javascript">
$(document).ready(function(){
    
	$('#begin_date').bootstrapdatepicker({
		format: "yyyy/mm/dd",
		viewMode: "date",
		//multidate: true,
		//multidateSeparator: "-",
		})
	
	$('#end_date').bootstrapdatepicker({
		format: "yyyy/mm/dd",
		viewMode: "date",
		//multidate: true,
		//multidateSeparator: "-",
		})
	  
});
</script>	
<script type="text/javascript">
	function checkForm() {
		with (document.form1) {
			/*
		
			if (document.getElementById('qtaData').value == '') {
				swal(' Please fill out Package Data:');
				document.getElementById('qtaData').focus();
				return false;
			}
			
			if (document.getElementById('qta01').value == '') {
				swal(' Please fill out data 1 months:');
				document.getElementById('qta01').focus();
				return false;
			}
			
		
			if (document.getElementById('qta03').value == '') {
				swal(' Please fill out data 3 months:');
				document.getElementById('qta03').focus();
				return false;
			}
			
			if (document.getElementById('qta06').value == '') {
				swal(' Please fill out data 6 months:');
				document.getElementById('qta06').focus();
				return false;
			}
			
			if (document.getElementById('qta12').value == '') {
				swal(' Please fill out data 12 months:');
				document.getElementById('qta12').focus();
				return false;
			}
			*/
			
			SetAction('roaming-item-action.php');
		}
	}

	function SetAction(url) {
		document.getElementById('form1').action = url;
		document.getElementById('form1').target = '_self';
		document.getElementById('form1').submit();
	}
</script>		
</body>
</html>