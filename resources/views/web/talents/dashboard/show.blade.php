@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="details_section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="detailsDiv">
                    <h2>Project Details <span>posted on {{date("d M' Y",strtotime($invitedProject->created_at))}}</span></h2>
                    <div style="padding: 13px 20px;">
                    <h3>{{$invitedProject->title}}</h3>
                        <h4>Description</h4>
                        <p>{{$invitedProject->description}}</p>
                        <div class="line-bottom"></div>
                        <h4>Skills Required</h4>
                        @foreach($invitedProject->skills as $skill)
                        <div class="talentDiv">
                            {{$skill->name}}
                        </div>
                        @endforeach
                        <div class="line-bottom" style="margin-top: 0px;"></div>
                        <h4>Project Brief File</h4>
                     
                        @foreach($invitedProject->files as $file)

                     
                            <a href="{{$file->file_full_path}}"><img src="{{$file->document_image}}" style="width:30px">{{$file->file_name}}</a>
                          <br/>     
                        @endforeach
                        <div class="line-bottom"></div>
                        <h4>Project Owner</h4>
                        <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px;"> Project Owner ID:
                            {{$invitedProject->client->temp_todz_id}}</h5>
                            <h5> <img src="{{asset('web/images/ic_user1.png')}}" alt="" style="padding-right: 6px; visibility:hidden"> 
                                Project ID:
                                {{config('constants.PROJECT_ID_PREFIX')}}{{$invitedProject->id}}</h5>
                            
                        {{--   @if($invitedProject->isApplied()==1) --}}
                            <a href="{{url('talent/message/'.$invitedProject->id.'/'.$invitedProject->client->todz_id)}}">
                                <button type="button" class="messageBtn chatenabled">Message</button></a>
                                {{-- @else
                                <button type="button" class="messageBtn">Message</button>
                                @endif --}}
                        <h6>( <strong>Please note:</strong> Accepting a job invite doesn’t mean that you have been
                            hired
                            for the job. Once you accept the job invite you will be able to message the project
                            owner. )
                        </h6>
                        @if($invitedProject->isApplied()==0)
                        <div class="line-bottom"></div>
                        <div class="row">
                            <div class="col-md-4">
                                <form action="{{route('reject_action')}}" method="post">
                                    @csrf
                                    <input type="hidden" name="project_id" value="{{$invitedProject->id}}">
                                    <button type="submit" class="rejectBtn">Reject</button>

                                </form> 
                                
                            </div>
                            <div class="col-md-4">
                                <button type="button" class="acceptBtn AcceptButton" data-id="{{$invitedProject->id}}">Accept</button>
                               
                            </div>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@include('web.includes.todder-popup')
@endsection
@section('footerScript')
@parent
@include('web.includes.todder-popup-script')

@endsection  