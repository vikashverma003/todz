@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
@php
$type = isset($data['type'])?$data['type']:'';
@endphp
<div class="content-wrapper">
   <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-toggle=tab  href="#client_reviews" id="client_reviews_tab">Client</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle=tab  href="#talent_reviews" id="talent_reviews_tab">Talent</a>
      </li>
    </ul>
    <div class="tab-content" style="margin:0;padding:0">

 <input type="hidden" name="user_type" id="user_type" value="{{$type}}">
<div id="client_reviews" class="container tab-pane active"><br>
   <div class="row">
      <div class="col-lg-12 stretch-card">
     
         <div class="card">
            <div class="card-body">
            @if (\Session::has('success'))
                  <div class="alert alert-success">
                     {!! \Session::get('success') !!}
                  </div>
                @endif
                @if (\Session::has('error'))
                  <div class="alert alert-danger">
                     {!! \Session::get('error') !!}
                  </div>
                @endif
               <h4 class="card-title">Client Reviews</h4>
           
               {{-- <div class="table-responsive"> --}}
                  <div >
                  <table class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Talent</th>
                           <th>Project Id</th>
                           <th>Rating</th>
                           <th>Review</th>
                           <th>Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @if(!$client_reviews->isEmpty())
                        @foreach ($client_reviews as $review)
                        <tr>
                            <td>{{$key++}}</td>
                            <td><a href="{{url('admin/talents/'.$review->given_by_user_id.'/edit')}}">{{$review->givenByUser->first_name}} {{$review->givenByUser->last_name}}</a></td>
                            <td><a href="{{url('admin/projects/'.$review->project_id)}}"><span class="badge badge-danger">PR_{{@$review->project_id}}</span></a></td>
                            <td>{{$review->rating}}/5</td>
                            <td>{{$review->feedback}}</td>
                          </tr>
                        @endforeach
                        @else
                        <tr>
                           <td colspan="7" style="text-align:center">No review record exist</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  {{ $client_reviews->appends(['type'=>config('constants.role.CLIENT')])->render() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="talent_reviews" class="container tab-pane"><br>
   <div class="row">
      <div class="col-lg-12 stretch-card">
     
         <div class="card">
            <div class="card-body">
            @if (\Session::has('success'))
                  <div class="alert alert-success">
                     {!! \Session::get('success') !!}
                  </div>
                @endif
                @if (\Session::has('error'))
                  <div class="alert alert-danger">
                     {!! \Session::get('error') !!}
                  </div>
                @endif
               <h4 class="card-title">Talent Reviews</h4>
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>#</th>
                           <th>Client</th>
                           <th>Project Id</th>
                           <th>Rating</th>
                           <th>Review</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @if(!$talent_reviews->isEmpty())
                        @foreach ($talent_reviews as $review)
                        <tr>
                            <td>{{$key++}}</td>
                           <td><a href="{{url('admin/clients/'.$review->given_by_user_id.'/edit')}}">{{$review->givenByUser->first_name}} {{$review->givenByUser->last_name}}</a></td>
                             <td><a href="{{url('admin/projects/'.$review->project_id)}}"><span class="badge badge-danger">{{@$review->project_id}}</span></a></td>
                            <td>{{$review->rating}}/5</td>
                            <td>{{$review->feedback}}</td>
                          </tr>
                        @endforeach
                        @else
                        <tr>
                           <td colspan="7" style="text-align:center">No review record exist</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  {{ $talent_reviews->appends(['type'=>config('constants.role.TALENT')])->render() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


</div>
</div>

@endsection
@section('footerScript')
@parent

<script>
  $(document).ready(function(){
     var type = $('#user_type').val();
     if(type == config('constants.role.CLIENT'))
     {
      $( "#client_reviews_tab" ).trigger( "click" );
     }
      else if(type == config('constants.role.TALENT'))
      {
        $( "#talent_reviews_tab" ).trigger( "click" );
      }
   });
   $(document).ready(function(){
     $(".nav-tabs a").click(function(){
       $(this).tab('show');
     });
   });
</script>

   @endsection