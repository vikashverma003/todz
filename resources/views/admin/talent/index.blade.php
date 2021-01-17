@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<style type="text/css">
    table#datatable_ajax td.sr_no{
        min-width: 120px !important;
    }
</style>
<div class="content-wrapper">
   <div class="row">
      <div class="col-lg-12 stretch-card">

         <div class="card">
            <div class="card-body">
                @if (\Session::has('success'))
                    <div class="alert alert-success">
                    {!! \Session::get('success') !!}
                    </div>
                @endif
                @if (\Session::has('error'))
                    <div class="alert alert-danger">
                        {!! \Session::get('error') !!}
                    </div>
                @endif
               <h4 class="card-title">Talents List</h4>
                <a href="{{route('export-talent')}}" class="btn btn-success mb-3 float-right" target="_blank" ><i class="fa fa-export"></i>Export</a>
               <div class="table-responsive">
                    <form name="filter_listing">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Sr. No
                                    </th>
                                    <th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Name
                                    </th>
                                    <th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Todz Id
                                    </th>
                                    <th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Email
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Phone
                                    </th>
                                    <th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Country
                                    </th>
                                    <th width="20%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Account Status
                                    </th>
                                    <th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Test Status
                                    </th>
                                    <th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Job Field
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Date
                                    </th>
                                    
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Actions
                                    </th>
                                </tr>
                                <tr role="row" class="filter">
                                    <td rowspan="1" colspan="1" class="sr_no">
                                        <select name="orderby" class="form-control" id="orderby">
                                            <option value="desc" selected>DESC</option>
                                            <option value="asc">ASC</option>
                                        </select>
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <input type="text" class="form-control form-filter input-sm" name="name" id="name" placeholder="Name">
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <input type="text" class="form-control form-filter input-sm" name="todz_id" id="todz_id" placeholder="Todz Id">
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <input type="text" class="form-control form-filter input-sm" name="email" id="email" placeholder="Email">
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <input type="text" class="form-control form-filter input-sm" name="phone" id="phone" placeholder="Phone">
                                    </td>
                                    <td style="width:150px !important">
                                        <select name="country[]" id="multiple" class="js-states form-control" multiple   autocomplete="off" >
                                        @foreach($allCountries as $allc)
                                            <option value="{{$allc->country_name}}">{{$allc->country_name}}</option>
                                        @endforeach
                                        </select>
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <select name="status[]" id="account-select2-multi-select" class="js-states form-control" multiple autocomplete="off" id="filterAccountStatus">

                                           
                                            <option value="1">Active</option>
                                            <option value="0">In-Active</option>
                                            <option value="2">Blocked</option>
                                            <option value="3">Deactivated</option>

                                        </select> 
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <select name="test_status" id="test-select2-multi-select" class="form-control"  autocomplete="off" id="filterTestStatus">
                                            <option value="">All</option>
                                            <option value="0">Pending</option>
                                            <option value="1">Approved</option>
                                            <option value="3">Screening Cleared</option>
                                            <option value="4">Technical Cleared</option>
                                            <option value="5">Aptitude Cleared</option>
                                            <option value="2">Rejected</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="job-select2-multi-select" name="job_category[]" class="js-states form-control" multiple autocomplete="off" id="filterJobStatus">
                                            
                                            @foreach($alljobcatetory as $allc)
                                                <option value="{{$allc->name}}">{{$allc->name}}</option>
                                            @endforeach
                                        </select>
                                        
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range" style="color: black">
                                            <i class="icon-calendar"></i>&nbsp; 
                                            <span class="thin uppercase visible-lg-inline-block">
                                                Select Date
                                            </span>&nbsp; <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="start" value="">
                                        <input type="hidden" name="end" value="">
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <button class="btn btn-sm red filter-cancel"><i class="fa fa-times"></i> Reset</button>
                                    </td>
                                </tr>
                            </thead>
                            <tbody id="dynamicContent">
                                @include('admin.talent.list')
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

@endsection

@section('footerScript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>


<script type="text/javascript">
    var start = moment().subtract(29, 'days');
    var end = moment();

    var filter_data = $("form[name=filter_listing]").serialize();
    var jqxhr = {abort: function () {  }};
    var full_path = "{{url('admin')}}";

    $(document).ready(function () {

        function cb(start, end) {
            $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            $('input[name="start"]').val(start.format('DD/MM/YYYY'))
            $('input[name="end"]').val(end.format('DD/MM/YYYY'))
            loadListings(full_path + '/talents/?page=');
        }

        $('#dashboard-report-range').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Today': [moment(), moment()],
               'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
               'Last 7 Days': [moment().subtract(6, 'days'), moment()],
               'Last 30 Days': [moment().subtract(29, 'days'), moment()],
               'This Month': [moment().startOf('month'), moment().endOf('month')],
               'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
               'This Year': [moment().startOf('year'), moment()],
               'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
            }
        }, cb);

        $(document).on('keyup', '#name, #email, #phone,#todz_id', function () {
            if($(this).val().length > 2)
            {
                loadListings(full_path + '/talents/?page=');
            }
            if($(this).val().length == 0)
            {
                loadListings(full_path + '/talents/?page=');
            }
        });

        $(document).on('change', '#orderby', function () {
            loadListings(full_path + '/talents/?page=');
        });
        $(document).on('change','#test-select2-multi-select,#account-select2-multi-select,#job-select2-multi-select,#multiple',function(){
            loadListings(full_path + '/talents/?page=');
        })

        $(document).on("click", ".pagination li a", function (e){
            e.preventDefault();
            startLoader('.page-content');
            var url = $(this).attr('href');
            var page = url.split('page=')[1];     
            loadListings(url, 'filter_listing');
        });

        function loadListings(url){

            var filtering = $("form[name=filter_listing]").serialize();
            //abort previous ajax request if any
            jqxhr.abort();
            jqxhr =$.ajax({
                type : 'get',
                url : url,
                data : filtering,
                dataType : 'html',
                beforeSend:function(){
                    startLoader('body');
                },
                success : function(data){
                    data = data.trim();
                    $("#dynamicContent").empty().html(data);
                },
                error : function(response){
                    stopLoader('body');
                },
                complete:function(){
                    stopLoader('body');
                }
            });
        }

        // reset form data
        $(document).on('click', '.filter-cancel', function (e) {
            e.preventDefault();
            $("form[name='filter_listing']")[0].reset();
            $('input[name="start"]').val('');
            $('input[name="end"]').val('');
            $('#dashboard-report-range span').html('Select Date');
            $("#account-select2-multi-select,#job-select2-multi-select,#multiple").val('').trigger('change')

            loadListings(full_path +'/talents/?page=');
        });

        $(document).on('click','.delete_user', function(){
            var id = $(this).data('id');
            swal({
              title: "Are you sure?",
              text: "Once deleted, you will not be able to recover this!",
              icon: "warning",
              buttons: true,
              dangerMode: true,
            })
            .then((willDelete) => {
              if (willDelete) {
                $.ajax({
                    type : 'post',
                    url : "{{url('admin/talents')}}"+'/'+id,
                    data : {
                        "id":id,
                        "_method":"DELETE",
                        "_token": "{{ csrf_token() }}",
                    },
                    dataType : 'html',
                    beforeSend:function(){
                        startLoader('body');
                    },
                    complete:function(){
                        stopLoader('body');
                    },
                    success : function(data){
                        //console.log(data);
                       window.location.reload();
                    },
                    error : function(response){
                        stopLoader('body');
                    }
                });
              }
            });
        });
    });
   
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
   
    $("#multiple").select2({
        placeholder: "Select Country",
        allowClear: true
    });
    $("#account-select2-multi-select").select2({
        placeholder: "Select Option",
        allowClear: true
    });
    
    $("#job-select2-multi-select").select2({
        placeholder: "Select Option",
        allowClear: true
    });
  </script>
@endsection