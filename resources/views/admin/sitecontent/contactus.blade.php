@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        {!! \Session::get('error') !!}
                    </div>
                    @endif
                    @if (\Session::has('success'))
                    <div class="alert alert-success">
                        {!! \Session::get('success') !!}
                    </div>
                    @endif
                    <h4 class="card-title">Content</h4>
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{url('admin/save-contactus')}}">
                        @csrf
                        <div class="form-group">
                            <label for="service_content">Content</label>
                            <textarea style="height:100px" name="content" class="form-control" id="content" placeholder="Content" />{{$content ?? old('content')}}</textarea>
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