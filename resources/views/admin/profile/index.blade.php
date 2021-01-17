@extends('admin.layouts.app')
@section('title','Project Details')
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="profile-data" style="border-radius: 8px;margin:auto;width:90% !important;">
            <div class="col-md-12  grid-margin stretch-card">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <h4><strong>Personal Details</strong></h4>
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Name</h3>
                                <p>{{$currentUser->first_name}} {{$currentUser->last_name}}</p>
                            </div>

                            <div class="col-md-4">
                                <h3>Email</h3>
                                <p>{{$currentUser->email}}</p>
                            </div>
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
</style>
@endsection