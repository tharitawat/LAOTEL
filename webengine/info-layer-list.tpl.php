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
function setUrl(val){
	window.open('?parent_id=<?=$this->parent_id?>&perpage='+val,'_self');
}
function bthclear(val){
	window.open('?parent_id=<?=$this->parent_id?>','_self');
}
</script>		
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
        SetAction('info-layer-edit.php?id=' + chk_id); // edit last id.
      }                                        
    } else if (val == 'delete') {     
      if (chkstatus < 1) {   
        swal("Please select any Check Box");     
        return false;
      }  
      else if (!confirm('Do you want to delete ? ')) {  
        return false;
      } else {               
        SetAction("info-layer-action.php?do=listdelete"); 
      }                                            
    } else if (val == 'update') {                
      if (chkstatus < 1) {   
        swal("Please select any Check Box");     
        return false;
      }  
      else if (!confirm('Do you want to update ? ')) {  
        return false;
      } else {             
        SetAction('info-layer-action.php?do=listupdate');   
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
						<span class="main-content-title mg-b-0 mg-b-lg-1">Info Page</span>
						</div>
						<div class="justify-content-center mt-2">
							<ol class="breadcrumb">
								<li class="breadcrumb-item tx-15"><a href="javascript:void(0);">Home</a></li>
								<li class="breadcrumb-item" aria-current="page">Info Page</li>
								<li class="breadcrumb-item" aria-current="page"><a href="info-item-list.php?parent_id=<?=$this->item->parent_id?>"><?=$this->cate->title_la?></a></li>
								<li class="breadcrumb-item active" aria-current="page"><?=$this->item->title_la?></li>
							</ol>
						</div>
					</div>
					<!-- /breadcrumb -->

					<!-- Start Content -->
					<div class="row row-sm">
					<div class="col-lg-12">
						<div class="card custom-card">
							<div class="card-body">
                            <p><strong>Search Data </strong> <?=$this->search_key?></p>
                            <form action="<?=$_SERVER['PHP_SELF']?>" method="GET" name="formSearch" id="formSearch" onSubmit="return chkSearch();">
							<table  border="0" cellpadding="4" cellspacing="0">

								<tr>
								<td class="label-search-head">Key Search: </td>
								<td><input name="search_key" type="text" class="form-control w-250" id="search_key" value="<?=$this->search_key?>">
								<input name="parent_id" id="parent_id" type="hidden" value="<?=$this->parent_id?>">
								<input name="cate_id" id="cate_id" type="hidden" value="<?=$this->cate_id?>">
								</td>
								<td><button name="cmdSearch" type="submit" class="btn btn-danger" id="cmdSearch" value="Search">Search</button>
									<button name="cmdClear" onclick="bthclear(<?=$this->parent_id?>);" type="button" class="btn  btn-dark-light" id="cmdClear" value="Clear">Clear</button></td>
								</tr>
								<tr>
								<td class="notable-data">&nbsp;</td>
								<td><span class="txt-red">* key search by name</span></td>
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
							<a class="btn ripple btn-primary" href="info-layer-add.php?parent_id=<?=$this->parent_id?>"><i class="fe fe-plus me-2"></i>Add Data</a>
						
							<a class="btn ripple btn-info" href="info-layer-sequence.php?parent_id=<?=$this->parent_id?>"><i class="fe fe-list me-2"></i>Sequence</a>
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
						<!-- Row -->
						<div class="row row-sm">
							<div class="col-lg-12">
								<div class="card custom-card">
									<div class="card-body">
										<form action="" method="post" enctype="multipart/form-data" name="form1" id="form1"> 
										<div class="table-responsive  deleted-table">
											
											<table id="user-datatable" class="table table-bordered border-bottom Userlist">
												<thead>
													<tr>
														<th width="5%" class="text-center">&nbsp;</th>
														<th width="25%">Title</th>
														<th width="10%">Layout (LA)</th>
														<th width="10%">Layout (EN)</th>
														<th width="10%">Layout (CN)</th>
														<th width="10%">Layout (VI)</th>
														<th width="10%">Status</th>
														<th width="15%">Modified Date</th>
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
															<?=$i?>
															<input type="hidden" name="id[]" id="id" value="<?= $val['id'] ?>" />
														</td>
														<td width="25%">
														<?=($val['title_la'] != '') ? $val['title_la'] :''?>
														<?=($val['title_en'] != '') ? $val['title_en'] :''?>
														<?=($val['title_cn'] != '') ? $val['title_cn'] :''?>
														<?=($val['title_vi'] != '') ? $val['title_vi'] :''?>
														</td>
														<td class="text-center"><?=($val['layout_la'] != '') ? $val['layout_la'] :''?></td>
														<td class="text-center"><?=($val['layout_en'] != '') ? $val['layout_en'] :''?></td>
														<td class="text-center"><?=($val['layout_cn'] != '') ? $val['layout_cn'] :''?></td>
														<td class="text-center"><?=($val['layout_vi'] != '') ? $val['layout_vi'] :''?></td>
														<td>
															<span class="text-muted tx-13">
															<select class="form-select border" id="status_display<?=$val['id']?>" name="status_display<?=$val['id']?>" style="width: 100px" onchange="editStatusOnline('InfoLayer',<?=$val['id']?>,this.value);">
															<option value="1"<?=($val['status'] == '1')? ' selected': ''?>>Online</option>
															<option value="0"<?=($val['status'] == '0')? ' selected': ''?>>Offline</option>
															</select>
															</span>
														</td>
														<td>
															<span class="text-muted tx-13"><?=date('d/m/Y',strtotime($val['modified_date']))?></span>
														</td>
														<td class="text-center"><div>
															<a href="info-layer-edit.php?id=<?=$val['id']?>" class="btn btn-icon btn-info-light" data-bs-toggle="tooltip" title="" data-bs-original-title="Edit">
															<i class="las la-pen"></i></a></div>
															<div style="padding-top: 5px;">
															<a href="info-layer-action.php?do=delete&id=<?=$val['id']?>" class="btn btn-icon btn-danger-light" data-bs-toggle="tooltip" title="" data-bs-original-title="Delete">
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

	</body>
</html>