@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="profile-data" style="border-radius: 8px;margin:auto;width:95% !important;">
            <div class="col-md-12  grid-margin stretch-card">
                <div class="row">
                   <div class="col-md-12">
                        <h4>Transaction Details</h4>
                   </div>
                   <div class="col-md-6">
                        <h3>Project Id</h3>
                        <p>{{$data->project_id ?? 'N/A'}}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>From User Id</h3>
                        <p>{{$data->from_user_id ?? 'N/A'}}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>To User Id</h3>
                        <p>{{$data->to_user_id ?? 'N/A'}}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Payment Type</h3>
                        <p>{{$data->payment_type ?? 'N/A'}}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Amount</h3>
                        <p>{{$data->amount ?? '0'}}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Fee</h3>
                        <p>{{$data->fee ?? '0'}}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Transaction Id</h3>
                        <p>{{$data->transaction_id ?? '0'}}</p>
                    </div>
                    <div class="col-md-6">
                        <h3>Transaction Date</h3>
                        <p>{{$data->created_at ?? 'N/A'}}</p>
                    </div>

                    <div class="col-md-12" style="max-width: 90%;overflow-x: scroll;word-break: break-all;">
                        <h4>Transaction Response Json</h4>
                        <p>{{$data->response_json ?? 'N/A'}}</p>
                   </div>
                </div>
            </div>
        </div>
   </div>
</div>
@endsection