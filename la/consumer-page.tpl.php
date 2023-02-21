<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/Consumer-Prepaid';
?>
<?php include "header.php" ?>

<div class="prepaid-top-bg">
    <div class="container">
        <!-- Breadcrumb -->
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
                <a href="#"><?=$this->menu->title_la?></a>
                <img src="./images/right-header-menu-dot.svg" alt="">
            </div>
            <div class="right-header-menu active-header-right">
                <a href="#"><?=$this->submenu->title_la?></a>
            </div>
        </div>

        <!-- Heading -->
        <div class="banner-Mphone">
            <div class="banner-Mphone-title">
                <div class="banner-Mphone-logo">
                    <img src="<?=$config['website']?>/img_submenu/<?=$this->submenu->image?>" alt="">
                </div>
                <p><?=$this->category->title_la?></p>
            </div>
            <div>
                <img src="<?=$config['website']?>/img_consumer_category/<?=$this->category->image_la?>" style="width: 100%">
            </div>
        </div>
    </div>
</div>

<div class="prepaid-bottom-bg">
    <div class="container">

        <div class="prepaid-product-service">
			<?php $i=0; ?>
			<?php foreach($this->itemList as $val){ ?>
			<?php $i++; ?>
			<?php
				$sql = "SELECT * FROM consumer_layers i WHERE 1 = 1 AND i.parent_id = '".$val['id']."' ORDER BY i.sequence ASC, i.id ASC";
				$stmt = $db->Prepare($sql);
				$rs = $db->Execute($stmt);
				$layerList = $rs->GetAssoc();
				$layerListCount = $rs->maxRecordCount();
			?>
			
            <!-- Item <?=$i?> -->
			
            <div class="any-box-prepaid">
                <div class="img-prepaid-product">
                    <img src="<?=$config['website']?>/img_consumer_group/<?=$val['image_la']?>" alt="">
                    <div class="ab-title-prepaid">
                        <p><?=$val['title_la']?></p>
                    </div>
                </div>
				<?php if($layerListCount >0){ ?>
				<?php foreach($layerList as $service){ ?>
                <a href="consumer-package.php?id=<?=$service['id']?>&parent_id=<?=$this->parent_id?>&submenu_id=<?=$this->submenu_id?>">
                    <div class="under-img-prepaid-product">
                        <div class="dropdown-logo-title button-prepaid">
                            <div class="dropdown-logo">
                                <img src="<?=$config['website']?>/img_service/group/<?=$service['image_icon']?>" alt="M phone" class="sidebar-img-inactive">
                                <img src="./images/Mphone-active.svg" alt="M phone" class="sidebar-img-active">
                            </div>
                            <p><?=$service['title_la']?></p>
                        </div>
                    </div>
                </a>
				<?php } ?>
               <?php } ?>
            </div>
			<?php } ?>	
          
        </div>

    </div>
</div>

</div>

<?php include "footer.php" ?>