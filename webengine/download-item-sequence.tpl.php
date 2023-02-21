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
		
<script language="javascript" type="text/javascript">
function checkForm(val) {  
  var chkstatus = 0;                                        
  var el_collection = eval('document.forms.form1.chkbox');
  var id_collection = eval('document.forms.form1.id'); // get id collection.
  var chk_id = 0; // set default value.

  if (el_collection.length>1) {
    for (c=0;c<el_collection.length;c++) {    
      if (el_collection[c].checked) {
        chkstatus++;
        chk_id = id_collection[c].value; // set last id from checkbox.
      }
    }                                            
  } else {
    if (el_collection.checked) {
      chkstatus++;
    }
  }     
  
  with(document.form1) {
	// Check	        
    if (val == 'edit') {       
      if (chkstatus < 1) {   
        swal("Please select any Check Box");     
        return false;
      }  
      else if (chkstatus > 1) {   
        swal("Please select only 1 Check Box"); 
        checkBox('checked');
        return false;
      } else {                           
        SetAction('download-item-edit.php?id=' + chk_id); // edit last id.
      }                                        
    } else if (val == 'delete') {     
      if (chkstatus < 1) {   
        swal("Please select any Check Box");     
        return false;
      }  
      else if (!confirm('Do you want to delete ? ')) {  
        return false;
      } else {               
        SetAction("download-item-action.php?do=listdelete&parent_id=<?=$this->parent_id?>"); 
      }                                            
    } else if (val == 'update') {                
      if (chkstatus < 1) {   
        swal("Please select any Check Box");     
        return false;
      }  
      else if (!confirm('Do you want to update ? ')) {  
        return false;
      } else {             
        SetAction('download-item-action.php?do=listupdate&parent_id=<?=$this->parent_id?>');   
      }     
    } 
	                
    // Check  
                                              
    return true;
  }
}

function SetAction(url) {
  document.getElementById('form1').action = url;
  document.getElementById('form1').target = '_self';
  document.getElementById('form1').submit();
}
</script>   
  
<script language="javascript">
function chkAllbox() {
  var chkstatus = 0;
  var chktmp;
  var el_collection = eval('document.forms.form1.chkbox');

  if (el_collection.length > 1) {
    for (c = 0; c < el_collection.length; c++) {
      if (el_collection[c].checked) {
        chkstatus++;  
      }
    }
    if (chkstatus == el_collection.length) {
      chktmp = true;  
    }
    else {   
      chktmp = false;
    }
  } else {
    chktmp = el_collection.checked;
  }    
  return chktmp;
}

function swapCheckBox() {
  document.form1.checkAll.checked = chkAllbox();
}

function checkBox(obj) {
  var chk = obj.checked;
  var el_collection = eval('document.forms.form1.chkbox');

  if (el_collection.length > 1) {
    for (c = 0; c < el_collection.length; c++) {
      el_collection[c].checked = chk
    }                               
  } else {
    el_collection.checked = chk
  }
}     
</script>
  
<script language="javascript">
function searchKey(url) {
   document.getElementById('search_key').action = '?';
   document.getElementById('search_key').target = '_self';
   document.getElementById('search_key').submit();
}

function checkSubmit(e) {
   if(e && e.keyCode == 13) {
      searchKey();
   }
}
</script>

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
						<span class="main-content-title mg-b-0 mg-b-lg-1">File Download</span>
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

					<!-- Start Content -->
                    <div class="row row-sm">
					<div class="col-lg-12">
						<div class="card custom-card">
							<div class="card-body">
                            <p><strong>Arrange Older : </strong> <?=$this->sort_txt?></p>
                            <form enctype="multipart/form-data" method="post" action="" id="form1" name="form1">
                            <table  border="0" cellpadding="4" cellspacing="0">

                                <tr>
                                <td class="label-search-head">Sort By: </td>
                                <td>
                                <select class="form-select border" name="sequence_by" id="sequence_by" style="width: 300px;">
                                        <option value="">None</option>
                                        <option value="1"<?=($this->sort_order == '1') ?' selected':''?>>Date Last Modified</option>                    
                                        <option value="4"<?=($this->sort_order == '4') ?' selected':''?>>Manual Sort</option>
                                        </select>
                                    
                                    </td>
                                <td><button name="Save" type="button" class="btn btn-danger" id="submit" value="Search" href="javascript:void();" onclick="return SetAction('save');">Save</button></td>
                                </tr>
                                <tr>
                                <td class="notable-data">&nbsp;</td>
                                <td><!--<span class="txt-red">* key search by name , company , detail</span>--></td>
                                </tr>            
                                </table>
                            </form>
                            <div class="clear"></div>
                            </div> 
                            </div>
                    </div>
                    </div>

					<!-- breadcrumb -->
					<div class="breadcrumb-header justify-content-between">
						<div class="left-content mt-2">
							<a class="btn ripple btn-primary" href="download-item-add.php?parent_id=<?=$this->parent_id?>"><i class="fe fe-plus me-2"></i>Add Data</a>
                            <a class="btn ripple btn-secondary" href="download-item-list.php?parent_id=<?=$this->parent_id?>"><i class="fe fe-list me-2"></i>Item List</a>
						</div>
						<div class="justify-content-center mt-2">
								<!--<button id="userlist-1" class="btn btn-secondary data-table-btn me-2">Delete</button>
								<button type="button" class="btn btn-secondary">
							 	 <i class="fe fe-download me-1"></i> Download User Data
								</button>-->
							</div>
					</div>
					<!-- /breadcrumb -->

                    
					<!--Row-->						
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="card custom-card">
									<div class="card-body">
                                    <form enctype="multipart/form-data" method="post" action="product-category-action" id="form2" name="form2">
                                    <input type="hidden" name="do" id="do" value="manual_sort">
                                    <input type="hidden" name="parent_id" id="parent_id" value="<?=$this->parent_id?>">
                                    <input type="hidden" name="sequence" id="sequence" value="">  

										<div class="table-responsive  deleted-table">
											
											<table id="user-datatable" class="table table-bordered border-bottom Userlist">
												<thead>
													<tr>
														<th width="5%" class="text-center">&nbsp;</th>
														<th width="10%" class="text-center">Sequence</th>
														<th width="25%">Title </th>
														<th width="25%">File</th>
														<th width="10%">Status</th>
														<th width="20%">Modified Date</th>
														<th width="5%">&nbsp; </th>
													</tr>
												</thead>
												<tbody>
													<?php if ($this->itemListCount > 0) { ?>
													<?php $i = 0; ?>
													<?php foreach ($this->itemList as $val) { ?>
													<?php $i++;?>	
													<tr>
														<td class="text-center">
                                                        <?=sprintf("%0"."2"."d",$i);?>															
														</td>
														<td class="text-center">
                                                            <input type="hidden" name="chkbox[]" id="chkbox" value="<?= $i ?>" />
                                                            <input type="hidden" name="id[]" id="id" value="<?= $val['id'] ?>" />
                                                            <input class="" name="sequence_new[]" id="sequence_new" type="text" style="width:50px; heigh:40px; text-align:center" maxlength="4" value="<?=$val['sequence'] ?>" align="absmiddle" />
                                                        </td>
                                                        <td><?=$val['title_la']?><BR><?=$val['title_en']?></td>
                                                       <td>
														<?php if($val['file_name_la'] != ''){ ?><a href="<?=$config['website']?>/img_product/file/<?=$val['file_name_la']?>" target="_blank"><?=$val['file_name_la']?></a><?php } ?>
														<?php if($val['file_name_en'] != ''){ ?><BR><a href="<?=$config['website']?>/img_product/file/<?=$val['file_name_en']?>" target="_blank"><?=$val['file_name_en']?></a><?php } ?>
														</td>
														<td>
															<span class="text-muted tx-13">
															<select class="form-select border" id="status_display<?=$val['id']?>" name="status_display<?=$val['id']?>" style="width: 100px" onchange="editStatusOnline('ProductFile',<?=$val['id']?>,this.value);">
															<option value="1"<?=($val['status'] == '1')? ' selected': ''?>>Online</option>
															<option value="0"<?=($val['status'] == '0')? ' selected': ''?>>Offline</option>
															</select>
															</span>
														</td>
														<td>
															<span class="text-muted tx-13"><?=date('d/m/Y',strtotime($val['modified_date']))?></span>
														</td>
														<td class="text-center"><div>
															<a href="download-item-edit.php?id=<?=$val['id']?>" class="btn btn-icon btn-info-light" data-bs-toggle="tooltip" title="" data-bs-original-title="Edit">
															<i class="las la-pen"></i></a></div>
															<div style="padding-top: 5px;">
															<a href="download-item-action.php?do=delete&id=<?=$val['id']?>" class="btn btn-icon btn-danger-light" data-bs-toggle="tooltip" title="" data-bs-original-title="Delete">
															<i class="las la-trash"></i></a></div>
																																	
														</td>
													</tr>
													<?php } ?>   
												 <?php } ?>  
												</tbody>
											</table>
										</div>
										</form>
										
									<!-- // Paging -->	
									<!--<div class="row">											
											<div class="col-sm-12 col-md-12">
											<div class="dataTables_paginate paging_simple_numbers" id="responsive-datatable_paginate">
												<ul class="pagination">
													<li class="paginate_button page-item previous disabled" id="responsive-datatable_previous">
													<a href="#" aria-controls="responsive-datatable" data-dt-idx="0" tabindex="0" class="page-link">Previous</a>
													</li>
													<li class="paginate_button page-item active">
													<a href="#" aria-controls="responsive-datatable" data-dt-idx="1" tabindex="0" class="page-link">1</a>
													</li>
													<li class="paginate_button page-item "><a href="#" aria-controls="responsive-datatable" data-dt-idx="2" tabindex="0" class="page-link">2</a></li><li class="paginate_button page-item "><a href="#" aria-controls="responsive-datatable" data-dt-idx="3" tabindex="0" class="page-link">3</a></li>
													<li class="paginate_button page-item next" id="responsive-datatable_next">
													<a href="#" aria-controls="responsive-datatable" data-dt-idx="7" tabindex="0" class="page-link">Next</a>
													</li>
												</ul>
												</div>
											</div>
										</div>	-->
									</div>
								</div>
								
							
							</div>
						</div>
						
						<!-- End Row -->
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
        <script language="javascript">
$(document).ready(function(){
 

	
});		
function editStatusOnline(type,id,status){
//	swal(status);

	if(confirm("Are you sure the edit status online ?") == true){
		//swal("Change");
		var type = type;
		var id = id;
		var status = status;

		$.get('ajax_edit_status.php', {
		  type : type,
		  id : id,
		  status : status,
		  time : new Date().getTime()
		  }, function(data) {
			//	alert(data);
        	//	swal("Complete");
			location.reload();
		});

			
	}
}	
function SetAction(val) {
  var sequence = $('#sequence_by').val();
 // alert(sequence);	
	  
  $('#sequence').val(sequence);
	
  document.getElementById('form2').action = 'download-item-action.php';
  document.getElementById('form2').target = '_self';
  document.getElementById('form2').submit();
}		
</script>		  
</body>
</html>
<?php
unset($_SESSION['item_form']);
session_destroy($_SESSION['item_form']);
?>                                                            