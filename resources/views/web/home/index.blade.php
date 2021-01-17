@extends('web.layouts.app')
@section('title', __('messages.header_titles.HOME'))

@section('content')
 
@include('web.home.banner')
  <!-- New Section -->
  <!-- <section class="container">
    <div class="row">
      <div class="col-md-8 offset-md-2">
        <div class="videoDiv responsive-video">
          <iframe width="805" height="453" src="https://www.youtube.com/embed/yAoLSRbwxL8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
          <img src="images/" alt="">
        </div>
      </div>
    </div>
  </section> -->
  
  <!-- New Section -->
  <section class="new-how-it-works">
    <div class="container">
      <div class="row">
        <div class="col-md-12 text-center">
          <h4>How it works?</h4>
        </div>

        <ul class="how_works_list">
          <li>
            <img class="img-fluid" src="{{asset('web/images/talent_signup.png')}}">
            <h5>FREE TALENT SIGNUP</h5>
            <p>Primairly , the talent will register on tod-Z platform before proceeding to further steps.</p>
          </li>
          <li>
            <img class="img-fluid" src="{{asset('web/images/assessment_process.png')}}">
            <h5>ASSESSMENT PROCESS</h5>
            <p>Talent will have 4 rounds of asessments, upon clearing all of them, he/she will be available on tod-Z platform.</p>
          </li>
          <li>
            <img class="img-fluid" src="{{asset('web/images/talent_availability.png')}}">
            <h5>TALENT AVAILABILITY</h5>
            <p>Talent who accomplish the asessment will be available on tod-Z paltform after granting him/her their todder ID & every talent has to be careful & honest with providing their availble time during their sign up on when they can work on tod-Z projects, as this will help with his/her selection on projects.</p>
          </li>
          <li>
            <img class="img-fluid" src="{{asset('web/images/business_owner_request.png')}}">
            <h5>FREE PROJECT OWNER SIGN UP</h5>
            <p>Project Owner will sign up on tod-Z and select the criteria where his business falls under , in order to be able to select the talent & Create the project.</p>
          </li>
        </ul>

        <ul class="how_works_list2">
          <li>
            <img class="img-fluid" src="{{asset('web/images/post_a_project.png')}}">
            <h5>CREATING A PROJECT</h5>
            <p>Project owner will be able to create the project which he is looking for a talent to gets it accomlished for his business , the criteria in which he will provide will help alot with talent selection the next step.</p>
          </li>
          <li>
            <img class="img-fluid" src="{{asset('web/images/pitch_talents.png')}}">
            <h5>TALENT PITCH </h5>
            <p>Unlike the traditional pitching process , at tod-Z the project owner has the right to pitch 5 talent & select the 1 whom he feels confident working with & our talent pitching tool will help him on his decision making.</p>
          </li>
          <li>
            <img class="img-fluid" src="{{asset('web/images/safe_payment.png')}}">
            <h5>SECURED PAYMENT</h5>
            <p>our escrow account payment system , will have all parties payments secured, as payments during every project will be released according to the approvals provided from todders & POs on the whole project or per milestone depending on the project duration nature.</p>
          </li>
          <li>
            <img class="img-fluid" src="{{asset('web/images/project_management_tools.png')}}">
            <h5>PROJECT MANAGEMENT TOOL</h5>
            <p>At tod-Z , we are having our built  project managment tool, where todders & POs have to do all their project working materials & communication through , this tool provides Project efficieny control & quality monitoring assurance, communication out of this tool discards the rights of escalations for both parties in case of disputes.</p>
          </li>
        </ul>

      </div>
    </div>
  </section>

  <!-- Job Categories -->
  <section class="job-category">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h4 class="mb-5">Job categories tod-Z supports</h4>
        </div>
        <div class="col-md-12">
          <div class="owl-carousel owl-theme">

          
          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/content_writer.png')}}">
            <p class="text-center">Content Writer</p>
          </div>
          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/ata entry.png')}}">
            <p class="text-center">Data Entry</p>
          </div>

          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Business Development strategist.png')}}">
            <p class="text-center"> Business Development Strategist</p>
          </div>

          
          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/marketing_project_and_product_manager.png')}}">
            <p class="text-center"> Marketing Project &amp; Product Manager</p>
          </div>
         
          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Legal Consultant.png')}}">
            <p class="text-center">Legal Consultant</p>
          </div>

          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Media startegist.png')}}">
            <p class="text-center"> Media Plan Strategist</p>
          </div>

          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Voice Over.png')}}">
            <p class="text-center">Voice Over</p>
          </div>
          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/HR.png')}}">
            <p class="text-center">HR</p>
          </div>

         
          <div class="item job-category-block pt-4 pb-3 pl-2 pr-2">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Graphic Designer.png')}}">
            <p class="text-center">Graphic Designer</p>
          </div>

         
          <div class="item job-category-block pt-4 pb-3 pl-2 pr-2">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/App developer.png')}}">
            <p class="text-center">App Developer</p>
          </div>
       
      
      
        
          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Web developer.png')}}">
            <p class="text-center">Web Developer</p>
          </div>
        
    
          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Web designer.png')}}">
            <p class="text-center">Web Designer</p>
          </div>

          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Operation startegist.png')}}">
            <p class="text-center">Operation Strategist</p>
          </div>

          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Reasearch Consultant.png')}}">
            <p class="text-center">Research Consultant</p>
          </div>

          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/Virtual Asistance.png')}}">
            <p class="text-center">Virtual Assistant</p>
          </div>

          <div class="job-category-block pt-4 pb-3 pl-2 pr-2 item">
            <img class="img-fluid mx-auto dp-block mb-3" src="{{asset('web/images/translator and voice-over.png')}}">
            <p class="text-center">Translator</p>
          </div>
       
    </div>

    </div>
  </div>

      </div>
    </div>
  </section>

  <section class="how_works_section">
    <div class="container">

      <h3>Our partners in success</h3>
      <div class="row">
        <div class="col-md-2 mr-3 ml-3">
          <img src="{{asset('web/images/partner-logo1.png')}}">
        </div>
        <div class="col-md-2 mr-3">
          <img src="{{asset('web/images/partner-logo2.png')}}">
        </div>
        <div class="col-md-2 mr-3">
          <img src="{{asset('web/images/partner-logo3.png')}}">
        </div>
        <div class="col-md-2 mr-3">
          <img src="{{asset('web/images/partner-logo4.png')}}">
        </div>
        <div class="col-md-2 mr-3">
          <img src="{{asset('web/images/partner-logo5.png')}}">
        </div>
       <!--  <div class="col-md-2">
          <img src="{{asset('web/images/ic_logo6.png')}}">
        </div> -->
        <!-- <div class="col-md-4">
          <img src="{{asset('web/images/1.png')}}">
          <h4>Create your profile!</h4>
          <p>Sign up now to create your account on tod-Z, upload your resume and documents and stay closer to work
            happily.</p>
        </div>

        <div class="col-md-4">
          <img src="{{asset('web/images/2.png')}}">
          <h4>Clear tod-Z Asessments!</h4>
          <p>You will need to accomplish one time tod-Z asessments, which includes by skill test , aptitutde test and
            interview!</p>
        </div>

        <div class="col-md-4">
          <img src="{{asset('web/images/3.png')}}">
          <h4>Congratulations</h4>
          <p>We will generate your talent ID which you will be using to communicate with the client to get the projects
            done!</p>
        </div> -->

      </div>

    </div>
  </section>

  


  <link rel="stylesheet" href="{{asset('web/owlcarousel/assets/owl.carousel.min.css')}}">
  <link rel="stylesheet" href="{{asset('web/owlcarousel/assets/owl.theme.default.min.css')}}">
 <style>
   .owl-carousel .owl-item img{
     width:auto;
   }
   .owl-item.cloned {
    margin-left: 1px;
}
img.img-fluid.mx-auto.dp-block.mb-3 {
    height: 49px;
}
.owl-stage-outer {
    padding: 10px 0;
    width: 102% !important;
}
.owl-stage,.owl-stage-outer {
    height: 206px !important;
}
.owl-item.active .job-category-block{
  height:185px !important;
}
button.owl-prev,button.owl-next {
    position: absolute;
    top: 33%;
    width: 50px;
    background: white !important;
    height: 50px;
    box-shadow: 0 0 10px #ccc;
    border-radius: 50% !important;
}
button.owl-prev{
  left: -24px;
}
button.owl-next{
  right: -36px;
}
button.owl-next span,button.owl-prev span{
font-size: 45px;
    line-height: .7;
    color: black !important;
}
.search-box input{
  color:white !important;
}
button.create-btn {
    background: transparent;
}
   </style>
@endsection

@section('footerScript')
@parent
{{-- <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script> --}}
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{asset('web/owlcarousel/owl.carousel.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/jquery.cookie.min.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('click','.redirectToCreateProject', function(){
            @guest
                window.location.href="{{url('/login')}}";
            @endguest
            @auth
                @if(\Auth::user()->role=='client')
                    window.location.href="{{route('client_dashboard')}}";
                @elseif(\Auth::user()->role=='talent')
                    window.location.href="{{route('talent_dashboard')}}";
                @else
                    window.location.href="{{url('admin/dashboard')}}";
                @endif
            @endauth
        });   
        var scroll_pos = 0;
        if($.cookie('first_time_visit')==undefined){
            
            $.ajax({
                type:'POST',
                url:'{{route("save_visit")}}',
                data: {
                    "first_time":true,
                    '_token':"{{ csrf_token() }}"
                },
                
                success:function(response){
                    if(response.status){
                        $.cookie('first_time_visit', 1);
                    }
                },
                error: function(error){
                    // 
                }
            });
        }
      // $(document).scroll(function() { 
      //     scroll_pos = $(this).scrollTop();
      //     if(scroll_pos > 300) {
      //         $(".new-hompage-header").css('background-color', '#212121');
      //     } else {
      //         $(".new-hompage-header").css('background-color', 'tranaparent');
      //     }
      // });
    });
    $(".owl-carousel").owlCarousel({
        loop: true,
        margin: 30,
        nav: true,
        autoplay: true,
        dots: false,
        autoplayHoverPause: true,
        responsive: {
          0: {
            items: 1
          },
          600: {
            items: 3
          },
          1000: {
            items: 6
          }
        }
    });

</script>

@endsection