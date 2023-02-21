<?php include "header.php" ?>
.....

<div class="outer-box" style="padding: 0">

	<div class="top-bg">
		<img src="./images/bg-line-water-header.png" alt="" />
	</div>

  <div class="container">
    <div class="content">
      <?php include "main-sidebar.php" ?>

      <div class="right-content news-section">
          <div class="right-header">
            <div class="right-header-menu">
              <a href="#">Home</a>
              <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu">
              <a href="#">Consumer</a>
              <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu">
              <a href="#">Contact us</a>
              <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu active-header-right">
              <a href="#">Customer Service Center</a>
            </div>

          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo" style="padding: 7px">
                <img src="./images/customer-service-center.png" alt="">
              </div>
              <p>customer service center</p>
            </div>
          </div>
		   <!--
          <div class="news-catagory">
			  <a href="?parent_id=1" class="part-item">
              <div class="news-any-catagory<?=($this->parent_id == '1') ? ' active-news':''?>">
                <p>ນວ</p>
              </div>
            </a>
			  
            <a href="?parent_id=3" class="part-item">
              <div class="news-any-catagory<?=($this->parent_id == '3') ? ' active-news':''?>">
                <p>ພາກກາງ</p>
              </div>
            </a>

            <a href="?parent_id=2" class="part-item">
              <div class="news-any-catagory<?=($this->parent_id == '2') ? ' active-news':''?>">
                <p>ພາກເໜືອ</p>
              </div>
            </a>

            <a href="?parent_id=4" class="part-item">
              <div class="news-any-catagory<?=($this->parent_id == '4') ? ' active-news':''?>">
                <p>ພາກໃຕ້</p>
              </div>
            </a>
          </div>
		 
          <div class="news-catagory owl-theme owl-carousel province-list" id="news-owl-carousel">
			  <?php foreach($this->provinceList as $val){ ?>
						<a href="?parent_id=<?=$_GET['parent_id']?>&province_id=<?=$val['id']?>">
							<div class="news-any-catagory<?=($this->province_id == $val['id']) ? ' active-news':''?>">
								<p><?=$val['prov_name_la']?></p>
							</div>
						</a>
			  <?php } ?>
					</div>
		  -->
		  <form name="form1" id="form1" method="get" action="">
		  <input type="hidden" id="main" name="main" value="<?=$this->main?>" />	  
		  <input type="hidden" id="menu" name="menu" value="<?=$this->menu?>" />	  
		  <div class="box-select-for-customer">
            <div class="select-region">
              <div class="head-select">
                <p>Select region</p>
              </div>
              <div class="body-select">
                <div class="radio-select" >
                  <input type="radio" id="parent_id1" name="parent_id" value="1"<?=($this->parent_id == '1') ? ' checked':''?> onClick="SetAction(this.value)" />
                  <label>ນວ</label>
                </div>
                <div class="radio-select" >
                  <input type="radio" id="parent_id2" name="parent_id" value="3"<?=($this->parent_id == '3') ? ' checked':''?> onClick="SetAction(this.value)" />
                  <label>ພາກກາງ</label>
                </div>
                <div class="radio-select" >
                  <input type="radio" id="parent_id3" name="parent_id" value="2"<?=($this->parent_id == '2') ? ' checked':''?> onClick="SetAction(this.value)" />
                  <label>ພາກເໜືອ</label>
                </div>
				 <div class="radio-select" >
                  <input type="radio" id="parent_id4" name="parent_id" value="4"<?=($this->parent_id == '4') ? ' checked':''?> onClick="SetAction(this.value)" />
                  <label>ພາກໃຕ້</label>
                </div>  
              </div>
              <p class="under-table-select" >1. Please select region.</p>
            </div>
            <div class="choose-branch">
              <div class="head-select">
                <p>Choose a province</p>
              </div>
              <div class="body-select">
				   <?php foreach($this->provinceList as $val){ ?>
                <div class="radio-select" >
                  <input type="radio" id="province_id" name="province_id" value="<?=$val['id']?>"<?=($this->province_id == $val['id']) ? ' checked':''?> onClick="SetAction(this.value)"  />
                  <label><?=$val['prov_name_la']?></label>
                </div>
				  <?php } ?>               
              </div>
              <p class="under-table-select" >2. And select the province you wish to contact.</p>
            </div>
          </div>
		  </form>	
          <div class="map-img">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d121435.1006075625!2d102.59060084751825!3d17.985858839371303!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sla!4v1668740529128!5m2!1sen!2sla" width="100%" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
          </div>
		  <?php foreach($this->itemList as $val){ ?>	
          <div class="customer-service-contact-button flex al-item-center">
            <div class="custom-service-title">
              <p><?=$val['title_la']?></p>
            </div>

            <div class="custom-service-contact flex al-item-center">
              <a href="tel:21-812147">
                <div class="custom-service-tel flex al-item-center">
                  <div class="banner-Mphone-logo flex">
                    <img src="./images/tel-contact-page.svg" alt="">
                  </div>
                  <p><?=$val['phone']?></p>
                </div>
              </a>
				<?php if($val['url_map'] != ''){ ?>
              <a href="<?=$val['url_map']?>" class="custom-service-map-button flex al-item-center" target="_blank">
                <div class="map-button-img flex">
                  <img src="./images/map_2.svg" alt="" class="bright-white">
                </div>
                <p>MAP</p>
              </a>
			<?php } ?>	
            </div>
          </div>
		  <?php } ?>

      </div>

    </div>
  </div>

  <div class="footer-bg">
		<img src="./images/bg-line-water-footer.png" alt="" />
	</div>
</div>
<?php include "footer.php" ?>
<script>
  $(document).ready(function ($) {
		const owl = $("#news-owl-carousel");
		owl.owlCarousel({
			items: 5,
			dots: false,
			autoWidth: true,
			margin: 10
		});
	});
</script>
<script>
  setActiveSideMenu(<?=$this->main?>);
  setActiveDropdownHaveDropdownInsideSideMenu(<?=$this->main?>);
  MainMenuActive(1)
  setActiveDropdownInSideMenu(<?=$this->main?>, <?=$this->menu?>);
  setActiveSecondDropdown(<?=$this->main?>, <?=$this->menu?>, <?=$this->submenu?>);
</script>
<script type="text/javascript"><!--
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
		alert(objId);
var selObj = null; with (document) {
if (getElementById) selObj = getElementById(objId);
if(selObj.options[selObj.selectedIndex].value !='' ){
if (selObj) eval(targ + ".location = '" + selObj.options[selObj.selectedIndex].value + "';");
}
if (restore) selObj.selectedIndex=0; }
}
function SetAction(val) {
  var main = '<?=$this->main?>';
  var menu = '<?=$this->menu?>';
	
 // alert(sequence);	
  $('#main').val(main);  
  $('#menu').val(menu);
	
  document.getElementById('form1').action = 'customer-service-center.php';
  document.getElementById('form1').target = '_self';
  document.getElementById('form1').submit();
}		
//-->
</script>	
