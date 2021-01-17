@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
   <div class="row">
        <div class="col-md-11 grid-margin stretch-card">
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
                    <h4 class="card-title">Update Comission & Charges</h4>
                  
                    <form class="forms-sample" method="post" enctype="multipart/form-data" action="{{url('admin/comission')}}">
                    @csrf
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="service_name"> <strong>Project Comission %</strong></label>
                                    <input type="number" min="0" max="100" name="project_comission" class="form-control" id="project_comission" placeholder="Project Comission" value="{{$com->project_comission??old('project_comission')}}" required />
                                    @if ($errors->has('project_comission'))
                                        <div class="error">{{ $errors->first('project_comission') }}</div>
                                    @endif
                                </div>
                            </div>


                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="service_name"><strong> Payment Gateway Fee %</strong></label>
                                    <input type="text" min="0" max="100" name="payment_gateway_fee" class="form-control" id="payment_gateway_fee" placeholder="Payment Gateway Fee" value="{{$com->payment_gateway_fee ?? old('payment_gateway_fee')}}" required />
                                    @if ($errors->has('payment_gateway_fee'))
                                        <div class="error">{{ $errors->first('payment_gateway_fee') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="service_name"> <strong>VAT %</strong></label>
                                    <input type="text" name="vat" class="form-control" id="vat" placeholder="VAT" value="{{$com->vat ?? old('vat')}}" required />
                                    @if ($errors->has('vat'))
                                        <div class="error">{{ $errors->first('vat') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="form-group">
                                    <label for="service_name"> <strong>VAT Number</strong></label>
                                    <input type="text" name="vat_number" class="form-control" id="vat_number" placeholder="VAT Number" value="{{$com->vat_number ?? old('vat_number')}}" required />
                                    @if ($errors->has('vat_number'))
                                        <div class="error">{{ $errors->first('vat_number') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                    <button type="submit" class="btn btn-success own_btn_background mr-2">Update</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection