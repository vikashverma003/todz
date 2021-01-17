@extends('web.layouts.app')
@section('title', 'Payment Safety')
@section('content')
<section class="thankyou-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Payment Safety</h2>
                <div class="main-content editor-content">
                    {!! $data !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection