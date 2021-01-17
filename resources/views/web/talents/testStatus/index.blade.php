@extends('web.layouts.app')
@section('title', __('messages.header_titles.SIGNUP'))

@section('content')
<section class="testSection">
        <div class="container">
            <div class="row">
                <div class="col-md-10 offset-md-1">
                    <h2>Hey There, Welcome Back!</h2>
                   <input type="hidden" name="hours_status" id="hours_status" value="{{$currentUser->talent->hours_approve}}">
                    @if($currentUser->talent->is_interview==config('constants.test_status.APPROVED'))
                    <img src="{{asset('web/images/ic_image2.png')}}" class="testImg">
                    <p> {{ sprintf(__('messages.online_test_message.FINAL_MESSAGE'),'All')}}
                    </p>
                   @elseif($currentUser->talent->is_interview==config('constants.test_status.DECLINED'))
                   <img src="{{asset('web/images/ic_image1.png')}}" class="testImg">
                   <p>{{ sprintf(__('messages.online_test_message.FAIL'),'Interview')}}
                </p> 
                @elseif($currentUser->talent->is_technical_test==config('constants.test_status.APPROVED'))
                    <img src="{{asset('web/images/ic_image2.png')}}" class="testImg">
                    <p> {{ sprintf(__('messages.online_test_message.APPROVED'),'Techincal','Interview')}}
                    </p>
                   @elseif($currentUser->talent->is_technical_test==config('constants.test_status.DECLINED'))
                   <img src="{{asset('web/images/ic_image1.png')}}" class="testImg">
                   <p>{{ sprintf(__('messages.online_test_message.FAIL'),'Techincal')}}
                </p> 
                @elseif($currentUser->talent->is_aptitude_test==config('constants.test_status.APPROVED'))
                <img src="{{asset('web/images/ic_image2.png')}}" class="testImg">
                <p> {{ sprintf(__('messages.online_test_message.APPROVED'),'Aptitude','Techincal')}}
                </p>
               @elseif($currentUser->talent->is_aptitude_test==config('constants.test_status.DECLINED'))
               <img src="{{asset('web/images/ic_image1.png')}}" class="testImg">
               <p>{{ sprintf(__('messages.online_test_message.FAIL'),'Aptitude')}}
                @elseif($currentUser->talent->is_profile_screened==config('constants.test_status.APPROVED'))
                <img src="{{asset('web/images/ic_image2.png')}}" class="testImg">
                <p> {{ sprintf(__('messages.online_test_message.APPROVED'),'first','Aptitude')}}
                </p>
               @elseif($currentUser->talent->is_profile_screened==config('constants.test_status.DECLINED'))
               <img src="{{asset('web/images/ic_image1.png')}}" class="testImg">
               <p>{{ sprintf(__('messages.online_test_message.FAIL'),'first')}}
            </p> 
            @else 
            <img src="{{asset('web/images/ic_image2.png')}}" class="testImg">
            <p> {{ __('messages.online_test_message.PENDING')}}
            </p>
                @endif
                    <ul class="testList">
                        <li class="{{($currentUser->talent->is_profile_screened!=config('constants.test_status.PENDING'))?'active':''}}">
                            <img src="{{asset('web/images/ic_profile_screening.png')}}" alt="">
                            <i>  @if($currentUser->talent->is_profile_screened==config('constants.test_status.APPROVED'))
                                <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                           @elseif($currentUser->talent->is_profile_screened==config('constants.test_status.DECLINED'))
                           <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                           @else 
                           1
                           @endif</i>

                            <h4>Profile Screening</h4>
                            @if($currentUser->talent->is_profile_screened==config('constants.test_status.PENDING'))
                            <h3>Status: <span class="cleared">pending</span></h3>
                            @elseif($currentUser->talent->is_profile_screened==config('constants.test_status.APPROVED'))
                            <h3>Status: <span class="cleared">cleared</span></h3>
                            @else 
                            <h3>Status: <span class="cleared">Fail</span></h3>
                            @endif

                        </li>
                        <li class="{{($currentUser->talent->is_aptitude_test!=config('constants.test_status.PENDING'))?'active':''}}">
                            <img src="{{asset('web/images/ic_aptitudetest.png')}}" alt="">
                            <i>
                                @if($currentUser->talent->is_aptitude_test==config('constants.test_status.APPROVED'))
                                <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                           @elseif($currentUser->talent->is_aptitude_test==config('constants.test_status.DECLINED'))
                           <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                           @else 
                           2
                           @endif
                            </i>
                            <h4>Aptitude Test</h4>
                            @if($currentUser->talent->is_profile_screened==config('constants.test_status.APPROVED'))
                            @if($currentUser->talent->is_aptitude_test==config('constants.test_status.PENDING'))
                            <h3>Status: <span class="cleared">pending</span></h3>
                            @elseif($currentUser->talent->is_aptitude_test==config('constants.test_status.APPROVED'))
                            <h3>Status: <span class="cleared">cleared</span></h3>
                            @else 
                            <h3>Status: <span class="cleared">Fail</span></h3>
                            @endif
                            @endif
                        </li>
                        <li class="{{($currentUser->talent->is_technical_test!=config('constants.test_status.PENDING'))?'active':''}}">
                            <img src="{{asset('web/images/ic_technicaltest.png')}}" alt="">
                            <i>  @if($currentUser->talent->is_technical_test==config('constants.test_status.APPROVED'))
                                <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                           @elseif($currentUser->talent->is_technical_test==config('constants.test_status.DECLINED'))
                           <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                           @else 
                           3
                           @endif</i>
                            <h4>Technical Test</h4>
                            @if($currentUser->talent->is_aptitude_test==config('constants.test_status.APPROVED'))
                            @if($currentUser->talent->is_technical_test==config('constants.test_status.PENDING'))
                            <h3>Status: <span class="cleared">pending</span></h3>
                            @elseif($currentUser->talent->is_technical_test==config('constants.test_status.APPROVED'))
                            <h3>Status: <span class="cleared">cleared</span></h3>
                            @else 
                            <h3>Status: <span class="cleared">Fail</span></h3>
                            @endif
                            @endif
                        </li>
                        <li class="{{($currentUser->talent->is_interview!=config('constants.test_status.PENDING'))?'active':''}}">
                            <img src="{{asset('web/images/ic_interview.png')}}" alt="">
                            <i>@if($currentUser->talent->is_interview==config('constants.test_status.APPROVED'))
                                <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                           @elseif($currentUser->talent->is_interview==config('constants.test_status.DECLINED'))
                           <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                           @else 
                           4
                           @endif</i>
                            <h4>Interview</h4>
                            @if($currentUser->talent->is_technical_test==config('constants.test_status.APPROVED'))
                            @if($currentUser->talent->is_interview==config('constants.test_status.PENDING'))
                            <h3>Status: <span class="cleared">pending</span></h3>
                            @elseif($currentUser->talent->is_interview==config('constants.test_status.APPROVED'))
                            <h3>Status: <span class="cleared">cleared</span></h3>
                            @else 
                            <h3>Status: <span class="cleared">Fail</span></h3>
                            @endif
                            @endif
                        </li>
                    </ul>

                </div>
            </div>


        </div>
    </section>
<div class="modal fade" id="hoursSetModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
     <div class="modal-header">
          <h2>Hourly Price</h2>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
    <div class="modal-body">
      <form method="get" action="{{route('talent_hour_approval')}}">
        <p class="tod_z_message">
          Your hourly rate us set to {{config('constants.APP_CURRENCY')}}{{$currentUser->talent->hourly_rate}} please accept if you agree.</p>
        <input type="submit" class='btn btn-success mt-2' name="action" value="Accept" />
        <input type="submit" class="btn btn-danger mt-2" name="action" value="Reject" />
      </form>
    </div>
  </div>
</div>
</div>
  
@endsection 
@section('footerScript')
@parent
<!-- <script src="{{asset('web/js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('web/js/jquery-migrate-1.2.1.min.js')}}"></script> -->

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
$(document).ready(function(){
   var status = $('#hours_status').val();
   if(status == 0)
   {
    $('#hoursSetModal').modal('show');
   }
});
</script>
@if (\Session::has('success') && \Session::get('success')==1)
    <script>
        $(document).ready(function(){
            swal({
               title: "Success",
               text: "Thanks for accepting hourly rate. We will connect with you soon.",
               icon: "success",
               dangerMode: false,
               showCancelButton: false, // There won't be any cancel button
            }).then((willconfirm) => {
                window.location.href = "{{route('talent_dashboard')}}";
            });
        });
    </script>
@endif
@endsection