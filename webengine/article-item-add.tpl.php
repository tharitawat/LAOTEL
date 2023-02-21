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
								<li class="breadcrumb-item active" aria-current="page">Article</li>
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
										<h3>ADD DATA</h3>
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
												<label class="form-label">Title (TH) <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="Title" id="title_th" name="title_th" value="<?= ($_SESSION['item_form']['title_th'] != null) ? $_SESSION['item_form']['title_th'] : $this->item->title_th ?>">
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Subject(TH)</label>
												<input type="text" class="form-control" placeholder="Subject" id="subject_th" name="subject_th" value="<?= ($_SESSION['item_form']['subject_th'] != null) ? $_SESSION['item_form']['email'] : $this->item->subject_th ?>">
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Description (TH)</label>
												<textarea class="form-control" placeholder="Detail" id="description_th" name="description_th"><?= ($_SESSION['item_form']['description_th'] != null) ? $_SESSION['item_form']['description_th'] : Utility::convTextFromDB($this->item->description_th) ?></textarea>
												</div>
											
											
											<?php if($this->item->image_th != ''){ ?>
											 <div class="control-group form-group">
											  <div class="form-row">
												<div class="col-sm-6">
												  <img src="../img_article/thumbnail/<?= $this->item->image_th ?>" width="400">
												</div>
											  </div>
											  </div>
											  <?php } ?>
											<div class="control-group form-group">
												<label class="form-label">Image (TH)</label>
												<input class="form-control" type="file" name="image_th" id="image_th">
												<span class="text-warning"> Size 500px x 500px (format .jpg, .png)</span>
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Alt Image (TH)</label>
												<input type="text" class="form-control" placeholder="Alt Image" name="image_alt_th" id="image_alt_th" value="">
											</div>
											
											<div class="form-group">
											<label class="form-label">Enable (TH)</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status_th" id="status_th" value="1" class="custom-switch-input" <?=((($_SESSION['item_form']['status_th'] != null) && ($_SESSION['item_form']['status_th'] == 1)) || (($_SESSION['item_form']['status_th'] == null) && ($this->item->status_th == 1))) ? ' checked=""':''?>>
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
												<label class="form-label">Subject(EN)</label>
												<input type="text" class="form-control" placeholder="Subject" id="subject_en" name="subject_en" value="<?= ($_SESSION['item_form']['subject_en'] != null) ? $_SESSION['item_form']['email'] : $this->item->subject_en ?>">
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">Description (EN) </label>
												<textarea class="form-control" placeholder="Detail" id="description_en" name="description_en"><?= ($_SESSION['item_form']['description_en'] != null) ? $_SESSION['item_form']['description_en'] : Utility::convTextFromDB($this->item->description_en) ?></textarea>
												</div>
											
											
											<?php if($this->item->image_en != ''){ ?>
											 <div class="control-group form-group">
											  <div class="form-row">
												<div class="col-sm-6">
												  <img src="../img_article/thumbnail/<?= $this->item->image_en ?>" width="400">
												</div>
											  </div>
											  </div>
											  <?php } ?>
											<div class="control-group form-group">
												<label class="form-label">Image (EN)</label>
												<input class="form-control" type="file" name="image_en" id="image_en">
												<span class="text-warning"> Size 500px x 500px (format .jpg, .png)</span>
											</div>
											
											<div class="control-group form-group">
												<label class="form-label">Alt Image (EN)</label>
												<input type="text" class="form-control" placeholder="Alt Image" name="image_alt_en" id="image_alt_en" value="">
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
												<?php if($this->item->image != ''){ ?>
												 <div class="control-group form-group">
												  <div class="form-row">
													<div class="col-sm-6">
													  <img src="../img_article/thumbnail/<?= $this->item->image ?>" width="400">
													</div>
												  </div>
												  </div>
												  <?php } ?>
												<div class="control-group form-group">
													<label class="form-label">Image Thumbnail</label>
													<input class="form-control" type="file" name="image" id="image">
													<span class="text-warning"> Size 500px x 500px (format .jpg, .png)</span>
												</div>
											
												<div class="control-group form-group">
												<label class="form-label">SEO Title <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="SEO Title" name="seo_title" id="seo_title" value="<?= ($_SESSION['item_form']['seo_title'] != null) ? $_SESSION['item_form']['seo_title'] : $this->item->seo_title ?>">
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">SEO Keyword<span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="SEO Keyword" name="seo_keyword" id="seo_keyword" value="<?= ($_SESSION['item_form']['seo_keyword'] != null) ? $_SESSION['item_form']['seo_keyword'] : $this->item->seo_keyword ?>">
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">SEO Rewrite <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="SEO Rewrite" name="seo_rewrite" id="seo_rewrite" value="<?= ($_SESSION['item_form']['seo_rewrite'] != null) ? $_SESSION['item_form']['seo_rewrite'] : $this->item->seo_rewrite ?>">
												</div>
												
												<div class="control-group form-group">
												<label class="form-label">SEO Description <span class="text-danger">*</span></label>
												<input type="text" class="form-control" placeholder="SEO Description" name="seo_description" id="seo_description" value="<?= ($_SESSION['item_form']['seo_description'] != null) ? $_SESSION['item_form']['seo_description'] : $this->item->seo_description ?>">
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
									<input type="hidden" name="do" id="do" value="insert" />
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
	
		
	
});
</script>	
<script type="text/javascript">
	function checkForm() {
		with (document.form1) {
			
		
			if (document.getElementById('title_th').value == '') {
				swal(' กรุณา กรอกข้อมูล Title:');
				document.getElementById('title_th').focus();
				return false;
			}
			/*
			if (document.getElementById('thumbnail_th').value == '') {
				swal(' กรุณา Select Thumb Image:');
				document.getElementById('thumbnail_th').focus();
				return false;
			}
			
		
			if (document.getElementById('image_th').value == '') {
				swal(' กรุณา Select File Image:');
				document.getElementById('image_th').focus();
				return false;
			}
			
			if (document.getElementById('imagem_th').value == '') {
				swal(' กรุณา Select File Mobile Image:');
				document.getElementById('imagem_th').focus();
				return false;
			}
			*/
			
			SetAction('article-item-action.php');
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