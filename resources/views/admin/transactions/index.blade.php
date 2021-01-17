@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-lg-6 grid-margin stretch-card">
          <div class="card">
            <div class="card-body">
              {{-- <h4 class="card-title">Line chart</h4> --}}
              <canvas id="transactionChart" style="height:250px"></canvas>
            </div>
          </div>
        </div>
        <div class="col-lg-6 grid-margin stretch-card">
            <div class="card">
              <div class="card-body">
                {{-- <h4 class="card-title">Line chart</h4> --}}
                <canvas id="earningChart" style="height:250px"></canvas>
              </div>
            </div>
          </div>
      </div>
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
               <h4 class="card-title">Transactions</h4>
               

               <div class="table-responsive">
                    <form name="filter_listing">
                        <table class="table table-striped table-bordered table-hover dataTable no-footer" id="datatable_ajax" aria-describedby="datatable_ajax_info" role="grid">
                            <thead>
                                <tr role="row" class="heading">
                                    <th width="7%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Sr. No
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Project Id
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        From User Id
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Payment Type
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        To User Id
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Amount
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Fee
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Transaction Id
                                    </th>
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Date
                                    </th>
                                    
                                    <th width="10%" class="sorting" tabindex="0" aria-controls="datatable_ajax" rowspan="1" colspan="1">
                                        Actions
                                    </th>
                                </tr>
                                
                            </thead>
                            <tbody id="dynamicContent">
                                @include('admin.transactions.list')
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
            loadListings(full_path + '/transactions/?page=');
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

        $(document).on('keyup', '#name, #email, #phone', function () {
            if($(this).val().length > 2)
            {
                loadListings(full_path + '/transactions/?page=');
            }
            if($(this).val().length == 0)
            {
                loadListings(full_path + '/transactions/?page=');
            }
        });

        $(document).on('change', '#filterStatus,#orderby', function () {
            loadListings(full_path + '/transactions/?page=');
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

            loadListings(full_path +'/transactions/?page=');
        });
    });
</script>
<script src="{{asset('admin/node_modules/chart.js/dist/Chart.min.js')}}"></script>
  <script>
    $(document).ready(function(){
      var data = {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
      datasets: <?php echo json_encode($usersGraph);?>
    };
     var options = {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          },
          gridLines: {
            drawBorder: true,
           // color:"rgba(0,0,0,0)",
           // zeroLineColor:"rgb(0, 0, 0)"
            }
        }],
        xAxes: [{
            gridLines: {
             // drawBorder: true,
            //  color: "rgba(0, 0, 0,0)",
            //  zeroLineColor:"rgb(0, 0, 0)"
            }
        }]
      },
      legend: {
        display: true,
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
    };
     if ($("#transactionChart").length) {
      var lineChartCanvas = $("#transactionChart").get(0).getContext("2d");
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: data,
        options: options
      });
    }
    });
    </script>
    <script>
    $(document).ready(function(){
      var data = {
      labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
      datasets: <?php echo json_encode($earningGraph);?>
    };
     var options = {
      scales: {
        yAxes: [{
          ticks: {
            beginAtZero: true
          },
          gridLines: {
            drawBorder: true,
           // color:"rgba(0,0,0,0)",
           // zeroLineColor:"rgb(0, 0, 0)"
            }
        }],
        xAxes: [{
            gridLines: {
             // drawBorder: true,
            //  color: "rgba(0, 0, 0,0)",
            //  zeroLineColor:"rgb(0, 0, 0)"
            }
        }]
      },
      legend: {
        display: true,
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
    };
     if ($("#earningChart").length) {
      var lineChartCanvas = $("#earningChart").get(0).getContext("2d");
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: data,
        options: options
      });
    }
    });
    </script>
@endsection