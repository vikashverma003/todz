@extends('web.layouts.app')
@section('title', __('messages.header_titles.PROJECT.CREATE'))

@section('content')

<section class="summary-section header-mt">
    <div class="container">
        <div class="row">
            <div class="offset-md-2 col-md-8">
                <div class="row wizzard-form">
                    <div class="col-md-4 text-center">
                        <p class="active">Post Project</p>
                        <span class="dot-wizzard active"></span>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="active">Select Talents</p>
                        <span class="dot-wizzard active"></span>
                    </div>
                    <div class="col-md-4 text-center">
                        <p class="active">Summary</p>
                        <span class="dot-wizzard active"></span>
                    </div>
                    <div class="col-md-12">
                        <div class="form-wizard">
                            <div class="line-colored third"></div>
                        </div>
                    </div>
                </div>

                <div class="summaryDiv">
                <h3>Project Details
                    <!-- <a href="{{route('project.index')}}">EDIT</a> -->
                </h3>

                    <h6>Title</h6>
                    <p>{{$inCompletedProject->title}}</p>

                    <h6>Description</h6>
                    <p>{{$inCompletedProject->description}}
                    </p>
                    <ul class="overviewList">
                        <li>
                            <h6>Months</h6>
                            <p>{{$inCompletedProject->duration_month}}</p>
                        </li>
                        <li>
                            <h6>Days</h6>
                            <p>{{$inCompletedProject->duration_day}}</p>
                        </li>
                        <li>
                            <h6>Cost</h6>
                            <span>
                                <strong>USD</strong>
                                <p style="margin: 0;">{{$inCompletedProject->cost}}</p>
                            </span>
                        </li>
                    </ul>
                    <h6>Talents Required</h6>
                   @foreach($inCompletedProject->skills as $skill)
                    <div class="talentDiv">
                        {{$skill->name}}
                    </div>
                    @endforeach

                    <h6>Project Brief File</h6>
                    @foreach($inCompletedProject->files as $file)
                    <span>
                    <a href="{{$file->file_full_path}}"><img src="{{$file->document_image}}" style="width:30px">{{$file->file_name}}</a>
                    </span>
                    @endforeach

                <h3>Talents Selected <a href="{{route('step_2')}}">EDIT</a></h3>
                    <ul class="talentList">
                        @foreach($inCompletedProject->talents as $user)
                       
                        <li>
                            {{-- <input id="talentN{{$user->id}}" type="checkbox" name="talents[]"  value="{{$user->id}}" /> --}}
                            <label for="talentN{{$user->id}}">
                                <h2>
                                    <img src="{{asset('web/images/ic_user.png')}}" alt="">
                                    Toddler ID: {{$user->todz_id}}
                                    <span>
                                        <img src="{{asset('web/images/Star_review.png')}}" alt="">
                                        4.5
                                    </span>
                                </h2>
                            <h1>{{$user->talent->job_title}}</h1>
                                <h4>
                                    <img src="{{asset('web/images/ic_work_experience.png')}}" alt="">
                                    {{$user->talent->work_experience}} years experience
                                </h4>
                                <h4>
                                    <img src="{{asset('webimages/ic_project_completed.png')}}" alt="">
                                    0 projects completed
                                </h4>
                                <h5>
                                    Availability: <strong>{{date('d F Y',strtotime($user->talent->available_start_date))}}- {{date('d F Y',strtotime($user->talent->available_end_date))}}</strong>
                                </h5>
                                <h5>
                                    Days: <strong> {{$user->talent->working_type}} days / week </strong>
                                </h5>
                                <h5>
                                    Hours: <strong> {{$user->talent->hours}} hours / day </strong>
                                </h5>
                            </label>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="form-group">
                    <form method="post" id="post_project">
                        @csrf
                    <button type="submit" name="post_project" class="theme-button active next-btn hover-ripple mb-4 mt-4 text-upper mr-3"> <i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><span class="btn-content">POST
                        PROJECT</span></button>
                    <!-- <button type="submit" name="cancel" class="theme-button tranaparent-btn hover-ripple mb-4 mt-4 text-upper" disabled>Cancel</button> -->
                    </form>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Congras modal -->
<div class="modal fade" id="congrasModal" tabindex="-1" role="dialog" aria-labelledby="basicModal"
aria-hidden="true">
<div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-body">
      <img src="{{asset('web/images/id_created.png')}}" alt="">
      <h4>Project Posted!</h4>
      <p class="tod_z_message">Congratulations your project has been posted successfully! You will be able to communicate  to the talent once they accept your project invite!</p>
      <a href="{{route('client_dashboard')}}" ><button class="hover-ripple text-upper">continue</button></a>
    </div>
  </div>
</div>
</div>
@endsection

@section('footerScript')
@parent
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<script>
  
  $(document).ready(function(){
	 $(document).on("submit","#post_project",function($e){
    
     $e.preventDefault();
     $(".loader-icon").show();
     $(".btn-content").hide();
		   $.ajax({
            type:'POST',
            url:'{{route("step_3")}}',
            data:{ "_token": "{{ csrf_token() }}"},
            success:function(response){
                $(".loader-icon").hide();
     $(".btn-content").show();
           //  var res= JSON.parse(response);
            if(response.status==1){
              $('#congrasModal').modal('show');
            }else{
              swal("Oops!", response.Message, "error");
            }
            }
        });
	 });
  });
  </script>
@endsection