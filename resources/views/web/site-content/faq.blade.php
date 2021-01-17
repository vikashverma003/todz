@extends('web.layouts.app')
@section('title', __('messages.header_titles.FAQ'))
@section('content')
<section class="thankyou-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>FAQs</h2>
                <div class="main-content">
                    @php
                        $vendor_selected = $_GET['category'] ?? '';
                    @endphp
                    <div class="row mb-2">
                        <div class="col-md-4 text-left">
                            <label>Select FAQs Category</label>
                            <select name="category" id="category" class="form-control">
                                <option value="">All</option>
                                @foreach($categories as $row)
                                    <option value="{{$row->category}}" @if($vendor_selected==$row->category) selected @endif>{{$row->category}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="accordion" id="accordionExample">
                        @foreach($data as $key=>$value)
                         <div class="card">
                            <div class="card-header" id="heading{{$key}}">
                                <h5 class="mb-0">
                                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse{{$key}}" aria-expanded="true" aria-controls="collapse{{$key}}">
                                    {{$value->title}}
                                    </button>
                                </h5>
                            </div>
                            <div id="collapse{{$key}}" class="collapse" aria-labelledby="heading{{$key}}" data-parent="#accordionExample">
                                <div class="card-body text-left">
                                    {!! $value->content !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('footerScript')
@parent
<script type="text/javascript">
    $(document).ready(function(){

        $("#category").on("change",function(e){
            let selectValue=$(this).val();
            var url = window.location.href.split('?')[0];    
            if (url.indexOf('?') > -1){
               url += '&category='+selectValue
            }else{
               url += '?category='+selectValue
            }
            window.location.href = url;
        });
    });
</script>
@endsection