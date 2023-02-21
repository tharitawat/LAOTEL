<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/News-Event';
?>
<?php include "header.php" ?>

<div class="outer-box" style="padding: 0">

	<div class="top-bg">
		<img src="./images/bg-line-water-header.png" alt="" />
	</div>

	<div class="container">
		<div class="content">

			<!-- Menu -->
   		    <?php include "main-sidebar.php" ?>

			<div class="right-content news-section">

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
						<a href="#">About Lao Telecom</a>
						<img src="./images/right-header-menu-dot.svg" alt="">
					</div>
					<div class="right-header-menu active-header-right">
						<a>News & Events</a>
					</div>
				</div>

				<div class="banner-Mphone">
					<!-- Title -->
					<div class="banner-Mphone-title">
						<div class="banner-Mphone-logo">
							<img src="./images/news&events.svg" alt="">
						</div>
						<p>News & Events</p>
					</div>

					<!-- Category -->
					<div class="news-catagory owl-theme owl-carousel" id="news-owl-carousel">
						<?php foreach($this->newsList as $cate){ ?>
						<a href="<?=$config['website']?>/la/news-event.php?parent_id=<?=$cate['id']?>">
							<div class="news-any-catagory<?=($this->parent_id == $cate['id']) ? ' active-news':''?>">
								<p><?=$cate['title_la']?></p>
							</div>
						</a>
						<?php } ?>
					</div>

					<!-- News Items -->
					<div class="box-of-news">
						<?php foreach($this->itemList as $val){ ?>
						<?php if($val['youtube'] != ''){ ?>
						<a href="<?=$config['website']?>/la/news-detail.php?id=<?=$val['news_id']?>" class="any-box-of-news">
							<div class="img-of-new">
								<iframe width="290" height="175" src="<?=$val['youtube']?>" title="<?=$val['image_alt']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
								
							<!--	<img src="<?=$config['website']?>/img_news/<?=$val['thumbnail']?>" alt="<?=$val['image_alt']?>"> -->
							</div>
							<div class="item-news-title">
								<?=$val['title_la']?>
							</div>
							<div class="footer-in-box-news">
								<div class="read-more-news">
									<p>Read more</p>
									<img src="./images/arrow-right.svg" alt="">
								</div>
								<div class="date-news">
									<p><?=date('d',strtotime($val['published_date']))?> <?=Lang::getLaoMonth(date('m',strtotime($val['published_date'])))?> <?=date('Y',strtotime($val['published_date']))?></p>
								</div>
							</div>
						</a>
						<?php }else{ ?>
						<a href="<?=$config['website']?>/la/news-detail.php?id=<?=$val['news_id']?>" class="any-box-of-news">
							<div class="img-of-new">
								<img src="<?=$config['website']?>/img_news/<?=$val['thumbnail']?>" alt="<?=$val['image_alt']?>">
							</div>
							<div class="item-news-title">
								<?=$val['title_la']?>
							</div>
							<div class="footer-in-box-news">
								<div class="read-more-news">
									<p>Read more</p>
									<img src="./images/arrow-right.svg" alt="">
								</div>
								<div class="date-news">
									<p><?=date('d',strtotime($val['published_date']))?> <?=Lang::getLaoMonth(date('m',strtotime($val['published_date'])))?> <?=date('Y',strtotime($val['published_date']))?></p>
								</div>
							</div>
						</a>
						<?php } // IF ?>
					<?php } ?>		
					</div>

					<!-- Pagination -->
					<?php if($paging){ ?>
					<div class="slide-news">
						<a href="#">
							<img src="./images/slide-left.svg" alt="">
						</a>
						<a href="#" class="number-slides-news active-news">
							<p>1</p>
						</a>
						<a href="#" class="number-slides-news">
							<p>2</p>
						</a>
						<a href="#" class="number-slides-news">
							<p>3</p>
						</a>
						<a href="#" class="number-slides-news">
							<p>4</p>
						</a>
						<a href="#" class="number-slides-news">
							<p>5</p>
						</a>
						<a href="#">
							<img src="./images/slide-right.svg" alt="">
						</a>
					</div>
					<?php } ?>

				</div>

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
  setActiveSideMenu(5)
  setActiveDropdownSideMenu(5, 5)
  MainMenuActive(1)
</script>