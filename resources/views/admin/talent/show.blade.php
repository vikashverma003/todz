@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="profile-data" style="border-radius: 8px;margin:auto;width:95% !important;">
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
        <div class="profile-data mt-5" style="border-radius: 8px;margin:auto;width:95% !important;">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div>
                        <h4 class="card-title">Documents</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>File Name</th>
                                      <!--   <th>File Image</th>-->
                                        <th>Original Name</th>
                                        <th>Type</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $key=1 @endphp
                                    @if(    $talent->talent->resume_file!='' && !is_null($talent->talent->resume_file))
                                            <tr>
                                                <td>{{$key++}}</td>
                                                <td><?php $Aa=explode("/",$talent->talent->resume_file);
                                                echo $Aa[count($Aa)-1];
                                                ?></td>
                                                <td></td>
                                                <td></td>
                                                <td>{{date('d/m/Y', strtotime($talent->talent->created_at))}}</td>
                                                <td>
                                                    <a href="{{$talent->talent->resume_file}}" target="_blank">
                                                        <img src="{{asset('web/images/ic_print.svg')}}" alt="Print">
                                                    </a>
                                                </td>
                                            </tr>
                                    @endif
                                    @if(    $talent->talent->workSample_file!='' && !is_null($talent->talent->workSample_file))
                                    <tr>
                                        <td>{{$key++}}</td>
                                        <td><?php $Aa=explode("/",$talent->talent->workSample_file);
                                        echo $Aa[count($Aa)-1];
                                        ?></td>
                                        <td></td>
                                        <td></td>
                                        <td>{{date('d/m/Y', strtotime($talent->talent->created_at))}}</td>
                                        <td>
                                            <a href="{{$talent->talent->workSample_file}}" target="_blank">
                                                <img src="{{asset('web/images/ic_print.svg')}}" alt="Print">
                                            </a>
                                        </td>
                                    </tr>
                            @endif
                                    @if($documents)
                                        @foreach($documents as $row)
                                       
                                            <tr>
                                                <td>{{$key++}}</td>
                                                <td>{{$row->file_name}}</td>
                                                <!-- <td><img src="{{asset($row->file_name)}}"></td> -->
                                                <td>{{$row->original_name}}</td>
                                                <td>{{$row->type}}</td>
                                                <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                                                <td> 
                                                    
                                                    <a href="{{asset(env('FILE_UPLOAD_PATH')).'/'.$row->file_name}}" target="_blank">
                                                        <img src="{{asset('web/images/ic_print.svg')}}" alt="Print">
                                                    </a>
                                                    
                                                </td> 
                                               <!-- <td>
                                                <a  href="{{url('admin/talents/edit_docx')}}/{{$row->user_id}}" data-toggle="tooltip" title="Edit">
                                                    <i class=" icon-pencil menu-icon"></i>
                                                    <span class="menu-title"></span>
                                                </a></td> -->
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="5">No Documents Uploaded.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="profile-data mt-5" style="border-radius: 8px;margin:auto;width:95% !important;">
            <div class="col-md-12 stretch-card">
                <div class="card">
                    <div>
                        <h4 class="card-title">Projects</h4>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Title</th>
                                        <th>Creation Date</th>
                                        <th>Cost</th>
                                        <th>Duration</th>
                                        <th>Owner ID</th>
                                        <th>Owner Name</th>
                                        <th>Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($projects)>0)
                                        @foreach($projects as $k=>$row)
                                            <tr>
                                                <td>{{++$k}}</td>
                                                <td>
                                                    <a href="{{url('admin/projects/'.$row->id)}}" target="_blank">
                                                        {{$row->title ?? 'N/A'}}
                                                    </a>
                                                </td>
                                                <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                                                <td>{{$row->cost ?? 0}}</td>
                                                <td>
                                                    @if($row->duration_month > 0)
                                                        {{$row->duration_month}} month
                                                    @endif

                                                    @if($row->duration_day > 0)
                                                        {{$row->duration_day}} days
                                                    @endif
                                                </td>
                                                <td>{{@$row->client->todz_id ?? "N/A"}}</td>
                                                <td>{{@$row->client->first_name}} {{@$row->client->last_name}}</td>
                                                <td>
                                                    @if(@$row->status=='completed')
                                                        <span >Completed</span>
                                                    @elseif(@$row->status=='dispute')
                                                        <span >{{@$row->status}}</span>
                                                    @elseif(@$row->status=='hired')
                                                        <span>In-Progress</span>
                                                    @else
                                                        <span>{{@$row->status}}</span>
                                                    @endif
                                                </td>
                                                
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="5" class="text-center">No Data Available.</td></tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </div>
</div>
@endsection