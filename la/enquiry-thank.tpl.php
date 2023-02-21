<?php
require_once "common.inc.php";
require_once DIR."library/htmlpurifier/HTMLPurifier.auto.php";
//require_once DIR."library/htmlpurifier/HTMLPurifier.standalone.php";
if (class_exists('HTMLPurifier')) $purifier = new HTMLPurifier();

global $db;
global $config;
 
?>
<?php include "header.php" ?>

<div class="outer-box" style="padding: 0">

	<div class="top-bg">
		<img src="./images/bg-line-water-header.png" alt="" />
	</div>

  <div class="container">
    <div class="content">
      <?php include "sidebar-about-us.php" ?>

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
              <a href="#">Enquiry</a>
            </div>
          </div>

          <div class="banner-Mphone">
            <div class="banner-Mphone-title">
              <div class="banner-Mphone-logo" style="padding: 7px">
                <img src="./images/enquiry.png" alt="">
              </div>
              <p>enquiry</p>
            </div>
          </div>

          <div class="flex">
            <div class="enquiry-left">
              <div class="enquiry-info">
                <p>Friendship Bridge Service Center</p>
                <div class="enquiry-any-info flex al-item-center">
                  <div class="enquiry-info-img flex al-item-center">
                    <img src="./images/Contact-us.svg" alt="">
                  </div>
                  <p>Dong Pho Si Village, Praha Phong District, Vientiane City</p>
                </div>

                <a href="tel:21-513067">
                  <div class="enquiry-any-info flex al-item-center">
                    <div class="enquiry-info-img flex al-item-center" style="padding: 10px">
                      <img src="./images/tel-contact-page.svg" alt="">
                    </div>
                    <p>21-513067</p>
                  </div>
                </a>
                
                <a href="mailto:guide@email.com">
                  <div class="enquiry-any-info flex al-item-center">
                    <div class="enquiry-info-img flex al-item-center" style="padding: 9px">
                      <img src="./images/email.svg" alt="">
                    </div>
                    <p>guide@email.com</p>
                  </div>
                </a>

              </div>

              <div class="enquiry-info">
                <p>Social Media</p>

                <a href="http://line.naver.jp/ti/p/@gha6746g" target="_blank">
                  <div class="enquiry-social flex al-item-center">
                    <div class="enquiry-social-img flex ">
                      <img src="./images/line.svg" alt="">
                    </div>
                    <p>@Lao Telecom</p>
                  </div>
                </a>

                <a href="https://vt.tiktok.com/ZSJ6dN3rG" target="_blank">
                  <div class="enquiry-social flex al-item-center">
                    <div class="enquiry-social-img flex ">
                      <img src="./images/tiktok.svg" alt="">
                    </div>
                    <p>Lao Telecom</p>
                  </div>
                </a>

                <a href="https://www.facebook.com/Laotel/" target="_blank">
                  <div class="enquiry-social flex al-item-center">
                    <div class="enquiry-social-img flex ">
                      <img src="./images/facebook.svg" alt="">
                    </div>
                    <p>Lao Telecom</p>
                  </div>
                </a>

                <a href="https://www.instagram.com/laotel/" target="_blank">
                  <div class="enquiry-social flex al-item-center">
                    <div class="enquiry-social-img flex ">
                      <img src="./images/instagram.svg" alt="">
                    </div>
                    <p>Lao Telecom</p>
                  </div>
                </a>

                <a href="https://twitter.com/search?f=tweets&q=%40laotel1&src=typd" target="_blank">
                  <div class="enquiry-social flex al-item-center">
                    <div class="enquiry-social-img flex ">
                      <img src="./images/twitter.svg" alt="">
                    </div>
                    <p>Lao Telecom</p>
                  </div>
                </a>

                <a href="https://www.youtube.com/user/laotelecompr" target="_blank">
                  <div class="enquiry-social flex al-item-center">
                    <div class="enquiry-social-img flex ">
                      <img src="./images/youtube.svg" alt="">
                    </div>
                    <p>Lao Telecom</p>
                  </div>
                </a>
              </div>
            </div>
			
            <div class="enquiry-right">
			<form id="formContact" action="contact-action.php" name="formContact" data-name="Email Form" method="post" class="form" aria-label="Email Form">	
              <div class="enquiry-input pd-enquiry-bt30">
				<input type="text" id="contact_name" name="contact_name" required="required"  placeholder="Name - Surname *">
              </div>
              <div class="flex enquiry-tel-email pd-enquiry-bt30">
				<input type="text" id="contact_tel" name="contact_tel" required="required" placeholder="Tel *">  
				<input type="text" id="contact_mail" name="contact_mail" required="required" placeholder="Email *">
              </div>
              <div class="enquiry-textarea flex">
                <textarea name="contact_message" placeholder="Message *" id="contact_message" cols="30" rows="10" required="required"></textarea>
              </div>

              <div class="enquiry-policy">
                <p>* Please fill out all fields and click submit.</p>
                <div class="enquiry-policy-check flex">
                  <div class="box-checkbox">
                   <input type="checkbox" id="accept_consent" name="accept_consent" value="1">
                  </div>
                  <p>I would like to receive e-mails for additional information and communications from the company.</p>
                </div>

                <div class="enquiry-policy-check flex">
                  <div class="box-checkbox">
                    <input type="checkbox"  id="accept_policy" name="accept_policy" value="1">
                  </div>
                  <p>I agree to the collection, use and disclosure of my personal information from this website.
                    according to the <a href="#">privacy policy</a> </p>
                </div>

              </div>

              <div class="enquiry-submit">
                <div class="news-catagory">
				  <input type="hidden" name="do" id="do" value="insert" />	
                  <a href="javascript:void();" onClick="return contactForm();">
                    <div class="news-any-catagory active-news">
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
			</form>
            </div>
			  
          </div>
      </div>
    </div>
  </div>

	<div class="footer-bg">
		<img src="./images/bg-line-water-footer.png" alt="" />
	</div>
</div>

<?php include "footer.php" ?>
<script type="text/javascript">
	function contactForm() {
		with (document.formContact) {
			//alert("OK");
			
			
			if (document.getElementById('contact_name').value == '') {
				alert(' Please Key input Field Name  :');
				document.getElementById('contact_name').focus();
				return false;
			}
			
			if (document.getElementById('contact_mail').value == '') {
				alert(' Please Key input Field Email  :');
				document.getElementById('contact_mail').focus();
				return false;
			}
			
			if (document.getElementById('contact_tel').value == '') {
				alert(' Please Key input Field Phone  :');
				document.getElementById('contact_tel').focus();
				return false;
			}
			
			
			
			if (document.getElementById('contact_message').value == '') {
				alert(' Please Key input Field Message  :');
				document.getElementById('contact_message').focus();
				return false;
			}
			
			
			
			if ($("#accept_consent").prop("checked") == false) {
					alert('I would like to receive e-mails for additional information and communications from the company');
                    document.getElementById('accept_consent').focus();
                    return false;
            }
			
			if ($("#accept_policy").prop("checked") == false) {
					alert('I agree to the collection, use and disclosure of my personal information from this website. according to the privacy policy');
					document.getElementById('accept_policy').focus();
					return false;
			}
			
			
			if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(formContact.contact_mail.value))
			{
				contactAction('contact-action.php');
			}else{
				
				alert("กรุณาระบุ อีเมล์ให้ตรงรูปแบบ");	
				document.getElementById('contact_mail').focus();
				return false;
			}
			
			
			
     }
}

	function contactAction(url) {
	//	alert("Submit");
	//	alert(url);
		document.getElementById('formContact').action = url;
		document.getElementById('formContact').target = '_self';
		document.getElementById('formContact').submit();
	}
</script>
<script>
  setActiveSideMenu(6)
  setActiveDropdownSideMenu(6, 2)
</script>