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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">Job Vacancy</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
								<li class="breadcrumb-item" aria-current="page">Career</li>
								<li class="breadcrumb-item active" aria-current="page">Job Vacancy</li>
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
											<div class="panel panel-primary tabs-style-2">
												<div class=" tab-menu-heading">
													<div class="tabs-menu1">
														<!-- Tabs -->
														<ul class="nav panel-tabs main-nav-line">
															<li><a href="#LA" class="nav-link active" data-bs-toggle="tab">Lao</a></li>
															<li><a href="#EN" class="nav-link" data-bs-toggle="tab">English</a></li>
															<li><a href="#CN" class="nav-link" data-bs-toggle="tab">Chinese</a></li>
															<li><a href="#VI" class="nav-link" data-bs-toggle="tab">Vietnam</a></li>															
														</ul>
													</div>
												</div>
													<div class="panel-body tabs-menu-body main-content-body-right border">
												<div class="tab-content">
												<div class="tab-pane active" id="LA">
															
												<div class="control-group form-group">
												<label class="form-label">Title (LA) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Title" id="title_la" name="title_la" value="<?= ($_SESSION['item_form']['title_la'] != null) ? $_SESSION['item_form']['title_la'] : $this->item->title_la ?>">
												</div>

												<div class="control-group form-group">
												<label class="form-label">Subject (LA) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Subject" id="subject_la" name="subject_la" value="<?= ($_SESSION['item_form']['subject_la'] != null) ? $_SESSION['item_form']['subject_la'] : $this->item->subject_la ?>">
												</div>

												<div class="control-group form-group">
												<label class="form-label">Job Description (LA)</label>
												<textarea class="form-control" placeholder="Detail" id="job_description_la" name="job_description_la"><?= ($_SESSION['item_form']['job_description_la'] != null) ? $_SESSION['item_form']['job_description_la'] : Utility::convTextFromDB($this->item->job_description_la) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Qualifications (LA)</label>
												<textarea class="form-control" placeholder="Detail" id="qualifications_la" name="qualifications_la"><?= ($_SESSION['item_form']['qualifications_la'] != null) ? $_SESSION['item_form']['qualifications_la'] : Utility::convTextFromDB($this->item->qualifications_la) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Other Description (LA)</label>
												<textarea class="form-control" placeholder="Detail" id="description_la" name="description_la"><?= ($_SESSION['item_form']['description_la'] != null) ? $_SESSION['item_form']['description_la'] : Utility::convTextFromDB($this->item->description_la) ?></textarea>
												</div>

																									
											<div class="form-group">
											<label class="form-label">Enable (LA)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status_la" id="status_la" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status_la'] != null) && ($_SESSION['item_form']['status_la'] == 1)) || (($_SESSION['item_form']['status_la'] == null) && ($this->item->status_la == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>
												
												</div>

												<div class="tab-pane" id="EN">
															
												<div class="control-group form-group">
												<label class="form-label">Title (EN) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Title" id="title_en" name="title_en" value="<?= ($_SESSION['item_form']['title_en'] != null) ? $_SESSION['item_form']['title_en'] : $this->item->title_en ?>">
												</div>


												<div class="control-group form-group">
												<label class="form-label">Subject (EN) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Subject" id="subject_en" name="subject_en" value="<?= ($_SESSION['item_form']['subject_en'] != null) ? $_SESSION['item_form']['subject_en'] : $this->item->subject_en ?>">
												</div>


												<div class="control-group form-group">
												<label class="form-label">Job Description (EN)</label>
												<textarea class="form-control" placeholder="Detail" id="job_description_en" name="job_description_en"><?= ($_SESSION['item_form']['job_description_en'] != null) ? $_SESSION['item_form']['job_description_en'] : Utility::convTextFromDB($this->item->job_description_en) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Qualifications (EN)</label>
												<textarea class="form-control" placeholder="Detail" id="qualifications_en" name="qualifications_en"><?= ($_SESSION['item_form']['qualifications_en'] != null) ? $_SESSION['item_form']['qualifications_en'] : Utility::convTextFromDB($this->item->qualifications_en) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Other Description (EN)</label>
												<textarea class="form-control" placeholder="Detail" id="description_en" name="description_en"><?= ($_SESSION['item_form']['description_en'] != null) ? $_SESSION['item_form']['description_en'] : Utility::convTextFromDB($this->item->description_en) ?></textarea>
												</div>

																						
											<div class="form-group">
											<label class="form-label">Enable (EN)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status_en" id="status_en" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status_en'] != null) && ($_SESSION['item_form']['status_en'] == 1)) || (($_SESSION['item_form']['status_en'] == null) && ($this->item->status_en == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>
												
												</div>

												<div class="tab-pane" id="CN">
															
												<div class="control-group form-group">
												<label class="form-label">Title (CN) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Title" id="title_cn" name="title_cn" value="<?= ($_SESSION['item_form']['title_cn'] != null) ? $_SESSION['item_form']['title_cn'] : $this->item->title_cn ?>">
												</div>


												<div class="control-group form-group">
												<label class="form-label">Subject (CN) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Subject" id="subject_cn" name="subject_cn" value="<?= ($_SESSION['item_form']['subject_cn'] != null) ? $_SESSION['item_form']['subject_cn'] : $this->item->subject_cn ?>">
												</div>


												<div class="control-group form-group">
												<label class="form-label">Job Description (CN)</label>
												<textarea class="form-control" placeholder="Detail" id="job_description_cn" name="job_description_cn"><?= ($_SESSION['item_form']['job_description_cn'] != null) ? $_SESSION['item_form']['job_description_cn'] : Utility::convTextFromDB($this->item->job_description_cn) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Qualifications (CN)</label>
												<textarea class="form-control" placeholder="Detail" id="qualifications_cn" name="qualifications_cn"><?= ($_SESSION['item_form']['qualifications_cn'] != null) ? $_SESSION['item_form']['qualifications_cn'] : Utility::convTextFromDB($this->item->qualifications_cn) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Other Description (CN)</label>
												<textarea class="form-control" placeholder="Detail" id="description_cn" name="description_cn"><?= ($_SESSION['item_form']['description_cn'] != null) ? $_SESSION['item_form']['description_cn'] : Utility::convTextFromDB($this->item->description_cn) ?></textarea>
												</div>

																						
											<div class="form-group">
											<label class="form-label">Enable (CN)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status_cn" id="status_cn" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status_cn'] != null) && ($_SESSION['item_form']['status_cn'] == 1)) || (($_SESSION['item_form']['status_cn'] == null) && ($this->item->status_cn == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>
												
												</div>

												<div class="tab-pane" id="VI">
															
												<div class="control-group form-group">
												<label class="form-label">Title (VI) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Title" id="title_vi" name="title_vi" value="<?= ($_SESSION['item_form']['title_vi'] != null) ? $_SESSION['item_form']['title_vi'] : $this->item->title_vi ?>">
												</div>


												<div class="control-group form-group">
												<label class="form-label">Subject (VI) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Subject" id="subject_vi" name="subject_vi" value="<?= ($_SESSION['item_form']['subject_vi'] != null) ? $_SESSION['item_form']['subject_vi'] : $this->item->subject_vi ?>">
												</div>


												<div class="control-group form-group">
												<label class="form-label">Job Description (VI)</label>
												<textarea class="form-control" placeholder="Detail" id="job_description_vi" name="job_description_vi"><?= ($_SESSION['item_form']['description_vi'] != null) ? $_SESSION['item_form']['job_description_vi'] : Utility::convTextFromDB($this->item->job_description_vi) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Qualifications (VI)</label>
												<textarea class="form-control" placeholder="Detail" id="qualifications_vi" name="qualifications_vi"><?= ($_SESSION['item_form']['qualifications_vi'] != null) ? $_SESSION['item_form']['description_vi'] : Utility::convTextFromDB($this->item->qualifications_vi) ?></textarea>
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Other Description (VI)</label>
												<textarea class="form-control" placeholder="Detail" id="description_vi" name="description_vi"><?= ($_SESSION['item_form']['description_vi'] != null) ? $_SESSION['item_form']['description_vi'] : Utility::convTextFromDB($this->item->description_vi) ?></textarea>
												</div>

																					
											<div class="form-group">
											<label class="form-label">Enable (VI)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status_vi" id="status_vi" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status_vi'] != null) && ($_SESSION['item_form']['status_vi'] == 1)) || (($_SESSION['item_form']['status_vi'] == null) && ($this->item->status_vi == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>
												
												</div>
																												
													</div>
														
												</div>
												
											
												
											</div>
										
												<div class="control-group form-group">
												<label class="form-label">Amount <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Amount" id="amount" name="amount" value="<?= ($_SESSION['item_form']['amount'] != null) ? $_SESSION['item_form']['amount'] : $this->item->amount ?>">
												</div>
												
												<div class="form-group">
													<div class="form-group mb-sm-0">
														<label class="form-label">Publish Date</label>
														<div class="input-group">											
															<div class="input-group-text">
													<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
												</div>
												<input class="form-control" name="published_date" id="published_date" placeholder="YYYY/MM/DD" value="<?= ($_SESSION['item_form']['published_date'] != NULL) ? $_SESSION['item_form']['published_date'] : (($this->item->published_date != null) ? date('Y/m/j', strtotime($this->item->published_date)) : '') ?>" type="text" readonly>
												
														</div>
													</div>
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
    
	$('#published_date').bootstrapdatepicker({
		format: "yyyy/mm/dd",
		viewMode: "date",
		//multidate: true,
		//multidateSeparator: "-",
		})
	  
	 
    $('#description_la').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'description_la');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#description_la").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });
    
    $('#description_en').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'description_en');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#description_en").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });
	
	$('#description_cn').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'description_cn');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#description_cn").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	

	$('#description_vi').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'description_vi');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#description_vi").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#job_description_la').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'job_description_la');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#job_description_la").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#job_description_en').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'job_description_en');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#job_description_en").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#job_description_cn').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'job_description_cn');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#job_description_cn").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#job_description_vi').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'job_description_vi');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#job_description_vi").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#qualifications_la').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'qualifications_la');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#qualifications_la").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#qualifications_en').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'qualifications_en');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#qualifications_en").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#qualifications_cn').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'qualifications_cn');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#qualifications_cn").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
	$('#qualifications_vi').summernote({
        placeholder: 'Description',	
        height: 200,
        minHeight: null,
        maxHeight: null,
        focus: false,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'italic', 'underline', 'clear']],
            ['font'],
            //['fontname', ['fontname']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['insert', ['table', 'link', 'picture']],
            ['view', ['height', 'hr', 'fullscreen', 'codeview']],
        ],
        fontNames: ['Sarabun', 'sans-serif', 'Prompt'],
        fontNamesIgnoreCheck: ['Sarabun', 'sans-serif', 'Prompt'],
        callbacks: {
            onImageUpload: function(file) {
                summernoteAjaxUpload(file[0], 'qualifications_vi');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#qualifications_vi").html(''); //either the class (.) or id (#) of your textarea or summernote element
			}
		  },
        },
    });	
	
});
</script>	
<script type="text/javascript">
	function checkForm() {
		with (document.form1) {
			
		
			if (document.getElementById('title_la').value == '') {
				swal(' Please fill out Title Field:');
				document.getElementById('title_la').focus();
				return false;
			}
			
			if (document.getElementById('amount').value == '') {
				swal(' Please fill out amount Field:');
				document.getElementById('amount').focus();
				return false;
			}

			
			SetAction('career-application-action.php');
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