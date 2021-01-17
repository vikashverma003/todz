@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)

@section('content')
<style type="text/css">
    table#datatable_ajax td.sr_no{
        min-width: 120px !important;
    }
   @media print { 
        nav.navbar.col-lg-12.col-12.p-0.fixed-top.d-flex.flex-row {
            display: none !important;
            }
            nav#sidebar {
    display: none;
}
div#content{
    width:100% !important;
    margin-left:0 !important;
    padding:0 !important;
}
.print-hide,.footer{
    display:none;
}
.navbar.fixed-top + .page-body-wrapper,.card-body{
    padding-top:0;
}
    }
</style>
<div class="content-wrapper">
   <div class="row">
      <div class="col-lg-12 stretch-card">
         <div class="card">
            <div class="card-body">
               <h4 class="card-title">Clients Summary</h4>
             
               <div class="float-right">
                <a href="javascript:demoFromHTML()" class="btn btn-primary mb-3 float mr-2 print-hide" ><i class="fa fa-file-pdf-o" aria-hidden="true"></i>PDF</a>
            </div>

                <div class="table-responsive">
                    <form name="filter_listing">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="auto" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Sr. No
                                    </th>
                                    <th width="auto" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Date
                                    </th>
                                   <!--  <th width="15%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
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
                                    <th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Account Status
                                    </th>
                                    <th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Entity
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Actions
                                    </th>-->
                                    <th width="12%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                      Total Client
                                    </th>
                                </tr>
                                <tr role="row" class="filter print-hide">
                                    <td rowspan="1" colspan="1" class="sr_no">
                                        <select name="orderby" class="form-control" id="orderby">
                                            <option value="desc" selected>DESC</option>
                                            <option value="asc">ASC</option>
                                        </select>
                                    </td>
                                    <td rowspan="1" colspan="1">
                                        <div id="dashboard-report-range" class="pull-right tooltips btn btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range" style="color: black;border: 1px solid black">
                                            <i class="icon-calendar"></i>&nbsp; 
                                            <span class="thin uppercase visible-lg-inline-block">
                                                Select Date
                                            </span>&nbsp; <i class="fa fa-angle-down"></i>
                                        </div>
                                        <input type="hidden" name="start" value="">
                                        <input type="hidden" name="end" value="">
                                    </td>
                                   {{--  <td rowspan="1" colspan="1">
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
                                    <td>
                                        <select name="country[]" id="multiple" class="js-states form-control" multiple  class="form-control" autocomplete="off">
                                            @foreach($allCountries as $allc)
                                            <option value="{{$allc->country_name}}">{{$allc->country_name}}</option>
                                            @endforeach
                                            </select>
                                    </td>
                                    <td rowspan="1" colspan="1"></td>
                                    <td rowspan="1" colspan="1">
                                    <select name="entity" class="form-control" id="filterStatus">
                                            <option value="">All</option>
                                            <option value="private">Private</option>
                                            <option value="individual">Individual</option>
                                            <option value="corporate">Corporate</option>
                                        </select> 
                                    </td> --}}
                                    <td rowspan="1" colspan="1">
                                        <button class="btn btn-sm btn-danger red filter-cancel"><i class="fa fa-times"></i> Reset Filter</button>
                                    </td>
                                    
                                    
                                </tr>
                            </thead>
                            <tbody id="dynamicContent">
                                @include('admin.client.summary.list')
                            </tbody>
                        </table>
                    </form>
                </div>

                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">  
                                <h4 class="card-title">Clients Summary Graph</h4>             
                                <canvas id="revenueChart" style="height:400px!important"></canvas>
                            </div>
                        </div>
                    </div>
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
<script src="{{asset('admin/node_modules/chart.js/dist/Chart.min.js')}}"></script>

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
            loadListings(full_path + '/client-summary/?page=');
            getRevenueGraphs(start.format('DD/MM/YYYY'), end.format('DD/MM/YYYY'))
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
                loadListings(full_path + '/client-summary/?page=');
            }
            if($(this).val().length == 0)
            {
                loadListings(full_path + '/client-summary/?page=');
            }
        });

        $(document).on('change', '#filterStatus,#orderby', function () {
            loadListings(full_path + '/client-summary/?page=');
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

            loadListings(full_path +'/client-summary/?page=');
        });

         getRevenueGraphs("","");
    });

    function makeChart(projectLabel,projectCount){
        console.log("projectLabel"+projectLabel);
        console.log("projectCount"+projectCount);

        var chr = document.getElementById("revenueChart");      
        var ctx = chr.getContext("2d");       
        // ctx.canvas.width = 800;
        var data = {
            type: "bar",
            data: {
                labels: projectLabel,
                datasets: [{
                    label: "Client",
                    backgroundColor:[
                        "#e41a1c",
                        "#9aed8b",
                        "#377eb8",
                        "#4daf4a",
                        "#984ea3",
                        "#ff7f00",
                        "#ffff33",
                        "#ff7f00",
                        "#984ea3",
                        "#4daf4a",
                        "#377eb8",
                        "#9aed8b"
                    ],
                    fillColor: "blue",
                    strokeColor: "green",
                    data:projectCount
                }]
            },
            options: {
                scales: {
                    xAxes: [{
                        barThickness: 30,  // number (pixels) or 'flex'
                        maxBarThickness: 30 ,// number (pixels)
                        gridLines: {
                        display: false,
                       },
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false,
                        },
                    }]
                },
                legend: {
                display: false,
                labels: {
                    usePointStyle: true, // show legend as point instead of box
                    fontSize: 10 // legend point size is based on fontsize
                }
            },
            elements: {
                point: {
                  radius: 3
                }
            },
            pointDot: true,
                pointDotRadius : 6,
                datasetStrokeWidth : 6,
                bezierCurve : false,
            }
        };

        var myfirstChart = new Chart(chr , data);
    }

    const getRevenueGraphs = (start, end)=>{
        $.ajax({
            url:"{{url('admin/client-summary-graph')}}",
            type:'get',
            data:{
                'start':start,
                'end':end
            },
            beforeSend:function(){
                startLoader('body');
            },
            complete:function(){
                stopLoader('body');
            },
            success:function(data){
                
                if(data.status)
                {
                    var label =[];
                    var value =[];
                    $.each(data.data.clientResponse, function(key,val){
                        label.push(val.label);
                        value.push(val.value);
                    });
                    makeChart(label, value);
                }else{
                    makeChart([],[]);
                }
            },
            error:function(){
                makeChart([]);
            }
        });
    }
</script>

<script>
    function demoFromHTML() {
        window.print();
        return;
    }
</script>
@endsection