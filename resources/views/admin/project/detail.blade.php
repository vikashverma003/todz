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
                        <!-- <div class="row">
                            <div class="col-md-12 p-0">
                                <label>Select Project</label>
                                <select class="js-example-basic-single form-control" name="projects" id="multiple">
                                    <option value="AL">Alabama</option>
                                    <option value="AasL">asd</option>
                                </select>
                            </div>
                        </div> -->


                        <div class="row">
                            <div class="col-md-12">
                                <h3>Title</h3>
                                <p>{{$data->title ?? 'N/A'}}</p>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-12">
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
                                <p>{{$data->talents[0]->first_name ?? 'N/A'}} {{$data->talents[0]->last_name ?? ''}}</p>
                            </div>
                            <div class="col-md-3">
                                <h3>Talent ID</h3>
                                <p>{{$data->talents[0]->todz_id ?? 'N/A'}} </p>
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

                        <div class="row">
                            <div class="col-md-3">
                                <h3>Allocation Date</h3>
                                @if(!$project_talent)
                                    <p>{{$data->created_at ?? 'N/A'}}</p>
                                @else
                                    <p>{{$project_talent->updated_at ?? 'N/A'}}</p>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <h3>Allocated Hours</h3>
                                @if($project_talent)
                                    <p>{{$project_talent->no_of_hours ?? 'N/A'}}</p>
                                @else
                                    0
                                @endif
                            </div>
                            <div class="col-md-3">
                                <h3>Spend Hours</h3>
                                <p>{{$spend_hours}}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <h3>Budget</h3>
                                @if($project_talent)
                                    <p>{{$project_talent->no_of_hours*$hourlyRate ?? 'N/A'}}</p>
                                @else
                                    <p>{{$data->cost}}</p>
                                @endif
                            </div>
                            <div class="col-md-3">
                                <h3>Recived Amount</h3>
                                <p>{{@$data->transactions->sum('amount') ?? 0}} </p>
                            </div>
                            <div class="col-md-3">
                                <h3>Paid Amount</h3>
                                <p>{{@$payments->sum('amount') ?? 0}} </p>
                            </div>
                            <div class="col-md-3">
                                <h3>Project Current Status</h3>
                                @if(@$data->status=='completed')
                                    <p >{{@$data->status}}</p>
                                @elseif(@$data->status=='dispute')
                                    <p >{{@$data->status}}</p>
                                @else
                                    <p>{{@$data->status}}</p>
                                @endif
                            </div>
                        </div>
                        @if(@$data->status=='completed')
                            <hr>
                            <h4><strong>Project Ratings</strong></h4>
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th scope="col">Rating (Out of 5)</th>
                                                <th scope="col">Feedback</th>
                                                <th scope="col">Rating Given By</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($data->ratings as $key=>$value)
                                                <tr>
                                                    <th>{{$value->rating}}</th>
                                                    <td>{{$value->feedback}}</td>
                                                    <td>{{@$value->rating_given_by ?? ''}}</td>
                                                    <td>{{$value->created_at}}</td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <th colspan="5" style="text-align:center;" >No Record</th>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif

                        <hr>
                        <h4><strong>Milestones</strong></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr. No.</th>
                                            <th scope="col">NAME</th>
                                            <th scope="col">DUE DATE</th>
                                            <th scope="col">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($milestones as $key=>$milestone)
                                            <tr>
                                                <th>{{$key+1}}</th>
                                                <th>{{$milestone->title}}</th>
                                                <td>{{$milestone->due_date}}</td>
                                                <!-- <td>${{$milestone->cost}}</td> -->
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
                                                <th colspan="5" style="text-align:center;" >No Milestones Record</th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <hr>
                        <h4><strong>TimeSheets</strong></h4>
                        @if(count($data->clientMileStone($talent_id)) > 0)
                            @foreach($data->clientMileStone($talent_id) as $key=> $milestone)
                                @if($milestone->timesheet->isNotEmpty())
                                    <h3>MileStone Title: {{$milestone->title}}</h3>
                                    <div class="milestoneTableDiv">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Date and time</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Hours</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($milestone->timesheet as $times)
                                                <tr>
                                                    <td>
                                                        {{date('d/m/Y',strtotime($times->updated_at))}}
                                                        <p class="time"> {{date('h:i a',strtotime($times->updated_at))}}</p>
                                                    </td>
                                                    <td>{{$times->description}}</td>
                                                    <td>{{$times->hours}}</td>
                                                    
                                                    <td>
                                                        @if($times->client_approved==0)
                                                            PENDING
                                                        @elseif($times->client_approved==1)
                                                            APPROVED
                                                        @else
                                                            DECLINED
                                                        @endif
                                                        
                                                    </td>
                                                </tr>
                                                @endforeach
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                @endif
                            @endforeach
                        @else
                            <div class="col-md-12 detailList text-center">No Timesheet added Yet.</div>
                        @endif
                        <hr>
                        
                        <h4><strong>Payments Received</strong></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr. No.</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">payment Source</th>
                                            <th scope="col">Amount</th>
                                            <th scope="col">Fee</th>
                                            <th scope="col">Transaction ID</th>
                                            <th scope="col">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($data->transactions as $key=>$payment)
                                            <tr>
                                                <th>{{$key+1}}</th>
                                                <td>{{date('d/m/Y',strtotime($payment->created_at))}}</td>
                                                <td>{{$payment->payment_type}}</td>
                                                <td>{{$payment->amount}}</td>
                                                <td>{{$payment->fee ?? 0}}</td>
                                                <td>{{$payment->transaction_id}}</td>
                                                
                                                <td><img src="{{asset('web/images/tick.png')}}" alt="Paid">Paid</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <th colspan="10" style="text-align:center;" >No Transactions Record</th>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <hr>
                        <h4><strong>Payments Paid to Talent</strong></h4>
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Sr. No.</th>
                                            <th scope="col">DATE</th>
                                            <th scope="col">AMOUNT</th>
                                            <th scope="col">STATUS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($payments as $key=>$payment)
                                            <tr>
                                                <th>{{$key+1}}</th>
                                                <td>{{date('d/m/Y',strtotime($payment->created_at))}}</td>
                                                <td>{{$payment->amount}}</td>
                                                
                                                <td><img src="{{asset('web/images/tick.png')}}" alt="Paid">Paid</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <th colspan="5" style="text-align:center;" >No Payments Record</th>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
@endsection

@section('footerScript')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
   
    $(document).ready(function() {
        $('#multiple').select2({
            placeholder: "Select Country",
            allowClear: true
        });
    });
  </script>
@endsection