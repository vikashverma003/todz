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