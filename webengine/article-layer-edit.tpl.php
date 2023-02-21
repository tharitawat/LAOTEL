<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;
 
?>
<!DOCTYPE html>
<html lang="en" style="--primary01:rgba(30, 77, 153, 0.1); --primary02:rgba(30, 77, 153, 0.2); --primary03:rgba(30, 77, 153, 0.3); --primary06:rgba(30, 77, 153, 0.6); --primary09:rgba(30, 77, 153, 0.9); --primary05:rgba(30, 77, 153, 0.5); --primary-bg-color:#1e4d99; --primary-bg-hover:#1e4d9995; --primary-bg-border:#1e4d99; --dark-null:#1e4d99; --transparent-null:#1e4d9995; --primary-transparentcolor:#1e4d9920; --darkprimary-null:#1e4d9920; --transparentprimary-null:#1e4d9920;">
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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">ARTICLE</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
								<li class="breadcrumb-item" aria-current="page">Article</li>
								<li class="breadcrumb-item active" aria-current="page"><?=$this->article->title_th?></li>
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
															<li><a href="#TH" class="nav-link active" data-bs-toggle="tab">Thai</a></li>
															<li><a href="#EN" class="nav-link" data-bs-toggle="tab">English</a></li>
															
														</ul>
													</div>
												</div>
												<div class="panel-body tabs-menu-body main-content-body-right border">
													<div class="tab-content">
														<div class="tab-pane active" id="TH">
															
												
				<div class="control-group form-group">
                <label class="control-label" for="description_th">Detail (TH)</label>
                <div class="mb-2">
                  <textarea class="form-control" placeholder="Detail" id="description_th" name="description_th"><?= ($_SESSION['item_form']['description_th'] != null) ? $_SESSION['item_form']['description_th'] : $this->item->description_th ?></textarea>
                </div>
              </div>
			  
			  <div class="control-group form-group">

			  		<div class="row mg-t-15">
					  <label class="control-label" for="layout_th">Select Show (TH) <span class="text-danger">*</span></label>
						<div class="col-lg-1">
							<label class="rdiobox"><input type="radio" id="layout_th_1" name="layout_th" value="1"<?= ((($_SESSION['item_form']['layout_th'] != null) && ($_SESSION['item_form']['layout_th'] == 1)) || (($_SESSION['item_form']['layout_th'] == null) && ($this->item->layout_th == 1))) ? ' checked' : '' ?>/> <span> Photo</span></label>
						</div>
						<div class="col-lg-1">
							<label class="rdiobox"><input type="radio" id="layout_th_2" name="layout_th" value="2"<?= ((($_SESSION['item_form']['layout_th'] != null) && ($_SESSION['item_form']['layout_th'] == 2)) || (($_SESSION['item_form']['layout_th'] == null) && ($this->item->layout_th == 2))) ? ' checked' : '' ?>/> <span> VDO</span></label>
						</div>
						<div class="col-lg-1">
							<label class="rdiobox"> <input type="radio" id="layout_th_0" name="layout_th" value="0"<?= ((($_SESSION['item_form']['layout_th'] != null) && ($_SESSION['item_form']['layout_th'] == 0)) || (($_SESSION['item_form']['layout_th'] == null) && ($this->item->layout_th == 0))) ? ' checked' : '' ?>/> <span> No</span></label>
						</div>
					</div>

              </div>


			  
			  <div id="show_layout_image_th">
			  <?php if ($this->item->image_th != ''){ ?>
				<div class="control-group form-group">
			  <div class="form-row">
                <div class="col-sm-6">
                  <img src="../img_article_layer/thumbnail/<?= $this->item->image_th ?>" width="400">
                </div>
			  </div>
			  </div>
              <?php } ?>
			  
			  <div class="control-group form-group">
                <label class="control-label" for="image_th">Image (TH) <span class="text-danger">*</span></label>
                <div class="mb-2">
                  <div class="custom-file">
					<input type="file" class="custom-file-input" id="image_th" name="image_th" onchange="show_pic(this.value);">
					<label class="custom-file-label" for="image_th" id="file_image_th">Choose file</label>
                  </div> 
                  <span class="text-warning"> <!--Size 555px x 473px--> (format .jpg, .png)</span>
                </div>
			  </div>
			  
              <div class="control-group form-group">
                <label class="control-label" for="image_alt_th">Image Alt (TH)</label>
                <div class="mb-2">
                  <input type="text" class="form-control" placeholder="Image Alt" id="image_alt_th" name="image_alt_th" value="<?= ($_SESSION['item_form']['image_alt_th'] != null) ? $_SESSION['item_form']['image_alt_th'] : $this->item->image_alt_th ?>"/>
                </div>
              </div>
              </div>
			  		
			  
			  <div id="show_layout_vdo_th">
			  <div class="control-group form-group">
                <label class="control-label" for="vdo_th">VDO (Link Youtube) (TH) <span class="text-danger">*</span></label>
                <div class="mb-2">
                  <input type="text" class="form-control" placeholder="Video" id="vdo_th" name="vdo_th" value="<?= ($_SESSION['item_form']['vdo_th'] != null) ? $_SESSION['item_form']['vdo_th'] : $this->item->vdo_th ?>"/>
                </div>
                <span class="text-warning"> Ex. https://www.youtube.com/embed/xxx</span>
              </div>
              </div>
											
										
											<div class="control-group form-group">
											<label class="form-label">Enable (TH)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status_th" id="status_th" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status_th'] != null) && ($_SESSION['item_form']['status_th'] == 1)) || (($_SESSION['item_form']['status_th'] == null) && ($this->item->status_th == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>
											
											
												</div>
												<div class="tab-pane" id="EN">
															
											
												<div class="control-group form-group">
                <label class="control-label" for="description_en">Detail (EN)</label>
                <div class="mb-2">
                  <textarea class="form-control" placeholder="Detail" id="description_en" name="description_en"><?= ($_SESSION['item_form']['description_en'] != null) ? $_SESSION['item_form']['description_en'] : $this->item->description_en ?></textarea>
                </div>
              </div>
			  
			  <div class="control-group form-group">

			  		<div class="row mg-t-15">
					  <label class="control-label" for="layout_en">Select Show (EN) <span class="text-danger">*</span></label>
						<div class="col-lg-1">
							<label class="rdiobox"><input type="radio" id="layout_en_1" name="layout_en" value="1"<?= ((($_SESSION['item_form']['layout_en'] != null) && ($_SESSION['item_form']['layout_en'] == 1)) || (($_SESSION['item_form']['layout_en'] == null) && ($this->item->layout_en == 1))) ? ' checked' : '' ?>/> <span> Photo</span></label>
						</div>
						<div class="col-lg-1">
							<label class="rdiobox"><input type="radio" id="layout_en_2" name="layout_en" value="2"<?= ((($_SESSION['item_form']['layout_en'] != null) && ($_SESSION['item_form']['layout_en'] == 2)) || (($_SESSION['item_form']['layout_en'] == null) && ($this->item->layout_en == 2))) ? ' checked' : '' ?>/> <span> VDO</span></label>
						</div>
						<div class="col-lg-1">
							<label class="rdiobox"> <input type="radio" id="layout_en_0" name="layout_en" value="0"<?= ((($_SESSION['item_form']['layout_en'] != null) && ($_SESSION['item_form']['layout_en'] == 0)) || (($_SESSION['item_form']['layout_en'] == null) && ($this->item->layout_en == 0))) ? ' checked' : '' ?>/> <span> No</span></label>
						</div>
					</div>

              </div>


			  
			  <div id="show_layout_image_en">
			  <?php if ($this->item->image_en != ''){ ?>
				<div class="control-group form-group">
			  <div class="form-row">
                <div class="col-sm-6">
                  <img src="../img_article_layer/thumbnail/<?= $this->item->image_en ?>" width="400">
                </div>
			  </div>
			  </div>
              <?php } ?>
			  
			  <div class="control-group form-group">
                <label class="control-label" for="image_en">Image (EN) <span class="text-danger">*</span></label>
                <div class="mb-2">
                  <div class="custom-file">
					<input type="file" class="custom-file-input" id="image_en" name="image_en" onchange="show_pic(this.value);">
					<label class="custom-file-label" for="image_en" id="file_image_en">Choose file</label>
                  </div> 
                  <span class="text-warning"> <!--Size 555px x 473px--> (format .jpg, .png)</span>
                </div>
			  </div>
			  
              <div class="control-group form-group">
                <label class="control-label" for="image_alt_en">Image Alt (EN)</label>
                <div class="mb-2">
                  <input type="text" class="form-control" placeholder="Image Alt" id="image_alt_en" name="image_alt_en" value="<?= ($_SESSION['item_form']['image_alt_en'] != null) ? $_SESSION['item_form']['image_alt_en'] : $this->item->image_alt_en ?>"/>
                </div>
              </div>
              </div>
						
						
			  
			  <div id="show_layout_vdo_en">
			  <div class="control-group form-group">
                <label class="control-label" for="vdo_en">VDO (Link Youtube) (EN) <span class="text-danger">*</span></label>
                <div class="mb-2">
                  <input type="text" class="form-control" placeholder="Video" id="vdo_en" name="vdo_en" value="<?= ($_SESSION['item_form']['vdo_en'] != null) ? $_SESSION['item_form']['vdo_en'] : $this->item->vdo_en ?>"/>
                </div>
                <span class="text-warning"> Ex. https://www.youtube.com/embed/xxx</span>
              </div>
              </div>
											
											<div class="form-group">
											<label class="form-label">Enable (EN)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status_en" id="status_en" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status_en'] != null) && ($_SESSION['item_form']['status_en'] == 1)) || (($_SESSION['item_form']['status_en'] == null) && ($this->item->status_en == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>
											
														</div>
														
													</div>
														
												</div>
												
												
											</div>
												
											<div class="form-group">
											<label class="form-label">Enable (All)</label>
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
									<input type="hidden" name="id" id="id" value="<?= $this->id ?>" />
									<input type="hidden" name="parent_id" id="parent_id" value="<?= $this->parent_id ?>" />
									<button type="button" onClick="return checkForm('save')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5">Save</button>
									<button type="reset" class="btn btn-warning pd-x-30 mg-t-5">Cancel</button>
									<a href="article-layer-list.php?parent_id=<?= $this->parent_id ?>">
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
	  
	 
    $('#description_th').summernote({
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
                summernoteAjaxUpload(file[0], 'description_th');
            },
			onFocus: function (contents) {
			if($(this).summernote('isEmpty')){
			  $("#description_th").html(''); //either the class (.) or id (#) of your textarea or summernote element
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
	
			

		// Default Load.
		
		<?php if ($this->item->layout_th == 0) { // No ?>
		$('#show_layout_image_th').hide();
		$('#show_layout_vdo_th').hide();
		<?php } // if ?>
		
		<?php if ($this->item->layout_th == 1) { // Image ?>
		$('#show_layout_vdo_th').hide();
		<?php } // if ?>
		
		<?php if ($this->item->layout_th == 2) { // VDO ?>
		$('#show_layout_image_th').hide();
		<?php } // if ?>
		
		
		
		<?php if ($this->item->layout_en == 0) { // No ?>
		$('#show_layout_image_en').hide();
		$('#show_layout_vdo_en').hide();
		<?php } // if ?>
		
		<?php if ($this->item->layout_en == 1) { // Image ?>
		$('#show_layout_vdo_en').hide();
		<?php } // if ?>
		
		<?php if ($this->item->layout_en == 2) { // VDO ?>
		$('#show_layout_image_en').hide();
		<?php } // if ?>
		
	
		
		// BEGIN LAYOUT
		$('input[name=layout_th]').on('click', function(){
			switch ($('input[name=layout_th]:checked').val()) {
				case '0' : // No
					$('#show_layout_image_th').hide();
					$('#show_layout_vdo_th').hide();
					break;
				case '1' : // Image
					$('#show_layout_image_th').show();
					$('#show_layout_vdo_th').hide();
					break;
				case '2' : // VDO
					$('#show_layout_vdo_th').show();
					$('#show_layout_image_th').hide();
					break;				
				default : 
					$('#show_layout_image_th').hide();
					$('#show_layout_vdo_th').hide();
			}
		});
		$('#layout_th_0').click(function() { 
			$('#show_layout_image_th').hide();
			$('#show_layout_vdo_th').hide();
		});
		
		$('#layout_th_1').click(function() {
			$('#show_layout_image_th').show();
			$('#show_layout_vdo_th').hide();
		});
		
		$('#layout_th_2').click(function() {
			$('#show_layout_vdo_th').show();
			$('#show_layout_image_th').hide();
		});
		
		

		
		
		$('input[name=layout_en]').on('click', function(){
			switch ($('input[name=layout_en]:checked').val()) {
				case '0' : // No
					$('#show_layout_image_en').hide();
					$('#show_layout_vdo_en').hide();
					break;
				case '1' : // Image
					$('#show_layout_image_en').show();
					$('#show_layout_vdo_en').hide();
					break;
				case '2' : // VDO
					$('#show_layout_vdo_en').show();
					$('#show_layout_image_en').hide();
					break;				
				default : 
					$('#show_layout_image_en').hide();
					$('#show_layout_vdo_en').hide();
			}
		});
		$('#layout_en_0').click(function() { 
			$('#show_layout_image_en').hide();
			$('#show_layout_vdo_en').hide();
		});
		
		$('#layout_en_1').click(function() {
			$('#show_layout_image_en').show();
			$('#show_layout_vdo_en').hide();
		});
		
		$('#layout_en_2').click(function() {
			$('#show_layout_vdo_en').show();
			$('#show_layout_image_en').hide();
		});
				
		
		// END LAYOUT		
	
	});
</script>
<script type="text/javascript">
	function checkForm() {
		with (document.form1) {
			//swal("OK");
			
			if ((document.getElementById('layout_th_1').checked == false) && (document.getElementById('layout_th_2').checked == false) ) { // Not Image & Not VDO 
			if (document.getElementById('description_th').value == '') {
				swal('กรุณากรอก Detail (TH) :');
				document.getElementById('description_th').focus();
				return false;
			}
			}
			
			
			
			if ((document.getElementById('layout_th_0').checked == false) && (document.getElementById('layout_th_1').checked == false) && (document.getElementById('layout_th_2').checked == false) && (document.getElementById('layout_th_3').checked == false)) {
				swal('กรุณาเลือก Select Show (TH) :');
				document.getElementById('layout_th_0').focus();
				return false;
			}
			
			if (document.getElementById('layout_th_1').checked == true) { // Image
			<?php if ($this->item->image_th == '') { ?>
			if (document.getElementById('image_th').value == '') {
				swal(' กรุณาแนบ Image (TH) :');
				document.getElementById('image_th').focus();
				return false;
			}
			<?php } // if ?>
			}
			
			if (document.getElementById('layout_th_2').checked == true) { // VDO
			if (document.getElementById('vdo_th').value == '') {
				swal('กรุณากรอก VDO (Link Youtube) (TH) :');
				document.getElementById('vdo_th').focus();
				return false;
			}
			}
			
			
			SetAction('article-layer-action.php');
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
<?php unset($_SESSION['item_form']); ?>