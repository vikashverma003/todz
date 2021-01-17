@extends('web.layouts.app')
@section('title', __('messages.header_titles.SIGNUP'))

@section('content')


<section class="login-section header-mt">
    <div class="container" style="text-align: center;">
      <img src="{{asset('web/images/signup_freelancer.png')}}" alt="" style="padding-bottom: 40px;">
      <div class="row">
        <div class="offset-md-2 col-md-8">
          <div class="row wizzard-form">
            <div class="col-md-4 text-center">
              <p class="active">Personal Details</p>
              <span class="dot-wizzard active"></span>
            </div>
            <div class="col-md-4 text-center">
              <p>Verification</p>
              <span class="dot-wizzard"></span>
            </div>
            <div class="col-md-4 text-center">
              <p>Work Details</p>
              <span class="dot-wizzard"></span>
            </div>
            <div class="col-md-12">
              <div class="form-wizard">
                <div class="line-colored"></div>
              </div>
            </div>
          </div>

          <div class="row wizard-data">
            <div class="col-md-8 offset-md-2">
              <h4 class="mt-4 mb-3">Enter your personal details below</h4>
              <form class="login-form mt-4"  action="{{url('talent/talent-signup')}}" method="post" id="signupFirstStep">
                @csrf
                <input type="hidden" name="phone_code" id="phone_code" class="form-control custom" placeholder="phone code" value="{{old('phone_code')}}">
                <div class="form-group mb-4">
                <input class="form-control custom" type="text" name="name" value="{{$data['first_name']??old('name')}}" placeholder="Ina Spencer" autocomplete="off">
                  <div class="text-left error_span name_error text-danger"></div>
                </div>
                <div class="form-group mb-4">
                  <input class="form-control custom" type="email" name="email" value="{{$data['email']??old('email')}}" placeholder="leannon.orion@quinten.net" readonly  autocomplete="off">
                  <div class="text-left error_span email_error text-danger"></div>
                  
                </div>
                <div class="form-group mb-4">
                    <input type="tel" name="phone_number" class="form-control custom" placeholder="{{__('messages.textfield_phone')}}" value="{{old('phone_number')}}" autocomplete="off">
                    <p class="text-left error_span phone_number_error text-danger"></p>
                    <p class="text-left error_span phone_code_error text-danger"></p>

                </div>

                <div class="form-group mb-4">
                    <select name="country" class="form-control custom" required="true">
                        <option value="">Country</option>
                        @foreach(@$countries as $row)
                            <option value="{{$row->country_name}}">{{$row->country_name}}</option>
                        @endforeach
                    </select>
                    <p class="text-left error_span country_error text-danger"></p>
                </div>

                <div class="form-group password mb-3">
                  <input class="form-control custom" type="password" id="password" name="password" placeholder="Create Password" autocomplete="off">
                  <img class="cursor-pointer" onclick="togglePasssword()" src="{{asset('web/images/ic_show-password.png')}}">
                  <p class="text-left error_span password_error text-danger"></p>
                </div>
                <div class="form-group password mb-3">
                  <input class="form-control custom" type="text" name="coupon"  id="coupon" placeholder="Coupon Code" autocomplete="off">
                
                </div>
                <p class="text-left error_span coupon_code_error text-danger"></p>
                <p class="terms-policy"> 
                  <div class="o-checkbox">
                    <input type="checkbox" value="1" name="terms_checkbox" id="my-checkbox" class="" required>
                    <label for="my-checkbox"></label>
                  </div>
                  By signing up, you accept the <a href="{{url('todder-terms-service')}}" target="_blank"> Terms of use </a> & <a href="{{url('privacy-policy')}}" target="_blank"> Privacy Policy</a>
                </p>
                <p class="text-left error_span terms_checkbox_error text-danger"></p>

                <div class="form-group">
                  <input type="hidden" name="facebook_id" value="{{$data['facebook_id']}}">
                  <input type="hidden" name="linkedin_id" value="{{$data['linkedin_id']}}">
                  <button type="button" class="theme-button next-btn active hover-ripple mb-4 mt-4 text-upper mr-3"
                    style="width: 100%;" onclick="checkCoupon()">CONTINUE</button>
                </div>
              </form>
            </div>
          </div>


        </div>
      </div>
    </div>
  </section>
  <style>
    .iti.iti--allow-dropdown{
        width:100%;
    }
         </style>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.11/css/intlTelInput.css" rel="stylesheet" />
   @endsection
   @section('footerScript')
   @parent
   <script src="{{asset('web/js/jquery-1.11.2.min.js')}}"></script>
    <script src="{{asset('web/js/jquery-migrate-1.2.1.min.js')}}"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.11/js/intlTelInput-jquery.min.js"></script>
   <script type="text/javascript" src="{{asset('web/js/waitme.min.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/loader.js')}}"></script>
   <script>
       $('input[type="tel"]').intlTelInput({
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
        });
        $("form").submit(function() {
            $("#phone_code").val($('input[type="tel"]').intlTelInput("getSelectedCountryData").dialCode);
        });
        
        function checkCoupon()
        {
            var code = $('#coupon').val();
            if(code != '')
            {
                $.ajax({
                    url:"{{route('check_applied_coupon')}}?code="+code,
                    success:function(response)
                    {
                        if(response.success == 1)
                        {
                            $('#signupFirstStep').submit();
                        }
                        else
                        {
                            swal("Oops!", response.message, "error");
                        }
                    }
                });
            }
            else
            {
                $('#signupFirstStep').submit();
            }
        }

        $(document).on('submit','#signupFirstStep',function(e){
            e.preventDefault();
            var formobject=$(this);
            $('#signupFirstStep').find('.error_span').html('');
            $.ajax({
                type:'POST',
                url:'{{url("talent/talent-signup")}}',
                data:formobject.serialize(),
                beforeSend:function(){
                    startLoader('body');
                },
                complete:function(){
                    stopLoader('body');
                },
                success:function(response){
                    if(response.status){
                        swal({title: "Success", text: response.message, type: "success"}).then(function(){ 
                            window.location.href = response.url;
                        });
                    }else{
                        swal({title: "Oops!", text: response.message, type: "error"});
                    }
                },
                error:function(data){
                    stopLoader('body');
                    if(data.responseJSON){
                        var err_response = data.responseJSON;  
                        if(err_response.errors==undefined && err_response.message) {
                            swal({title: "Error!", text: err_response.message, type: "error"});
                        }          
                        $.each(err_response.errors, function(i, obj){
                            $('#signupFirstStep').find('.error_span.'+i+'_error').text(obj).show();
                        });
                    }
                }
            });
        });
   
  </script>
@endsection