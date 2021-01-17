@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)


@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-10 grid-margin stretch-card">
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

                    <h3 style="text-align: center;">Payment Information</h3>
                    <hr>
                    <h5>Wallet Information</h5>
                    @if(is_null($currentUser->mangopayUser))
                        <p>Note: No Payment wallet addet yet.</p>
                        <a href="{{route('add_user')}}"><button type="button" class="saveBtn active own_btn_background">Add Payment Wallet</button></a>
                    @else
                        <div class="row">
                            <div class="col-md-4">
                                <h5>Balance</h5>
                                <p><img src="{{asset('web/images/tick.png')}}" alt="tick">{{$walletInfo->Balance->Currency}} {{$walletInfo->Balance->Amount/100}}</p>
                            </div>
                            <div class="col-md-4">
                                <h5>Mangopay Account User Id</h5>
                                <p><img src="{{asset('web/images/tick.png')}}" alt="tick"> {{$currentUser->mangopayUser->mangopay_user_id}}</p>
                            </div>
                            <div class="col-md-4">
                                <h5>Mangopay Account Wallet Id</h5>
                                <p><img src="{{asset('web/images/tick.png')}}" alt="tick"> {{$currentUser->mangopayUser->mangopay_wallet_id}}</p>
                            </div>
                        </div>
                    @endif
                    <br>
                    <div class="line-bottom"></div>
                    <hr>
                    <h5>KYC Documents</h5>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!is_null(@$kycDoc))
                                @foreach(@$kycDoc as $kyc)
                                    <tr>
                                        <td>{{$kyc->Id}}</td>
                                        <td>{{$kyc->Type}}</td>
                                        <td>{{@$kyc->Status}}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" style="text-align: center;">No Document uploaded yet.</td></tr>
                            @endif
                        </tbody>
                    </table>
                    <br/>
                    <a href="{{route('kyc_doc')}}"><button type="button" class="saveBtn active">Upload KYC Document</button></a>
                    <br/>
                    <hr>
                    <h5>Bank Accounts</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Owner Name</th>
                                <th>Bank Type</th>
                                <th>IBAN</th>
                                <th>Account No</th>
                                <th>Active</th>
                            </tr>
                        </thead>
                        <tbody>
                        @if(!is_null(@$bankAccounts))
                            @foreach($bankAccounts as $bank)
                                <tr>
                                    <td>{{$bank->OwnerName}}</td>
                                    <td>{{$bank->Type}}</td>
                                    <td>{{@$bank->IBAN}}</td>
                                    <td>{{@$bank->AccountNumber}}</td>
                                    <td>{{$bank->Active}}</td>
                                </tr>
                            @endforeach
                         @else
                            <tr><td colspan="6" style="text-align: center;">No Bank Account added yet.</td></tr>
                        @endif
                        </tbody>
                    </table>
                    <br/>
                    @if(!$bankAccounts)
                        <a href="{{route('add_bank')}}"><button type="button" class="saveBtn active">Add Bank Account</button></a>
                    @endif  
                </div>
            </div>
        </div>
   </div>
</div>
@endsection