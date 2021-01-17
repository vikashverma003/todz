@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)


@section('content')
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        {{-- <div class="d-flex align-items-center justify-content-md-center"> --}}
                        <a href="#" class="d-flex align-items-center justify-content-md-center" style="color:black;text-decoration:none">
                            <i class="mdi mdi-wallet icon-lg text-success"></i>
                            <div class="ml-3">
                                <p class="mb-0">Total Revenue</p>
                                <h6>${{$projectTotalRevenue}}</h6>
                            </div>
                        </a>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
            </div>

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <a href="#" class="d-flex align-items-center justify-content-md-center" style="color:black;text-decoration:none">
                    
            
                    <i class="mdi mdi-upload icon-lg text-success"></i>
                    <div class="ml-3">
                      <p class="mb-0">Total Job posted</p>
                      <h6>{{$projectsCount}}</h6>
                    </div>
                  {{-- </div> --}}
                  </a>
                </div>
              </div>
            </div>
{{--             
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <p class="mb-0">Total Client</p>
                      <h6>{{$client}}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <p class="mb-0">Total Talents</p>
                      <h6>{{$talents}}</h6>
                    </div>
                  </div>
                </div>
              </div>
            </div> --}}
          </div>
          <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Revenues Graph</h4>
                  <select id="revenue_filter" class="float-right">
                    <option value="1" {{isset($_GET['revenueShow'])?$_GET['revenueShow']==1?'selected="selected"':'':''}}>All</option>
                    @foreach($getRevenueYear as $y)
                  <option value="{{$y->year}}" {{isset($_GET['revenueShow'])?$_GET['revenueShow']==$y->year?'selected="selected"':'':''}}>{{$y->year}}</option>
                    @endforeach
                  </select>                 
                   <canvas id="revenueChart" style="height:400px!important"></canvas>
                </div>
              </div>
            </div>
            <div class="col-lg-6 grid-margin stretch-card">
           
              <div class="card">
               
                <div class="card-body">
                    <h4 class="card-title">Projects Graph</h4>
                  <select id="project_filter" class="float-right">
                    <option value="1" {{isset($_GET['projectShow'])?$_GET['projectShow']==1?'selected="selected"':'':''}}>All</option>
                    <option value="2" {{isset($_GET['projectShow'])?$_GET['projectShow']==2?'selected="selected"':'':''}}>this month</option>
                    <option value="3" {{isset($_GET['projectShow'])?$_GET['projectShow']==3?'selected="selected"':'':''}}>this year</option>
                  </select>
                  {{-- <h4 class="card-title">Line chart</h4> --}}
                  <canvas id="projectsChart" style="height:250px"></canvas>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Talents v/s Clients</h4>
                    <canvas id="userChart" style="height:250px"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-4 stretch-card">
              <div class="row flex-grow">
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                      <a href="#" class="card-body" style="color:black;text-decoration:none">
                          
                      <h6 class="card-title mb-0">Total Talents</h6>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                          <div class="d-lg-flex">
                            <h2 class="mb-0">{{$talents}}</h2>
                           
                          </div>
                         
                        </div>
                        <div class="d-inline-block">
                          <div class="bg-success px-3 px-md-4 py-2 rounded">
                            <i class="mdi mdi-account icon-lg text-white"></i>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
                <div class="col-12 grid-margin stretch-card">
                  <div class="card">
                    <a href="#" class="card-body" style="color:black;text-decoration:none">
                        
                      <h6 class="card-title mb-0">Total Clients</h6>
                      <div class="d-flex justify-content-between align-items-center">
                        <div class="d-inline-block pt-3">
                          <div class="d-lg-flex">
                          <h2 class="mb-0">{{$client}}</h2>
                            
                          </div>
                         
                        </div>
                 
                        <div class="d-inline-block">
                          <div class="bg-warning px-3 px-md-4 py-2 rounded">
                            <i class="mdi mdi-account icon-lg text-white"></i>
                          </div>
                        </div>
                      </div>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
       
@endsection

@section('footerScript')
@parent
  <!-- Plugin js for this page-->
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
     if ($("#userChart").length) {
      var lineChartCanvas = $("#userChart").get(0).getContext("2d");
      var lineChart = new Chart(lineChartCanvas, {
        type: 'line',
        data: data,
        options: options
      });
    }
    });

    </script>
    <script>
    let projectData=JSON.parse('<?php echo $projectAnalitics;?>');
var data = {
  labels: projectData.projectLabel,
  datasets: [
    {
      data: projectData.projectCount,
      backgroundColor: [
        "#e41a1c",
        "#9aed8b",
        "#377eb8",
        "#4daf4a",
        "#984ea3",
        "#ff7f00",
        "#ffff33",
        "#55dde0"
      ],
      hoverBackgroundColor: [
        "#e41a1c",
        "#9aed8b",
        "#377eb8",
        "#4daf4a",
        "#984ea3",
        "#ff7f00",
        "#ffff33",
        "#55dde0"
      ],
      hoverBorderColor: [
        "#e41a1c",
        "#9aed8b",
        "#377eb8",
        "#4daf4a",
        "#984ea3",
        "#ff7f00",
        "#ffff33",
        "#55dde0"
      ]
    }]
};

var myChart = new Chart(document.getElementById('projectsChart'), {
  type: 'pie',
  data: data,
  options: {
  	responsive: true,
    tooltips: {
        enabled: true
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
    cutoutPercentage: 0,
    // tooltips: {
    // 	filter: function(item, data) {
    //     var label = data.labels[item.index];
    //     if (label) return item;
    //   }
    // }
  }
});
$("#project_filter").on("change",function(e){
    let selectValue=$(this).val();
    var url = window.location.href.split('?')[0];
       
    if (url.indexOf('?') > -1){
       url += '&projectShow='+selectValue
    }else{
       url += '?projectShow='+selectValue
    }
    window.location.href = url;
});

    </script>
    <script>
      
      let projectData1=JSON.parse('<?php echo $adminRevenueBarChart;?>');
      var chr = document.getElementById("revenueChart");      
      var ctx = chr.getContext("2d");    	
	    // ctx.canvas.width = 800;
	    var data = {
      type: "bar",
      data: {
        labels: projectData1.projectLabel,
        datasets: [{
          label: "Revenue",
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
          data:projectData1.projectCount
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

    $("#revenue_filter").on("change",function(e){
let selectValue=$(this).val();
var url = window.location.href.split('?')[0];    
if (url.indexOf('?') > -1){
   url += '&revenueShow='+selectValue
}else{
   url += '?revenueShow='+selectValue
}
window.location.href = url;
});
    </script>   
    
  <!-- End plugin js for this page-->
  @endsection