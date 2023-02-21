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
						  <span class="main-content-title mg-b-0 mg-b-lg-1">USER</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">User</li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

					<!-- row -->
					<div class="row">
						<div class="col-lg-12 col-md-12">
							<div class="card">
								<div class="card-body">
									<div class="main-content-label mg-b-5">
										<h3>ADD DATA</h3>
									</div>
									<form method="post" enctype="multipart/form-data" class="form-horizontal" role="form" data-toggle="validator" name="form1" id="form1" action="">									
											<div class="control-group form-group">
												<label class="form-label">Name</label>
												<input type="text" class="form-control required" placeholder="Name" id="fullname" name="fullname" value="<?= ($_SESSION['user']['fullname'] != null) ? $_SESSION['user']['fullname'] : $this->item->fullname ?>">
											</div>
											<div class="control-group form-group">
												<label class="form-label">Email</label>
												<input type="email" class="form-control required" placeholder="Email Address" id="email" name="email" value="<?= ($_SESSION['user']['email'] != null) ? $_SESSION['user']['email'] : $this->item->email ?>">
												<span class="lable-alert" id="chk_member"><input type="hidden" name="conf_email" id="conf_email" value="false" /></span>	
											</div>
											<div class="control-group form-group">
												<label class="form-label">Phone Number</label>
												<input class="form-control" placeholder="(000) 000-0000" type="text" spellcheck="false" data-ms-editor="true" id="phone" name="phone" value="<?= ($_SESSION['user']['phone'] != null) ? $_SESSION['user']['phone'] : $this->item->phone ?>">
											</div>
											<div class="control-group form-group mb-2">
												<label class="form-label">Password</label>
												<input type="password" class="form-control required" placeholder="password" onChange="fncKeyPassword(this.value,5);" maxlength="20">
											</div>
											<div class="control-group form-group mb-2">
												<label class="form-label">Confirm Password</label>
												<input type="password" class="form-control required" placeholder="confirm password" name="re_password" id="re_password" onChange="fncKeyRePassword(this.value);" >
												<span class="lable-alert" id="sp_text"></span>	
											</div>
											<?php if($this->item->image != ''){ ?>
											  <div class="mb-0">
											  <div class="form-row">
												<div class="col-sm-6">
												  <img src="../img_user/thumbnail/<?= $this->item->image ?>" width="400">
												</div>
											  </div>
											  </div>
											  <?php } ?>
											<div class="mb-0">
												<label class="form-label">Image Profile</label>
												<input class="form-control" type="file" name="image" id="image">
												<span class="text-warning"> Size 500px x 500px (format .jpg, .png)</span>
											</div>
											<div class="mb-0">
											<label class="form-label">Type Level</label>
											<select class="form-select border" id="type" name="type">
												<option label="Choose one"></option>
												<?php foreach ($this->typeList as $val) { ?>
												<option value="<?= $val['id'] ?>"<?= ((($_SESSION['user']['type'] != null) && ($_SESSION['user']['type'] == $val['id'])) || (($_SESSION['user']['type'] == null) && ($this->item->type == $val['id']))) ? ' selected="selected"' : '' ?>><?= $val['title'] ?></option>
												<?php } // foreach ?>>
											</select>											
											</div>
											<div class="mb-0">
											<label class="form-label">Enable</label>
											<label class="custom-switch ps-0">
													
													<input type="checkbox" name="status" id="status" value="1" class="custom-switch-input" <?=((($_SESSION['user']['status'] != null) && ($_SESSION['user']['status'] == 1)) || (($_SESSION['user']['status'] == null) && ($this->item->status == 1))) ? ' checked=""':''?>>
													<span class="custom-switch-indicator custom-switch-indicator-lg"></span>
												</label>
											</div>	
										
											<div class="table-responsive mg-t-20" style="display:none">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="1"<?= (in_array('1', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>PRODUCT</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="2"<?= (in_array('2', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>RENTAL</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="3"<?= (in_array('3', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>SERVICE</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="4"<?= (in_array('4', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>INSTALLATION</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="5"<?= (in_array('5', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>MEMBER</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="6"<?= (in_array('6', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>PROMOTION</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="7"<?= (in_array('7', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>BANNER</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="8"<?= (in_array('8', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>REVIEW</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="9"<?= (in_array('9', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>ORDER</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="10"<?= (in_array('10', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>REQUEST QUOTATION</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="11"<?= (in_array('11', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>SHIPPING</td>
														</tr>
														<tr>
															<td width="5%">
															<input type="checkbox" id="role_menu" name="role_menu[]" value="12"<?= (in_array('12', $this->roleMenuList)) ? ' checked="checked"' : '' ?>>
															</td>
															<td>USER</td>
														</tr>
													</tbody>
												</table>
											</div>
																				
											<div class="form-group">
												<label class="form-label">Mac Address</label>
												<div class="input-group">
													<input type="text" class="form-control" placeholder="Mac Address" name="mac_address" id="mac_address">
													<span class="input-group-append">
														<button class="btn btn-secondary" type="button">
														<i class="fa fa-laptop"></i> </button>
													</span>
												</div>
											</div>
											<div class="row">											
												<div class="col-sm-8">
													<div class="form-group mb-sm-0">
														<label class="form-label">Effective Date</label>
														<div class="input-group">											
															<div class="input-group-text">
													<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
												</div>
												<input class="form-control" name="created_date" id="created_date" placeholder="YYYY/MM/DD" value="<?= ($_SESSION['user']['created_date'] != NULL) ? $_SESSION['user']['created_date'] : (($this->item->created_date != null) ? date('Y/m/j', strtotime($this->item->created_date)) : '') ?>" type="text" readonly>
												<div class="input-group-text">
													<i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
												</div>
												<input class="form-control" name="expired_date" id="expired_date" placeholder="YYYY/MM/DD" value="<?= ($_SESSION['user']['expired_date'] != NULL) ? $_SESSION['user']['expired_date'] : (($this->item->expired_date != null) ? date('Y/m/j', strtotime($this->item->expired_date)) : '') ?>" type="text" readonly>
														</div>
													</div>
												</div>
												<div class="col-sm-4 ">
													<div class="form-group mb-0">
														<label class="form-label">Last Login </label>
														<input class="form-control" id="" placeholder="MM/DD/YYYY HH:MM" type="text" disabled readonly>
													</div>
												</div>
												

											</div>
											
									<div class="control-group form-group" style="padding-top: 25px;">
									<input type="hidden" name="do" id="do" value="insert" />
									<button type="button" onClick="return checkForm('save')" class="btn btn-primary pd-x-30 mg-r-5 mg-t-5">Save</button>
									<button type="reset" class="btn btn-warning pd-x-30 mg-t-5">Cancel</button>
									<a href="javascript:history.back();">
									<button type="button" class="btn btn-danger pd-x-30 mg-t-5" id="Reset">Back</button>	
									</a>
								</div>
										
										</form>
								</div>
							</div>
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

		<!--Internal  Sweet-Alert js-->
		<script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="assets/plugins/sweet-alert/jquery.sweet-alert.js"></script>

		<!-- Sweet-alert js  -->
		<script src="assets/plugins/sweet-alert/sweetalert.min.js"></script>
		<script src="assets/js/sweet-alert.js"></script>
		
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
		
		<!-- Theme Color js -->
		<script src="assets/js/themecolor.js"></script>

		<!-- custom js -->
		<script src="assets/js/custom.js"></script>
				
		<script language="javascript">
		$(document).ready(function(){
			
		$('#created_date').bootstrapdatepicker({
		format: "yyyy/mm/dd",
		viewMode: "date",
		//multidate: true,
		//multidateSeparator: "-",
		})
		
		$('#lastlogin_date').bootstrapdatepicker({
		format: "yyyy/mm/dd",
		viewMode: "date",
		//multidate: true,
		//multidateSeparator: "-",
		})
		
		$('#expired_date').bootstrapdatepicker({
		format: "yyyy/mm/dd",
		viewMode: "date",
		//multidate: true,
		//multidateSeparator: "-",
		})


 
  	var conf_email = document.getElementById('conf_email').value; 
	
	$("#email").bind('keyup', function (e) {
	//	 alert($("#email").val());
    $.get('ajax_check_user.php', { 
		  email : $('#email').val(),
		  time : new Date().getTime()
		}, function(data) {
		 
 		  $('#chk_member').html(data);  
		  $('#email').focus();
 		}); 
	  });  
	 
	 
	 $('#image').change(function(e) {
			var filename = document.form1.image.value;  
			document.getElementById('file_image').innerHTML = filename;
	 });
	 
 });
</script>	
<script language="javascript">
function fncKeyPassword(_val,num){
  //document.getElementById("sp_text").innerHTML = _val.length+"/4";
	var key = _val.length;
	var elem = document.getElementById('password').value;
	
	if (key < num){ 
		  swal("Password must be greater than 4"); 
		  document.getElementById('password').value = '';
   	      document.getElementById('password').focus();
	}
	if (!elem.match(/^([a-z0-9\_])+$/i)){
	swal("รหัสผ่านใช้ตัวอักษร 5 ถึง 20 ตัว เฉพาะตัวอักษรภาษาอังกฤษและ/หรือตัวเลขเท่านั้น");
		  document.getElementById('password').value = '';
   	      document.getElementById('password').focus();
	}
}
function fncKeyRePassword(pass){
   with(document.form1){
	if (document.getElementById('re_password').length == document.getElementById('password').length) {
	  if (document.getElementById('re_password').value == document.getElementById('password').value) {	
     // alert(' การยืนยันรหัสผ่านไม่ถูกต้อง :');
	  		document.getElementById("sp_text").innerHTML = "<label style='color:#0C0;'>ยืนยันรหัสผ่านถูกต้อง</label>";
 
		  //   document.getElementById('re_password').focus();
   //   return false;
    } else {
		document.getElementById("sp_text").innerHTML = "<label style='color:#F00;'> ยืนยันรหัสผ่านไม่ถูกต้อง</label>  ";
 
		document.getElementById('re_password').value = '';
   	      document.getElementById('re_password').focus();		
	}
	} else { 		
	document.getElementById("sp_text").innerHTML = "<label style='color:#F00;'>กำหนดรหัสผ่านไม่ถูกต้อง</label>"; }
	//	  document.getElementById('re_password').value = '';
   	//      document.getElementById('re_password').focus();	
	}
}
</script>		
<script type="text/javascript">
	function checkForm() {
		with (document.form1) {
			//swal("OK");
			if (document.getElementById('email').value == '') {
				swal(' กระณาระบุอีเมล :');
				document.getElementById('email').focus();
				return false;
			}
			
			
			if (document.getElementById('password').value == '') {
				swal(' กรุณาระบุรหัสผ่าน :');
				document.getElementById('password').focus();
				return false;
			}
			
			
			if ((document.getElementById('password').value != '') && (document.getElementById('re_password').value != document.getElementById('password').value)) {
				swal(' กรุณายืนยันรหัสผ่าน :');
				document.getElementById('re_password').focus();
				return false;
			}
			
			if (document.getElementById('fullname').value == '') {
				swal(' กรุณากรอก Fullname :');
				document.getElementById('fullname').focus();
				return false;
			}
			
			SetAction('user-item-action.php');
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