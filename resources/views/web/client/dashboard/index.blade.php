@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')
<section class="dashboard-section">
    <div class="container">
        <h1>
            My Dashboard
        </h1>
        <div class="row">
            <div class="col-md-3">

                <div class="project-tabs">
                    <h2>My Projects</h2>
                    <ul class="nav nav-tabs" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" href="#postedPro" role="tab" data-toggle="tab">
                                Posted Projects
                            <span>{{$postedProjects->total()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#activePro" role="tab" data-toggle="tab">
                                Active Projects
                                <span>{{ $activeProjects->total() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#upcomingPro" role="tab" data-toggle="tab">
                                Upcoming Projects
                                <span>{{$upcomingProjects->total()}}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#completedPro" role="tab" data-toggle="tab">
                                Completed Projects
                                <span>{{ $completedProjects->total() }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#disputedPro" role="tab" data-toggle="tab">
                                Disputed Projects
                                <span>{{ $disputedProjects->total() }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            <div class="col-md-6">
                <!-- Tab panes -->
                <div class="tab-content">
                    

                    <div role="tabpanel" class="tab-pane fade show active" id="postedPro">
                        <div class="tabs-data">
                            <h2>Posted Projects</h2>
                            <ul class="tab-list">
                                @foreach($postedProjects as $project)
                                <li>
                                <a href="{{route('project.show',[$project->id])}}" >
                                    <h3>
                                        {{$project->title}}
                                    </h3>
                                    <h4>Description</h4>
                                    <p>{{substr($project->description, 0, 150)}}</p>
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
                                            <p>${{$project->cost}}</p>
                                        </li>
                                    </ul>
                                    @foreach($project->skills as $skill)
                                    <div class="talentDiv">
                                        {{$skill->name}}
                                    </div>
                                    @endforeach
                                </a>
                                <h4>Talents Selected <span>{{$project->talents->count()}}/5</span></h4>

                                    <ul class="selected-talent-list">
                                        @foreach($project->talents as $talent)
                                        <li>
                                            @if($talent->pivot->status==config('constants.project_talent_status.ACCEPTED'))
                                            <img src="{{asset('web/images/ic_user_tick.png')}}" alt="">
                                            @else
                                            <img src="{{asset('web/images/ic_user_exclamation.png')}}" alt="">
                                            @endif
                                        <h5>ID: {{$talent->todz_id}}</h5>
                                        </li>
                                        @endforeach
                                        @if($project->talents->count()<5)
                                        <li>
                                            <img src="{{asset('web/images/ic_user1.png')}}" alt="">
                                        <a href="{{route('add_additional_todder',[$project->id])}}">+Add more</a>
                                        </li>
                                        @endif
                                    </ul>
                               
                                </li>
                                @endforeach
                            </ul>
                            {!! $postedProjects->links() !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="activePro">
                        <div class="tabs-data">
                            <h2>Active Projects</h2>
                           <ul class="tab-list">
                                @foreach($activeProjects as $project)
                                <li>
                                <a href="{{url('client/project/'.$project->id.'/'.$project->hiredTodder->todz_id.'/show')
                              }}" >
                                    <h3>
                                        {{$project->title}}
                                    </h3>
                                    <h4>Description</h4>
                                    <p>{{substr($project->description, 0, 150)}}</p>
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
                                            <p>${{$project->cost}}</p>
                                        </li>
                                    </ul>
                                    @foreach($project->skills as $skill)
                                    <div class="talentDiv">
                                        {{$skill->name}}
                                    </div>
                                    @endforeach

                                    <h4>Hired Talent </h4>

                                    <ul class="selected-talent-list">
                                      
                                        <li>
                                            <img src="{{asset('web/images/ic_user_tick.png')}}" alt="">
                                        <h5>ID: {{$project->hiredTodder->todz_id}}</h5>
                                        </li>
                                      
                                    </ul>
                                </a>
                                </li>
                                @endforeach
                            </ul> 
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="upcomingPro">
                        <div class="tabs-data">
                            <h2>Upcoming Projects</h2>
                            <ul class="tab-list">
                                @foreach($upcomingProjects as $project)
                                <li>
                                <a href="{{route('project.show',[$project->id])}}" >
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
                                            <p>${{$project->cost}}</p>
                                        </li>
                                    </ul>
                                    <hr>
                                    
                                    @foreach($project->talents as $talent)
                                        <img class="mr-1" src="{{asset('web/images/ic_user1.png')}}" alt="">
                                        <h5>Todder ID: {{$talent->todz_id}}</h5>
                                        <br>
                                    @endforeach
                                   
                                </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="completedPro">
                        <div class="tabs-data">
                            <h2>Completed Projects</h2>
                            <ul class="tab-list">
                                @foreach($completedProjects as $project)
                                <li>
                                    <a href="{{url('client/project/'.$project->id.'/'.$project->hiredTodder->todz_id.'/show')}}" >
                                        <h4>Title</h4>
                                        <p>{{$project->title}}</p>
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
                                                <p>${{$project->cost}}</p>
                                            </li>
                                        </ul>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            {!! $postedProjects->links() !!}
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="disputedPro">
                        <div class="tabs-data">
                            <h2>Disputed Projects</h2>
                            <ul class="tab-list">
                                @foreach($disputedProjects as $project)
                                <li>
                                    <a href="{{url('client/project/'.$project->id.'/'.$project->hiredTodder->todz_id.'/show')}}" >
                                        <h4>Title</h4>
                                        <p>{{$project->title}}</p>
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
                                                <p>${{$project->cost}}</p>
                                            </li>
                                        </ul>
                                    
                                        <h4>Self Dispute Reason</h4>
                                        <p>{{substr($project->close_reason, 0, 150)}}</p>

                                        <h4>Todder Dispute Reason</h4>
                                        <p>{{substr($project->todder_dispute_reason, 0, 150)}}</p>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                            {!! $postedProjects->links() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="messagesDiv">
                    <h2>Messages</h2>
                    
                    @if($activetoder->isNotEmpty())
                        <ul>
	                        @foreach($activetoder as $abc)
	                        <li>
	                            <a href="{{url('client/message/'.$abc->project->id."/".$abc->user->todz_id)}}">
	                        		<h3>{{$abc->project->title}}<span>{{NotificationManager::getAgoTime($abc->date,0)}}</span></h3>
	                            	<h4><img src="{{asset('web/images/ic_user.png')}}" alt="">Id: {{$abc->user->todz_id}}</h4>
		                          	@if(!is_null($abc->messageDetail()))
		                        		<h5>{{Auth::user()->id==$abc->messageDetail()->from_id?'You':'Todder' }}: {{$abc->messageDetail()->message}}</h5>
		                        	@endif
		                        </a>
	                        </li>
	                        @endforeach
	                    </ul>
                    	<a href="{{url('client/message/'.$activetoder[0]->project->id."/".$activetoder[0]->user->todz_id)}}">view all messages</a>
                    @else
                    <ul>
                        <li>No Message</li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
@section('footerScript')
@parent
<script src="{{asset('web/js/jquery-1.11.2.min.js')}}"></script>
<script src="{{asset('web/js/jquery-migrate-1.2.1.min.js')}}"></script>
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
            url:"/client/fetch_posted_project?page="+page,
            success:function(data)
            {
                $('#postedPro').html(data);
            }
        });
    }
     
});
</script>
    @endsection