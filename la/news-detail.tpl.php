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

<div class="outer-box">

  <div class="top-bg">
    <img src="./images/bg-line-water-header.png" alt="" />
  </div>

  <div class="container">

    <div class="right-content">
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
        <div class="right-header-menu">
          <a href="news-event.php">News & Events</a>
          <img src="./images/right-header-menu-dot.svg" alt="">
        </div>
        <div class="right-header-menu active-header-right">
          <a href="#"><?=$this->item->title_la?></a>
        </div>
      </div>

      <h2 class="news-event-title"><?=$this->item->title_la?></h2>

      <div class="news-details-section">
        <?php if($this->item->image != ''){ ?> 
        <div class="news-img-in-section">
          <img src="<?=$config['website']?>/img_news/<?=$this->item->image?>" alt="<?=$this->item->image_alt?>">
        </div>
		<?php } ?>
	
        <div class="flex-news-button">
		  <?php if($this->item->youtube != ''){ ?> 
          <button class="news-button-video" onclick='openVideo("<?=$this->item->youtube?>")'>
            <div class="button-play-video flex">
              <img src="./images/play-video.svg" alt="">
            </div>
            <span>Video</span>
          </button>
		  <?php } ?>
		  <?php if($this->galleryListCount > 0){ ?>	
          <a class="fancybox" href="<?=$config['website']?>/img_news/<?=$this->item->image?>" data-fancybox="gallery">
            <button class="news-button-video ">
              <div class="button-play-video flex">
                <img src="./images/Gallery.svg" alt="">
              </div>
              <span>Gallery</span>
            </button>
          </a>
		   <?php } ?>	
        </div>

        <!-- Image Gallery -->
		<?php foreach($this->galleryList as $val){ ?>  
        <a class="fancybox" href="<?=$config['website']?>/img_news/gallery/<?=$val['image']?>" data-fancybox="gallery"></a>
		<?php } ?>  
        
      </div>
	  <div class="news-details-section">
        <div class="news-detail-text"><?=$this->item->subject_la?></div>        
      </div>
		
      <div class="news-details-section">
        <div class="news-detail-text"><?=$this->item->description_la?></div>        
      </div>
	
	  <?php if($this->layerListCount > 0){ ?>
		<?php foreach($this->layerList as $layer){ ?>	
		  <h2 class="news-event-title"><?=$layer['title_la']?></h2>
		
		  <div class="news-details-section">
			<div class="news-detail-text"><?=$layer['description_la']?></div>
			 <?php if($layer['image_la'] != ''){ ?> 
			<div class="news-img-in-section">
			  <img src="<?=$config['website']?>/img_news_layer/<?=$layer['image_la']?>" alt="<?=$layer['image_alt_la']?>">
			</div>
			  <?php } ?> 
			  
			   <?php if($layer['vdo_la'] != ''){ ?> 
			 <div class="news-img-in-section"> 
			  <iframe width="600" height="480" src="<?=$layer['vdo_la']?>" title="<?=$layer['title_la']?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			 </div>	
			   <?php } ?>
		  </div>
		 <?php } ?>
     <?php } ?> 

      <div class="social-footer flex al-item-center">
        <a class="bg-line flex social-footer-button" href="#nogo">
          <img src="./images/line-share.svg" alt="">
          <span>Share</span>
        </a>

        <div class="facebook-button flex al-item-center">
          <a class="bg-facebook flex social-footer-button" href="#nogo">
            <img src="./images/facebook-share.svg" alt="">
            <span>Share</span>
          </a>
          <div class="relative flex">
            <img src="./images/message-alert.svg" alt="">
            <p class="ab-text-in-alert-message">60K</p>
          </div>
        </div>
      </div>

    </div>

  </div>

  <div class="footer-bg">
    <img src="./images/bg-line-water-footer.png" alt="" />
  </div>

</div>

<!-- Video Popup -->
<div class="video-popup">
  <div class="video-inner">
    <button onclick="closeVideo()">
      Close
    </button>
    <iframe width="100%" height="500" src="" title="YouTube video player" frameborder="0"
      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen
      id="video_iframe"></iframe>
  </div>
</div>

<?php include "footer.php" ?>

<script>
  function openVideo(url) {
    const videoPopup = $(".video-popup");
    const videoIframe = $("#video_iframe");
    if (videoPopup) {
      videoPopup.addClass("video-popup-active");
      videoIframe.attr("src", url);
    }
  }

  function closeVideo() {
    const videoPopup = $(".video-popup");
    const videoIframe = $("#video_iframe");
    if (videoPopup) {
      videoPopup.removeClass("video-popup-active");
      videoIframe.attr("src", "");
    }
  }
</script>