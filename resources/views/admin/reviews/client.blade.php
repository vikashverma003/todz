@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">

    <div class="tab-content" style="margin:0;padding:0">
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
                             <td><a href="{{url('admin/clients/'.$review->given_by_user_id.'/edit')}}">{{$review->givenByUser->first_name}} {{$review->givenByUser->last_name}}</a></td>
                           <!-- {{$review->givenByUser->first_name}} {{$review->givenByUser->last_name}} -->
                            <td><a href="{{url('admin/projects/'.$review->project_id)}}"><span class="badge badge-danger">PR_{{@$review->project_id}}</span></a></td>
                            <td>{{$review->rating}}/5</td>
                            <td>{{$review->feedback}}</td>
                             <td>
                                <a class="action-button" href="{{route('edit_review',$review->id)}}" data-toggle="tooltip" title="Edit">
                                <i class=" icon-pencil menu-icon"></i>
                                <span class="menu-title"></span>
                                </a>
                                 <a class="action-button" href="{{route('delete_review',$review->id)}}" data-toggle="tooltip" title="Edit">
                                <i class=" icon-trash menu-icon"></i>
                                <span class="menu-title"></span>
                                </a>
                              </td>
                            </tr>
                        @endforeach
                        @else
                        <tr>
                           <td colspan="7" style="text-align:center">No review record exist</td>
                        </tr>
                        @endif
                     </tbody>
                  </table>
                  {{ $client_reviews->render() }}
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
     $(".nav-tabs a").click(function(){
       $(this).tab('show');
     });
   });
</script>

   @endsection