@extends('web.layouts.app')
@section('title', __('messages.header_titles.SIGNUP'))

@section('content')



<section class="login-section header-mt">
    <div class="container" style="text-align: center;">
        <img src="{{asset('images/signup_freelancer.png')}}" alt="" style="padding-bottom: 40px;">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="row wizzard-form">
                    <div class="col-md-4 text-center">
                        <p class="active">Personal Details</p>
                        <span class="dot-wizzard active"></span>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="active">Verification</p>
                        <span class="dot-wizzard active"></span>
                    </div>
                    <div class="col-md-4 text-center">
                        <p>Work Details</p>
                        <span class="dot-wizzard"></span>
                    </div>
                    <div class="col-md-12">
                        <div class="form-wizard">
                            <div class="line-colored second"></div>
                        </div>
                    </div>
                </div>

                <div class="row wizard-data">
                    <div class="col-md-8 offset-md-2">
                        <h4 class="mt-4 mb-3">Verify your email id</h4>

                        <h5>Enter the 6 digit OTP code sent to your email id
                        <strong>{{$currentUser->email}}</strong> </h5>
                        <form class="email_verify" >
                            <div class="form-group mb-4">
                                <input class="form-control custom" type="text" name="code" placeholder="Enter Code Here">
                               
                            </div>
                            {{-- <p><b>OTP: {{$otp}}</p> --}}
                                @if(Session::has('error'))
                                <div class="text-danger">{{Session::get('error')}}</div>
                                @endif
                            <h6>Didn’t receive the code? <a href="#" class="resend-otp">Re-send</a></h6>
                            <div class="form-group">
                                <button class="theme-button next-btn active hover-ripple mb-4 text-upper mr-3"
                                    style="width: 100%;">VERIFY AND CONTINUE</button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</section>



  @endsection
   @section('footerScript')
   @parent
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <script>
     
     $(document).ready(function(){
        $(document).on("submit",".email_verify",function($e){
        $e.preventDefault();
           var code = $("input[name='code']").val();
              $.ajax({
               type:'POST',
               url:'{{route("talentValidateOtp")}}',
               data:{ "_token": "{{ csrf_token() }}",
   
                'code':code
                },
               success:function(response){
                var res= JSON.parse(response);
               if(res.status==1){
                window.location.href="{{route('signup_work')}}";
               }else{
                 swal("Oops!", res.Message, "error");
               }
               }
           });
        });
     });
     </script>
   <!--  <script>
    $(document).ready(function(){
    $(document).on('click','.resend-otp',function(e){
        e.preventDefault();
        swal({
           title: "Sure",
           text: "Do you want to Resend the Otp?",
           icon: "warning",
           buttons: true,
           dangerMode: false,
       })
       .then((willconfirm) => {
            if (willconfirm) {
                $.ajax({
                    type:'POST',
                    url:'{{route("emailVarificationResend")}}',
                    data:{
                      "_token": "{{ csrf_token() }}",
                      'status': 1
                    },
                    success:function(response){
                      console.log(response);
                        if(response.status==1){
                            swal({title: "OTP", text: response.message, type: "success"}).then(function(){ 
                                //location.reload();
                            });
                        }else{
                          console.log(22);
                          swal("Oops!", response.message, "error");
                        }
                    },
                    error:function(){
                      console.log(33);
                        stopLoader('body');
                    }
                });
            }
        });
    });

 });
     </script>-->
     
@endsection