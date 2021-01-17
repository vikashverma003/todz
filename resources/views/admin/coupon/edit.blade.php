@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
   <div class="row">
   <div class="col-md-8 offset-md-2 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                @if (\Session::has('error'))
                  <div class="alert alert-danger">
                     {!! \Session::get('error') !!}
                  </div>
                @endif
                  <h4 class="card-title">Edit Coupon</h4>
                  
                  <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{url('admin/coupon/'.$coupon->id)}}">
                    @method('PUT')
                  @csrf
                    <div class="form-group">
                      <label for="service_name"> Name</label>
                      <input type="text" name="name" class="form-control" id="service_name" placeholder="Name" value="{{$coupon->name}}" required />
                    @if ($errors->has('name'))
                    <div class="error">{{ $errors->first('name') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="coupon_type">Coupon For</label>
                       <select name="coupon_type" id="coupon_type" class="form-control" required>
                            <option value="{{config('constants.COUPON_TYPE.BOTH')}}">Both (Client & Talent)</option>
                            <option value="{{config('constants.COUPON_TYPE.CLIENT')}}">Client</option>
                            <option value="{{config('constants.COUPON_TYPE.TALENT')}}">Talent</option>
                        </select>
                    @if ($errors->has('description'))
                    <div class="error">{{ $errors->first('description') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="service_name"> Coupon Code</label>
                      <input type="text" name="coupon_code" class="form-control" id="coupon_code" placeholder="Coupon Code" value="{{$coupon->code}}" readonly required />
                    @if ($errors->has('coupon_code'))
                    <div class="error">{{ $errors->first('coupon_code') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="coupon_value">Coupon Value (in %age)</label>
                      <input type="number" name="coupon_value" class="form-control" id="coupon_value" placeholder="Coupon Value" value="{{$coupon->coupon_value}}" min="0" max="100"  step="any" required />
                    @if ($errors->has('coupon_value'))
                    <div class="error">{{ $errors->first('coupon_value') }}</div>
                    @endif
                    </div>
                    <div class="form-group">
                      <label for="service_description">Description</label>
                      <textarea style="height:100px" name="description" class="form-control" id="service_description" placeholder="Description" >{{$coupon->description}}</textarea>
                    @if ($errors->has('description'))
                    <div class="error">{{ $errors->first('description') }}</div>
                    @endif
                    </div>
                    <button type="submit" class="btn own_btn_background mr-2">Update</button>
                  </form>
                </div>
              </div>
            </div>
   </div>
</div>
@endsection