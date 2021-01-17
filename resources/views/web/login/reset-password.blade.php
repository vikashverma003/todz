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
                        @if (\Session::has('error'))
                          <div class="text-danger">
                                <p class="text-danger">{!! \Session::get('error') !!}</p>
                          </div>
                        @endif

                        @if (\Session::has('success'))
                          <div class="text-success">
                                <p class="text-success">{!! \Session::get('success') !!}</p>
                          </div>
                        @endif
                        <form class="login-form mt-4" method="post">
                            @csrf
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="password" name="password" placeholder="{{__('messages.textfield_password')}}" required/>
                            </div>
                            @if($errors->has('password'))
                              <p class="text-danger">{{ $errors->first('password') }}</p>
                            @endif
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="password" name="c_password" placeholder="{{__('messages.textfield_confirm_password')}}" required/>
                            </div>
                            @if($errors->has('c_password'))
                              <p class="text-danger">{{ $errors->first('c_password') }}</p>
                            @endif
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="hidden" name="email_token" value="{{$tkn}}" placeholder="{{__('messages.textfield_confirm_password')}}" required/>
                            </div>
                            @if($errors->has('email_token'))
                              <p class="text-danger">{{ $errors->first('email_token') }}</p>
                            @endif
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