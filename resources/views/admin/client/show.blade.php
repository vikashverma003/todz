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
                        <h4>Client Profile</h4>
                        @if(!is_null($client->user_image))
                        <div style="position:relative">
                            <img src="{{asset(env('IMAGE_UPLOAD_PATH')).''.$client->user_image}}" alt="" class="profileImg2" style="width: 114px;border-radius: 50%;height: 114px !important;border: 2px solid #f9d100;
                                padding: 9px;">
                        </div>
                        @else
                        <div class="first_letter">
                            <span>{{strtoupper(substr($client->first_name,0,1))}}</span>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Name</h3>
                                <p>{{$client->first_name}} {{$client->last_name}}</p>
                            </div>
                            <div class="col-md-6">
                                <h3>Email Id</h3>
                                <p>{{$client->email}} <img src="{{asset('web/images/tick.png')}}" alt=""
                                    style="all: unset;">
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h3>Registration Date</h3>
                                <p>{{$client->created_at}}</p>
                            </div>
                            <div class="col-md-6">
                                <h3>Contact Number</h3>
                                <p>+ {{$client->phone_code}} {{$client->phone_number}}</p>
                            </div>
                            <div class="col-md-6">
                                <h3>Tod-Z Id</h3>
                                <p>{{$client->todz_id}}
                                </p>
                            </div>

                            <div class="col-md-6">
                                <h3>Country</h3>
                                <p>{{$client->country ?? 'N/A'}}</p>
                            </div>
                             <div class="col-md-6">
                                <h3>Entity</h3>
                                 @if($client->entity==config('constants.entity.CORPORATE'))
                                   <p>Corporate</p>
                                @elseif($client->entity==config('constants.entity.INDIVIDUAL'))
                                    <p>Individual</p>
                                @elseif($client->entity==config('constants.entity.PRIVATE'))
                                   <p>Private</p>
                                @endif
                            </div>
                            @if(in_array($client->entity, array('corporate','private')))
                                <div class="col-md-6">
                                    <h3>Company Name</h3>
                                    <p>{{$client->company_name ?? 'N/A'}}
                                    </p>
                                </div>
                                 <div class="col-md-6">
                                    <h3>Number of employees</h3>
                                    <p>{{$client->no_of_employees ?? '0'}}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h3>Company Description</h3>
                                    <p>{{$client->description ?? 'N/A'}}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h3>Location</h3>
                                    <p>{{$client->location ?? 'N/A'}}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h3>Company Address</h3>
                                    <p>{{$client->company_address ?? 'N/A'}}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h3>Registration Number</h3>
                                    <p>{{$client->registration_number ?? 'N/A'}}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h3>VAT details</h3>
                                    <p>{{$client->vat_details ?? 'N/A'}}
                                    </p>
                                </div>
                            @endif
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
                                        <th>Talent ID</th>
                                        <th>Talent Name</th>
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
                                                <td>{{@$row->talents[0]->todz_id ?? "N/A"}}</td>
                                                <td>{{@$row->talent[0]->first_name ?? 'N/A'}} {{@$row->talent[0]->last_name ?? ''}}</td>
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