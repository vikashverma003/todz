<div class="tabs-data">
<h2>{{$title}}</h2>
    <ul class="tab-list">
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
                    <p>${{$project->cost}}</p>
                </li>
            </ul>
        </a>
            <div class="line-bottom" style="margin-top: 0px;"></div>
            <h4>Project Owner</h4>
            <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;"> Project
                Owner ID:
                {{$project->client->todz_id}}</h5>
            @if($project->talentMileStone()<1)
            <a href="{{route('milestone_overview',[$project->id])}}">    
            <div class="milestone-status">
                Milestones not created
            </div>
         </a>
        @endif
        </li>
        @endforeach
      

    </ul>
    {!! $activeProject->links() !!}
</div>