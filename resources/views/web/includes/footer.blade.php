  
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
    </div>
  </div>
</div>

<section class="sectionFooter ">
    <div class="container">
        <div class="row">
            <div class="col-md-5 col  footer-list">
                <a href="/" target="_blank">
                  <img src="{{asset('web/images/logo_footer.png')}}" alt="logo">
                </a>
                <h3 class="pt-1" style="color: rgb(255, 213, 0);">
                    <strong>BETA</strong>
                </h3>
            </div>

            <div class="col-md-2 col footer-list">
                <h4>Company</h4>
                
                <p><a href="{{url('payment-safety')}}">Payment Safety</a></p>
                <p><a href="{{url('adb')}}">ADB</a></p>
                <p><a href="{{url('faq')}}">FAQ</a></p>
            </div>

            <div class="col-md-2 col footer-list">
                <h4>Terms</h4>
                <p><a href="{{url('about-us')}}">About us</a></p>
                <p><a href="{{url('contact-us')}}">Contact us</a></p>
                <p><a href="{{url('client-terms-service')}}">Project Owner terms & conditions</a></p>
                <p><a href="{{url('todder-terms-service')}}">Todder terms & conditions</a></p>
                <p><a href="{{url('privacy-policy')}}">Privacy Policy</a></p>
            </div>

            <div class="col-md-3 col-6 col footer-list">
                <h4>Connect with us</h4>
                <ul class="soial-links">
                  <!-- <li>
                    <a href="#">
                      <img src="{{asset('web/images/instagram.png')}}" alt="">
                    </a>
                  </li> -->
                  {{-- <li>
                    <a href="#">
                      <img src="{{asset('web/images/twitter_active.png')}}" alt="">
                    </a>
                  </li> --}}
                  {{-- <li>
                    <a href="#">
                      <img src="{{asset('web/images/youtube.png')}}" alt="">
                    </a>
                  </li> --}}
                  	<li>
                    	<a href="https://www.facebook.com/TalentOnDemandZ" target="_blank">
                      		<img src="{{asset('web/images/facebook_active.png')}}" alt="fb">
                    	</a>
                  	</li>
                  	<li>
                    	<a href="https://www.linkedin.com/company/tod-z" target="_blank">
                      		<i class="fa fa-linkedin-square" style="font-size: x-large;padding-top: 4px;"></i>
                    	</a>
                  	</li>
                </ul>
                {{-- <span>Partners in success</span><img src="{{asset('web/images/aws_logo.png')}}" alt=""> --}}
                <!-- <h3 class="pb-0">Powered By</h3> -->
                <!-- <img src="{{asset('web/images/mangopay.png')}}" alt="mangopay"> -->
                <!-- <img src="{{asset('web/images/payline.png')}}" alt="payline"> -->
                
            </div>
        </div>
    </div>
    <h5>tod-Z.com is owned by todZ OÜ , A company registered in Estonia Under EU Regulations</h5>
    <h6>Ⓒ {{date('Y')}} tod-Z.com. All Rights Reserved</h6>
</section>
<div class="cookiealert cookieDiv" role="alert">
    <div class="row">
        <div class="col-lg-9 col-md-9">
            <p>By continuing to use this site you agree to our <a href="{{url('privacy-policy')}}" target="_blank">Cookie Policy</a></p>
        </div>
        <div class="col-lg-3 col-md-3">
            <button type="button" class="gotitBtn acceptcookies">Got it</button>
        </div>
    </div>
</div>
