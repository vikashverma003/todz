@extends('web.layouts.app')
@section('title', __('messages.header_titles.PROJECT.CREATE'))

@section('content')

<section class="talent-section header-mt">
  <div class="container">
      <div class="row">
          <div class="offset-md-2 col-md-8">
             
              <form method="post" id="project_create_form">
            
          @csrf
              <div class="select-talents">
                  <h3>Select Talents for your project</h3>
                  <p>Based upon the talents you require, we have the following Talent suggestions for you. You
                      can send job invitations to maximum 5 talents.</p>

                  <div style="display: flex; flex-wrap: wrap; align-items: center;margin-bottom: 15px;">
                      <h6>Sort By</h6>
                      <ul class="nav nav-tabs" role="tablist">
                          <li class="nav-item">
                              <a class="nav-link active" href="#rating" role="tab" data-toggle="tab">Rating <img
                                      src="{{asset('web/images/ic_arrow_black.png')}}" alt=""></a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#availability" role="tab" data-toggle="tab">Availability
                                  <img src="{{asset('web/images/ic_arrow_down.png')}}" alt=""></a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="#projects" role="tab" data-toggle="tab">No. of Projects
                                  <img src="{{asset('web/images/ic_arrow_black.png')}}" alt=""></a>
                          </li>
                      </ul>
                    <h6 style="margin-left: auto;opacity: 0.8;">Selected: <span id="count-todder">{{count($user_ids)}}</span>/5</h6>
                  </div>

                  <!-- Tab panes -->
                  <div class="tab-content">
                      <div role="tabpanel" class="tab-pane fade show active" id="rating">
                        <ul class="talentList">
                            @foreach($users as $user)
                            <li>
                            <input id="talentR{{$user->id}}" type="checkbox" name="talents[]" value="{{$user->id}}" {{in_array($user->id,$user_ids)?'checked="checked"':''}} />
                                <label for="talentR{{$user->id}}">
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
                                        <img src="{{asset('web/images/ic_project_completed.png')}}" alt="">
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
                      <div role="tabpanel" class="tab-pane fade" id="availability">
                        <ul class="talentList">
                            @foreach($users as $user)
                            <li>
                                <input id="talentA{{$user->id}}" type="checkbox" name="talents[]" value="{{$user->id}}"  />
                                <label for="talentA{{$user->id}}">
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
                                        <img src="{{asset('web/images/ic_project_completed.png')}}" alt="">
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
                      <div role="tabpanel" class="tab-pane fade" id="projects">
                        <ul class="talentList">
                            @foreach($users as $user)
                            <li>
                                <input id="talentN{{$user->id}}" type="checkbox" name="talents[]"  value="{{$user->id}}"  />
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
                                        <img src="{{asset('web/images/ic_project_completed.png')}}" alt="">
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
                  </div>
              </div>

              <div class="form-group">
                  <button id="submit" class="theme-button {{count($user_ids)?'active':''}} next-btn hover-ripple mb-4 mt-4 text-upper mr-3"  {{count($user_ids)?:'disabled'}}>Add</button>
                 <a href="{{route('client_dashboard')}}" class="theme-button tranaparent-btn hover-ripple mb-4 mt-4 text-upper">Cancel</a>
              </div>
            </form>
          </div>
      </div>
  </div>
</section>

@endsection

@section('footerScript')
@parent
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
     $(document).on('click','input[name="talents[]"]', function() {
        
        var valor = [];
    $('input[name="talents[]"]').each(function () {
        if (this.checked){
         if(valor.indexOf($(this).val()) < 0) {
            valor.push($(this).val());
              }
         }   
        });  
        if (valor.length > 5) {
           $(this).prop('checked', false);
       }else if (valor.length>0 ) {
           $("#count-todder").text(valor.length);  
           $('#submit').prop('disabled', false);  
           $('#submit').addClass('active');
       } else {
           $('#submit').prop('disabled', 'disabled');
           $('#submit').removeClass('active');
             $("#count-todder").text(valor.length);  
       }
    });

</script>

@endsection