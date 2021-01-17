@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="myProSection">
    <div class="top-bar">
        <div class="container">
            <h3>{{$project->title}}</h3>
            <h5> 
                <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;"> 
                Project Owner ID: {{$project->client->temp_todz_id ? $project->client->temp_todz_id : 'N/A'}}
            </h5>
            <h5> 
                <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;visibility:hidden">Project ID:
                {{config('constants.PROJECT_ID_PREFIX')}}{{$project->id}}
            </h5>

        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">

                <div class="project-tabs">
                    <h2>My Projects</h2>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link " href="#overview" role="tab" data-toggle="tab">
                                Overview
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#details" role="tab" data-toggle="tab">
                                Details
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#milestones" role="tab" data-toggle="tab">
                                Milestones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#timesheets" role="tab" data-toggle="tab">
                                Timesheets
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#payment" role="tab" data-toggle="tab">
                                Payment Details
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-9">
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel " class="tab-pane fade " id="overview">
                        @if($project->status==config('constants.project_status.DISPUTE'))
                            <br>
                            <h3>Client Dispute Reason </h5>
                            <p class="detailList">{{$project->close_reason ? $project->close_reason : 'N/A'}}</p>
                        @endif

                        <h3>Submission Details</h3>
                        <ul class="detailList" >
                            <li>
                                <h4>Start Date</h4>
                                <p>-</p>
                            </li>
                            <li>
                                <h4>Due Date</h4>
                                <p>-</p>
                            </li>
                            <li>
                                <h4>Completed On</h4>
                                {{-- <p>{{@$project->talents->where('id',Auth::user()->id)[0]->pivot->no_of_hours}}</p> --}}
                                <p>-</p>
                            </li>
                        </ul>
                        


                        <h3>Payments</h3>
                        <ul class="detailList">
                            <li>
                                <h4>Total</h4>
                                <p>${{ProjectManager::projectTotalPrice($project->id,\Auth::user()->id)}}</p>
                            </li>
                            <li>
                                <h4>Received</h4>
                                <p>
                                <p>${{$payments->isNotEmpty()?$payments->pluck('amount')->sum():0}}</p>
                            </li>
                            <li>
                                <h4>Pending</h4>
                                <p>
                                	@if($payments->isNotEmpty())
                                		<p>${{ProjectManager::projectTotalPrice($project->id,\Auth::user()->id)-$payments->isNotEmpty()?$payments->pluck('amount')->sum()-$payments->pluck('amount')->sum():0}}</p>
                                	@else
 										<p>${{ProjectManager::projectTotalPrice($project->id,\Auth::user()->id)-$payments->isNotEmpty()?$payments->pluck('amount')->sum():0}}</p>
 									@endif
 								</p>
                            </li>
                        </ul>
                        <h3>Milestones</h3>
                      
                            @if($milestones->isEmpty())
                            <div class="milestoneDiv">
                                <h5>
                                    <img src="{{asset('web/images/ic_work_experience.png')}}" alt="">
                                    You have not set up your milestones yet! 
                                </h5>
                            </div>
                            @else
                            <div class="milestoneTableDiv">
                                <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th scope="col">NAME</th>
                                    <th scope="col">START DATE</th>
                                    <th scope="col">DUE DATE</th>
                                    <th scope="col">HOURS</th>
                                    {{-- <th scope="col">SUBMITTED ON </th> --}}
                                    <th scope="col">PAYMENT</th>
                                    <th scope="col">STATUS</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach($milestones as $key=> $milestone)
                                  <tr>
                                    <th>{{$milestone->title}}</th>
                                    <td>{{$milestone->start_date}}</td>
                                    <td>{{$milestone->due_date}}</td>
                                    <td>{{$milestone->no_of_hours}}</td>
                                    {{-- <td>-</td> --}}
                                    <td>-</td>
                                    <td>  @if($milestone->status==0)
                                        <span class="pending">Pending</span>
                                            @else
                                    <span class="approved">Approved</span>
                                    @endif</td>
                                  </tr>
                                  @endforeach
                                </tbody>
                                </table>
                            </div>
                            @endif
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="details">
                        <div class="projectDetails">
                            <h4>Title</h4>
                            <p>{{$project->title}}</p>
                            <h4>Description</h4>
                            <p>{{$project->description}}
                            </p>
                            <ul class="overviewList">
                                <li>
                                    <h4>Months</h4>
                                    <p>{{$project->duration_month}}</p>
                                </li>
                                <li>
                                    <h4>Days</h4>
                                    <p>{{$project->duration_day}}</p>
                                </li>
                                <li>
                                    <h4>Cost</h4>
                                    <span>
                                        <strong>USD</strong>
                                        <p style="margin: 0;">{{$project->cost}}</p>
                                    </span>
                                </li>
                            </ul>
                            <h4>Project Brief File</h4>

                        @foreach($project->files as $file)

                     
                        <a href="{{$file->file_full_path}}"><img src="{{$file->document_image}}" style="width:30px">{{$file->file_name}}</a>
                      <br/>     
                    @endforeach
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="milestones">
                        <h3>Milestones</h3>
                   

                      <!-- ************************ -->
                    @if(!$milestones->isEmpty())
                      <div id="accordion" class="myaccordion">

                        @foreach($milestones as $key=> $milestone)
                        <div class="card">
                            <div class="card-header" id="heading{{$key}}">
                                <h2 class="mb-0">
                                    <button
                                        class="d-flex align-items-center justify-content-between btn btn-link"
                                        data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true"
                                        aria-controls="collapse{{$key}}">
                                        {{$key+1}}. {{$milestone->title}} -
                                        @if($milestone->status==0)
                                    <span class="pending">Approved Pending</span>
                                        @else
                                <span class="approved">Approved</span>
                                @endif
                                        <span class="fa-stack">
                                            <i class="fa fa-plus"></i>
                                        </span>
                                    </button>
                                </h2>
                            </div>
                            <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}"
                                data-parent="#accordion">
                                <div class="card-body">
                                    <h3>Description
                                        <strong id="milestone-{{$milestone->id}}">
                                            <?php //dd($milestone,$milestone->runing_time);?>
                                            @if(is_null($milestone->runing_time))
                                            0 Hr 0 Min
                                            @else 
                                            {{ ProjectManager::getRuningHours($milestone->runing_time)}}
                                        @endif
                                    </strong>
                                    
                                    </h3>
                                    <p>{{$milestone->description}}</p>
                                    <ul class="overviewList">
                                     
                                      <li>
                                            <h3>Start Date</h3>
                                            <p>{{$milestone->start_date}}</p>
                                        </li>
                                        <li>
                                            <h3>Due Date</h3>
                                            <p>{{$milestone->due_date}}</p>
                                        </li>
                                           <li>
                                            <h3>Hours</h3>
                                            <p>{{$milestone->no_of_hours}} hrs</p>
                                        </li>
                                         {{--  <li>
                                            <h3>Completed On</h3>
                                            <p>-</p>
                                        </li> --}}
                                    </ul>
                                    <div class="line-bottom" style="margin-top: 0px;"></div>
                                    <h3>Cost</h3>
                                <h4>${{$milestone->cost}}
                                    <img src="/images/tick copy.png" alt="">
                                    <span>( Payment Due: Once this milestone is approved by project owner,
                                        the payment for this will be released )</span>
                                    </h4>
                                    <div class="line-bottom" style="margin-top: 0px;"></div>
                                    
                                </div>
                            </div>
                        </div>
                        @endforeach
                        

                    </div>
                    @endif
                    
                    </div>

                    <div role="tabpanel" class="tab-pane fade" id="timesheets">
                        

                        @foreach($milestones as $key=> $milestone)
                        @if($milestone->timesheet->isNotEmpty())
                        <h3>{{$milestone->title}}</h3>
                        <div class="milestoneTableDiv">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Date and time</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">HRS</th>
                                        <th scope="col">Files</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($milestone->timesheet as $times)
                                    <tr>
                                        <th>
                                            {{date('d/m/Y',strtotime($times->updated_at))}}
                                            <p class="time"> {{date('h:i a',strtotime($times->updated_at))}}</p>
                                        </th>
                                        <td>{{$times->description}}
                                        </td>
                                        <td>{{$times->hours}}</td>
                                        <td>{{$times->document}}</td>
                                        <td>
                                        <a href="{{$times->full_file_url}}" type="button" class="downBtn">
                                                <img src="{{asset('web/images/dwnlrd.png')}}" alt="">
                                        </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </div>
                        @endif
                        @endforeach

                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="payment">
                        <h3>Payments</h3>
                        <ul class="detailList">
                            <li>
                                <h4>Total</h4>
                            <p>${{ProjectManager::projectTotalPrice($project->id,\Auth::user()->id)}}</p>
                            </li>
                            <li>
                                <h4>Received</h4>
                                <p>${{$payments->isNotEmpty()?$payments->pluck('amount')->sum():0}}</p>
                            </li>
                            <li>
                                <h4>Pending</h4>
                                @if($payments->isNotEmpty())
                                <p>${{ProjectManager::projectTotalPrice($project->id,\Auth::user()->id)-$payments->isNotEmpty()?$payments->pluck('amount')->sum()-$payments->pluck('amount')->sum():0}}</p>
                                @else
 <p>${{ProjectManager::projectTotalPrice($project->id,\Auth::user()->id)-$payments->isNotEmpty()?$payments->pluck('amount')->sum():0}}</p>
 @endif
                            </li>
                        </ul>
                        <h3>Payment Details</h3>
                        <div class="milestoneTableDiv">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Milestone</th>
                                        <th scope="col">cost</th>
                                        {{-- <th scope="col">Due Date</th> --}}
                                        <th scope="col">Paid on</th>
                                        <th scope="col">status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $key=> $payment)
                                    @php $completion = 0;@endphp
                                    <tr>
                                        <td>
                                            @if(ProjectManager::getProjectDuration($project->id,\Auth::user()->id)<=30)
												100%
                                                @php $completion = 1;@endphp
											@else
											    @if($key<2)
											        25%
                                                    @php $completion = 2;@endphp
											    @else
											    	50%
                                                    @php $completion = 3;@endphp
											    @endif
											@endif
										</td>
                                        <td><span class="completed">{{$payment->amount}}</span></td>
                                        <td>{{date('d/m/Y',strtotime($payment->created_at))}}</td>
                                        <td><img src="{{asset('web/images/tick.png')}}" alt="">Paid</td>
                                        <td>
                                            <a href="{{url('talent/milestone-invoice/'.$payment->project_id.'/'.$payment->id)}}" target="_blank">
                                                <img src="{{asset('web/images/ic_print.svg')}}" alt="Print">Invoice
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <th colspan="8" style="text-align:center;" >No Payment Record</th>
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
</section>



@endsection
@section('headerScript')
@parent
<link rel="stylesheet" href="{{asset('web/dropzone/basic.min.css')}}" >
<link rel="stylesheet" href="{{asset('web/dropzone/dropzone.min.css')}}" >

@endsection
@section('footerScript')
    @parent
    <script src="{{asset('web/js/main.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <script  src="{{asset('web/dropzone/dropzone.min.js')}}" ></script>
  <script>

$(document).ready(function(){

    $hash=window.location.hash;
    if(window.location.hash==''){
        $hash="#overview";
    }
    $('.nav-tabs a[href="'+ $hash + '"]').addClass('active');
    $($hash).addClass('show active');
});
$('.nav-tabs a[data-toggle="tab"]').on("click", function() {
    $('.nav-tabs a').removeClass('active');
    $(".tab-pane").removeClass('show active');
    let newUrl;
    
    const hash = $(this).attr("href");
    newUrl ="{{route('project_overview',[$project->id])}}" + hash;

    history.replaceState(null, null, newUrl);
   
    $('.nav-tabs a[href="'+ $hash + '"]').delay( 800 ).addClass('active');
    $($hash).delay( 800 ).addClass('show active');
});
</script>
@endsection  