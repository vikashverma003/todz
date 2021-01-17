@php $count=0; @endphp
<div id="accordion" class="myaccordion">
    @forelse($project->clientMileStone($talent->id) as $key=> $milestone)
    <div class="card">
        <div class="card-header" id="heading{{$key}}">
            <h2 class="mb-0">
                <button
                    class="d-flex align-items-center justify-content-between btn btn-link"
                    data-toggle="collapse" data-target="#collapse{{$key}}" 
                     aria-expanded="true" aria-controls="collapse{{$key}}">
                    {{++$count}}. {{$milestone->title}} - &nbsp;
                    @if($milestone->status == config('constants.milestone_status.PENDING'))
                    <span class="pending"> Pending</span>
                    @elseif($milestone->status == config('constants.milestone_status.APPROVED'))
                    <span class="approved"> Approved</span>
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
                <h3>Description</h3>
                <p>{{$milestone->description}}</p>
                <ul class="overviewList">
                   
                    <li>
                        <h3>Start Date</h3>
                        <p>{{date('d F`Y',strtotime($milestone->start_date))}}</p>
                    </li>
                    <li>
                        <h3>Due Date</h3>
                        <p>{{date('d F`Y',strtotime($milestone->due_date))}}</p>
                    </li>
                    <li>
                        <h3>Hours</h3>
                        <p>{{$milestone->no_of_hours}} hrs</p>
                    </li>
                  {{--   <li>
                        <h3>Completed On</h3>
                        <p>-</p>
                    </li> --}}
                </ul>
                {{-- <div class="line-bottom" style="margin-top: 0px;"></div>
                <h3>Cost</h3>
                <h4>
                    ${{$milestone->cost}}
                    <img src="images/ic_project_completed.png" alt="">
                    <span>( Payment Due: Once you approve this milestone, the payment for
                        this will be released )</span>
                </h4> --}}
                <div class="line-bottom"></div>
                <h3>
                    Deliverables
                    <!-- <button type="button" class="downloadBtn">
                        <img src="images/" alt="">
                        Download All
                    </button> -->
                </h3>
                <p>{{$milestone->d_description}}</p>
                @switch(ProjectManager::isTodderHired($project->id,$talent->id))
                @case(1)
                @if($milestone->status == config('constants.milestone_status.PENDING'))
                <button type="button" class="approveBtn" onclick="approve_milestone('{{$milestone->id}}','{{config('constants.milestone_status.APPROVED')}}')">Approve</button>
                <button type="button" class="raiseBtn" onclick="approve_milestone('{{$milestone->id}}','{{config('constants.milestone_status.REJECTED')}}')">Reject</button>
                @endif
                    @break
                @endswitch

              
                
            </div>
        </div>
    </div>
    @empty
        <h3>Milestones</h3>
        <div class="col-md-12 detailList text-center">No Milestones added Yet.</div>
    @endforelse
</div>