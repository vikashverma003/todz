@extends('web.layouts.app')
@section('title', 'Why Work With Us')
@section('content')
<section class="thankyou-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2>Why Work With Us</h2>
                <div class="main-content editor-content">
                    {!! $client !!}
                </div>
                <div class="main-content editor-content">
                    {!! $talent !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection