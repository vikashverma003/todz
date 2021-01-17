<h3>Milestones</h3>
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
                    <button type="button" data-id="{{$milestone->id}}"  class="playBtn">
                        {{in_array($milestone->is_task_runing,[config('constants.TRACKER_STATUS.PAUSE'),config('constants.TRACKER_STATUS.PENDING')])?'Start':'Pause'}} <img src="{{asset('web/images/ic_user.png')}}" alt="">
                        </button>
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
                    <button type="button" class="deliverableBtn">Upload Deliverables</button>

                    @if($milestone->status==0)
                        <button type="button" class="escalationBtn" data-milestone="{{$milestone->id}}"  data-owner="{{$project->client->id}}" data-project="{{$project->id}}" data-toggle="modal" data-target="#escalationModal">Raise Escalation</button>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
        {{-- @if(ProjectManager::isTaskRunning($project->id)) --}}
        <div id="timer" style="visibility:hidden"></div>
        {{-- @endif --}}
        <button type="button" class="addBtn">+ &nbsp;Add Milestone</button>
    </div>
@endif
<form id="createmilestoen" style="{{$milestones->isEmpty()?'display:block':'display:none'}}" action="{{route('milestone_create',[$project->id])}}" method="post">
    @csrf
    <input type="hidden" name="project_id" value="{{$project->id}}">
    <div class="create-miletone">
        <h3 class="custom"> <span style="font-size: 20px;">+</span>&nbsp;Create Milestone</h3>
        <div class="milestone-form">
            <input type="text" name="title" placeholder="Project Title" required>
            <input type="text" name="description" placeholder="Description" required>
            <div class="row">
              
                <div class="col-md-4">
                    <span class="datePicker">
                        <img src="{{asset('web/images/ic_work_experience.png')}}" alt="">
                        <input type="text" name="start_date" id="datepicker" placeholder="Start Date" required autocomplete="off">
                    </span>
                </div>
                <div class="col-md-4">
                    <span class="datePicker">
                        <img src="{{asset('web/images/ic_work_experience.png')}}" alt="">
                        <input type="text" name="due_date" id="datepicker1" placeholder="Due Date" required autocomplete="off">
                    </span>
                </div>
                 <div class="col-md-4">
                    <span class="cost">
                        <strong>hrs</strong>
                    <input type="text" name="no_of_hours" placeholder="No of Hours" onkeyup="this.value=this.value.replace(/[^\d]/,'')" required autocomplete="off">
                    </span>
                </div>
              {{--   <div class="col-md-4">
                    <span class="cost">
                        <strong>USD</strong>
                        <input type="text" name="cost" placeholder="Cost" required>
                    </span>
                </div> --}}
            </div>
            <input type="text" name="d_description" placeholder="Describe the deliverables for this milestone" required>
            <button type="submit">add milestone</button>
        </div>
    </div>
</form>