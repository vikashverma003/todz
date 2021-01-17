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
                    <h4 class="card-title">Edit FAQ</h4>
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{url('admin/faqs/'.$data->id)}}">
                        @csrf
                        <input type="hidden" name="id" value="{{$data->id}}">
                        <input type="hidden" name="_method" value="PUT">

                        <div class="form-group">
                            <label for="category"> Category</label>
                            <input type="text" name="category" class="form-control" id="category" placeholder="Category (Heading)" value="{{$data->category ?? old('category')}}" required />
                            @if ($errors->has('category'))
                                <div class="error">{{ $errors->first('category') }}</div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="service_name"> Title</label>
                            <input type="text" name="title" class="form-control" id="service_name" placeholder="Title" value="{{$data->title ?? old('title')}}" />
                            @if ($errors->has('title'))
                                <div class="error">{{ $errors->first('title') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="service_content">Content</label>
                            <textarea style="height:100px" name="content" class="form-control" id="content" placeholder="Content" />{{$data->content ?? old('content')}}</textarea>
                            @if ($errors->has('content'))
                                <div class="error">{{ $errors->first('content') }}</div>
                            @endif
                        </div>
                        
                        <button type="submit" class="btn own_btn_background mr-2">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>

@endsection