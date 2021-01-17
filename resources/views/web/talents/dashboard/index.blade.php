@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')
<section class="dashboard-section">
    <div class="container">
        <h1>
            My Dashboard
        </h1>
        @if(!isset(\Auth::user()->mangopayUser))
            <div class="row">
                <div class="col-md-12">
                    <div class="alert text-danger p-0"><strong>Warning: </strong> Please create your wallet in order to get hired!</div>
                </div>
            </div>
        @endif
        <div class="row">

            <div class="col-md-3">

                <div class="project-tabs">
                    <h2>My Projects</h2>
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#postedPro" role="tab" data-toggle="tab">
                                Job Inviations
                            <span>{{$invitedProject->total()}}</span>
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="#activePro" role="tab" data-toggle="tab">
                                Active Projects
                                <span>{{ $activeProject->total() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#upcomingPro" role="tab" data-toggle="tab">
                                Upcoming Projects
                                <span>{{$upcommingProject->total()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#completedPro" role="tab" data-toggle="tab">
                                Completed Projects
                                <span>{{$completedProject->total()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#disputedPro" role="tab" data-toggle="tab">
                                Disputed Projects
                                <span>{{$disputedProject->total()}}</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-6">
                @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                  </div>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                  </div>
                @endif
                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="postedPro">
                        <div class="tabs-data">
                            <h2>Job Invitations</h2>
                            @if($invitedProject->total()>0)
	                            <ul class="tab-list">
	                                @foreach($invitedProject as $project)
		                                <li>
		                                <a href="{{route('talent_project_detail',[$project->id])}}">
		                                    <h3>
		                                        {{$project->title}}
		                                    </h3>
		                                    <h4>Description</h4>
		                                    <p>{{substr($project->description, 0, 150)}}</p>
		                                    <h4>Skills Required</h4>
		                                    @foreach($project->skills as $skill)
		                                    <div class="talentDiv">
		                                        {{$skill->name}}
		                                    </div>
		                                    @endforeach
		                                </a>
		                                    <hr />
		                              
		                                    <div class="row">
		                                        <div class="col-md-6">
		                                            <form action="{{route('reject_action')}}" method="post">
		                                                @csrf
		                                                <input type="hidden" name="project_id" value="{{$project->id}}">
		                                                <button type="submit" class="rejectBtn">Reject</button>
		                                                {{-- <button type="submit" name="reject" class="theme-button hover-ripple btn-white-bck full-width mt-4 mb-3">Reject</button> --}}
		                                            </form>        
		                                </div>
		                                        <div class="col-md-6">
		                                          
		                                            <button type="button" class="acceptBtn AcceptButton" data-id="{{$project->id}}">Accept</button>
		                                      
		                                </div>
		                                    </div>
		                               

		                                </a>
		                                </li>
	                                @endforeach
	                            </ul>
	                            {!! $invitedProject->links() !!}
	                        @else
	                        	<ul class="tab-list"><li>No Job Invites Yet.</li></ul>
	                        @endif
                        </div>
                    </div>
                   
                    <div role="tabpanel" class="tab-pane fade" id="activePro">
                        <div class="tabs-data">

                            <h2>Active Projects</h2>
                            <ul class="tab-list">
                                @if($activeProject->total()>0)
                                    @foreach($activeProject as $project)
                                        <li>
                                            <a href="{{route('milestone_overview',[$project->id])}}">
                                            <h3>
                                                {{$project->title}}
                                            </h3>
                                            <h4>Description</h4>
                                            <p>{{substr($project->description, 0, 150)}}</p>
                                            <ul class="overviewList">
                                                <li>
                                                    <h4>Start Date</h4>
                                                    <p>-</p>
                                                </li>
                                                <li>
                                                    <h4>Due Date</h4>
                                                    <p>-</p>
                                                </li>
                                                <li>
                                                    <h4>Cost</h4>
                                                    <p>-</p>
                                                    {{-- <p>${{$project->cost}}</p> --}}
                                                </li>
                                            </ul>
                                            </a>
                                            <div class="line-bottom" style="margin-top: 0px;"></div>
                                            <h4>Project Owner</h4>
                                            <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;"> Project
                                                Owner ID:
                                                {{$project->client->temp_todz_id}}</h5>
                                            @if($project->talentMileStone()<1)
                                                <a href="{{route('milestone_overview',[$project->id])}}">    
                                                <div class="milestone-status">
                                                    Milestones not created
                                                </div>
                                             </a>
                                            @endif
                                        </li>
                                    @endforeach
                                @else
                                    <li>No Projects Available.</li>
                                @endif
                            </ul>
                            {!! $activeProject->links() !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="upcomingPro">
                        <div class="tabs-data">
                            <h2>Upcoming Projects</h2>
                            <ul class="tab-list">
                                @if($upcommingProject->total()>0)
                                    @foreach($upcommingProject as $project)
                                    <li>
                                        <a href="{{route('milestone_overview',[$project->id])}}">
                                        <h3>
                                            {{$project->title}}
                                        </h3>
                                        <h4>Description</h4>
                                        <p>{{substr($project->description, 0, 150)}}</p>
                                        <ul class="overviewList">
                                            <li>
                                                <h4>Start Date</h4>
                                                <p>-</p>
                                            </li>
                                            <li>
                                                <h4>Due Date</h4>
                                                <p>-</p>
                                            </li>
                                            <li>
                                                <h4>Cost</h4>
                                                <p>-</p>
                                                {{-- <p>${{$project->cost}}</p> --}}
                                            </li>
                                        </ul>
                                        </a>
                                            <div class="line-bottom" style="margin-top: 0px;"></div>
                                            <h4>Project Owner</h4>
                                            <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;"> Project
                                                Owner ID:
                                                {{$project->client->temp_todz_id}}</h5>
                                            @if($project->talentMileStone()<1)
                                            <a href="{{route('milestone_overview',[$project->id])}}">    
                                                <div class="milestone-status">
                                                    Milestones not created
                                                </div>
                                             </a>
                                        @endif
                                    </li>
                                    @endforeach
                                @else
                                    <li>No Projects Available.</li>
                                @endif
                            </ul>
                            {!! $upcommingProject->links() !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="completedPro">
                        <div class="tabs-data">
                        <h2>Completed Projects</h2>
                        <ul class="tab-list">
                            @if($completedProject->total()>0)
                                @foreach($completedProject as $project)
                                <li>
                                    <a href="{{route('project_overview',[$project->id])}}">
                                        <h3>
                                            {{$project->title}}
                                        </h3>
                                        <h4>Description</h4>
                                        <p>{{substr($project->description, 0, 150)}}</p>
                                        
                                        <div class="line-bottom" style="margin-top: 0px;"></div>
                                        <h4>Project Owner</h4>
                                        <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;">
                                            Project Owner ID:
                                            {{$project->client->temp_todz_id}}
                                        </h5>
                                        
                                    </a>
                                </li>
                                @endforeach
                            @else
                                <li>No Projects Available.</li>
                            @endif
                        </ul>
                        {!! $upcommingProject->links() !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="disputedPro">
                        <div class="tabs-data">
                            <h2>Disputed Projects</h2>
                            <ul class="tab-list">
                                @if($disputedProject->total()>0)
                                    @foreach($disputedProject as $project)
                                    <li>
                                        <a href="{{route('project_overview',[$project->id])}}">
                                            <h3>
                                                {{$project->title}}
                                            </h3>
                                            <h4>Description</h4>
                                            <p>{{substr($project->description, 0, 150)}}</p>
                                            <h4>Self Dispute Reason</h4>
                                            <p>{{substr($project->todder_dispute_reason, 0, 150)}}</p>

                                            <h4>Client Dispute Reason</h4>
                                            <p>{{substr($project->close_reason, 0, 150)}}</p>
                                            <div class="line-bottom" style="margin-top: 0px;"></div>
                                            <h4>Project Owner</h4>
                                            <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;">
                                                Project Owner ID:
                                                {{$project->client->temp_todz_id}}
                                            </h5>
                                            
                                        </a>
                                    </li>
                                    @endforeach
                                @else
                                    <li>No Projects Available.</li>
                                @endif
                            </ul>
                            {!! $upcommingProject->links() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="messagesDiv">
                    <h2>Messages</h2>
                    <ul>
                        @foreach($projects as $project)
                        <li>
                          <a href="{{url('talent/message/'.$project->id.'/'.$project->client->todz_id)}}">
                            <h3>{{$project->title}}<span> @if(count($project->messages)>0)
                            {{NotificationManager::getAgoTime($project->messages[0]->created_at,0)}}
                            @endif
                            </span></h3>
                            <h4><img src="{{asset('web/images/ic_user.png')}}" alt="">Id: {{$project->client->temp_todz_id}}</h4>
                            @if(count($project->messages)>0)
                                <h5>{{Auth::user()->id==$project->messages[0]->from_id?'You':'Client' }}:  {{$project->messages[0]->message}}</h5>
                            @endif
                          </a>
                        </li>
                        @endforeach
                    </ul>
                    @if($projects->count()>0)
                        <a href="{{url('talent/message/'.$projects[0]->id.'/'.$projects[0]->client->todz_id)}}">view all messages</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@include('web.includes.todder-popup')
@endsection
@section('footerScript')
@parent
<script src="{{asset('web/js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('web/js/jquery-migrate-1.2.1.min.js')}}"></script>
@include('web.includes.todder-popup-script')



<script>
$(document).ready(function(){
    
    $(document).on('click', '#postedPro .pagination a', function(event){
        event.preventDefault(); 
        var page = $(this).attr('href').split('page=')[1];
        fetch_data(page);
    });
    
     function fetch_data(page)
     {
      $.ajax({
       url:"/talent/fetch_invited_project?page="+page,
       success:function(data)
       {
        $('#postedPro').html(data);
       }
      });
     }

     $(document).on('click', '#upcomingPro .pagination a', function(event){
      event.preventDefault(); 
      var page = $(this).attr('href').split('page=')[1];
      fetch_upcomming(page);
     });
    
     function fetch_upcomming(page)
     {
      $.ajax({
       url:"/talent/fetch_upcomming_project?page="+page,
       success:function(data)
       {
        $('#upcomingPro').html(data);
       }
      });
     }
     
    });
    
    </script>
    @endsection