@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="postedProjectSection">
    <div class="container">
        @php
            $allStatus = array(config('constants.project_status.PENDING'), config('constants.project_status.HIRED'), config('constants.project_status.ACTIVE'), config('constants.project_status.IN-COMPLETE'));
        @endphp
        @if(in_array($project->status, $allStatus))
            <div class="row">
                <div class="offset-md-2 col-md-8 pl-0">
                    <button type="button" class="endProjectBtn" data-id="{{$project->id}}" data-toggle="modal" data-target="#escalationModal">End Project</button>
                </div>
            </div>
        @endif
        <br>
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h3>Project Details <span>posted on {{date('d M\' Y',strtotime($project->created_at))}}</span></h3>
                <h2>{{$project->title}}</h2>

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
                <h4>Skills Required</h4>
                @foreach($project->skills as $skill)
                <div class="talentDiv">
                    {{$skill->name}}
                </div>
                @endforeach
              

                <h4>Project Brief File</h4>
                @foreach($project->files as $file)
               
                    <a href="{{$file->file_full_path}}"><img src="{{$file->document_image}}" style="width:30px">{{$file->file_name}}</a>
                    <br/>
               
                @endforeach
                <div class="line-bottom"></div>
                <h3>Talents Selected</h3>
                <ul class="selectedList">

                    @foreach($project->talents as $talent)
                  
                    <li>
                        <div class="box">
                            <h5>
                                <img src="{{asset('web/images/ic_user.png')}}" alt="">
                                Toddler ID: {{$talent->todz_id}}
                                <i>
                                    <img src="{{asset('web/images/Star_review.png')}}" alt="">
                                    4.5
                                </i>
                            </h5>
                            <h6>
                                {{$talent->talent->job_title}}
                                <span><img src="{{asset('web/images/ic_project_completed.png')}}" alt=""> 0 projects completed
                                </span>
                            </h6>
                            @if($talent->pivot->status==config('constants.project_talent_status.ACCEPTED'))
                            <h4>
                                <br/>
                               No Of Days: {{$talent->pivot->no_of_days}} Days
                               <br/>
                               Price: ${{$talent->pivot->no_of_hours*$talent->talent->hourly_rate}} 
                            </h4>
                            @endif
                        </div>
                        @if($talent->pivot->status ==config('constants.project_talent_status.ACCEPTED'))
                        <a href="{{url('client/project/'.$project->id."/".$talent->todz_id.'/show')}}">    
                            <div class="milestone-status">
                                View Details 
                            </div>
                         </a>
                        <div style="display: flex; flex-wrap: wrap;align-items: center;">
                        <a href="{{url('client/message/'.$project->id."/".$talent->todz_id)}}"><button type="button" >Message</button></a>
                            <p>( Accepted Job Invite on {{ date("d M' Y",strtotime($talent->pivot->updated_at))}})</p>
                        </div>
                    
                      
                      
                        @elseif($talent->pivot->status==config('constants.project_talent_status.PENDING'))
                        <div style="display: flex; flex-wrap: wrap;align-items: center;">
                            <a href="{{url('client/message/'.$project->id."/".$talent->todz_id)}}"><button type="button" >Message</button></a>
                            <p>( Can accept inviation in 2 d:16 h: 01 m)</p>
                            </div>
                            @else 
                            <div style="display: flex; flex-wrap: wrap;align-items: center;">
                               <button type="button" style="background-color:#e2e2e2;color: red;" >Rejected</button>
                                    <p>( Rejected Job Invite on {{ date("d M' Y",strtotime($talent->pivot->updated_at))}})</p>
                                </div>


                        @endif
                    </li>
                    @endforeach
                  
                </ul>
                @if($project->talents->whereIn('status',[config('constants.project_talent_status.ACCEPTED'),config('constants.project_talent_status.PENDING')])->count()<5)
                    <a href="{{route('add_additional_todder',[$project->id])}}"><button type="button" class="selectBtn">+ &nbsp;Select Talent</button></a>
                @endif
            </div>
        </div>
    </div>
</section>
<div id="escalationModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="max-width: 40%">
        <div class="modal-content">
            <h4 class="modal-title mt-2" style="text-align: center;">End Project</h4>
            <div class="modal-body">
                <form method="post" name="escalationForm" id="escalationForm" onsubmit="addProjectCloseRecord()">
                    <div class="form-group reason">
                        <label for="recipient-name" class="col-form-label">Reason :</label>
                        <input type="text" class="form-control" name="reason" required="true"> 
                        <span class="error"></span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary add_escalationform_btn">Save</button>
                <button type="button" class="btn btn-secondary escalationform_dismiss" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footerScript')
@parent
<script src="{{asset('web/js/main.js')}}"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).on('click','.endProjectBtn', function(){
        var $form = $('#escalationForm');
        $(document).find('span.error').empty();
        $('.add_escalationform_btn').prop('disabled', false);
        $('#escalationForm')[0].reset();
    });

    $("#escalationForm").submit(function(e) {
        e.preventDefault();
        addProjectCloseRecord();
    });
    $(document).on('click','.add_escalationform_btn', function(e){
        e.preventDefault();
        addProjectCloseRecord();
    });

    function addProjectCloseRecord(){
        var formdata = new FormData($('#escalationForm')[0]);
        formdata.append('_token', "{{ csrf_token() }}");
        formdata.append('project_id', '{{$project->id}}');

        $.ajax({
            type:'POST',
            url:'{{url("client/end-project")}}',
            data:formdata,
            processData: false,
            contentType: false,
            beforeSend:function(){
                //startLoader('.modal-content');
                $('.add_escalationform_btn').prop('disabled', true);
            },
            complete:function(){
                //stopLoader('.modal-content');
                $('.add_escalationform_btn').prop('disabled', false);
            },
            success:function(response){
                if(response.status){
                    swal("Yeah!", response.message, "success");
                    $('#escalationForm')[0].reset();
                    $(document).find('span.error').empty();
                    $('.escalationform_dismiss').trigger('click');
                    setTimeout(window.location.reload(), 1000)
                }else{
                    swal("Oops!", response.message, "error");
                }
            },
            error: function(error){
                $('.add_escalationform_btn').prop('disabled', false);
                // stopLoader('.modal-content');
                if(error.status == 422) {
                    errors = error.responseJSON;
                    $.each(errors.errors, function(key, value) {
                        $('.'+key).find('span.error').empty().addClass('text-danger').text(value).finish().fadeIn();
                    }); 
                }
            }
        });
    }
</script>
@endsection