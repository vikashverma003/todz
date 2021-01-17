@if(count($project->clientMileStone($talent->id)) > 0)
    @foreach($project->clientMileStone($talent->id) as $key=> $milestone)
        @if($milestone->timesheet->isNotEmpty())
            <h3>{{$milestone->title}}</h3>
            <div class="milestoneTableDiv">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Date and time</th>
                            <th scope="col">Description</th>
                            <th scope="col">HRS</th>
                            <th scope="col">Document</th>
                            <th scope="col">Files</th>
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
                            <td>{{$times->document}}</td>
                            <td>
                                <a href="{{$times->full_file_url}}" type="button" class="downBtn" target="_blank">
                                    <img src="{{asset('web/images/dwnlrd.png')}}" alt="">
                                </a>
                            </td>
                            <td>
                                @if($times->client_approved==0)
                                    PENDING

                                    <a href="javascript:;" data-id="{{$times->id}}" class="btn btn-sm acceptTimesheet" style="position:relative;">
                                        <img src="{{asset('web/images/ic_tick.png')}}" alt="" class="tick" style="height: 40px">
                                    </a>

                                    <a href="javascript:void(0)" data-id="{{$times->id}}" style="position:relative;" class="btn btn-sm rejectTimesheet">
                                        <img src="{{asset('web/images/ic_cross.png')}}" alt="" class="tick" style="height: 40px">
                                    </a>
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
    <h3>Timesheet</h3>
    <div class="col-md-12 detailList text-center">No Timesheet added Yet.</div>
@endif