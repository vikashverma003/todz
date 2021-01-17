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
                  <h4 class="card-title">Add Brand</h4>
                  
                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{url('admin/brands')}}">
                  @csrf
                    <div class="form-group">
                      <label for="service_name"> Name</label>
                      <input type="text" name="name" class="form-control" id="service_name" placeholder="category Name" value="{{old('name')}}" required />
                    @if ($errors->has('name'))
                    <div class="error">{{ $errors->first('name') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="service_description">Description</label>
                      <textarea style="height:100px" name="description" class="form-control" id="service_description" placeholder="Description" />{{old('description')}}</textarea>
                    @if ($errors->has('description'))
                    <div class="error">{{ $errors->first('description') }}</div>
                    @endif
                    </div>
                  
                    
                  <div class="form-group">
                      <label>Brand Image</label>
                      <input type="file" name="service_image" class="file-upload-default" accept="image/*"  onchange="readURL(this);" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" >
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      @if ($errors->has('service_image'))
                        <div class="error">{{ $errors->first('service_image') }}</div>
                    @endif
                    <img id="blah" style="display:none" src="" alt="service Image" style="margin-top:10px;border:3px solid #3bc3c4" />
                    </div>
                    <button type="submit" class="btn own_btn_background mr-2">Save</button>
                  </form>
                </div>
              </div>
            </div>
   </div>
</div>
<script>
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah')
                    .attr('src', e.target.result)
                    .width(200)
                    .height('auto')
                    .css({'display':'block',"margin-top":"10px","border":"3px solid #3bc3c4"});
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
    </script>
@endsection