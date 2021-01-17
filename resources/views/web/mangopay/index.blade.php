@extends('web.layouts.app')
@section('title', __('messages.header_titles.DASHBOARD'))

@section('content')

<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-10 offset-md-1">

                <div class="profile-data" style="border-radius: 8px;">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">


                            <h4>Create User on MangoPay</h4>
                        <form method="post" action="{{route('create_wallet')}}">
                                @csrf
                          
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="FirstName" placeholder="Enter First Name " value="{{$user->first_name}}" name="FirstName" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="LastName" placeholder="Enter Last Name" value="{{$user->last_name}}" name="LastName" required>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="AddressLine1" placeholder="Enter Address Line 1 " name="AddressLine1" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="AddressLine2" placeholder="Enter Address Line 2" name="AddressLine2" >
                                        </div>
                                </div>



                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="City" placeholder="Enter City" name="City" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="Region" placeholder="Enter Region" name="Region" required>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="PostalCode" placeholder="Enter PostalCode" name="PostalCode" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                        <input type="text" class="form-control" id="Birthday" placeholder="Enter Birthday" name="Birthday" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="Occupation" placeholder="Enter Occupation" name="Occupation" required>
                                        </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="IncomeRange" placeholder="Enter IncomeRange" name="IncomeRange" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                        <div class="form-group">
                                        <input type="text" class="form-control" value="{{$user->email}}" id="Email" placeholder="Enter Email" name="Email" required>
                                        </div>
                                </div>
                            <button type="submit" class="saveBtn active" id="submit"><i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><strong class="btn-content">Submit</strong></button>
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
        //$( "#Birthday" ).datepicker();
          $( "#Birthday" ).datepicker({  maxDate: 0 });

      });
</script>
@endsection        