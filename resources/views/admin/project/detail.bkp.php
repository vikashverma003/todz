@extends('admin.layouts.app')
@section('title','Project Details')
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="profile-data" style="border-radius: 8px;margin:auto;width:90% !important;">
            <div class="col-md-12  grid-margin stretch-card">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <h4><strong>Project Details</strong></h4>
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Title</h3>
                                <p>{{$data->title ?? 'N/A'}}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Description</h3>
                                <p>{{$data->description ?? 'N/A'}}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-3">
                                <h3>Created On</h3>
                                <p>{{$data->created_at ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-3">
                                <h3>Allocation Date</h3>
                                <p>{{$data->created_at ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-3">
                                <h3>Duration</h3>
                                <p>
                                    @if($data->duration_month > 0)
                                        {{$data->duration_month}} month
                                    @endif

                                    @if($data->duration_day > 0)
                                        {{$data->duration_day}} days
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-3">
                                <h3>Cost</h3>
                                <p>{{$data->cost ?? 0}}</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-3">
                                <h3>Talent Name</h3>
                                <p>{{$data->talent->first_name ?? 'N/A'}} {{$data->talent->last_name ?? ''}}</p>
                            </div>
                            <div class="col-md-3">
                                <h3>Talent ID</h3>
                                <p>{{$data->talent->todz_id ?? 'N/A'}} </p>
                            </div>
                            <div class="col-md-3">
                                <h3>Client Name</h3>
                                <p>{{$data->client->first_name ?? 'N/A'}} {{$data->client->last_name ?? ''}}</p>
                            </div>
                            <div class="col-md-3">
                                <h3>Client ID</h3>
                                <p>{{$data->client->todz_id ?? 'N/A'}}</p>
                            </div>
                        </div>
                        <br>
                        <h4><strong>Milestones Details</strong></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">NAME</th>
                                            <th scope="col">DUE DATE</th>
                                            
                                            <th scope="col">PAYMENT</th>
                                            <th scope="col">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($milestones as $key=>$milestone)
                                            <tr>
                                                <th>{{$key+1}}</th>
                                                <th>{{$milestone->title}}</th>
                                                <td>{{$milestone->due_date}}</td>
                                                
                                                <td>${{$milestone->cost}}</td>
                                                <td>
                                                    @if($milestone->status == config('constants.milestone_status.PENDING'))
                                                    <span class="pending"> Pending</span>
                                                    @elseif($milestone->status == config('constants.milestone_status.APPROVED'))
                                                    <span class="approved"> Approved</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <th colspan="12" style="text-align:center;" >No Milestones Record</th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <br>
                        <h4><strong>Payment Details</strong></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <!-- <th scope="col">Milestone</th> -->
                                            <th scope="col">cost</th>
                                            <th scope="col">Paid on</th>
                                            <th scope="col">status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $key=>$payment)
                                            <tr>
                                                <th>{{$key+1}}</th>
                                                <!-- <th>50%</th> -->
                                                <td>{{$payment->amount}}</td>
                                                <td>{{date('d/m/Y',strtotime($payment->created_at))}}</td>
                                                <td><img src="{{asset('web/images/tick.png')}}" alt="Paid">Paid</td>
                                                <td>
                                                    <a href="{{url('admin/milestone-invoice/'.$payment->project_id.'/'.$payment->id)}}" target="_blank">
                                                        <img src="{{asset('web/images/ic_print.svg')}}" alt="Print">Invoice
                                                    </a>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <th colspan="12" style="text-align:center;" >No Payment Record</th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
</style>
@endsection