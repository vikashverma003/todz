@extends('web.layouts.app')
@section('title','Error')
@section('content')
<section class="login-section email-verification header-mt">
    <div class="container">
        <div class="row">
            <div class="col-md-5">
                <h3 class="mb-2">Error</h3>
                
                <div class="row">
                    <div class="col-md-12">
                        <p>{{$message ?? 'Something went wrong.'}}</p>
                        <a href="{{url('/')}}">Click Here</a> to visit site.
                    </div>
                </div>
            </div>
            <div class="offset-md-2 col-md-5">
                <img class="img-fluid dp-block mx-auto" src="{{asset('web/images/login-bannar.png')}}">
            </div>
        </div>
    </div>
</section>
@endsection