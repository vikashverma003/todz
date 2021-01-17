@extends('web.layouts.app')
@section('title', __('messages.header_titles.PROJECT.CREATE'))

@section('content')

<!-- Login block -->
<section class="login-section header-mt">
    <div class="container">
      <div class="row">
        <div class="offset-md-2 col-md-8">
          <div class="row wizzard-form">
            <div class="col-md-4 text-center">
              <p class="active">Post Project</p>
              <span class="dot-wizzard active"></span>
            </div>
            <div class="col-md-4 text-center">
              <p>Select Talents</p>
              <span class="dot-wizzard"></span>
            </div>
            <div class="col-md-4 text-center">
              <p>Summary</p>
              <span class="dot-wizzard"></span>
            </div>
            <div class="col-md-12"><div class="form-wizard"><div class="line-colored"></div></div></div>
          </div>
  
          <div class="row">
            <div class="col-md-12">
              <h4 class="mt-4 mb-3">Post a New Project</h4>
            <form id="project_create_form" class="post-project" action="{{route('project.store')}}" method="post"  enctype="multipart/form-data" onsubmit="return validateForm()">
                @csrf
                <div class="form-group">
                    <input class="form-control custom" type="text" name="title" placeholder="Project Title" value="{{old('title')}}">
                    @if($errors->has('title'))
                    <p class="text-danger">{{ $errors->first('title') }}</p>
                    @endif
                </div>
  
                <div class="form-group mt-4">
                    <textarea class="form-control" name="description" rows="6" placeholder="Project Description ( Eg. I am working at a new product and i need the best ui / ux designer )">{{old('description')}}</textarea>
                    @if($errors->has('description'))
                    <p class="text-danger">{{ $errors->first('description') }}</p>
                    @endif
                </div>

                <label>Desired Project Duration</label>
                <small class="dp-block mb-2">* The maximum duration of a project cannot be more than 6 months</small>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <select class="form-control custom" name="duration_month">
                            <option value="" selected="selected" disabled>Months</option>
                            @for($i=1;$i<=6;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                            </select>
                            @if($errors->has('duration_month'))
                                <p class="text-danger">{{ $errors->first('duration_month') }}</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <select class="form-control custom" name="duration_day">
                            <option value="" selected="selected" disabled>Days</option>
                            @for($i=1;$i<=31;$i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                        @if($errors->has('duration_day'))
                            <p class="text-danger">{{ $errors->first('duration_day') }}</p>
                        @endif
                  </div>
                </div>
                </div>
                <div class="form-group project-cost">
                    <label>Enter Total Project Cost</label>
                    <span>USD</span>
                    <input class="form-control custom" type="text" name="cost" value="{{old('cost')}}" placeholder="Cost">
                </div>
                @if($errors->has('cost'))
                    <p class="text-danger">{{ $errors->first('cost') }}</p>
                @endif
                <div class="form-group">
                  <label>Skill needed in the project</label>
                  <input class="form-control custom" type="text" name="project_title" placeholder="Add Skill" autocomplete="off">
                  <div class="full-width" style="position:relative">
                  <div class="full-width  " id="skills">

                  </div>
                </div>
                </div>
                <div class="form-group selected-box mt-4">
                
                </div>
                <div class="form-group">
                  <label>Upload Project Brief File</label>
                  <div id="file-uploadsection" class="fallback dropzone  text-center p-2">
                
                  {{-- <input type="file" name="project_file"  /> --}}
                </div>

                
                </div>
                <div class="form-group">
                  <button id="submit" class="theme-button next-btn hover-ripple mb-4 mt-4 text-upper mr-3">NEXT</button>
                  <button class="theme-button tranaparent-btn hover-ripple mb-4 mt-4 text-upper">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  
<style>
    

div#skills {
    top: 0;
    position: absolute;
    background: #fff;
    z-index: 5;
    margin-top: 2px;
}
li.full-width.pb-2.skill-list {
    padding: 10px;
    border-bottom: 1px solid #ccc;
    cursor: pointer;
}
ul.list-inline {
    border-left: 1px solid #ccc;
    border-right: 1px solid #ccc;
}
label.error {
    color: red;
    font-size: 12px;
}
label#cost-error {
    position: absolute;
}
  </style>
@endsection
@section('headerScript')
@parent
<link rel="stylesheet" href="{{asset('web/dropzone/basic.min.css')}}" >
<link rel="stylesheet" href="{{asset('web/dropzone/dropzone.min.css')}}" >

@endsection

@section('footerScript')
@parent

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.1/dist/jquery.validate.min.js"></script>
<script  src="{{asset('web/dropzone/dropzone.min.js')}}" ></script>

<script>
  $(document).ready(function(){
	 $(document).on("keyup focus","input[name='project_title']",function($e){
     $e.preventDefault();
		var keyward = $("input[name='project_title']").val();
		   $.ajax({
            type:'POST',
            url:'{{route("search_skill")}}',
            data:{ "_token": "{{ csrf_token() }}",

             'keyward':keyward
             },
            success:function(response){
              $("#skills").html(response);
             // console.log(response);
           //  var res= JSON.parse(response);
            
        }
	 });
  });
  $(document).delegate(".skill-list",'click',function($e){
      var id=$(this).data('id');
      var name=$(this).data('name');
      $(".selected-box ").append(`<span class="mr-3 mb-3" id="skill-${id}">${name}<a href="javascript:void(0)" class="delete-skill" data-id="${id}">+</a>
      <input type="hidden" class="d-none" name="skills[]" value="${id}" /></span>`);
      $("#skills").html("");
      $('input[name="project_title"]').val("");
     
    });
    $(document).delegate(".delete-skill",'click',function($e){
      var id=$(this).data('id');
      $("#skill-"+id).remove();
    });
  });
  
  $('input').on('blur', function() {
        if ($("#project_create_form").valid()) {
            $('#submit').prop('disabled', false);  
            $('#submit').addClass('active');
        } else {
            $('#submit').prop('disabled', 'disabled');
            $('#submit').removeClass('active');
        }
    });
    $('select').on('blur', function() {
        if ($("#project_create_form").valid()) {
            $('#submit').prop('disabled', false);  
            $('#submit').addClass('active');
        } else {
            $('#submit').prop('disabled', 'disabled');
            $('#submit').removeClass('active');
        }
    });
    $("#project_create_form").validate({
      onfocusout: function(e) {  // this option is not needed
        this.element(e);       // this is the default behavior
    },
        rules: {
          title: {
                required: true
            },
            description: {
                required: true
            },
            duration_month: {
                required: true
            },
            duration_day: {
                required: true
            },
            cost: {
                required: true
            },
            'skills[]':{
              required: true
            }
        }
    });
  </script>
   <script>
       var workReferenceUpload = false;
       function validateForm(){
            if(!workReferenceUpload){
              swal({
                title: "Alert",
                text: "Please upload project brief file",
                type: "warning",
                showCancelButton    : true,
                confirmButtonColor  : "#ff0000",
                confirmButtonText   : "Yes",
                allowOutsideClick: false,
              });
              return false;
            }
           
        }
        </script>

  <script>
    $("div#file-uploadsection").dropzone({ 
      url: "{{route('project-file-upload')}}",
      addRemoveLinks : true,
      //maxFilesize: 10,
      //maxFilesize: 10,
      maxFiles: 1,
      timeout: 100000,
      maxfilesexceeded: function(file) {
                    this.removeAllFiles();
                    this.addFile(file);

                },
      acceptedFiles: ".jpeg,.jpg,.png,.gif,.pdf,.doc,.docx",
      dictDefaultMessage: '<span class="theme-color fw-500">Upload</span> or <span class="theme-color fw-500">Drag</span> &amp; Drop your file.[accepted file formats<span class="theme-color fw-500"> jpeg,png,pdf,doc</span> ] max upload size <span class="theme-color fw-500"> 20 MB</span> ',
      dictResponseError: 'Error uploading file!',
      headers: {
          'X-CSRF-TOKEN':'{{ csrf_token() }}'
      },
      removedfile: function(file) { 

var name = file.name;   
console.log(file.name);       
$.ajax({
  headers: {
    'X-CSRF-TOKEN': '{{ csrf_token() }}'
},
type: 'POST',
url: "{{route('project-file-delete')}}",
data: {filename:name},
dataType: 'html'
});
var fileRef;
workReferenceUpload=false;
    return (fileRef = file.previewElement) != null ? 
          fileRef.parentNode.removeChild(file.previewElement) : void 0;
},
  success: function(file, response) {
    workReferenceUpload=true;                 
  },

  });
    </script>
@endsection