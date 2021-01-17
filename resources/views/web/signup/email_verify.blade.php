@extends('web.layouts.app')
@section('title', __('messages.header_titles.SIGNUP'))

@section('content')

<!-- Login block -->
<section class="login-section email-verification header-mt">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <h3 class="mb-2">Email Verification</h3>
          <p>Enter the 6 digit OTP code sent to your email id <br>
          <strong>{{$currentUser->email}}</strong></p>
          <div class="row">
            <div class="col-md-12">
            <form class="login-form mt-4 email_verify" method="post" action="{{route('email_varification')}}">
                @csrf
                <div class="form-group mb-4">
                <input class="form-control custom" type="text" name="code" placeholder="{{__('messages.textfield_verify_code')}}" autocomplete="off" required>
                {{-- <p><b>OTP: {{$otp}}</b></p> --}}
                  @if(Session::has('error'))
                  <div class="text-danger">{{Session::get('error')}}</div>
                  @endif
                </div>    
                 <p class="text-center mt-4 simple-text">Didn’t receive the code? <a href="{{route('email_varification')}}"> Re-send </a></p>         
                <button class="theme-button hover-ripple full-width  mb-3">{{__('messages.verify_continue_btn')}}</button>
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
 
    <!-- Congras modal -->
    <div class="modal fade" id="congrasModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
    aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <img src="{{asset('web/images/id_created.png')}}" alt="">
          <h4>tod-Z id: <span class="todz_id"></span></h4>
          <p class="tod_z_message"></p>
          <a href="{{route('client_dashboard')}}" ><button class="hover-ripple text-upper">continue</button></a>
        </div>
      </div>
    </div>
  </div>

</div>
  @endsection
@section('footerScript')
@parent
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<script>
  
  $(document).ready(function(){
	 $(document).on("submit",".email_verify",function($e){
    
     $e.preventDefault();
		var code = $("input[name='code']").val();
		   $.ajax({
            type:'POST',
            url:'{{route("validateOtp")}}',
            data:{ "_token": "{{ csrf_token() }}",

             'code':code
             },
            success:function(response){
             var res= JSON.parse(response);
            if(res.status==1){
              $(".todz_id").text(res.todz_id);
              $(".tod_z_message").text(res.Message);
              $('#congrasModal').modal('show');
            }else{
              swal("Oops!", res.Message, "error");
            }
            }
        });
	 });
  });
  </script>
@endsection