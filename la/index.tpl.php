<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;

$page_title = '';
$page_description = '';
$meta_canonical = $config['website'].'/index';
?>
<?php include('header.php'); ?>
<!-- Banner -->
<?php if($this->bannerListCount > 0){ ?>
<div class="slider-pro" id="my-slider">
    <div class="sp-slides">
		<?php $i=0; ?>
		<?php foreach($this->bannerList as $val){ ?>
		<?php $i++; ?>
        <!-- Slide <?=$i?> -->
		<?php if($val['image_la'] != ''){ ?>
        <div class="sp-slide">
            <img class="sp-image" src="<?=$config['website']?>/img_banner/<?=$val['image_la']?>" />
        </div>
		<?php } ?>
       <?php } ?> 
    </div>
</div>
<?php } ?>
<!-- End banner -->

<!-- Live & Package & Service  -->
<div class="live-package-service">
    <!-- Live -->
	<?php if($this->special_image != ''){ ?>
    <div class="live-box">
        <img src="<?=$config['website']?>/img_special/<?=$this->special_image?>" width="100%">
    </div>
	<?php } ?>

    <!-- Package & Service -->
	<?php if($this->serviceListCount1 > 0){ ?>
    <div class="package-service">
        <div class="container">
            <h2 class="section-heading">Package and Service</h2>
        </div>

        <div class="package-service-owl-carousel-box">

            <button class="pre-btn-package-service-owl">
                <img src="images/arrow-left-red.svg">
            </button>

            <div class="container">
                <div class="package-service-owl-carousel owl-theme owl-carousel" id="package-service-owl-carousel">
					<?php $i=0; ?>
					<?php foreach($this->serviceList1 as $val){ ?>
					<?php $i++; ?>
                    <!-- Item <?=$i?> -->
                    <div class="package-service-item">
                        <div class="package-service-item-image-box">
                            <img src="<?=$config['website']?>/img_service/<?=$val['image_la']?>" class="package-service-item-image">
                        </div>
                        <!-- Title -->
                        <h2 class="package-service-item-title">
                            <?=$val['title_la']?>
                        </h2>
                        <!-- Body -->
                        <p class="package-service-item-body">
                            <?=$val['subject_la']?>
                        </p>
                        <a href="<?=$val['url_la']?>" class="btn-view-more">
                            View All
                            <img src="images/arrow-right-red.svg" alt="">
                        </a>
                    </div>
					<?php } ?>	
                  

                </div>
            </div>

            <button class="next-btn-package-service-owl">
                <img src="images/arrow-right-red.svg">
            </button>
        </div>
    </div>
	<?php } ?>
</div>

<!-- Sim Net -->
<?php if($this->image_la1 != ''){ ?>
<div class="video-section">
	<a href="<?=$this->url_la1?>" target="_blank">
    <img src="<?=$config['website']?>/img_section/<?=$this->image_la1?>" class="video-image" alt="<?=$this->title_la1?>">
	</a>   
</div>
<?php } ?>
<!--
<div class="bg-sim-net">
    <h2 class="sim-net-title">Sim Net</h2>
    <p class="sim-net-body">Internet.. No Sim net/HSPA (Mobile Broadband Technology) freedom<br>for your connection..
        There will be no word " limit "</p>
    <a href="#nogo" class="btn-view-more sim-net-btn-view-more">
        View More
        <img src="images/arrow-right-white.svg" class="sim-net-arrow-right-white">
        <img src="images/arrow-right-red.svg" class="sim-net-arrow-right-red">
    </a>
</div>
-->


<!-- Internet Fiber -->
<?php if($this->serviceListCount2 > 0){ ?>
<div class="live-package-service internet-fiber">
    <div class="container">
        <div class="package-service">
            <h2 class="section-heading">Internet Fiber</h2>

            <div class="package-service-owl-carousel internet-fiber-box">
				<?php $i=0; ?>
				<?php foreach($this->serviceList2 as $val){ ?>
				<?php $i++; ?>
                <!-- Item <?=$i?> -->	
                <div class="package-service-item internet-fiber-item">
                    <div class="package-service-item-image-box">
                        <img src="<?=$config['website']?>/img_service/<?=$val['image_la']?>" class="internet-fiber-image">
                    </div>
                    <!-- Body -->
                    <p class="package-service-item-body">
                        <?=$val['subject_la']?>
                    </p>
                    <a href="<?=$val['url_la']?>" class="btn-view-more">
                        View All
                        <img src="images/arrow-right-red.svg" alt="">
                    </a>
                </div>
				<?php } ?>
                
            </div>
        </div>
    </div>
</div>
<?php } ?>

<!-- Happy Call -->
<?php if($this->image_la2 != ''){ ?>
<div class="video-section">
	<a href="<?=$this->url_la2?>" target="_blank">
    <img src="<?=$config['website']?>/img_section/<?=$this->image_la2?>" class="video-image" alt="<?=$this->title_la2?>">
	</a>   
</div>
<?php } ?>
<!--
<div class="bg-sim-net bg-happy-call">
    <div class="container">
        <div class="happy-call-container">
            <div class="happy-call-body">
                <h2 class="sim-net-title">Happy Call</h2>
                <p class="sim-net-body">
                    It is a special service that allows you to make calls even<br>
                    if your number has run out of call charges.
                </p>
                <a href="#nogo" class="btn-view-more sim-net-btn-view-more">
                    View More
                    <img src="images/arrow-right-white.svg" class="sim-net-arrow-right-white">
                    <img src="images/arrow-right-red.svg" class="sim-net-arrow-right-red">
                </a>
            </div>
        </div>
    </div>
</div>
-->

<!-- Privilege -->
<?php if($this->serviceListCount3 > 0){ ?>
<div class="live-package-service bg-privilege">
    <div class="container">
        <div class="package-service">
            <h2 class="section-heading">Privilege</h2>

            <div class="package-service-owl-carousel internet-fiber-box">
				<?php $i=0; ?>
				<?php foreach($this->serviceList3 as $val){ ?>
				<?php $i++; ?>
                <!-- Item <?=$i?> -->	
                <div class="package-service-item internet-fiber-item">
                    <div class="package-service-item-image-box">
                        <img src="<?=$config['website']?>/img_service/<?=$val['image_la']?>" class="internet-fiber-image">
                    </div>
                    <!-- Body -->
                    <p class="package-service-item-body">
                       <?=$val['subject_la']?>
                    </p>
                    <a href="<?=$val['url_la']?>" class="btn-view-more">
                        View All
                        <img src="images/arrow-right-red.svg" alt="">
                    </a>
                </div>
				<?php } ?>
            
            </div>
        </div>
    </div>
</div>
<?php } ?>


<!-- Video -->
<?php if($this->vdo_image != ''){ ?>
<div class="video-section">
	
    <img src="<?=$config['website']?>/img_vdo/<?=$this->vdo_image?>" class="video-image">

    <div class="video-overlay"></div>

    <a class="btn-play-video" onclick="openVideo()">
        <img src="images/polygon.svg" alt="">
    </a>
</div>


<!-- Video Popup -->
<div class="video-popup">
    <div class="video-inner">
        <button onclick="closeVideo()">
            Close
        </button>
        <iframe width="100%" height="500" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="video_iframe"></iframe>
    </div>
</div>
<?php } ?>


<!-- News -->
<div class="bg-news bg-privilege">
    <div class="container">
        <div class="package-service">
           <h2 class="section-heading">News & Event</h2>

            <div class="package-service-owl-carousel internet-fiber-box">
				<?php $i=0; ?>
				<?php foreach($this->newsList as $val){ ?>
				<?php $i++; ?>
                <!-- Item <?=$i?> -->
                <div class="package-service-item internet-fiber-item news-item">
                    <div class="package-service-item-image-box">
                        <img src="<?=$config['website']?>/img_news/<?=$val['image']?>" class="internet-fiber-image">
                    </div>
                    <!-- Body -->
                    <p class="package-service-item-body">
                       <?=$val['title_la']?>
                    </p>
                    <div class="news-footer">
                        <a href="<?=$config['website']?>/la/news-detail.php?id=<?=$val['news_id']?>" class="btn-view-more">
                            Read more
                            <img src="images/arrow-line-red.svg" class="arrow-line-red">
                            <img src="images/arrow-line-white.svg" class="arrow-line-white">
                        </a>
                        <span class="news-date"><?=date('d',strtotime($val['published_date']))?> <?=Lang::getLaoMonth(date('m',strtotime($val['published_date'])))?> <?=date('Y',strtotime($val['published_date']))?></span>
                    </div>
                </div>
				<?php } ?>
               

            </div>
        </div>

        <div class="news-view-all">
            <a href="<?=$config['website']?>/la/news-event.php" class="btn-view-more">
                View All
                <img src="images/arrow-right-red.svg" alt="">
            </a>
        </div>
    </div>
</div>

<!-- Ads -->
<?php if($this->prListCount > 0){ ?>
<div class="ads-banner">

    <button class="pre-btn-package-service-owl pre-btn-ads-owl">
        <img src="images/arrow-left-red.svg" class="arrow-left-red">
        <img src="images/arrow-left-white.svg" class="arrow-left-white">
    </button>

    <div class="owl-theme owl-carousel" id="ads-carousel">
       <?php $i=0; ?>
		<?php foreach($this->prList as $val){ ?>
		<?php $i++; ?>
        <!-- Slide <?=$i?> -->
        <div >
            <img src="<?=$config['website']?>/img_pr/<?=$val['image_la']?>" alt="<?=$val['image_alt_la']?>">
        </div>
		<?php } ?>


    </div>

    <button class="next-btn-package-service-owl next-btn-ads-owl">
        <img src="images/arrow-right-red.svg" class="arrow-right-red">
        <img src="images/arrow-right-white.svg" class="arrow-right-white">
    </button>
</div>
<?php } ?>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function ($) {
        $('#my-slider').sliderPro({
            width: "100%",
            autoHeight: true,
            touchSwipe: false
        });

        const owl = $("#package-service-owl-carousel");
        owl.owlCarousel({
            items: 4,
            dots: false
        });

        // Go to the next item
        $('.next-btn-package-service-owl').click(function () {
            owl.trigger('next.owl.carousel');
        })

        // Go to the previous item
        $('.pre-btn-package-service-owl').click(function () {
            owl.trigger('prev.owl.carousel');
        })

        const adsOwl = $("#ads-carousel");
        adsOwl.owlCarousel({
            items: 1,
            dots: false
        });

        // Go to the next item
        $('.next-btn-ads-owl').click(function () {
            adsOwl.trigger('next.owl.carousel');
        })

        // Go to the previous item
        $('.pre-btn-ads-owl').click(function () {
            adsOwl.trigger('prev.owl.carousel');
        })
    });

    function openVideo() {
        const videoPopup = document.querySelector(".video-popup");
        const videoIframe = document.getElementById("video_iframe");
        if (videoPopup) {
            videoPopup.classList.add("video-popup-active");
            videoIframe.src = "<?=$this->vdo_url?>";
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