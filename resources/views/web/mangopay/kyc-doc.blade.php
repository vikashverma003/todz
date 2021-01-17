@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="profile-section">
    <div class="container">
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
    <form action="{{route('uploadKycDoc')}}" method="post"  enctype="multipart/form-data">
        @csrf
        <div class="row">
        
            <div class="col-md-6 offset-md-3">
                <div class="col-md-12">
                    <div class="form-group">
                        <select name="document_type" id="document_type" class="form-control" >
                            <option value="" selected="selected" disabled>Document Type</option>
                            @foreach($doc_type as $type)
                        <option value="{{$type}}">{{$type}}</option>
                            @endforeach
                        </select>
                    </div>
                     @if ($errors->has('document_type'))
                              <div class="alert alert-danger">
                                {!! $errors->first('document_type') !!}
                              </div>
                             @endif
            </div>
                <div class="col-md-12">
                        <div class="form-group">
                            <input type="file" class="form-control" id="file" placeholder="file" value="" name="file" >
                        </div>
                         @if ($errors->has('file'))
                              <div class="alert alert-danger">
                                {!! $errors->first('file') !!}
                              </div>
                             @endif
                </div>
                <div class="col-md-12">

                    <button type="submit" class="saveBtn active" id="submit"><i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><strong class="btn-content">Submit</strong></button>
</div>
            </div>
        </div>
    </form>
    </div>
</section>
<style>
    .modal-dialog.frstmdl-body {
  width: 409px;
}
button#submit.active {
  background: #f9d100;
 
}
button#submit.active strong {
  color: black;
 
}
.error {
  color: red;
  font-size: 13px;
}
.special_field{
    display:none;
}
    </style>
@endsection
@section('headerScript')
@parent

@endsection
@section('footerScript')
@parent

@endsection        