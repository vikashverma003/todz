<div class="tabs-data">
    <h2>{{$title}}</h2>
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
</div>