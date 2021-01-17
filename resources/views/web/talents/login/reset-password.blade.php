@extends('web.layouts.app')
@section('title', __('messages.header_titles.RESET_PASSWORD'))

@section('content')
<section class="login-section email-verification header-mt">
  <div class="container">
    <div class="row">
      <div class="col-md-5">
        <h3 class="mb-2">{{ __('messages.nav.RESET_PASSWORD')}}</h3>
        <!-- <p>{{ __('messages.text_forgot_password')}}<br></p> -->
        <!-- <strong>leannon.orion@quinten.net</strong></p> -->
        <div class="row">
          <div class="col-md-12">
            <form class="login-form mt-4" method="post">
              @csrf
              <div class="form-group mb-4">
                <input class="form-control custom" type="password" name="password" placeholder="{{__('messages.textfield_password')}}" required/>
              </div>
               <div class="form-group mb-4">
                <input class="form-control custom" type="password" name="c_password" placeholder="{{__('messages.textfield_confirm_password')}}" required/>
              </div>
              <div class="form-group mb-4">
                <input class="form-control custom" type="hidden" name="email_token" value="{{$tkn}}" placeholder="{{__('messages.textfield_confirm_password')}}" required/>
              </div>
              <br>    
              <button class="theme-button hover-ripple full-width  mb-3">{{__('messages.continue_btn')}}</button>
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
@endsection