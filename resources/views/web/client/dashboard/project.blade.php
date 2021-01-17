@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')
    <section class="myProSection">
        <div class="top-bar">
            <div class="container">
                <h3>{{$project->title}} <!--<span>Started on 20.01.2020</span>--></h3>
                <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;"> Todder ID: 1234t3214</h5>
                <!-- <h5>Project Status :{{$project->status}}</h5> -->
                @if(!in_array($project->status, array(config('constants.project_status.COMPLETED'), config('constants.project_status.DISPUTE'))))
                    <a href="{{url('client/message/'.$project->id."/".$talent->todz_id)}}">  
                        <button type="button" class="messageBtn2">Message</button>
                    </a>

                    @php
    		            $allStatus = array(config('constants.project_status.HIRED'));
    		        @endphp
    		        @if(in_array($project->status, $allStatus))
                    	<button type="button" class="endProjectBtn" data-id="{{$project->id}}" data-toggle="modal" data-target="#escalationModal">End Project</button>
                    @endif

                    @switch(ProjectManager::isTodderHired($project->id,$talent->id))
                    @case(1)
                            <button type="button" class="messageBtn2 hired" >Hired</button>
                            @if($project->is_full_payment_escrow==0)
                            <button type="button" class="messageBtn2 remaing_payment" id="remaing-btn">Add Remaining Payment</button>
                            @endif
                        @break

                    @case(2)
                    <button type="button" class="messageBtn2 already_hired" >Already Another Hired</button>
                   
                        @break

                    @default
                    <button type="button" class="messageBtn2 not-hired-yet" id="hired-btn">hire</button>
                    @endswitch
                @endif
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-3">

                    <div class="project-tabs">
                        <h2>My Project</h2>
                        <ul class="nav nav-tabs" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" href="#overview " role="tab" data-toggle="tab">
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
                            <!-- <li class="nav-item">
                                <a class="nav-link" href="#deliverables" role="tab" data-toggle="tab">
                                    Deliverables
                                </a>
                            </li> -->
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
                        <div role="tabpanel" class="tab-pane fade show active" id="overview">
                            @include('web.client.dashboard.project-includes.overview')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="details">
                            <div class="projectDetails">
                                <h4>Title</h4>
                                <p>{{$project->title}}</p>
                                <h4>Description</h4>
                                <p>{{$project->description}}</p>
                                <ul class="overviewList">
                                    <li>
                                        <h4>Months</h4><p>{{$project->duration_month}}</p>
                                    </li>
                                    <li>
                                        <h4>Days</h4><p>{{$project->duration_day}}</p>
                                    </li>
                                    <li>
                                        <h4>Cost</h4><span><strong>USD</strong><p style="margin: 0;">{{$project->cost}}</p></span>
                                    </li>
                                </ul>
                                <h4>Project Brief File</h4>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="milestones">
                            @include('web.client.dashboard.project-includes.milestones')
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="deliverables">
                            <div class="milestoneTableDiv">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th scope="col">Milestone Name</th>
                                            <th scope="col">DUE DATE</th>
                                            <th scope="col">SUBMITTED ON </th>
                                            <th scope="col">Deliverables</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>Wireframing</th>
                                            <td>03/28/2020</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td><img src="images/" alt=""></td>
                                        </tr>
                                        <tr>
                                            <th>What is Lorem Ipsum?</th>
                                            <td>03/28/2020</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td><img src="images/" alt=""></td>
                                        </tr>
                                        <tr>
                                            <th>What is Lorem Ipsum?</th>
                                            <td>03/28/2020</td>
                                            <td>-</td>
                                            <td>-</td>
                                            <td><img src="images/" alt=""></td>
                                        </tr>
                                        <tr>
                                            <th>What is Lorem Ipsum?</th>
                                            <td>03/28/2020</td>
                                            <td>-</td>
                                            <td> - </td>
                                            <td><img src="images/" alt=""></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="timesheets">
                            @include('web.client.dashboard.project-includes.timesheets')
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="payment">
                            @include('web.client.dashboard.project-includes.payments')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<div id="escalationModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="max-width: 40%">
        <div class="modal-content">
            <h4 class="modal-title mt-2" style="text-align: center;">Close Project</h4>
            <div class="modal-body">
                <form method="post" name="escalationForm" id="escalationForm" onsubmit="addProjectCloseRecord()">
                    <div class="form-group request_type">
                        <label for="recipient-name" class="col-form-label">Request Type :</label>
                        <br>
                        <label>
                        	<input type="radio" name="request_type" value="complete"> Completed
                        </label> 
                        <label>
                        	<input type="radio" name="request_type" value="dispute" checked="true"> Dispute 
                        </label>
                        <span class="error"></span>
                    </div>

                    <div class="form-group rating completed_div" style="display: none;">
                    	<label for="recipient-name" class="col-form-label">Rating :</label>
                        <select class="form-control" name="rating" id="rating" required="true">
                        	@foreach(range(1,5) as $row)
                        		<option value="{{$row}}">{{$row}} Star</option>
                        	@endforeach
                        </select>
                        <span class="error"></span>
                    </div>
                    <input type="hidden" name="todz_id" value="{{$todz_id}}">
                    <!--<div class="form-group feedback completed_div" style="display: none;">
                        <label for="recipient-name" class="col-form-label">Feedback :</label>
                        <input type="text" class="form-control" name="feedback" required="true"> 
                        <span class="error"></span>
                    </div> -->

                    <div class="form-group reason reason_div">
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
    <!-- Congras modal -->
<div class="modal fade" id="congrasModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-body">
      {{-- <img src="{{asset('web/images/id_created.png')}}" alt=""> --}}
      <h4>Comment</h4>
      <form id="milestone-action">
          @csrf
      <textarea name="comment" class="form-control"></textarea>
      <br/>

        <input type="hidden" name="id" id="milestone_id" />
        <input type="hidden" name="status" id="milestone_status" />
    <button type="submit" id="con-btn" class="hover-ripple text-upper">continue</button>
      </form>
    </div>
    </div>
    </div>
</div>
@endsection
@section('footerScript')
@parent

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="{{asset('web/js/main.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/waitme.min.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/loader.js')}}"></script>
<script type="text/javascript">
    var PaymentPending = false;
</script>

@if(in_array($project->status, array(config('constants.project_status.HIRED'))))
    @switch(ProjectManager::isTodderHired($project->id,$talent->id))
        @case(1)
            @if($project->is_full_payment_escrow==0)
            	@if(\App\Models\ProjectPayment::where('project_id', $project->id)->count() ==2)
            	<script type="text/javascript">
                    PaymentPending = true;
                </script>
            	@endif
            @endif
        @break
    @endswitch
@endif

<script type="text/javascript">


    function approve_milestone(id,status)
    {
        if(PaymentPending){
            swal("Alert!", "Please add remaining payment.", "info");
            return false;
        }
        $("#milestone_id").val(id);
        $("#milestone_status").val(status);
        $("#con-btn").text(status==1?'Approve':'Reject');
        $('#congrasModal').modal('show');
    }
    $(document).on('submit','#milestone-action',function(e){
        e.preventDefault();
        $.ajax({
            type:'POST',
            url:'{{route("update_milestone_status")}}',
            data:$(this).serialize(),
            beforeSend:function(){
                startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success:function(response){
                if(response.status==1){
                    swal("Yeah!", response.Message, "success");
                    setTimeout(location.reload.bind(location), 3000);
                }else{
                  swal("Oops!", response.Message, "error");
                }
            },
            error:function(){
                stopLoader('body');
            }
        });
    });

    $(document).on('click','.acceptTimesheet',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        swal({
           title: "Sure",
           text: "Do you want to Accept/Reject this timesheet?",
           icon: "warning",
           buttons: true,
           dangerMode: false,
       })
       .then((willconfirm) => {
            if (willconfirm) {
                $.ajax({
                    type:'POST',
                    url:'{{route("update_timesheet_status")}}',
                    data:{
                        'id':id,
                        '_token':"{{ csrf_token() }}",
                        'status': 1
                    },
                    beforeSend:function(){
                        startLoader('body');
                    },
                    complete:function(){
                        stopLoader('body');
                    },
                    success:function(response){
                        if(response.status==1){
                            swal({title: "Status Changed", text: response.message, type: "success"}).then(function(){ 
                                location.reload();
                            });
                        }else{
                          swal("Oops!", response.message, "error");
                        }
                    },
                    error:function(){
                        stopLoader('body');
                    }
                });
            }
        });
    });

    $(document).on('click','.rejectTimesheet',function(e){
        e.preventDefault();
        var id = $(this).data('id');
        swal({
           title: "Sure",
           text: "Do you want to Reject this timesheet?",
           icon: "warning",
           buttons: true,
           dangerMode: false,
       })
       .then((willconfirm) => {
            if (willconfirm) {
                $.ajax({
                    type:'POST',
                    url:'{{route("update_timesheet_status")}}',
                    data:{
                        'id':id,
                        '_token':"{{ csrf_token() }}",
                        'status': 2
                    },
                    beforeSend:function(){
                        startLoader('body');
                    },
                    complete:function(){
                        stopLoader('body');
                    },
                    success:function(response){
                        if(response.status==1){
                            swal({title: "Status Changed", text: response.message, type: "success"}).then(function(){ 
                                location.reload();
                            });
                        }else{
                          swal("Oops!", response.message, "error");
                        }
                    },
                    error:function(){
                        stopLoader('body');
                    }
                });
            }
        });
    });

    $('input[type=radio][name=request_type]').change(function() {
    	var val = $(this).val();
    	$('.completed_div').hide();
    	$('.reason_div').show();
    	if (this.value == 'complete') {
    		$('.completed_div').show();
    		$('.reason_div').hide();
    	}
    });

    $(document).on('click','.endProjectBtn', function(){
        var $form = $('#escalationForm');
        $(document).find('span.error').empty();
        $('.add_escalationform_btn').prop('disabled', false);
        $('#escalationForm')[0].reset();
        $('.completed_div').hide();
    	$('.reason_div').show();
    	$('input[type=radio][name=request_type][value="dispute"]').prop('checked', true);
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
            url:'{{url("client/close-project")}}',
            data:formdata,
            processData: false,
            contentType: false,
            beforeSend:function(){
                startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success:function(response){
                stopLoader('body');
                if(response.status){
                    swal("Yeah!", response.message, "success");
                    $('#escalationForm')[0].reset();
                    $(document).find('span.error').empty();
                    $('.escalationform_dismiss').trigger('click');
                    window.location = response.url;
                }else{
                    swal("Oops!", response.message, "error");
                }
            },
            error: function(error){
                stopLoader('body');
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

/* rating */
     $(document).on('click','.add_escalationform_btn',function(e){
        e.preventDefault();
        var todz_id = $("input[name='todz_id']").val();
        var rating_number = $("#rating").val();
        //var request_type = $("input[name='request_type']").val();
        
         jQuery.ajax({
                    type:'POST',
                    url:'{{url("client/project")}}' + '/' + rating_number +'/'+todz_id +'/'+'sendRating',
                    data:{ 
                        "_token": "{{ csrf_token() }}",
                         'status': 1
                    },
                    success:function(response){
                        console.log(response); 
                        console.log(1); 
                        window.location = response.url;
                    },
                    error:function(){
                        console.log(0)
                    }
                });
    });
</script>

<script>
$("#hired-btn").on('click',function(){
   swal({
	   title: "Sure",
	   text: "Do you want to hire this todder?",
	   icon: "warning",
	   buttons: true,
	   dangerMode: false,
   })
   .then((willconfirm) => {
	   	if (willconfirm) {
	       jQuery.ajax({
				type:'POST',
				url:'{{url("client/hire_todder")}}',
	       		data:{ 
					"_token": "{{ csrf_token() }}",
					'project_id':'{{$project->id}}',
					'todz_id':'{{$talent->todz_id}}'
	        	},
                beforeSend:function(){
                    startLoader('body');
                },
                complete:function(){
                    stopLoader('body');
                },
	       		success:function(response){
	       			console.log(response);
                    stopLoader('body');
		           	if(response.status==1){
		           		swal({title: "Hired", text: response.msg, type: "success"}).then(function(){ 
							location.reload();
						});
		       		}else if(response.status==2){
		        		window.location.href=response.msg;
		       		}else{
		         		swal({title: "Oops!", text: response.msg, type: "error"});
		       		}
	       		},
                error:function(){
                    stopLoader('body');
                }
	   		});
		}
   	});
});

$("#remaing-btn").on('click',function(){
    swal({
       title: "Sure",
       text: "Do you want to escrow remaining payment?",
       icon: "warning",
       buttons: true,
       dangerMode: false,
    }).then((willconfirm) => {
        if (willconfirm) {
            jQuery.ajax({
                type:'POST',
                url:'{{url("client/add_remaining_payment")}}',
                data:{ 
                    "_token": "{{ csrf_token() }}",
                    'project_id':'{{$project->id}}',
                    'todz_id':'{{$talent->todz_id}}'
                },
                beforeSend:function(){
                    startLoader('body');
                },
                complete:function(){
                    stopLoader('body');
                },
                success:function(response)
                {
                    stopLoader('body');
                    if(response.status==1)
                    {
                        swal({title: "Hired", text: response.msg, type: "success"}).then(function(){ 
                            location.reload();
                        });
                    }else if(response.status==2){
                        window.location.href=response.msg;
                    }else{
                        swal({title: "Oops!", text: response.msg, type: "error"});
                    }
                },
                error:function(){
                    stopLoader('body');
                }
            });
        }
   });
});
</script>


@if(isset($_REQUEST['successPayment']))
<script>
    $( document ).ready(function() {

        swal({title: "Success",  text:'Thanks for making the payment don\'t worry we will keep the payment save in escrow', type: "success"});
        var currURL= window.location.href; //get current address

        //Get the URL between what's after '/' and befor '?' 
        //1- get URL after'/'
        var afterDomain= currURL.substring(currURL.lastIndexOf('/') + 1);
        //2- get the part before '?'
        var beforeQueryString= afterDomain.split("?")[0];  
        window.history.pushState('', "Milestone", beforeQueryString );
    });
    </script>
@endif

@if(in_array($project->status, array(config('constants.project_status.HIRED'))))

        @switch(ProjectManager::isTodderHired($project->id,$talent->id))
            @case(1)
                
                @if($project->is_full_payment_escrow==0 && ($ProjectDate >30))
                    <script type="text/javascript">
                        $( document ).ready(function() {
                            swal({
                               title: "Alert",
                               text: "Please add remaining payment",
                               icon: "warning",
                               dangerMode: false,
                               showCancelButton: false, // There won't be any cancel button
                            }).then((willconfirm) => {
                                jQuery.ajax({
                                    type:'POST',
                                    url:'{{url("client/add_remaining_payment")}}',
                                    data:{ 
                                        "_token": "{{ csrf_token() }}",
                                        'project_id':'{{$project->id}}',
                                        'todz_id':'{{$talent->todz_id}}'
                                    },
                                    beforeSend:function(){
                                        startLoader('body');
                                    },
                                    complete:function(){
                                        stopLoader('body');
                                    },
                                    success:function(response)
                                    {
                                        if(response.status==1)
                                        {
                                            swal({title: "Hired", text: response.msg, type: "success"}).then(function(){ 
                                                location.reload();
                                            });
                                        }else if(response.status==2){
                                            window.location.href=response.msg;
                                        }else{
                                            swal({title: "Oops!", text: response.msg, type: "error"});
                                        }
                                    },
                                    error:function(){
                                        stopLoader('body');
                                    }
                                });
                            });
                        });
                    </script>
                @endif
            @break
        @endswitch
@endif
@endsection  
