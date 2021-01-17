@extends('web.layouts.app')
@section('title','Profile')
@section('content')
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
            </div>
            <div class="col-md-3">
                <div class="profile-tabs">
                    @if(!is_null($currentUser->user_image))
                        <span><img src="{{asset($currentUser->user_image)}}" alt="" class="profileImg2"></span>
                    @else
                    <br>
                    <div class="first_letter" style="margin-left:auto;margin-right:auto;"><span style="line-height: 1;">{{substr($currentUser->first_name,0,1)}}</span></div>
                    @endif
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" href="#basicDetails" role="tab" data-toggle="tab">
                            Basic Details
                            </a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="#reviews" role="tab" data-toggle="tab">
                            Reviews
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#paymentDetails" role="tab" data-toggle="tab">
                            Payment Details
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="#changePass" role="tab" data-toggle="tab">
                            Change Password
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-9">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane fade show active" id="basicDetails">
                        <div class="profile-tabs-data">
                            <h4>My Profile- Basic Details <button type="button" class="edit_profile">edit</button></h4>
                            <div class="profile-data">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h3>Update Profile Image</h3>
                                        @if(!is_null($currentUser->user_image))
                                        <div style="position:relative" class="col-md-3">
                                            <img src="{{asset($currentUser->user_image)}}" alt="" class="profileImg2">
                                            <div class="editIcon"> <a href="javascript:volid(0)" data-toggle="modal" data-target="#image-upload" > <img style="max-width:18px;"  src="{{asset('web/images/editIcon.svg')}}"> </a></div>
                                        </div>
                                        @else
                                        <div class="first_letter col-md-3">
                                            <span>{{strtoupper(substr($currentUser->first_name,0,1))}}</span>
                                            <div class="editIcon"> <a href="javascript:volid(0)" data-toggle="modal" data-target="#image-upload" > <img style="max-width:18px;"  src="{{asset('web/images/editIcon.svg')}}"> </a></div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <hr>
                                <!-- upload image code -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Name</h3>
                                        <p>{{$currentUser->first_name}} {{$currentUser->last_name}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Todder ID</h3>
                                        <p>{{$currentUser->todz_id}}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Email Id</h3>
                                        <p>{{$currentUser->email}} <img src="{{asset('web/images/tick.png')}}" alt=""
                                            style="all: unset;"></p>
                                    </div>
                                    <div class="col-md-6">
                                        <h3>Contact Number</h3>
                                        <p>+ {{$currentUser->phone_code}} {{$currentUser->phone_number}}</p>
                                    </div>
                                </div>
                                <div class="row edit_profile_div" style="display: none;">
                                    <form method="post" id="editProfileForm" class="col-md-12" action="{{route('client_profile_update')}}">
                                        @csrf
                                        <input type="hidden" name="phone_code" id="phone_code" value="{{$currentUser->phone_code}}">
                                        <div class="profile-tabs-data">
                                            <h4>Edit Profile</h4>
                                            <div class="profile-data">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Enter First Name" name="first_name" value="{{$currentUser->first_name}}">
                                                        </div>
                                                        <p class="text-danger error_span first_name_error"></p>
                                                        
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <input type="text" class="form-control" placeholder="Enter Last Name" name="last_name" value="{{$currentUser->last_name}}">
                                                        </div>
                                                        <p class="text-danger error_span last_name_error"></p>
                                                    </div>
                                                    @if(in_array($currentUser->entity, array('corporate','private')))
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Enter Company Name" name="company_name" value="{{$currentUser->company_name}}">
                                                            </div>
                                                            <p class="text-danger error_span company_name_error"></p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Enter Company Description" name="description" value="{{$currentUser->description}}">
                                                            </div>
                                                            <p class="text-danger error_span description_error"></p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Enter Company Address" name="company_address" value="{{$currentUser->company_address}}">
                                                            </div>
                                                            <p class="text-danger error_span company_address_error"></p>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Enter No of employees" name="no_of_employees" value="{{$currentUser->no_of_employees}}">
                                                            </div>
                                                            <p class="text-danger error_span no_of_employees_error"></p>
                                                        </div> 
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Enter Location" name="location" value="{{$currentUser->location}}">
                                                            </div>
                                                            <p class="text-danger error_span location_error"></p>
                                                        </div> 
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Enter Registration Number" name="registration_number" value="{{$currentUser->registration_number}}">
                                                            </div>
                                                            <p class="text-danger error_span registration_number_error"></p>
                                                        </div> 
                                                        <div class="col-md-5">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" placeholder="Enter Vat Details" name="vat_details" value="{{$currentUser->vat_details}}">
                                                            </div>
                                                            <p class="text-danger error_span vat_details_error"></p>
                                                        </div> 
                                                    @endif
                                                   
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <input type="tel" name="phone_number" class="form-control custom" placeholder="{{__('messages.textfield_phone')}}" value="+{{$currentUser->phone_code}}{{$currentUser->phone_number}}">
                                                        </div>
                                                        <p class="text-danger error_span phone_number_error"></p>
                                                        <p class="text-danger error_span phone_code_error"></p>
                                                    </div>
                                                        
                                                    <div class="col-md-12">
                                                        <button type="submit" class="saveBtn active" id="submit"><i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><strong class="btn-content">Save Changes</strong></button>
                                                    </div>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="reviews">
                        <div class="profile-tabs-data">
                            <h4>Reviews</h4>
                            <div class="profile-data">
                                <ul class="reviewsList">
                                    {{-- <li>
                                        <h3>
                                            11 Feburary’ 2020
                                            <strong><img src="{{asset('web/images/Star_review.png')}}" alt="">4.5</strong>
                                        </h3>
                                        <h6>
                                            “Amazing job done”
                                        </h6>
                                    </li> --}}
                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="paymentDetails">
                        <div class="profile-tabs-data">
                            <h4>Payment Details</h4>
                            <div class="profile-data">
                                
                                <h5>Payment Information</h5>
                                <hr>
                                <h5>GST/VAT Details</h5>
                                <h3>Country Code (Used for Invoice): {{$currentUser->invoice_country_code ?? 'N/A'}}</h3>
                                <h3>Country of Operation: {{$currentUser->country_of_operation ?? 'N/A'}}</h3>
                                <h3>Country of Origin: {{$currentUser->country_of_origin ?? 'N/A'}}</h3>
                                <h3>Liable to pay VAT/GST: {{$currentUser->gst_vat_applicable ?? 'N/A'}}</h3>
                                
                                @if($currentUser->gst_vat_applicable=='yes')
                                    <h3>VAT/GST registration number: {{$currentUser->vat_gst_number ?? 'N/A'}}</h3>
                                    <h3>Rate of VAT/GST: {{$currentUser->vat_gst_rate ?? 'N/A'}}</h3>
                                @endif
                                <a href="{{url('client/add-gst-details')}}"><button type="button" class="saveBtn active">Update GST/VAT Details</button></a>
                                <br>
                                <hr>


                                @if(is_null($currentUser->mangopayUser))
                                    <a href="{{route('add_user')}}"><button type="button" class="saveBtn active">Add Payment Wallet</button></a>
                                @else
                                <h3>Wallet Balance</h3>
                                <p>{{$walletInfo->Balance->Currency}} {{($walletInfo->Balance->Amount/100)}}</p>
                                <h3>Mangopay Account User Id</h3>
                                <p><img src="{{asset('web/images/tick.png')}}" alt=""> {{$currentUser->mangopayUser->mangopay_user_id}}</p>
                                <h3>Mangopay Account Wallet Id</h3>
                                <p><img src="{{asset('web/images/tick.png')}}" alt=""> {{$currentUser->mangopayUser->mangopay_wallet_id}}</p>
                                <br/>

                                <h5>KYC Documents</h5>

                                @if(!is_null($kycDoc))
                                <table class="table ">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($kycDoc)
                                            @foreach($kycDoc as $kyc)
                                                <tr>
                                                    <td>{{$kyc->Id}}</td>
                                                    <td>{{str_replace("_"," ",$kyc->Type)}}</td>
                                                    <td>{{str_replace("_"," ",@$kyc->Status)}}</td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr><td colspan="5" style="text-align: center;"> No Records.</td></tr>
                                        @endif
                                    </tbody>
                                </table>
                                @endif
                                <br/>
                                 @if($count_docx<1)
                                 <a href="{{route('kyc_doc')}}"><button type="button" class="saveBtn active">Upload KYC Doc</button></a> 
                                 @else
                                  <a href="#" data-toggle="modal" data-target="#exampleModal3" data-whatever="@mdo" ><button type="button" class="saveBtn active">Upload KYC Doc</button></a>
                                 @endif
                                <hr/>         
                                <br/>
                                {{-- <a href="{{route('add_payment_to_wallet')}}"><button type="button" class="saveBtn active">Add Money to wallet</button></a> --}}
                                {{-- <br/> --}}

                                <h5>Saved Cards</h5>
                                @if(!is_null($Cards))
                                    <div style='margin: auto;  max-width: 95vw; font-family: "Helvetica Neue", Helvetica, sans-serif; box-shadow: 0 3px 6px rgba(0,0,0,0.16), 0 3px 6px rgba(0,0,0,0.23); padding: 10px; margin-top: 50px; margin-bottom: 50px; border-radius: 15px; background: #f9fcff;'>
                                        <h1 style="font-weight: 500; text-align: center; ">Saved Cards</h1>
                                        <!--
                                            INFO: The selectable class adds a pointer and shadow animations on hover.
                                            -->
                                        <!-- Cards -->
                                        @foreach($Cards as $key=> $card)
                                        <!-- Visa - selectable -->
                                        <div class="radio">
                                            <input type="radio" id="radio-{{$key}}"   name="defaultCard" value="{{$card->Id}}" {{in_array($card->Id,$defaultCardid)?'checked':''}} />
                                            <label for="radio-{{$key}}" class="radio-label"></label>
                                        </div>
                                        <div class="credit-card visa selectable">
                                            <div class="credit-card-last4">
                                                {{$card->Alias}}
                                            </div>
                                            <div class="credit-card-expiry">
                                                {{$card->ExpirationDate}}
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                                
                                <a href="{{route('add_card')}}"><button type="button" class="saveBtn active">Add Card</button></a>
                                <hr>
                                <br/>
                                @if(!is_null($bankAccounts))
                                <table class="table">
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
                                        @foreach($bankAccounts as $bank)
                                        <tr>
                                            <td>{{$bank->OwnerName}}</td>
                                            <td>{{$bank->Type}}</td>
                                            <td>{{@$bank->IBAN}}</td>
                                            <td>{{@$bank->AccountNumber}}</td>
                                            </td>
                                            <td>{{$bank->Active}}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @endif
                                <br/>
                                <a href="{{route('add_bank')}}"><button type="button" class="saveBtn active">Add Bank Account</button></a>          
                                {{-- <span>Your mangopay account has been linked, all your payments will be
                                happening from this account only.</span>
                                <h3>Mangopay Account</h3>
                                <p><img src="{{asset('web/images/tick.png')}}" alt=""> business@mangopay.com <button
                                    type="button">remove</button></p>
                                --}}
                                @endif

                                <div class="line-bottom"></div>
                                
                                <br>
                                
                            </div>
                        </div>
                    </div>
                    
                    <div role="tabpanel" class="tab-pane fade" id="changePass">
                        <form method="post" id="changePasswordForm" name="theForm">
                            @csrf
                            <div class="profile-tabs-data">
                                <h4>Change Password</h4>
                                <div class="profile-data">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="form-group">
                                                <input type="password" class="form-control"
                                                    placeholder="Enter Old Password" id="old_password" name="old_password" onKeyup="checkform()">
                                                <i><img onclick="toggleOldPasssword()" src="{{asset('web/images/ic_show-password.png')}}" alt=""></i>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control"
                                                    placeholder="Enter New Password" id="new_password" name="new_password" onKeyup="checkform()">
                                                <i><img onclick="toggleNewPasssword()" src="{{asset('web/images/ic_show-password.png')}}" alt=""></i>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control"
                                                    placeholder="Confirm New Password" id="confirm_password" name="new_con_password" onKeyup="checkform()">
                                                <i><img onclick="toggleConfirmPasssword()" src="{{asset('web/images/ic_show-password.png')}}" alt=""></i>
                                            </div>
                                            <!-- <button type="submit" class="saveBtn " id="submit"><i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><strong class="btn-content">Save Changes</strong></button> -->
                                            <input id="submitbutton" type="submit" disabled="disabled" value="Submit" />

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="exampleModal3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">KYC DOCUMENT</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          <div class="form-group">
                            <div class="col-lg- 12">
                                <p>Can not upload more than one kyc document</p>
                             </div>
                          </div>       
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        
                      </div>
                      </div>
                    </div>
                  </div>
                </div>
<div class="modal" id="image-upload">
    <div class="modal-dialog frstmdl-body modal-sm">
        <div class="modal-content">
            <div id="croppic"><span style="margin-top:90px;"><p>accepted file formats<span class="theme-color fw-500"> jpeg,png,gif<p></span></span></div>
            <span class="btn" id="cropContainerHeaderButton">Upload Image</span>
        </div>
    </div>
</div>
<style>
    .modal-dialog.frstmdl-body {
    width: 409px;
    }
    button#submit.active {
    background: #f9d100;
    }
    }
    button.active {
    background: #f9d100 !important;
    }
    button#submit.active strong {
    color: black;
    }
    .error {
    color: red;
    font-size: 13px;
    }
    button.saveBtn.active {
    background: #f9d100;
    }
    .iti.iti--allow-dropdown{
     width:100% !important;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.11/css/intlTelInput.css" rel="stylesheet" />
@endsection
@section('headerScript')
@parent
<link href="{{asset('web/css/croppic.css')}}" rel="stylesheet">
@endsection
@section('footerScript')
@parent
<script>
    function toggleNewPasssword() {
        var x = document.getElementById("new_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
      function toggleConfirmPasssword() {
        var x = document.getElementById("confirm_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
      function toggleOldPasssword() {
        var x = document.getElementById("old_password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }  
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script type="text/javascript" src="{{asset('web/js/waitme.min.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/loader.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/16.0.11/js/intlTelInput-jquery.min.js"></script>
<script src="{{asset('web/js/croppic.min.js')}}"></script>
<script>
    var croppicHeaderOptions = {
                  //uploadUrl:'img_save_to_file.php',
                  cropData:{
                "_token": "{{ csrf_token() }}",
                  },
                  cropUrl:"{{route('upload-profile-image')}}",
                  customUploadButtonId:'cropContainerHeaderButton',
                  modal:false,
                  processInline:true,
                  loaderHtml:'<div class="loader bubblingG"><span id="bubblingG_1"></span><span id="bubblingG_2"></span><span id="bubblingG_3"></span></div> ',
                  onBeforeImgUpload: function(){ console.log('onBeforeImgUpload') },
                  onAfterImgUpload: function(){console.log('onAfterImgUpload')
    },
                  onImgDrag: function(){ console.log('onImgDrag') },
                  onImgZoom: function(){ console.log('onImgZoom') },
                  onBeforeImgCrop: function(){ console.log('onBeforeImgCrop') },
                  onAfterImgCrop:function(){location.reload(); },
                  onReset:function(){ console.log('onReset') },
                  onError:function(errormessage){errormessage('onError:'+errormessage) }
          } 
          var croppic = new Croppic('croppic', croppicHeaderOptions);       
</script>

<script type="text/javascript" language="javascript">
    function checkform()
    {
        var f = document.forms["theForm"].elements;
        var cansubmit = true;

        for (var i = 0; i < f.length; i++) {
            if (f[i].value.length == 0) cansubmit = false;
        }

        if (cansubmit) {
        document.getElementById('submitbutton').disabled = false;
    }
    else {
        document.getElementById('submitbutton').disabled = 'disabled';
    }
    }
</script> 

<script>
    $('input[type="tel"]').intlTelInput({
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/8.4.6/js/utils.js"
    });
    $("#editProfileForm").submit(function() {
        if(!$('input[type="tel"]').intlTelInput("getSelectedCountryData").dialCode==undefined){
            $("#phone_code").val($('input[type="tel"]').intlTelInput("getSelectedCountryData").dialCode);
        }
    });
</script>
<script>
    $(document).ready(function(){
        $(document).on('click','.edit_profile', function(){
            ($(this).text()=='edit') ? $(this).text('cancel') : $(this).text('edit')
            $('.edit_profile_div').toggle();
        });
        $(document).on('submit','#editProfileForm',function(e){
            e.preventDefault();
            var formobject=$(this);
            $('#editProfileForm').find('.error_span').html('');
            $.ajax({
                type:'POST',
                url:'{{route("client_profile_update")}}',
                data:formobject.serialize(),
                beforeSend:function(){
                    startLoader('body');
                },
                complete:function(){
                    stopLoader('body');
                },
                success:function(response){
                    if(response.status){
                        swal({title: "Success", text: response.message, type: "success"}).then(function(){ 
                            location.reload();
                        });
                    }else{
                        swal({title: "Oops!", text: response.message, type: "error"});
                    }
                },
                error:function(data){
                    stopLoader('body');
                    if(data.responseJSON){
                        var err_response = data.responseJSON;  
                        if(err_response.errors==undefined && err_response.message) {
                            swal({title: "Error!", text: err_response.message, type: "error"});
                        }          
                        $.each(err_response.errors, function(i, obj){
                            $('#editProfileForm').find('.error_span.'+i+'_error').text(obj).show();
                        });
                    }
                }
            });
        });

        $(document).on('submit','#changePasswordForm',function(e){
           
            e.preventDefault();
            var formobject=$(this);
            $(".loader-icon").show();
          $(".btn-content").hide();
            $.ajax({
            type:'POST',
            url:'{{route("talent-change-password")}}',
            data:formobject.serialize(),
            success:function(response){
                $(".loader-icon").hide();
                $(".btn-content").show();
                if(response.success==1){
            //    / swal("Accepted", response.message, "success");
                swal({title: "Success", text: response.msg, type: "success"}).then(function(){ 
    location.reload();
    }
    );
            }else{
              swal({title: "Oops!", text: response.msg, type: "error"});
            }
            }
        });
        });
        $(document).on('change','input[name="defaultCard"]',function(e){
           
           e.preventDefault();
         //  alert($(this).val());
    
           $.ajax({
           type:'POST',
           url:'{{route("set_default_card")}}',
           data:{
            "_token": "{{ csrf_token() }}",
            "cardId":$(this).val()
           },
           success:function(response){
    //                if(response.success==1){
    //            //    / swal("Accepted", response.message, "success");
    //                swal({title: "Success", text: response.msg, type: "success"}).then(function(){ 
    //   location.reload();
    //   }
    // );
    //            }else{
    //              swal({title: "Oops!", text: response.msg, type: "error"});
    //            }
           }
       });
       })
    });
    
     $('input').on('keyup', function() {
        if ($("#changePasswordForm").valid()) {
            $('#submit').prop('disabled', false);  
            $('#submit').addClass('active');
        } else {
            $('#submit').prop('disabled', 'disabled');
            $('#submit').removeClass('active');
        }
    });
    
    $("#changePasswordForm").validate({
      onfocusout: function(e) {  // this option is not needed
        this.element(e);       // this is the default behavior
    },
        rules: {
            old_password: {
                required: true
            },
            new_password: {
                required: true,
                minlength : 6
            },
            new_con_password: {
                required: true,
                equalTo : "#new_password"
            }
        }
    });
</script>
{{--  --}}
@endsection