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
				<h4 class="card-title">Add User</h4>
				  
				<form class="forms-sample" name="sub_admin_form" id="sub_admin_form" method="post" action="{{url('admin/sub-admins')}}">
				  @csrf
					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label for="first_name">First Name</label>
							  	<input type="text" name="first_name" class="form-control" id="first_name" placeholder="First Name" value="{{old('first_name')}}" required autocomplete="off" />
								<p class="error span_error first_name_error"></p>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<label for="last_name">Last Name</label>
							  	<input type="text" name="last_name" class="form-control" id="last_name" placeholder="Last Name" value="{{old('last_name')}}" required  autocomplete="off" />
								<p class="error span_error last_name_error"></p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label for="email">Email</label>
							  	<input type="text" name="email" class="form-control" id="email" placeholder="Email" value="{{old('email')}}" required  autocomplete="off" />
								<p class="error span_error email_error"></p>
							</div>
						</div>
						<div class="col-md-5">
							<div class="form-group">
								<label for="phone_number">Phone Number</label>
							  	<input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="Phone Number" value="{{old('phone_number')}}" autocomplete="off"  required />
								<p class="error span_error phone_number_error"></p>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-5">
							<div class="form-group">
								<label for="password">Password</label>
							  	<input type="password" name="password" class="form-control" id="password" placeholder="Password" value="{{old('password')}}"  autocomplete="off" required />
								<p class="error span_error password_error"></p>
							</div>
						</div>
					</div>
					<div><b>Permissions</b></div>
					<br>
                    <div class="row">
        
                        @foreach($permissions as $row)
                        	<div class="col-md-4">
								<div class="form-group">
									<label>
										<input type="checkbox" name="permissions[]" value="{{$row->id}}"/> {{$row->title}}
									</label>
								</div>
							</div>
                        @endforeach

        				<div class="col-md-12">
        					
                        	<p class="error span_error permissions_error"></p>
                        </div>
                    </div>

					<button type="button" class="form_submit_btn btn btn-success own_btn_background mr-2">Save</button>
				</form>
				</div>
			</div>
		</div>
   	</div>
</div>
<link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
@endsection

@section('footerScript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script type="text/javascript">
	

	$(document).ready(function () {
        $('.js-example-basic-multiple').select2({
			placeholder: "Select Permission",
	    	allowClear: true
		});

        $(document).on('click','.form_submit_btn', function(e){
            e.preventDefault();
            $(document).find('.span_error').empty().hide();
            var data = new FormData($('#sub_admin_form')[0])
            
            $.ajax({
                url: "{{url('admin/sub-admins')}}", //url
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