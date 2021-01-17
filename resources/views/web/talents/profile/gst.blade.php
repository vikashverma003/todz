@extends('web.layouts.app')
@section('title','Profile')

@section('content')
<section class="profile-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                           
                            <ul class="nav nav-tabs" role="tablist">
                                
                                <li class="nav-item">
                                    <a class="nav-link" href="{{url('talent/profile')}}">
                                    Back To Profile
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade show active" id="basicDetails">
                                <div class="row">
                                    <form method="post" id="editGstVatForm" name="editGstVatForm" class="col-md-12">
                                        @csrf
                                        
                                        <div class="profile-tabs-data">
                                            <h4>Edit GST/VAT Details</h4>
                                            <div class="profile-data">
                                                <div class="row">
                                                    
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Country Code (Used for Invoice)</label>
                                                            <select name="invoice_country_code" class="form-control custom">
                                                                <option value="">Select</option>
                                                                @foreach(config('constants.invoice_country_codes') as $key=>$value)
                                                                    <option value="{{$key}}" @if($currentUser->invoice_country_code==$key)selected @endif>{{$key}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <p class="text-danger error_span invoice_country_code_error"></p>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Country of Operation</label>
                                                            <select name="country_of_operation" class="form-control custom">
                                                                <option value="">Select</option>
                                                                @foreach($countries as $row)
                                                                    <option value="{{$row->country_name}}" @if($currentUser->country_of_operation==$row->country_name)selected @endif>{{$row->country_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <p class="text-danger error_span country_of_operation_error"></p>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="form-group">
                                                            <label>Country of Origin</label>
                                                            <select name="country_of_origin" class="form-control custom">
                                                                <option value="">Select</option>
                                                                @foreach($countries as $row)
                                                                    <option value="{{$row->country_name}}" @if($currentUser->country_of_origin==$row->country_name)selected @endif>{{$row->country_name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <p class="text-danger error_span country_of_origin_error"></p>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <div>Are you liable to pay VAT/GST for the services you are offering ?</div>
                                                            
                                                            <label>
                                                                <input style="height: 15px !important;" type="radio" name="gst_vat_applicable" value="yes" @if($currentUser->gst_vat_applicable=='yes') checked @endif> Yes
                                                            </label>
                                                            &nbsp;
                                                            <label>
                                                                <input style="height: 15px !important;" type="radio" name="gst_vat_applicable" value="no"  @if($currentUser->gst_vat_applicable=='no') checked @endif> No
                                                            </label>
                                                        </div>
                                                        <p class="text-danger error_span gst_vat_applicable_error"></p>
                                                    </div>
                                                    <div class="col-md-5 gst_vat_applicable_yes_div">
                                                        <div class="form-group">
                                                            <label>VAT/GST registration number (Required if VAT/GST applicable)</label>
                                                            <input type="text" name="vat_gst_number" class="form-control custom" value="{{$currentUser->vat_gst_number}}" placeholder="VAT/GST Number">
                                                        </div>
                                                        <p class="text-danger error_span vat_gst_number_error"></p>
                                                    </div>
                                                    <div class="col-md-5 gst_vat_applicable_yes_div">
                                                        <div class="form-group">
                                                            <label>Rate of VAT/GST %(Required if VAT/GST applicable)</label>
                                                            <input type="text" name="vat_gst_rate" class="form-control custom" value="{{$currentUser->vat_gst_rate}}" placeholder="VAT/GST Rate">
                                                        </div>
                                                        <p class="text-danger error_span vat_gst_rate_error"></p>
                                                    </div>
                                                    
                                                        
                                                    <div class="col-md-12">
                                                        <button type="submit" class="saveBtn active gstSubmitBtn">
                                                            <strong class="btn-content">Save Changes</strong>
                                                        </button>
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
            </div>
        </div>
    </div>
</section>

@endsection

@section('footerScript')
@parent

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


<script type="text/javascript" src="{{asset('web/js/waitme.min.js')}}"></script>
<script type="text/javascript" src="{{asset('web/js/loader.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
    $(document).ready(function(){
        $(document).on('submit','#editGstVatForm',function(e){
            e.preventDefault();
            var formobject=$(this);
            var $form = $('#editGstVatForm');
            $form.find('.error_span').html('');
            $.ajax({
                type:'POST',
                url:'{{route("talent_add_gst_vat_details")}}',
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
                            $form.find('.error_span.'+i+'_error').text(obj).show();
                        });
                    }
                }
            });
        });

        

        
    });
</script>
@endsection