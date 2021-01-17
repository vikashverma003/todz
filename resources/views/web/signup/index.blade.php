@extends('web.layouts.app')
@section('title', __('messages.header_titles.SIGNUP'))
@section('content')
<!-- Login block -->
<section class="login-section header-mt">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h3>Join us, and find the best freelance services for your {{ucwords($entity)}} {{($entity=='individual') ? 'projects' : 'entity'}}</h3>
                <div class="row">
                    <div class="col-md-6">
                        <a href="{{route('li_redirect')}}"><button class="linkedIn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_linkedin.png')}}">Linkedin</button></a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('fb_redirect')}}"><button class="facebook-btn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_facebook.png')}}">Facebook</button></a>
                    </div>
                    <div class="col-md-12 text-center line-block">
                        <hr>
                        <span>or</span>
                    </div>

                    <div class="col-md-12">
                        <form class="login-form mt-4" action="{{url('signup')}}" method="post" id="signupFirstStepClient">
                            @csrf
                            <input type="hidden" name="entity" value="{{$entity}}">
                            <input type="hidden" name="phone_code" id="phone_code" class="form-control custom" placeholder="phone code" value="{{old('phone_code')}}" autocomplete="off">
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="name" placeholder="{{__('messages.textfield_name')}}"  value="{{old('name')}}" autocomplete="off" >
                                @if($errors->has('name'))
                                <p class="text-danger">{{ $errors->first('name') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="email" name="email" placeholder="{{__('messages.textfield_email')}}" value="{{old('email')}}" autocomplete="off">
                                @if($errors->has('email'))
                                <p class="text-danger">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                            @if($entity=='corporate' || $entity=='private')
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="company_name" placeholder="{{__('messages.textfield_companyName')}}"  value="{{old('company_name')}}" autocomplete="off" >
                                @if($errors->has('company_name'))
                                <p class="text-danger">{{ $errors->first('company_name') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="description" placeholder="{{__('messages.textfield_description')}}"  value="{{old('description')}}" autocomplete="off" >
                                @if($errors->has('description'))
                                <p class="text-danger">{{ $errors->first('description') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="no_of_employees" placeholder="{{__('messages.textfield_TotalEmp')}}"  value="{{old('no_of_employees')}}" autocomplete="off" >
                                @if($errors->has('no_of_employees'))
                                <p class="text-danger">{{ $errors->first('no_of_employees') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="location" placeholder="Location"  value="{{old('location')}}" autocomplete="off" >
                                @if($errors->has('location'))
                                <p class="text-danger">{{ $errors->first('location') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="company_address" placeholder="Company Address"  value="{{old('company_address')}}" autocomplete="off" >
                                @if($errors->has('company_address'))
                                <p class="text-danger">{{ $errors->first('company_address') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="registration_number" placeholder="Registration Number"  value="{{old('registration_number')}}" autocomplete="off" >
                                @if($errors->has('registration_number'))
                                <p class="text-danger">{{ $errors->first('registration_number') }}</p>
                                @endif
                            </div>
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="vat_details" placeholder="VAT Details"  value="{{old('vat_details')}}" autocomplete="off" >
                                @if($errors->has('vat_details'))
                                <p class="text-danger">{{ $errors->first('vat_details') }}</p>
                                @endif
                            </div>
                            @endif
                            <div class="input-group">
                                <input type="tel" name="phone_number" class="form-control custom" placeholder="{{__('messages.textfield_phone')}}" value="{{old('phone_number')}}">
                                @if($errors->has('phone_number'))
                                <p class="text-danger">{{ $errors->first('phone_number') }}</p>
                                @endif
                            </div>
                            <br />
                            <div class="form-group mb-4">
                                <select name="country" class="form-control custom" required="true">
                                    <option value="">Country</option>
                                    @foreach(@$countries as $row)
                                        <option value="{{$row->country_name}}">{{$row->country_name}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('country'))
                                <p class="text-danger">{{ $errors->first('country') }}</p>
                                @endif
                            </div>

                            <div class="form-group password mb-3">
                                <input class="form-control custom" type="password" name="password"  id="password" placeholder="{{__('messages.textfield_password')}}" autocomplete="off">
                                <img class="cursor-pointer" onclick="togglePasssword()" src="{{asset('web/images/ic_show-password.png')}}">
                                @if($errors->has('password'))
                                <p class="text-danger">{{ $errors->first('password') }}</p>
                                @endif
                            </div>
                            <div class="form-group password mb-3">
                                <input class="form-control custom" type="text" name="coupon"  id="coupon" placeholder="Coupon Code" autocomplete="off">
                                @if($errors->has('coupon'))
                                <p class="text-danger">{{ $errors->first('coupon') }}</p>
                                @endif
                            </div>
                            <p class="terms-policy"> 
                                <div class="o-checkbox">
                                    <input type="checkbox" value="1" name="terms_checkbox" id="my-checkbox" class="">
                                    <label for="my-checkbox"></label>
                                </div>
                                By signing up, you accept the <a href="{{url('client-terms-service')}}" target="_blank"> Terms of use </a> & <a href="{{url('privacy-policy')}}" target="_blank"> Privacy Policy</a>
                            </p>
                            @if($errors->has('terms_checkbox'))
                            <p class="text-danger">{{ $errors->first('terms_checkbox') }}</p>
                            @endif
                            <button type="button" onclick="checkCoupon()" class="theme-button hover-ripple full-width mt-4 mb-3">{{__('messages.signup_btn')}}</button>
                            <p class="text-center" style="font-size: 14px;">Already a member? <a href="{{route('login.index')}}"> Log In </a></p>
                        </form>
                    </div>
                </div>
            </div>
            <div class="offset-md-2 col-md-5">
                <img class="img-fluid dp-block mx-auto" src="{{asset('web/images/login-bannar.png')}}">
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
<!-- <script src="{{asset('web/js/jquery-migrate-1.2.1.min.js')}}"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.11/js/intlTelInput-jquery.min.js"></script>
<script type="text/javascript">
    
    function checkCoupon(){
        var code = $('#coupon').val();
        if(code != ''){
            $.ajax({
                url:"{{route('check_applied_coupon_client')}}?code="+code,
                success:function(response)
                {
                    console.log(response);
                    if(response.success == 1)
                    {
                        $('#signupFirstStepClient').submit();
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
          $('#signupFirstStepClient').submit();
        }
    }

    $('input[type="tel"]').intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
    $("form").submit(function() {
        $("#phone_code").val($('input[type="tel"]').intlTelInput("getSelectedCountryData").dialCode);
    });
</script>
@endsection