@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')

<div class="content-wrapper">
   <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
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
                <h4 class="card-title">Change Password</h4>
                  
                <form class="forms-sample" name="changePasswordForm" id="changePasswordForm" method="post" action="{{url('admin/change-password')}}">
                  @csrf
                    
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Current Password" required autocomplete="off" />
                                <p class="error span_error current_password_error"></p>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" name="password" class="form-control" id="password" placeholder="New Password" required  autocomplete="off" />
                                <p class="error span_error password_error"></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="password">Confirm Password</label>
                                <input type="password" name="confirm_password" class="form-control" id="confirm_password" placeholder="Confirm Password" required  autocomplete="off" />
                                <p class="error span_error confirm_password_error"></p>
                            </div>
                        </div>
                    </div>

                    <button type="button" class="form_submit_btn btn btn-success own_btn_background mr-2">Save</button>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footerScript')
<script type="text/javascript">
    

    $(document).ready(function () {
        
        $(document).on('click','.form_submit_btn', function(e){
            e.preventDefault();
            $(document).find('.span_error').empty().hide();
            var data = new FormData($('#changePasswordForm')[0])
           
            $.ajax({
                url: "{{url('admin/change-password')}}",
                type: 'POST', //request method
                data: data,
                processData: false,  // Important!
                contentType: false,
                beforeSend: function() {
                    startLoader('body');
                },
                complete:function(){
                     stopLoader('body');
                },
                success: function(data) {
                    if(data.status){
                        swal({
                              title: "Success",
                              text: data.message,
                              icon: "success",
                              buttons: true,
                              dangerMode: true,
                              showCancelButton:false
                        }).then((willDelete) => {
                           
                            window.location = data.url;
                        });
                                                
                    }else{
                        stopLoader('body');
                        swal({
                            title: "Error",
                            text: data.message,
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                            showCancelButton:false
                        });
                    }
                },
                error: function(error){
                    stopLoader('body');
                   
                    if(error.status == 422) {
                        errors = error.responseJSON;
                        $.each(errors.errors, function(key, value) {
                            $('.'+key+'_error').empty().addClass('text-danger').text(value).finish().fadeIn();
                        });                        
                    }
                    else {
                        
                        swal({
                            title: "Error",
                            text: "Something went wrong",
                            icon: "error",
                            buttons: true,
                            dangerMode: true,
                            showCancelButton:false
                        });
                    }
                }
            });
        });
    });
</script>
@endsection