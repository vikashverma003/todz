@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
   <div class="row">
   <div class="col-md-8 offset-md-2 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                @if (\Session::has('error'))
                  <div class="alert alert-danger">
                     {!! \Session::get('error') !!}
                  </div>
                @endif
                  <h4 class="card-title">Edit Review</h4>
                  
                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{route('update_review')}}">
                  @csrf
                  <input type="hidden" name="review_id" value="{{$review->id}}">
                    <div class="form-group">
                      <label for="rating"> Rating</label>
                      <input type="integer" name="rating" class="form-control" id="rating" placeholder="Rating" value="{{$review->rating}}" required />
                    @if ($errors->has('rating'))
                    <div class="error">{{ $errors->first('rating') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="feedback">Review</label>
                      <textarea style="height:100px" name="feedback" class="form-control" id="feedback" placeholder="Review" >{{$review->feedback}}</textarea>
                    @if ($errors->has('feedback'))
                    <div class="error">{{ $errors->first('feedback') }}</div>
                    @endif
                    </div>
                    <button type="submit" class="btn own_btn_background mr-2">Update</button>
                  </form>
                </div>
              </div>
            </div>
   </div>
</div>
@endsection