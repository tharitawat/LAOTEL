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
          <a href="#">The opening ceremony of the training titled: "Modern Leadership Creation & Tech Talk: Trends in
            Digital Technologies" by cooperation between Lao Telecom and Digital State Administration Center, Ministry
            of Technology and Communications</a>
        </div>
      </div>

      <h2 class="news-event-title">The opening ceremony of the training titled: "Modern Leadership Creation & Tech
          Talk: Trends in Digital
          Technologies" by cooperation between Lao Telecom and Digital State Administration Center, Ministry of
          Technology and Communications
      </h2>
        
      <div class="news-details-section">
        <div class="news-img-in-section">
          <img src="./images/the-opening-ceremony.svg" alt="">
        </div>

        <button class="news-button-video" onclick='openVideo("https://www.youtube.com/embed/YGMEQJXA8yo")'>
          <div class="button-play-video flex">
            <img src="./images/play-video.svg" alt="">
          </div>
          <span>Video</span>
        </button>
      </div>

      <div class="news-details-section">
        <div class="news-detail-text">Lao Telecommunications and the Digital State Administration Center of the Ministry of Technology and
          Communications organized a training session for key employees to participate in skills training on the topic:
          "Modern Leadership Creation & Tech Talk: Trends in Digital Technologies" between August 22-24, 2022 for 3 days
          under the co-chairing of Mr. Aloonnadet Banjit, Deputy Director General of Organization-Administration of Lao
          Telecommunications Public Company and Mrs. Chittaphon Chansilirat Deputy Director General of Digital
          Government Center, MTC along with the board of directors and seminarians from the Ministry of Technology and
          Communications and Laos Telecom in total 47 people.</div>
        <div class="news-img-in-section">
          <img src="./images/news-img-section1.svg" alt="">
        </div>
      </div>

      <div class="news-details-section">
        <div class="news-detail-text">Lao Telecommunications and the Digital State Administration Center of the Ministry of Technology and
          Communications organized a training session for key employees to participate in skills training on the topic:
          "Modern Leadership Creation & Tech Talk: Trends in Digital Technologies" between August 22-24, 2022 for 3 days
          under the co-chairing of Mr. Aloonnadet Banjit, Deputy Director General of Organization-Administration of Lao
          Telecommunications Public Company and Mrs. Chittaphon Chansilirat Deputy Director General of Digital
          Government Center, MTC along with the board of directors and seminarians from the Ministry of Technology and
          Communications and Laos Telecom in total 47 people.</div>
        <div class="news-img-in-section">
          <img src="./images/news-img-section2.svg" alt="">
        </div>
      </div>

      <div class="news-details-section">
        <div class="news-detail-text">Lao Telecommunications and the Digital State Administration Center of the Ministry of Technology and
          Communications organized a training session for key employees to participate in skills training on the topic:
          "Modern Leadership Creation & Tech Talk: Trends in Digital Technologies" between August 22-24, 2022 for 3 days
          under the co-chairing of Mr. Aloonnadet Banjit, Deputy Director General of Organization-Administration of Lao
          Telecommunications Public Company and Mrs. Chittaphon Chansilirat Deputy Director General of Digital
          Government Center, MTC along with the board of directors and seminarians from the Ministry of Technology and
          Communications and Laos Telecom in total 47 people.
        </div>
      </div>

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
        <iframe width="100%" height="500" src="" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen id="video_iframe"></iframe>
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