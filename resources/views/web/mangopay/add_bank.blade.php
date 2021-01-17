@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="profile-section">
    <div class="container">
        <div class="row">
            
            <div class="col-md-10 offset-md-1">
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
                <div class="profile-data" style="border-radius: 8px;">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">


                            <h4>Add Bank Account</h4>
                        <form method="post" action="{{route('save_bank_detail')}}">
                                @csrf
                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select name="BankAccountType" id="BankAccountType" class="form-control custom" required>
                                            <option value="" selected="selected" disabled>Bank Account Type</option>
                                            @foreach($bankAcType as $type)
                                        <option value="{{$type}}">{{$type}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                            </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="Tag" placeholder="Tag" value="" name="Tag" required>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" class="form-control" id="AddressLine1" placeholder="Enter AddressLine1" name="AddressLine1" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" class="form-control" id="AddressLine2" placeholder="Enter AddressLine2" name="AddressLine2" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" class="form-control" id="City" placeholder="Enter City" name="City" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" class="form-control" id="Region" placeholder="Enter Region" name="Region" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">

                                        <input type="text" class="form-control" id="PostalCode" placeholder="Enter PostalCode" name="PostalCode" >
                                    </div>
                                </div>

                                <div class="col-md-6 ">
                                    <div class="form-group">
                                       
                                        <select name="Country" class="form-control custom" required>
                                            <option value="" selected="selected" disabled>Country</option>
                                            @foreach($countries as $con)
                                        <option value="{{$con->country_code}}">{{$con->country_name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="OwnerName" placeholder="Enter Name" name="OwnerName" required>
                                    </div>
                                </div>


                                <div class="col-md-6 special_field IBAN" >
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="IBAN" placeholder="Enter IBAN" name="IBAN" >
                                    </div>
                                </div>
                                <div class="col-md-6 special_field IBAN OTHER">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="BIC" placeholder="Enter BIC" name="BIC" >
                                    </div>
                                </div>
                             
                               
                             

<div class="col-md-6 special_field US CA GB OTHER">
    <div class="form-group">
        <input type="text" class="form-control" id="AccountNumber" placeholder="Enter AccountNumber" name="AccountNumber" >
    </div>
</div>
<div class="col-md-6 special_field US">
    <div class="form-group">
        <input type="text" class="form-control" id="ABA" placeholder="Enter ABA" name="ABA" >
    </div>
</div>
<div class="col-md-6 special_field US">
    <div class="form-group">
        <input type="text" class="form-control" id="DepositAccountType" placeholder="Enter DepositAccountType" name="DepositAccountType" >
    </div>
</div>


<div class="col-md-6 special_field CA">
    <div class="form-group">
        <input type="text" class="form-control" id="InstitutionNumber" placeholder="Enter InstitutionNumber" name="InstitutionNumber" >
    </div>
</div>
<div class="col-md-6 special_field CA">
    <div class="form-group">
        <input type="text" class="form-control" id="BranchCode" placeholder="Enter BranchCode" name="BranchCode" >
    </div>
</div>
<div class="col-md-6 special_field CA">
    <div class="form-group">
        <input type="text" class="form-control" id="BankName" placeholder="Enter BankName" name="BankName" >
    </div>
</div>



<div class="col-md-6 special_field GB">
    <div class="form-group">
        <input type="text" class="form-control" id="SortCode" placeholder="Enter SortCode" name="SortCode" >
    </div>
</div>

<div class="col-md-12">

                            <button type="submit" class="saveBtn active" id="submit"><i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><strong class="btn-content">Add Bank Account</strong></button>
</div>
                        </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<style>
    .modal-dialog.frstmdl-body {
  width: 409px;
}
button#submit.active {
  background: #f9d100;
 
}
button#submit.active strong {
  color: black;
 
}
.error {
  color: red;
  font-size: 13px;
}
.special_field{
    display:none;
}
    </style>


@endsection
@section('headerScript')
@parent

@endsection
@section('footerScript')
@parent
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $( function() {
        $( "#Birthday" ).datepicker();
      });
      $(document).on('change','#BankAccountType',function(){
          var type=$(this).val();
          $(".special_field").hide();
          $("."+type).show();
      })
</script>
@endsection        