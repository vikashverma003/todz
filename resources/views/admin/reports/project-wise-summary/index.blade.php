@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

<div class="content-wrapper">
    
   <div class="row">
      <div class="col-lg-12 stretch-card">

         <div class="card">
            <div class="card-body">
                
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6 float-right text-right">
                        <a href="{{route('export-projectwisesummary-pdf')}}" class="btn btn-primary mb-3 float mr-2 pr-5" target="_blank" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i>Export PDF
                        </a>
                            &nbsp;

                        <a href="{{route('export-projectwisesummary-excel')}}" class="btn btn-success mb-3 float ml-2" target="_blank" ><i class="fa fa-file-excel-o" aria-hidden="true"></i>Export Excel</a>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Project Wise Summary</h4>
                    </div>
                    <div class="col-md-6 float-right text-right">
                        <form name="filter_listing">
                            <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range" style="color: black;border: 1px solid black">
                                <i class="icon-calendar"></i>&nbsp; 
                                <span class="thin uppercase visible-lg-inline-block">
                                    Select Date
                                </span>&nbsp; <i class="fa fa-angle-down"></i>
                            </div>
                            <input type="hidden" name="start" value="">
                            <input type="hidden" name="end" value="">
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                        <div class="card" style="border: 1px solid">
                            <div class="card-body">
                                <a href="javascript:;" class="d-flex align-items-center justify-content-md-center" style="color:black;text-decoration:none">
                                    <i class="mdi mdi-wallet icon-lg text-primary"></i>
                                    <div class="ml-3">
                                        <p class="mb-0">Total Agreed Amount</p>
                                        <h6 class="agreedAmount">${{@$agreedAmount ?? 0}}</h6>
                                    </div>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                        <div class="card" style="border: 1px solid">
                            <div class="card-body">
                                <a href="javascript:;" class="d-flex align-items-center justify-content-md-center" style="color:black;text-decoration:none">
                                    <i class="mdi mdi-wallet icon-lg text-danger"></i>
                                    <div class="ml-3">
                                        <p class="mb-0">Total Received Amount</p>
                                        <h6 class="recivedAmount">${{@$recivedAmount ?? 0}}</h6>
                                    </div>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 grid-margin stretch-card">
                        <div class="card" style="border: 1px solid">
                            <div class="card-body">
                                <a href="javascript:;" class="d-flex align-items-center justify-content-md-center" style="color:black;text-decoration:none">
                                    <i class="mdi mdi-wallet icon-lg text-success"></i>
                                    <div class="ml-3">
                                        <p class="mb-0">Total Paid Amount</p>
                                        <h6 class="paidAmount">${{@$paidAmount ?? 0}}</h6>
                                    </div>
                                </a>
                                
                            </div>
                        </div>
                    </div>
                </div>
               
                
                <div class="table-responsive mt-0">
                    <table id="summary_datatable" class="table table-striped table-bordered table-hover dataTable no-footer" aria-describedby="datatable_ajax_info" role="grid" style="width:100%">
                        <thead>
                            <tr class="text-right">
                                <th >Sr. No.</th>
                                <th class="text-left">Project</th>
                                <th >Creation Date</th>
                                <th >Allocation Date</th>
                                <th >Project Duration</th>
                                <th >Agreed Amount</th>
                                <th >Recieved Amount</th>
                                <th >Paid Amount</th>
                                <th >Talent ID</th>
                                <th >Talent Name</th>
                                <th >Client Name</th>
                                <th >Status</th>
                            </tr>
                        </thead>
                        <tbody id="dynamicContent">
                            @include('admin.reports.project-wise-summary.list')
                        </tbody>
                    </table>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>


@endsection

@section('footerScript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
    var start = moment().subtract(30, 'days');
    var end = moment();
     var jqxhr = {abort: function () {  }};
     var full_path = "{{url('admin')}}";

    $(document).ready(function() {
        //$('#summary_datatable').DataTable({sDom: 'lrtip'});
        $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        function cb(start, end) {
            $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            $('input[name="start"]').val(start.format('DD/MM/YYYY'))
            $('input[name="end"]').val(end.format('DD/MM/YYYY'))
            loadListings(full_path + '/project-wise-summary/?page=');
            
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

        function loadListings(url){

            var filtering = $("form[name=filter_listing]").serialize();
            //abort previous ajax request if any
            jqxhr.abort();
            jqxhr =$.ajax({
                type : 'get',
                url : url,
                data : filtering,
                dataType : 'json',
                beforeSend:function(){
                    startLoader('body');
                },
                success : function(data){
                    
                    $("#dynamicContent").empty().html(data.html);
                    $('.agreedAmount').text(data.agreedAmount);
                    $('.paidAmount').text(data.paidAmount);
                    $('.recivedAmount').text(data.recivedAmount);
                },
                error : function(response){
                    stopLoader('body');
                },
                complete:function(){
                    stopLoader('body');
                }
            });
        }
    });

</script>
@endsection