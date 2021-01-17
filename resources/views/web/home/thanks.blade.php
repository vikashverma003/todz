@extends('web.layouts.app')
@section('title', __('messages.header_titles.HOME'))

@section('content')
<section class="thankyou-section">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2>THANK YOu!</h2>

                <div class="main-content">
                    <img src="http://clipart-library.com/images_k/check-mark-transparent-gif/check-mark-transparent-gif-14.png"
                        width="172" height="110" />
                    <h4>Thanks you have completed online exam.
                        Admin will review your result and update profile completion step.</h4>
                    </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('footerScript')
@parent

@endsection