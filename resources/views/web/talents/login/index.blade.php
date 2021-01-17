@extends('web.layouts.app')
@section('title', __('messages.header_titles.LOGIN'))

@section('content')

<!-- Login block -->
<section class="login-section header-mt">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <h3>Welcome Back,<br> Please Login to your Account</h3>
          <div class="row">
            <div class="col-md-6">
              <a href="{{route('li_redirect')}}"><button class="linkedIn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_linkedin.png')}}">Linkedin</button></a>
            </div>
            <div class="col-md-6">
              <a href="{{route('fb_redirect')}}"><button class="facebook-btn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_facebook.png')}}">Facebook</button></a>
            </div>
            <div class="col-md-12 text-center line-block"><hr><span>Or</span></div>
            <div class="col-md-12">
              @if (\Session::has('error'))
          <div class="text-danger">
              <ul>
                  <li>{!! \Session::get('error') !!}</li>
              </ul>
          </div>
          @endif
        <form class="login-form mt-4" method="post" action="{{route('login.store')}}" >
                @csrf
                <input type="hidden" name="role" value="{{config('constants.role.TALENT')}}" />
                <div class="form-group mb-4">
                  <input class="form-control custom" type="email" name="email" placeholder="leannon.orion@quinten.net" required>
                  @if($errors->has('email'))
                  <p class="text-danger">{{ $errors->first('email') }}</p>
                @endif
                </div>
                <div class="form-group password mb-3">
                  <input class="form-control custom" id="password" type="password" name="password" placeholder="Password" required>
                  <img class="cursor-pointer" onclick="togglePasssword()" src="{{asset('web/images/ic_show-password.png')}}">
                </div>
                @if($errors->has('password'))
                  <p class="text-danger">{{ $errors->first('password') }}</p>
                @endif
                <div class="remeber_me">
                    <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> <span> Remember me</span> </label>
                </div>
                <a class="dp-inline-block mb-5" href="{{route('client_forgot_password')}}">Forgot Password?</a>
                <button class="theme-button hover-ripple full-width mb-3">Login</button>
                <!-- {{route('signup.index')}} -->
                <p class="text-center">Not a member yet? <a data-toggle="modal" data-target="#signupSelectionModal" href="#"> Sign Up </a></p>
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
<!-- signupSelectionModal -->
<div class="modal fade" id="signupSelectionModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
  <div class="modal-content">

    <div>
      <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal">Todder</a>
      <hr class="mt-0 mb-0">
      <a class="dropdown-item pt-1" data-toggle="modal" data-target="#signupModal">Project Owner</a>
    </div>

  </div>
</div>
</div>
 
  
  

@endsection
@section('footerScript')
@parent
<script>
$(document).ready(function(e){
$("#signupSelectionModal").click(function($e){
$(this).modal('hide');
});
});
</script>


@endsection
