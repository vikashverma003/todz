@extends('web.layouts.app')
@section('title', __('messages.header_titles.HOME'))

@section('content')

<section class="categories-details">
    <div class="container">
        <div class="row">
            <div class="col-md-12 offset-md-0">
                @if(session()->has('error'))
    <div class="alert alert-warning">
        {{ session()->get('error') }}
    </div>
@endif
            <form action="{{route('create_payment_link')}}" method="post">
                @csrf
                <select name="card_type">
                    <option >CB_VISA_MASTERCARD</option>
                    <option >DINERS</option>
                    <option >MASTERPASS</option>
                    <option >MAESTRO</option>
                    <option >P24</option>
                    <option >IDEAL</option>
                    <option >BCMC</option>
                    <option >PAYLIB</option>
                </select>
                <input type="text" name="amount" value="" placeholder="Amount">
                <input type="submit" name="submit" />
            </div>
        </div>
    </div>
</section>

@endsection
@section('headerScript')
@parent

@endsection
@section('footerScript')
@parent

@endsection