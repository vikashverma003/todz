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
                  <h4 class="card-title">Edit Service</h4>
                  
                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{url('admin/skills/'.$skill->id)}}">
                    @method('PUT')
                  @csrf
                    <div class="form-group">
                      <label for="service_name"> Name</label>
                      <input type="text" name="name" class="form-control" id="service_name" placeholder="Name" value="{{$skill->name}}" required />
                    @if ($errors->has('name'))
                    <div class="error">{{ $errors->first('name') }}</div>
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