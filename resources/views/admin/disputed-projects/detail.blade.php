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
                        <h4>Project Details</h4>
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Title</h3>
                                <p>{{$data->title ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-4">
                                <h3>Duration</h3>
                                <p>
                                    @if($data->duration_month > 0)
                                        {{$data->duration_month}} month
                                    @endif

                                    @if($data->duration_day > 0)
                                        {{$data->duration_day}} days
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-4">
                                <h3>Cost</h3>
                                <p>{{$data->cost ?? 0}}</p>
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