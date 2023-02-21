<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/Package';
?>
<?php include "header.php" ?>
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
            <a href="#"><?=$this->menu_main[$this->main]?></a>
            <img src="./images/right-header-menu-dot.svg" alt="">
          </div>
          <div class="right-header-menu">
            <a href="#"><?=$this->menu_sub[$this->menu]?></a>
            <img src="./images/right-header-menu-dot.svg" alt="">
          </div>
          <div class="right-header-menu">
            <a href="#"><?=$this->menu_group[$this->submenu]?></a>
            <img src="./images/right-header-menu-dot.svg" alt="">
          </div>
          <div class="right-header-menu active-header-right">
            <a href="#"><?=$this->layer->title_la?></a>
          </div>
        </div>

        <!-- Text Title -->

        <div class="banner-Mphone">
          <div class="banner-Mphone-title">
            <div class="banner-Mphone-logo" style="padding: 12px">
              <img src="<?=$config['website']?>/img_service/group/<?=$this->layer->image_icon?>" alt="">
            </div>
            <p><?=$this->layer->title_la?></p>
          </div>
        </div>

        <div class="news-catagory owl-theme owl-carousel page-no-title" id="news-owl-carousel">
			<?php $i=0; ?>
			<?php foreach($this->itemList as $val){ ?>
			<?php $i++; ?>	
          <a href="<?=$config['website']?>/la/content-page.php?id=<?=$val['id']?>&parent_id=<?=$this->parent_id?>&main=<?=$this->main?>&menu=<?=$this->menu?>&submenu=<?=$this->submenu?>">
            <div class="news-any-catagory<?=($val['id'] == $this->id)? ' active-news':''?>">
              <div class="flex-in-news-catagory-button">
				  <?php if($val['image_icon'] != ''){ ?>
                <div class="logo-in-news-any-catagory">
                  <img src="<?=$config['website']?>/img_service/group/<?=$val['image_icon']?>" alt="" class="bright-white">
                </div>
				  <?php } ?>
                <p><?=$val['title_la']?></p>
              </div>
            </div>
          </a>
			<?php } ?>
			
        </div>

        <div class="banner-Mphone">

          <!-- - Image Banner -->

         <?php if($this->group->image_la != ''){ ?>	
			 <a href="#" class="Img-Mphone">
            <img src="<?=$config['website']?>/img_consumer_group/<?=$this->group->image_la?>" alt="">
             </a>
		  <?php } ?>	

          <div class="banner-home-digital" style="margin-top: 30px">
           <?php if($this->layer->image != ''){ ?>
			<div class="left-banner-home-digital flex relative">              
              <img src="<?=$config['website']?>/img_service/group/<?=$this->layer->image?>" alt="<?=$this->layer->image_alt?>">            
			</div>	
 	 	    <?php } ?>

            <!-- VDO Youtube -->
			 <?php if($this->layer->youtube != ''){ ?>
            <div class="right-banner-home-digital flex relative">
              <img src="<?=$config['website']?>/img_service/group/cover/<?=$this->layer->thumbnail_youtube?>" alt="">
              <a class="btn-play-video" onclick="openVideo()">
                <img src="images/polygon.svg" alt="">
              </a>
            </div>
			  <?php } ?>
          </div>

          <!-- Text Subject -->
			 <?php if($this->layer->description_la != ''){ ?>
          <p class="under-banner-Mphone mt-100"><?=$this->layer->description_la?></p>
		  <?php } ?>
          
        </div>

         <?php if($this->layer->subject_la != ''){ ?>
        <div class="package-Mphone" style="margin-top: 0">
          <p class="package-Mphone-title"><?=$this->layer->subject_la?></p>
        </div>
		 <?php } ?> 

		<?php if($this->layerListCount > 0){ ?>
		<!-- Layer -->
		<?php foreach($this->layerList as $layer){ ?>
		<?php if($layer['title_la'] != ''){ ?> 
		<div class="package-Mphone" style="margin-top: 0">
          <p class="package-Mphone-title"><?=$layer['title_la']?></p>
        </div>  
		 <?php } ?>
		  
		  <?php if($layer['image_la'] != ''){ ?> 
		<div class="package-Mphone" style="margin-top: 0">
            <div class="Img-Mphone">
				<img src="<?=$config['website']?>/img_consumer_service_layer/<?=$layer['image_la']?>" alt="<?=$layer['image_alt_la']?>">
			</div>
			<div style="padding: 10px;"></div>	
        </div>  
		 <?php } ?>
		 <?=$layer['description_la']?> 		 
		    <div class="line-service-page"></div>
		 <?php } //foreach ?>
		
		 <?php } //IF ?>  
        


        

        <!-- [ DOCUMENT ] -->

          
		<?php if($this->fileListCount > 0){ ?>	
		<div class="package-Mphone" style="margin-top: 0">
            <p class="package-Mphone-title" 
              style="margin-top: 40px;line-height: 1.2;">
              application form
            </p>
            <?php $i=0; ?>
			
			<?php foreach($this->fileList as $file){ ?>
			<?php $i++; ?>  
            <div class="download-button flex al-item-center" style="margin-bottom: <?=($this->fileListCount == $i) ? '40px':'10px'?>">
              <div class="download-button-left flex al-item-center">
                <div class="file-download-img flex">
                  <img src="./images/file-pdf.svg" alt="">
                </div>
                <p><?=$file['title_la']?></p>
              </div>
              <div class="download-button-right flex al-item-center">
                <p class="storage-download"><?=number_format($file['file_size_la']/1024)?> KB.</p>
                <a href="<?=$config['website']?>/img_product/file/<?=$file['file_name_la']?>" class="for-download flex al-item-center">
                  <p>Download</p>
                  <div class="download-img">
                    <img src="./images/Download.svg" alt="">
                  </div>
                </a>
              </div>
            </div>
			<?php } ?>
			
            <div class="new-consumer-line"></div>
            <div class="any-package-Mphone" style="margin-top: 40px"></div>
          </div>
		<?php } // IF?>
		  
		<?php if($this->packageListCount > 0){ ?>	  
        <?php $i=0; ?>
		<?php foreach($this->packageList as $name){ ?>
		<?php $i++; ?>  
		  
        <div class="package-Mphone">		  	
          <p class="package-Mphone-title"><?=$name['title_la']?></p>
          <div class="any-package-Mphone">
			<?php
			   $sql = "SELECT * FROM package_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.title_la = ? ORDER BY i.sequence ASC";
			   $stmt = $db->Prepare($sql);
			   $rs = $db->Execute($stmt,array($name['title_la']));
			   $itemList = $rs->GetAssoc();
			   $itemListCount = $rs->maxRecordCount();
												   
			  ?>
		  <?php $x=0; ?>
		  <?php foreach($itemList as $val){ ?>
		  <?php $x++; ?>  	
          <!-- Item -->
            <div class="details-Mphone">
              <div class="box-package-Mphone">
                <div class="pd-of-line-box-package">
                  <h1 class="box-package-Mphone-code">Code <?=$val['packageKey']?></h1>
                </div>
                <div class="data-Mphone">
                  <p>Data Volume</p>
                  <h1><?=$val['specialValue']?></h1>
                </div>
                <div class="data-Mphone">
                  <p>Age of use</p>
                  <h1><?=$val['qtaDay']?> Day</h1>
                </div>
                <div class="font-in-bg-under">
                  <p class="cost-package-Mphone"><?=number_format($val['qtaBalance'])?> kip</p>
                  <div class="password-package-Mphone">
                    <p>Dial</p>
                    <button><?=$val['ussdCode']?></button>
                    <a href="#" class="button-tel-package">
                      <img src="./images/tel-package.svg" alt="">
                    </a>
                  </div>
                </div>
				  <!--
                <div class="bg-package-promotion">
                  <p>Popular</p>
                  <img src="./images/button-popular.svg" alt="">
                </div>
				
                <div class="leg-bg-package-promotion">
                  <img src="./images/double-triangle.svg" alt="">
                </div>
				    -->
              </div>

              <a href="#" class="shop-package">
                <div class="logo-shop-package">
                  <img src="./images/shop-package.svg" alt="">
                </div>
                <p>Shop now</p>
              </a>
            </div>
          <?php } ?>
            
            
          </div>
        </div>

        <?php } ?>
		<div class="line-service-page"></div>
		<?php } // IF?>
		  

        <!-- [ PACKAGE LIST Corporate ] -->

        <!-- Package Item Corporate [ Data Center On Cloud ] -->
		<?php if($this->cloudListCount > 0){ ?>	         
        <div class="package-Mphone">
          <p class="package-Mphone-title">Data Center On Cloud</p>
          <div class="any-package-Mphone package-business ">

            <!-- Item -->
			<?php $i=0; ?>
			<?php foreach($this->cloudList as $val){ ?>
			<?php $i++; ?>    
            <div class="details-Mphone">
              <div class="box-package-Mphone">
                <div class="details-on-bg-footer">
                  <div class="pd-of-line-box-package">
                    <h1 class="box-package-Mphone-code"><?=$val['title_la']?></h1>
                  </div>
                  <div class="data-Mphone">
                    <p>vCPU <?=$val['qtaVcpu']?></p>
                    <p>Mem (GB) <?=$val['qtaMem']?></p>
                    <p>Disk (GB) <?=$val['qtaDisk']?></p>
                  </div>
                </div>

                <div class="font-in-bg-under">
                  <p class="cost-package-Mphone">per Month</p>
                  <p class="cost-package-Mphone">(LAK) <?=number_format($val['qtaBalance'])?></p>
                </div>               
              </div>
             
            </div>
			<?php } // foreach?>
			  <div class="line-service-page"></div>
          </div>
        </div>		
		<?php } // IF?>

		<!-- Package Item Corporate [ Internet Leased Line ] -->

		<?php if($this->leaselineCount > 0){ ?>	  
        <?php $i=0; ?>
		<?php foreach($this->leaselineList as $name){ ?>
		<?php $i++; ?>  
		  
        <div class="package-Mphone">		  	
          <p class="package-Mphone-title"><?=$name['title_la']?></p>
          <div class="any-package-Mphone package-business">
			<?php
			   $sql = "SELECT * FROM leaseline_items i WHERE 1 = 1 AND i.status = '1' AND i.status_la = '1' AND i.title_la = ? ORDER BY i.sequence ASC";
			   $stmt = $db->Prepare($sql);
			   $rs = $db->Execute($stmt,array($name['title_la']));
			   $itemList = $rs->GetAssoc();
			   $itemListCount = $rs->maxRecordCount();
												   
			  ?>
			  <?php $x=0; ?>
			  <?php foreach($itemList as $val){ ?>
			  <?php $x++; ?>  	
			  <!-- Item -->
				<div class="details-Mphone Internet-Leased-Line ">
				  <div class="box-package-Mphone">
					<div class="details-on-bg-footer">
					  <div class="pd-of-line-box-package">
						<h1 class="box-package-Mphone-code">Package</h1>
					  </div>
					  <div class="data-Mphone">
						<p><?=$val['valueLeft']?></p>
					  </div>
					</div>

					<div class="font-in-bg-under">
					  <p class="cost-package-Mphone"><?=$val['valueRight']?></p>
					</div>               

				  </div>

				</div>
			  <?php } ?>            
          </div>
        </div>

        <?php } ?>
		<div class="line-service-page"></div>
		<?php } // IF?>		  
		  
        
        <!-- Package Item Corporate [ Data Package GPS ] -->
		<?php if($this->gpsListCount > 0){ ?>	
        <div class="package-Mphone">
          <p class="package-Mphone-title">Net Sim GPS package details</p>
        </div>

        <div class=" DATA-Package-GPS roaming-box">
          <!-- Header -->

          <div class="header-DATA-Package-GPS flex al-item-center ">
            <div class="left-DATA-Package-GPS text-center">
              <p>Data Package</p>
              <p>received / month</p>
            </div>
            <div class="right-DATA-Package-GPS text-center ">
              <p class="right-DATA-Package-GPS-title">Package price (kip) that customers pay each month</p>
              <div class="right-DATA-Package-GPS-under-title flex ">
                <p>1 months</p>
                <p>3 months</p>
                <p>6 months</p>
                <p>12 months</p>
              </div>
            </div>
          </div>

          <!-- Body -->
 			  <?php $x=0; ?>
			  <?php foreach($this->gpsList as $val){ ?>
			  <?php $x++; ?>  
          <div class="body-DATA-Package-GPS flex">
            <div class="left-body-DATA-Package-GPS text-center ">
              <p><?=$val['qtaData']?></p>
            </div>
            <div class="right-body-DATA-Package-GPS flex text-center">
              <p><?=number_format($val['qta01'])?></p>
              <p><?=number_format($val['qta03'])?></p>
              <p><?=number_format($val['qta06'])?></p>
              <p><?=number_format($val['qta12'])?></p>
            </div>
          </div>
			  <?php } ?>
			
        </div>
		<?php } ?>
        <!-- [ Data List Consumer ] -->

        <!-- Table Layout [Roaming] -->
		
        <div class="check-roaming">
		  <?php if($this->roamingCount > 0){ ?>		
          <p>Check Roaming Service Rates</p>
		  <form method="get" name="formeSim" id="formeSim" enctype="multipart/form-data" action="content-page.php">  	
          <div class="check-roaming-button-dropdown">
            <div class="check-roaming-any-button-dropdown">
              <div class="check-roaming-title-logo flex">
                <img src="./images/Lao-Telecom-Postpaid.svg" alt="">
              </div>
              <select name="type" id="type">
                <option value="1">ອັດຕາຄ່າບໍລິການ ເບີລາຍເດືອນ</option>
                <option value="2">ອັດຕາຄ່າບໍລິການ ເບີຕື່ມເງິນ</option>
              </select>
              <div>
                <img src="./images/undrop.svg" alt="">
              </div>
            </div>

            <div class="check-roaming-any-button-dropdown">
              <div class="check-roaming-title-logo flex">
                <img src="./images/South-Korea.svg" alt="">
              </div>
              <select name="country_id" id="country_id">
			  <?php foreach($this->countryList as $val){ ?>
                <option value="<?=$val['id']?>"><?=$val['title_la']?></option>
			  <?php } ?>	  
              </select>
              <div>
                <img src="./images/undrop.svg" alt="">
              </div>				
            </div>
			  
			<input type="hidden" name="id" id="id" value="<?=$this->id?>">
			<input type="hidden" name="parent_id" id="parent_id" value="<?=$this->parent_id?>">
			<input type="hidden" name="main" id="main" value="<?=$this->main?>">
			<input type="hidden" name="menu" id="menu" value="<?=$this->menu?>">
			<input type="hidden" name="submenu" id="submenu" value="<?=$this->submenu?>"> 
          </div>
			<div class="idd-search">
				<button type="submit" name="submit" id="submit">Submit</button> 
			</div>	
			  
		  </form>
			<?php } ?>
			<?php if($this->roamingListCount > 0){ ?>
          <div class="roaming-box">

            <div class="scroll-roming-box-responsive">

              <!-- Header -->
              <div class="roaming-box-header">
                <!-- Country -->
                <div class="roaming-box-country roaming-box-border-right">Country</div>

                <!-- Country code -->
                <div class="roaming-box-country-code roaming-box-border-right">Country code</div>

                <div class="roaming-box-service-rate-operator">
                  <!-- Operator -->
                  <div class="roaming-box-operator roaming-box-border-right">Operator Name</div>

                  <!-- Service rates -->
                  <div class="roaming-box-service-rate roaming-box-border-right">
                    <div class="roaming-box-service-rate-heading roaming-box-border-bottom">Service rates</div>
                    <div class="roaming-box-service-rate-list">
                      <div class="roaming-box-service-rate-item roaming-box-border-right">Domestic Calls in the roaming
                        country (kip/min.)</div>
                      <div class="roaming-box-service-rate-item roaming-box-border-right">Calling back to Thailand
                        (kip/min.)</div>
                      <div class="roaming-box-service-rate-item roaming-box-border-right">Call to other countries
                        (kip/min.)</div>
                      <div class="roaming-box-service-rate-item roaming-box-border-right">Answering calls (kip/min.)
                      </div>
                      <div class="roaming-box-service-rate-item">Sending SMS (kip/SMS)</div>
                    </div>
                  </div>

                  <!-- Signal -->
                  <div class="roaming-box-signal roaming-box-border-right">Signal</div>

                  <!-- On - screen network -->
                  <div class="roaming-box-screen">On - screen network</div>
                </div>

              </div>
				<?php foreach($this->roamingList as $val){ ?> 
              <!-- Body -->
				
              <div class="roaming-box-body">
                <!-- Country -->
                <div class="roaming-box-body-country roaming-box-border-right">South Korea</div>

                <!-- Country code -->
                <div class="roaming-box-body-country-code roaming-box-border-right">82</div>

                <div style="flex: 1;display: flex;flex-direction: column;">
                  <!-- Row 1 -->
                  <div class="roaming-box-body-service-rate-operator">
                    <!-- Operator -->
                    <div class="roaming-box-body-operator roaming-box-border-right"></div>

                    <div class="roaming-box-body-service-rate-list">
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right">1,500</div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right">2,000</div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right">1,500</div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right">3,000</div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right">1,500</div>
                    </div>

                    <!-- Signal -->
                    <div class="roaming-box-body-signal roaming-box-border-right"></div>

                    <!-- On - screen network -->
                    <div class="roaming-box-body-screen"></div>
                  </div>

                  <!-- Row 2 -->
                  <div class="roaming-box-body-service-rate-operator">
                    <!-- Operator -->
                    <div class="roaming-box-body-operator roaming-box-border-right roaming-box-border-top">KT</div>

                    <div class="roaming-box-body-service-rate-list">
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                    </div>

                    <!-- Signal -->
                    <div class="roaming-box-body-signal roaming-box-border-right roaming-box-border-top">
                      3G 2100
                    </div>

                    <!-- On - screen network -->
                    <div class="roaming-box-body-screen roaming-box-border-top">olleh KT</div>
                  </div>

                  <!-- Row 3 -->
                  <div class="roaming-box-body-service-rate-operator">
                    <!-- Operator -->
                    <div class="roaming-box-body-operator roaming-box-border-right roaming-box-border-top">SK Telecom
                    </div>

                    <div class="roaming-box-body-service-rate-list">
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                      <div class="roaming-box-body-service-rate-item roaming-box-border-right roaming-box-border-top">
                        <img src="./images/check-roaming.png" alt="">
                      </div>
                    </div>

                    <!-- Signal -->
                    <div class="roaming-box-body-signal roaming-box-border-right roaming-box-border-top">
                      3G 2100<br>
                      4G 1800<br>
                      4G 2100<br>
                      5G
                    </div>

                    <!-- On - screen network -->
                    <div class="roaming-box-body-screen roaming-box-border-top">
                      450 05<br>
                      KOR SK Telecom<br>
                      SK Telecom
                    </div>
                  </div>
                </div>
              </div>
			  	
				<?php } ?>
            </div>
          </div>
			<?php } ?>
        </div>
		
        <!-- Table Layout [IDD Call] -->

		<?php if($this->iddcallListCount > 0){ ?>
        <div class="package-Mphone">
          <p class="package-Mphone-title">idd call</p>
          <div class="home-digital-info">
            <p>Enter your desired country in the box below.</p>
          </div>
        </div>

        <div class="idd-submit">
		<form method="get" name="formIDD" id="formIDD" enctype="multipart/form-data" action="content-page.php">
			
          <div class="idd-search">
			<input type="hidden" name="id" id="id" value="<?=$this->id?>">
			<input type="hidden" name="parent_id" id="parent_id" value="<?=$this->parent_id?>">
			<input type="hidden" name="main" id="main" value="<?=$this->main?>">
			<input type="hidden" name="menu" id="menu" value="<?=$this->menu?>">
			<input type="hidden" name="submenu" id="submenu" value="<?=$this->submenu?>">
			<input type="text" name="iddcall_key" id="iddcall_key" value="">
            <button type="submit" name="submit" id="submit">Submit</button>
          </div>
		</form>	  	
		  <?php if($this->iddcall_key != ''){ ?>	
          <div class="roaming-box service-fees roaming-box-list-consumer">
            <!-- Header -->
            <div class="roaming-box-header">
              <div class="roaming-box-country roaming-box-border-right">
                <p>Country name</p>
              </div>

              <div class="roaming-box-country-code roaming-box-border-right">
                <p>Country code</p>
              </div>

              <div class="roaming-box-country-code roaming-box-border-right">
                <p>Abbreviation</p>
              </div>

              <div class="roaming-box-country-code roaming-box-border-right">
                <p>PRICE (LAK/MIN)</p>
              </div>

            </div>
            <!-- Body -->
			 <?php foreach($this->iddcallList as $val){ ?> 
            <div class="roaming-box-body">
              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">
                <p><?=$val['country_name']?></p>
              </div>

              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">
                <p><?=$val['country_code']?></p>
              </div>

              <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">
                <p><?=$val['country_value']?></p>
              </div>

              <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">
                <p><?=number_format($val['qtaBalance'])?></p>
              </div>

            </div>
			 <?php } ?>
            
          </div>
		  <?php } ?>		
        </div>
		<?php } ?>

        <!-- Table Layout [Wifi Service Area] -->
		<?php if($this->wifiareaListCount > 0){ ?>
        <div class="package-Mphone">
          <p class="package-Mphone-title">WIFI Service Areas</p>
        </div>

        <div class="roaming-box service-fees roaming-box-list-consumer wifi-service-box">
          <!-- Header -->
          <div class="roaming-box-header">

            <div class=" roaming-box-number roaming-box-country roaming-box-border-right">
              <p>No</p>
            </div>

            <div class="roaming-box-country roaming-box-border-right">
              <p>Location (Lao)</p>
            </div>

            <div class="roaming-box-country-code roaming-box-border-right">
              <p>Number of Access Points</p>
            </div>

            <div class="roaming-box-country-code roaming-box-border-right">
              <p>Indoor Access Points</p>
            </div>

            <div class="roaming-box-country-code roaming-box-border-right">
              <p>Outdoor Access Points</p>
            </div>

          </div>
          <!-- Body -->
		    <?php $i=0; $number = 0; $indoor = 0; $outdoor = 0; ?>
			<?php foreach($this->wifiareaList as $val){ ?>	
			<?php $i++; ?>
          <div class="roaming-box-body">
			
            <div
              class=" roaming-box-number roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">
              <p><?=$i?></p>
            </div>

            <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">
              <p><?=$val['location']?></p>
            </div>

            <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">
              <p><?=($val['number_point'] > 0) ? number_format($val['number_point']):''?></p>
            </div>

            <div class="roaming-box-body-country roaming-box-border-right roaming-box-border-bottom">
              <p><?=($val['indoor_point'] > 0) ? number_format($val['indoor_point']):''?></p>
            </div>

            <div class="roaming-box-body-country-code roaming-box-border-right roaming-box-border-bottom">
              <p><?=($val['outdoor_point'] > 0) ? number_format($val['outdoor_point']):''?></p>
            </div>

          </div>
			<?php 
					$number = $number+$val['number_point'];
					$indoor = $indoor+$val['indoor_point'];
					$outdoor = $outdoor+$val['outdoor_point'];													   
			 ?>
			<?php } ?>
         
          <!-- Footer  -->
          <div class="roaming-box-header roaming-box-footer ">
            <div class="roaming-box-country roaming-box-border-right">
              <p>Total</p>
            </div>

            <div class="roaming-box-country-code roaming-box-border-right">
             <p><?=number_format($number)?></p>
            </div>

            <div class="roaming-box-country-code roaming-box-border-right">
             <p><?=number_format($indoor)?></p>
            </div>

            <div class="roaming-box-country-code roaming-box-border-right">
              <p><?=number_format($outdoor)?></p>
            </div>

          </div>
        </div>
		<?php } ?>
		  
        <!-- Table Layout [eSIM] -->
		
		<?php if($this->esimListCount > 0){ ?>
        <div class="package-Mphone">
          <p class="package-Mphone-title">Please select brand</p>
        </div>
		
		<form method="get" name="formeSim" id="formeSim" enctype="multipart/form-data" action="content-page.php">  
		<div class="idd-search">
          <div class="check-roaming-any-button-dropdown ">
           
              <select name="brand_id" id="brand_id">
				<?php foreach($this->brandList as $val){ ?> 
                <option value="<?=$val['id']?>"<?=($this->brand_id == $val['id']) ? ' selected':''?>><?=$val['title']?></option>
                <?php } ?>
              </select>
            <div>
              <img src="./images/undrop.svg" alt="">
            </div>
          </div>
          <button type="submit" name="submit" id="submit">Submit</button>
        </div>
		  
			<input type="hidden" name="id" id="id" value="<?=$this->id?>">
			<input type="hidden" name="parent_id" id="parent_id" value="<?=$this->parent_id?>">
			<input type="hidden" name="main" id="main" value="<?=$this->main?>">
			<input type="hidden" name="menu" id="menu" value="<?=$this->menu?>">
			<input type="hidden" name="submenu" id="submenu" value="<?=$this->submenu?>">
        
		  </form>
		<?php } ?>  
		<div class="idd-search"></div>  
		<?php if(($this->esimListCount1 > 0) ||($this->esimListCount2 > 0)){ ?>  
        <div class="box-select-for-customer e-sim-select ">
          <div class="select-region">
            <div class="head-select">
              <p>Mobile</p>
            </div>
            <div class="body-select">
			<?php foreach($this->esimList1 as $esim){ ?>	
              <div class="radio-select">
                <label><?=$esim['title']?></label>
              </div>
			<?php } ?>
            </div>
          </div>
          <div class="choose-branch">
            <div class="head-select">
              <p>Electronic Devices</p>
            </div>
            <div class="body-select">
              <?php foreach($this->esimList2 as $esim){ ?>	
              <div class="radio-select">
                <label><?=$esim['title']?></label>
              </div>
			<?php } ?>

            </div>
          </div>
        </div>
		<?php } ?>
		  
		  
         <!-- [ Request Form ] -->
		<?php if($this->layer->form_request == '1'){ ?>
		 <form method="post" name="formRequest" id="formRequest" enctype="multipart/form-data" action="">    
        <div class="package-Mphone">
          <p class="package-Mphone-title">SERVICE REQUEST FORM</p>
        </div>

        <div class="home-digital-info">
          <p>Provide information about the service, if you are interested in the service, choose a package to buy or
            want try it for free for 1 month</p>
        </div>

        <div class="business-request enquiry-right suggester-input">

          <div class="enquiry-input">
            <div class="wd100">
              <p>Name and Surname</p>
              <input type="text" class="mt-10">
            </div>
            <div class="wd100 ">
              <p>Company name</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input">
            <div class="wd100">
              <p>Telephone/Mobile number</p>
              <input type="text" class="mt-10">
            </div>
            <div class="wd100 ">
              <p>WhatsApp number</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input ">
            <div class="wd100">
              <p>Email</p>
              <input type="text" class="mt-10">
            </div>
            <div class="wd100">
              <p>Province</p>
              <div class="check-roaming-any-button-dropdown wd100 mt-10">
                <select name="province_id" id="province_id">
                  <option value="">Select Province</option>
			      <?php foreach($this->provinceList as $val){ ?>					
                  <option value="<?=$val['id']?>"><?=$val['prov_name_la']?></option>
				  <?php } ?>	
                </select>
                <div>
                  <img src="./images/undrop.svg" alt="">
                </div>
              </div>
            </div>
          </div>

          <div class="enquiry-input ">
            <div class="wd100">
              <p>District</p>
              <div class="check-roaming-any-button-dropdown wd100 mt-10">
                <select>
                  <option value=""></option>
                  <option value="">ເມືອງ</option>
                </select>
                <div>
                  <img src="./images/undrop.svg" alt="">
                </div>
              </div>
            </div>
            <div class="wd100 ">
              <p>Address</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input">
            <div class="wd100 ">
              <p>Message</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-submit">
            <div class="news-catagory">
              <a href="#">
                <div class="news-any-catagory">
                  <p>Submit</p>
                </div>
              </a>

              <a href="#">
                <div class="news-any-catagory">
                  <p>Cancel</p>
                </div>
              </a>
            </div>
          </div>

        </div>

        <div class="line-service-page"></div>
		  </form>	 
		<?php } ?>
		  
		<?php if($set){ ?>  
        <div class="package-Mphone">
          <p class="package-Mphone-title">Person provides advice</p>
        </div>

        <div class="home-digital-info">
          <p>Register the person who recommends using the internet service. to receive special privileges</p>
        </div>

        <div class="business-request enquiry-right suggester-input">
          <div class="enquiry-input ">
            <div class="wd100">
              <p>Suggester Name</p>
              <input type="text" class="mt-10">
            </div>
            <div class="wd100 ">
              <p>Suggester Username</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input ">
            <div class="wd50">
              <p>Suggester Phone</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-submit">
            <div class="news-catagory">
              <a href="#">
                <div class="news-any-catagory">
                  <p>Submit</p>
                </div>
              </a>

              <a href="#">
                <div class="news-any-catagory">
                  <p>Cancel</p>
                </div>
              </a>
            </div>
          </div>



        </div>

        <!-- Select FTTH Speed -->

        <div class="package-Mphone">
          <p class="package-Mphone-title">Register for FTTH installation via website</p>
        </div>

        <div class="home-digital-info">
          <p>Provide information about the service, if you are interested in the service, choose a package to buy or
            want to try it for free for 1 month</p>
        </div>

        <div class="business-request enquiry-right suggester-input">

          <div class="enquiry-input ">
            <div class="wd100">
              <p>Name and Surname</p>
              <input type="text" class="mt-10">
            </div>
            <div class="wd100">
              <p>Telephone/Mobile number</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input ">
            <div class="wd100">
              <p>WhatsApp number</p>
              <input type="text" class="mt-10">
            </div>
            <div class="wd100">
              <p>Address</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input ">
            <div class="wd100 ">
              <p>Province</p>
              <div class="check-roaming-any-button-dropdown wd100 mt-10">
                <select>
                  <option value=""></option>
                  <option value="">ແຂວງ</option>
                </select>
                <div>
                  <img src="./images/undrop.svg" alt="">
                </div>
              </div>
            </div>
            <div class="wd100">
              <p>District</p>
              <div class="check-roaming-any-button-dropdown wd100 mt-10">
                <select>
                  <option value=""></option>
                  <option value="">ເມືອງ</option>
                </select>
                <div>
                  <img src="./images/undrop.svg" alt="">
                </div>
              </div>
            </div>
          </div>

          <div class="enquiry-submit">
            <div class="news-catagory">
              <a href="#">
                <div class="news-any-catagory">
                  <p>Submit</p>
                </div>
              </a>

              <a href="#">
                <div class="news-any-catagory">
                  <p>Cancel</p>
                </div>
              </a>
            </div>
          </div>
        </div>



        <div class="package-Mphone">
          <p class="package-Mphone-title">Select FTTH Speed</p>
        </div>


        <div class=" FTTH-Speed roaming-box mt-unset">
          <!-- Header -->

          <div class="header-DATA-Package-GPS flex al-item-center ">
            <div class="left-header-FTTH-Speed text-center">
              <div>
                Prepaid
              </div>
              <div class="flex">
                <p>Abroad</p>
                <p>in the country</p>
              </div>
            </div>
            <div class="right-header-FTTH-Speed text-center ">
              <div>Prepaid</div>
              <div>01 Month</div>
            </div>
          </div>

          <!-- Body -->

          <div class="body-DATA-Package-GPS flex">
            <div class="left-body-FTTH-Speed flex">
              <p>3</p>
              <p>25</p>
            </div>
            <div class="right-body-FTTH-Speed">140,000</div>
          </div>

          <div class="body-DATA-Package-GPS flex">
            <div class="left-body-FTTH-Speed flex">
              <p>5</p>
              <p>25</p>
            </div>
            <div class="right-body-FTTH-Speed">230,000</div>
          </div>

          <div class="body-DATA-Package-GPS flex">
            <div class="left-body-FTTH-Speed flex">
              <p>7</p>
              <p>25</p>
            </div>
            <div class="right-body-FTTH-Speed">308,000</div>
          </div>

        </div>

        <div class="line-service-page"></div>



        <!-- Feedback -->

        <div class="banner-Mphone">
          <div class="banner-Mphone-title">
            <div class="banner-Mphone-logo" style="padding: 12px">
              <img src="./images/Feedback.svg" alt="">
            </div>
            <p>Feedback</p>
          </div>
        </div>

        <div class="business-request enquiry-right suggester-input">

          <div class="enquiry-input ">
            <div class="wd100 ">
              <p>Please select your service</p>
              <div class="check-roaming-any-button-dropdown wd100 mt-10">
                <select>
                  <option value=""></option>
                  <option value="">ແຂວງ</option>
                </select>
                <div>
                  <img src="./images/undrop.svg" alt="">
                </div>
              </div>
            </div>
            <div class="wd100">
              <p>Name and Surname</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input ">
            <div class="wd100 ">
              <p>Province</p>
              <div class="check-roaming-any-button-dropdown wd100 mt-10">
                <select>
                  <option value=""></option>
                  <option value="">ແຂວງ</option>
                </select>
                <div>
                  <img src="./images/undrop.svg" alt="">
                </div>
              </div>
            </div>
            <div class="wd100">
              <p>District</p>
              <div class="check-roaming-any-button-dropdown wd100 mt-10">
                <select>
                  <option value=""></option>
                  <option value="">ເມືອງ</option>
                </select>
                <div>
                  <img src="./images/undrop.svg" alt="">
                </div>
              </div>
            </div>
          </div>

          <div class="enquiry-input">
            <div class="wd100 ">
              <p>Address</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input ">
            <div class="wd100">
              <p>Telephone/Mobile number</p>
              <input type="text" class="mt-10">
            </div>
            <div class="wd100">
              <p>Email</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-input">
            <div class="wd100 ">
              <p>Comment</p>
              <input type="text" class="mt-10">
            </div>
          </div>

          <div class="enquiry-submit ">
            <div class="news-catagory mt-50">
              <a href="#">
                <div class="news-any-catagory">
                  <p>Submit</p>
                </div>
              </a>

              <a href="#">
                <div class="news-any-catagory">
                  <p>Cancel</p>
                </div>
              </a>
            </div>
          </div>

        </div>
		<?php } ?>

      </div>
    </div>

    <!-- Video Popup -->
    <div class="video-popup">
      <div class="video-inner">
        <button onclick="closeVideo()">
          Close
        </button>
        <iframe width="100%" height="500" src="" title="YouTube video player" frameborder="0"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen id="video_iframe"></iframe>
      </div>
    </div>
  </div>

  <div class="footer-bg">
    <img src="./images/bg-line-water-footer.png" alt="" />
  </div>

</div>

<?php include "footer.php" ?>

<script>
  setActiveSideMenu(<?=$this->main?>);
  setActiveDropdownHaveDropdownInsideSideMenu(<?=$this->main?>);
  MainMenuActive(1)
  setActiveDropdownInSideMenu(<?=$this->main?>, <?=$this->menu?>);
  setActiveSecondDropdown(<?=$this->main?>, <?=$this->menu?>, <?=$this->submenu?>);

  $(document).ready(function ($) {
    const owl = $("#news-owl-carousel");
    owl.owlCarousel({
      items: 5,
      dots: false,
      autoWidth: true,
      margin: 10
    });
  });

  function openVideo() {
    const videoPopup = document.querySelector(".video-popup");
    const videoIframe = document.getElementById("video_iframe");
    if (videoPopup) {
      videoPopup.classList.add("video-popup-active");
      videoIframe.src = "<?=$this->layer->youtube?>";
    }
  }

  function closeVideo() {
    const videoPopup = document.querySelector(".video-popup");
    const videoIframe = document.getElementById("video_iframe");
    if (videoPopup) {
      videoPopup.classList.remove("video-popup-active");
      videoIframe.src = "";
    }
  }
</script>