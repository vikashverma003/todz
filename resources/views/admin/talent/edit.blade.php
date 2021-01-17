@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
   <div class="row">
      <div class="profile-data" style="border-radius: 8px;margin:auto;width:90% !important;">
         <div class="col-md-12  grid-margin stretch-card">
            <div class="row">
               <div class="col-md-12">
                  <h4>Talent Profile</h4>
                  @if(!is_null($talent->user_image))
                  <div style="position:relative">
                     <img src="{{asset(env('IMAGE_UPLOAD_PATH')).''.$talent->user_image}}" alt="" class="profileImg2" style="width: 114px;border-radius: 50%;height: 114px !important;border: 2px solid #f9d100;
                        padding: 9px;">
                  </div>
                  @else
                  <div class="first_letter">
                     <span>{{strtoupper(substr($talent->first_name,0,1))}}</span>
                  </div>
                  @endif
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Name</h3>
                            <p>{{$talent->first_name}} {{$talent->last_name}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Email Id</h3>
                            <p>{{$talent->email}} <img src="{{asset('web/images/tick.png')}}" alt=""
                           style="all: unset;"></p>
                        </div>

                        <div class="col-md-6">
                            <h3>Registration Date (YYYY-MM-DD H:i:s)</h3>
                            <p>{{$talent->created_at}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Contact Number</h3>
                            <p>+ {{$talent->phone_code}} {{$talent->phone_number}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Tod-Z Id</h3>
                            <p>{{$talent->todz_id}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h3>Job Field</h3>
                            <p>{{$talent->talent->job_field}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h3>Job Title</h3>
                            <p>{{$talent->talent->job_title}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h3>Available Start Date</h3>
                            <p>{{$talent->talent->available_start_date}}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h3>Available End Date</h3>
                            <p>{{$talent->talent->available_end_date}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Work Experience</h3>
                            <p>{{$talent->talent->work_experience}} Years</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Working Type</h3>
                            <p>{{$talent->talent->working_type}} days/week</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Working Hours</h3>
                            <p>{{$talent->talent->hours}} hours/day</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Register Via</h3>
                            <p>{{($talent->facebook_id) ? "Facebook" : ($talent->linkedin_id ? 'Linkedin' : 'Web')}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Facebook Id</h3>
                            <p>{{$talent->facebook_id ?? 'N/A'}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Linkedin Id</h3>
                            <p>{{$talent->linkedin_id?? 'N/A'}}</p>
                        </div>

                        <div class="col-md-6">
                            <h3>Country</h3>
                            <p>{{$talent->country?? 'N/A'}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Expected Hourly Rate</h3>
                            <p>{{$talent->expected_hourly_rate ?? '0'}}</p>
                        </div>

                        <div class="col-md-6">
                            <h3>Current Hourly Rate</h3>
                            <p>{{$talent->talent->hourly_rate ?? '0'}}</p>
                        </div>
                        <div class="col-md-6">
                            <h3>Skills</h3>
                            @php
                            $a = '';
                            foreach($talent->talent->skills as $skill)
                            {
                              $a = $a.$skill->name.', ';
                            }
                            @endphp
                            <p>{{substr($a, 0, -2)}}
                            </p>
                        </div>
                    </div>
               </div>
            </div>
         </div>
      </div>

      <div class="profile-data" style="border-radius: 8px;margin:auto;width:90% !important;">
         <div class="col-md-12  grid-margin stretch-card">
            <div class="row">
               <div class="col-md-12">
                  <div class="row">
                     <div class="col-md-12">
                     <form action="{{route('udpate_hourly_price')}}" method="post">
                        @csrf
                        <h3>Hourly Price</h3>
                        <input type="hidden" name="user_id" value="{{$talent->id}}" />
                     <input type="text" name="hourle_rate" id= "hourle_rate_check" value="{{$talent->talent->hourly_rate}}" />
                        <input type="submit" name="update" style="background: #f9d100;" value="update">
                     </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>

      <div class="profile-data result_Response" style="border-radius: 8px;margin:auto;width:90% !important;display: none;">
         <div class="col-md-12  grid-margin stretch-card">
            <div class="row">
               <div class="col-md-12">
                   <?php
                   echo json_encode($results);
                   ?>
               </div>
            </div>
         </div>
      </div>



      <div class="profile-data mt-5" style="border-radius: 8px;margin:auto;width:90% !important;">
         <div class="col-md-12  grid-margin stretch-card">
            <ul class="testList">
               <li class="active">
                   <img src="{{asset('web/images/ic_profile_screening.png')}}" alt="">
                   <i class="no-line">
                      @if($talent->talent->is_profile_screened==config('constants.test_status.APPROVED'))
                           <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                      @elseif($talent->talent->is_profile_screened==config('constants.test_status.DECLINED'))
                      <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                      @else 
                      1
                      @endif
                   
                     
                     </i>
                   <h4>Profile Screening</h4>
                   {{-- <h3>Status: <span class="cleared">cleared</span></h3> --}}
                   @if($talent->talent->is_profile_screened==config('constants.test_status.PENDING'))
                    <a href="{{route('send_interview_invite',['user_id'=>$talent->id])}}"><button class="btn btn-success mt-1 mb-3">Send Interview Invite</button></a>
                  </br>
                  <a href="{{route('prfile_screen')}}?status=1&user_id={{$talent->id}}" class="btn  btn-sm" style="position:relative"><img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick"></a>&nbsp;
                 
                  <a href="javascript:void(0)" data-url="{{route('prfile_screen')}}" style="position:relative" class="btn btn-sm rejectResion"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a>
                   {{-- <a href="{{route('prfile_screen')}}?status=2&user_id={{$talent->id}}" style="position:relative" class="btn btn-sm"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a> --}}
                     {{-- @else 
                  <h3>Status: <span class="cleared">{{($talent->talent->is_profile_screened==config('constants.test_status.APPROVED'))?'Approved':'Declined'}}</span></h3> --}}

                     @endif

               </li>
               <li class="{{($talent->talent->is_profile_screened==config('constants.test_status.APPROVED'))?'active':''}}">
                   <img src="{{asset('web/images/ic_aptitudetest.png')}}" alt="">
                   <i class="line">
                     @if($talent->talent->is_aptitude_test==config('constants.test_status.APPROVED'))
                     <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                @elseif($talent->talent->is_aptitude_test==config('constants.test_status.DECLINED'))
                <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                @else 
                2
                @endif</i>
                   <h4>Aptitude Test</h4>
                   @if($talent->talent->is_profile_screened==config('constants.test_status.APPROVED'))
                   @if($talent->talent->is_aptitude_test==config('constants.test_status.PENDING'))
           
{{--                  
                   @if($talent->attitudeTest->count()>0)
                   <p> Total Test Sent:&nbsp;&nbsp; <b class="badge badge-success">{{$talent->attitudeTest->count()}}</b></p>
                   @endif
                     @if($talent->talent->is_aptitude_test!=config('constants.test_status.APPROVED'))
                   <form action="{{route('apptitude_test_attachment')}}">
                      <input type="hidden" name="user_id" value="{{$talent->id}}">
                         <select name="aptitude_test_id" class="form-control">
                            <option value="">select Test</option>
                            @foreach(@$tests as $test)
                         <option value={{$test->test_id}}>{{$test->test_name}}</option>
                            @endforeach
                         </select>
                         <button type="submit" class="btn btn-success mt-2">Attach Test</button>
                      </form>
                      @endif --}}
                       <!-- <a href="{{route('send_interview_invite',['user_id'=>$talent->id])}}"><button class="btn btn-success mt-1 mb-3">Send Interview Invite</button></a> -->
                      <br/>
                      <a href="javascript:void(0)" data-status="1" data-userId="{{$talent->_id}}" data-url="{{route('aptitude_action')}}" class="btn  btn-sm apptitudeResult" style="position:relative"><img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick"></a>&nbsp;
                      {{-- <a href="{{route('aptitude_action')}}?status=2&user_id={{$talent->id}}" style="position:relative" class="btn btn-sm"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a> --}}
                      <a href="javascript:void(0)" data-status="2" data-userId="{{$talent->_id}}" data-url="{{route('aptitude_action')}}" style="position:relative" class="btn btn-sm apptitudeResult"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a>
                  
                      {{-- @else 
                   <h3>Status: <span class="cleared">{{($talent->talent->is_profile_screened==config('constants.test_status.APPROVED'))?'Approved':'Declined'}}</span></h3> --}}
 
                      @endif
                      @endif
               </li>
               <li class="{{($talent->talent->is_aptitude_test==config('constants.test_status.APPROVED'))?'active':''}}">
                   <img src="{{asset('web/images/ic_technicaltest.png')}}" alt="">
                   <i class="line">   @if($talent->talent->is_technical_test==config('constants.test_status.APPROVED'))
                     <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                @elseif($talent->talent->is_technical_test==config('constants.test_status.DECLINED'))
                <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                @else 
                3
                @endif</i>
                   <h4>Technical Test</h4>
                   @if($talent->talent->is_aptitude_test==config('constants.test_status.APPROVED'))
                   @if($talent->talent->is_technical_test==config('constants.test_status.PENDING'))
                   @if($talent->attitudeTest->count()>0)
                   <p> Total Test Sent:&nbsp;&nbsp; <b class="badge badge-success">{{$talent->attitudeTest->count()}}</b></p>
                   @endif
                   @if($talent->talent->is_technical_test!=config('constants.test_status.APPROVED'))
                   <form action="{{route('technical_test_attachment')}}">
                      <input type="hidden" name="user_id" value="{{$talent->id}}">
                         <select name="technical_test_id" class="form-control">
                            <option value="">select Test</option>
                            @foreach(@$tests as $test)
                         <option value={{$test->test_id}}>{{$test->test_name}}</option>
                            @endforeach
                         </select>
                         <button type="submit" class="btn btn-success mt-2">Attach Test</button>
                      </form>
                      @endif
                      <br/>
                   <a href="{{route('technical_action')}}?status=1&user_id={{$talent->id}}" class="btn  btn-sm" style="position:relative"><img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick"></a>&nbsp;
                   {{-- <a href="{{route('technical_action')}}?status=2&user_id={{$talent->id}}" style="position:relative" class="btn btn-sm"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a> --}}

                   <a href="javascript:void(0)" data-url="{{route('technical_action')}}" style="position:relative" class="btn btn-sm rejectResion"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a>
                   {{-- @endif --}}

                   @endif
                   @endif
               </li>
               <li class="{{($talent->talent->is_technical_test==config('constants.test_status.APPROVED'))?'active':''}}">
                   <img src="{{asset('web/images/ic_interview.png')}}" alt="">
                   <i class="line">
                     @if($talent->talent->is_interview==config('constants.test_status.APPROVED'))
                     <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick">
                @elseif($talent->talent->is_interview==config('constants.test_status.DECLINED'))
                <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick">
                @else 
                4
                @endif

                   </i>
                   <h4>Interview</h4>
                   @if($talent->talent->is_technical_test==config('constants.test_status.APPROVED'))

                   @if($talent->talent->is_interview==config('constants.test_status.PENDING'))
                   <a href="{{route('send_interview_invite',['user_id'=>$talent->id])}}"><button class="btn btn-success mt-1 mb-3">Send Interview Invite</button></a>
                   <br/>
                   <a data-talentId="{{$talent->id}}" data-hourApprove="{{$talent->talent->hours_approve}}" data-hourlyRate="{{!is_null($talent->talent->hourly_rate)?'1':'0'}}" onclick="checkHourlyRate(this)" class="btn  btn-sm" style="position:relative"><img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick"></a>&nbsp;
                   {{-- <a href="{{route('interview_action')}}?status=2&user_id={{$talent->id}}" style="position:relative" class="btn btn-sm"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a> --}}
                   <a href="javascript:void(0)" data-url="{{route('interview_action')}}" style="position:relative" class="btn btn-sm rejectResion"><img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick"></a>
                   @endif
                   @endif

               </li>
           </ul>
         </div>
      </div>
      @if($results->isNotEmpty() || !is_null($talent->talent->aptitude_result))
      <div class="profile-data mt-5" style="border-radius: 8px;margin:auto;width:90% !important;">
      <div class="col-lg-12 stretch-card">

         <div class="card">
            <div class="card-body">
         
               <h4 class="card-title">Test Result</h4>
               {{-- <a class="nav-link add_button" href="{{url('admin/brands/create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a> --}}
                @if($talent->talent->is_aptitude_test==config('constants.test_status.APPROVED') || $talent->talent->is_aptitude_test==config('constants.test_status.DECLINED'))
                    Aptitude Test Result : {{$talent->talent->aptitude_result}}
                @endif
               @if($results->isNotEmpty())
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>transcript_id</th>
                           <th>Report Url</th>
                           <th>test_id</th>
                           <th>test_name</th>
                           <th>percentage</th>
                           <th>percentile</th>
                           <th>average_score</th>
                           <th>test_result</th>
                           <th>time</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @foreach ($results as $result)
                        <tr>
                           <td>{{$key++}}</td>
                           <td>{{@$result->transcript_id}}</td>
                           <td>@if(!is_null($result->Report_url))
                           <a href="{{$result->Report_url}}" target="_blank" >Download</a>
                           @endif
                        </td>
                           <td>{{@$result->test_id}}</td>
                           <td>{{@$result->test_name}}</td>
                           <td>{{@$result->percentage}}</td>
                           <td>{{@$result->percentile}}</td>
                           <td>{{@$result->average_score}}</td>
                           <td >
                              @if($result->test_result=='PASS')
                              <b class="badge badge-success">{{$result->test_result}}</b>
                              @else
                              <b class="badge badge-danger">{{$result->test_result}}</b>
                              @endif
                           </td>
                           <td>{{@$result->time}}</td>
                        </tr>
                        @endforeach
                  
                     </tbody>
                  </table>
               </div>
               @endif
            </div>
         </div>
      </div>
   </div>
   @endif
   </div>
</div>



  <!-- Modal -->
  <div class="modal fade" id="rejectModel" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
          <h2> Reject Reason</h2>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
       <div class="modal-body">
         <form id="formId" action="{{route('prfile_screen')}}" method="get">
            <input type="hidden" name="status" value="2" required/>
            <input type="hidden" name="user_id" value="{{$talent->id}}" required />
            <textarea class="form-control" name="reject_reason" placeholder="Rejection Reason" required></textarea>
            <input type="submit" class="btn btn-danger mt-2" >
         </form>
       </div>
    
     </div>
   </div>
 </div>

 <!-- Modal -->
  <div class="modal fade" id="aptitudeResultModel" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
          <h2> Apptitude Result</h2>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
       <div class="modal-body">
         <form id="ApptitudeformId" action="{{route('aptitude_action')}}" method="get">
            <input type="hidden" name="status" id="aptitude_status" value="2" required/>
            <input type="hidden" name="user_id" value="{{$talent->id}}" required />
            <textarea class="form-control" name="aptitude_result" placeholder="Aptitude Result" required></textarea>
            <br>
            <button type="submit" class="btn btn-danger mt-2">Submit</button>
           <!-- <input type="submit" class="btn btn-danger mt-2" > -->
         </form>
       </div>
    
     </div>
   </div>
 </div> 


<style>
   .testList {
    display: flex;
    list-style-type: none;
    padding: 0;
    margin: 0;
    width:100%;
}
.testList li {
    width: 25%;
    text-align: center;
}
.testList li.active img, li.inactive img {
    filter: opacity(1);
}
.testList li i {
    background-color: #D1D0D0;
    border-radius: 50%;
    padding: 8px 7px;
    height: 32px;
    width: 32px;
    color: #FFFFFF;
    font-family: Graphik;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0;
    line-height: 16px;
    text-align: center;
    font-style: unset;
    display: block;
    margin: auto;
    position: relative;
    z-index: 9;
}
.testSection h4 {
    opacity: 0.8;
    color: #000000;
    font-family: Graphik;
    font-size: 16px;
    font-weight: 500;
    letter-spacing: 0;
    line-height: 24px;
    text-align: center;
    padding-top: 10px;
}
.testList li h3 {
    font-family: Graphik;
    font-size: 14px;
    font-weight: 400;
    letter-spacing: 0;
    line-height: 24px;
    color: rgba(0, 0, 0, 0.4);
}
.testList .cleared {
    color: #199FAB;
    font-family: Graphik;
    font-size: 14px;
    font-weight: 500;
    letter-spacing: 0;
    line-height: 24px;
    text-transform: uppercase;
}
.testList li img {
    display: block;
    margin: auto;
    margin-bottom: 20px;
    filter: opacity(0.4);
    width: 40px;
    height: 40px;
}
.testList .tick {
    position: absolute;
    top: 0;
    /* right: 0; */
    left: -7px;
    bottom: 0;
    margin: auto;
    width: 44px;
    height: 46px;
}
.testList li i.line::before {
    content: '';
    position: absolute;
    /* width: 225px; */
    width: 198px;
    border-bottom: 1px dashed rgba(0, 0, 0, 0.2);
    top: 15px;
    right: 32px;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
$(document).on('click',".rejectResion",function(){
   var urlr=$(this).data('url');
   $("#formId").attr('action',urlr);
   $('#rejectModel').modal({ show: true });

});
$(document).on('click',".apptitudeResult",function(){
   var urlr=$(this).data('url');
   var status = $(this).data('status');
   $('#aptitude_status').val(status);
   $("#ApptitudeformId").attr('action',urlr);
   $('#aptitudeResultModel').modal({ show: true });

})
function checkHourlyRate(obj)
{
  var status = $(obj).attr('data-hourlyRate');
  var talent_id = $(obj).attr('data-talentId');
  var hourStatus = $(obj).attr('data-hourApprove');
  if(status == '1')
  {
    if(hourStatus == 0)
    {
      alert('Hourly Rate is not approved by Talent');
    }
    else if(hourStatus == 1)
    {
      window.location.href = "{{route('interview_action')}}?status=1&user_id="+talent_id;
    }
    else if(hourStatus == 2)
    {
      alert('Hourly Rate is rejected by Talent');
    }
    else
    {
      return false;
    }
  }
  else{
    alert('Please Add Hourly Rate First');
  }
}
</script>

<script>
var myInput = document.getElementById('hourle_rate_check');
myInput.addEventListener('keypress', function(e) {
  var key = !isNaN(e.charCode) ? e.charCode : e.keyCode;
  function keyAllowed() {
    var keys = [8,9,13,16,17,18,19,20,27,46,48,49,50,
                51,52,53,54,55,56,57,91,92,93];
    if (key && keys.indexOf(key) === -1)
      return false;
    else
      return true;
  }
  if (!keyAllowed())
    e.preventDefault();
}, false);

</script>

@endsection