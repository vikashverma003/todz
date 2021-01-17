@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
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
               <h4 class="card-title">Wallet Balance</h4>
               
               <a href="{{route('export-wallet-detail')}}" class="btn btn-success mb-3 float-right" target="_blank" ><i class="fa fa-export"></i>Export</a>
               <div class="table-responsive">
                    <form name="filter_listing">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="7%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Sr. No
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        User Name
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        User Type
                                    </th>
                                    
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Wallet Id
                                    </th>
                                    
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        User Id
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Wallet Balance
                                    </th>
                                   
                                    {{-- <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Date
                                    </th> --}}
                                    
                                </tr>
                                {{-- <tr role="row" class="filter">
                                    <td rowspan="1" colspan="1">
                                        <select name="orderby" class="form-control" id="orderby">
                                            <option value="desc" selected>DESC</option>
                                            <option value="asc">ASC</option>
                                        </select>
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <input type="text" class="form-control form-filter input-sm" name="name" id="name" placeholder="Title">
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <input type="text" class="form-control form-filter input-sm" name="user_name" id="user_name" placeholder="Name">
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <input type="text" class="form-control form-filter input-sm" name="todz_id" id="todz_id" placeholder="Todz Id">
                                    </td>
                                    <td rowspan="1" colspan="1">
                                    
                                    </td>
                                  
                                    <td rowspan="1" colspan="1"></td>
                                    <td rowspan="1" colspan="1">
                                        <!-- <select name="status" class="form-control" id="filterStatus">
                                            <option value="">Status</option>
                                            <option value="1">Enabled</option>
                                            <option value="0">Disabled</option>
                                        </select> -->
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
                                </tr> --}}
                            </thead>
                            <tbody id="dynamicContent">
                                @include('admin.wallet-balance.list')
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
            loadListings(full_path + '/revenue/?page=');
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

        $(document).on('keyup', '#name, #user_name, #todz_id', function () {
            if($(this).val().length > 2)
            {
                loadListings(full_path + '/revenue/?page=');
            }
            if($(this).val().length == 0)
            {
                loadListings(full_path + '/revenue/?page=');
            }
        });

        $(document).on('change', '#filterStatus,#orderby', function () {
            loadListings(full_path + '/revenue/?page=');
        });

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

            loadListings(full_path +'/revenue/?page=');
        });
    });
</script>
@endsection