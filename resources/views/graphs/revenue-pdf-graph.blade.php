<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>

<body>
    <h4 class="card-title">Revenues Summary Graph</h4>             
    <canvas id="revenueChart" style="height:400px!important"></canvas>
</body>
<script src="{{asset('admin/node_modules/jquery/dist/jquery.min.js')}}"></script>
<script src="{{asset('admin/node_modules/popper.js/dist/umd/popper.min.js')}}"></script>
<script src="{{asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('admin/node_modules/chart.js/dist/Chart.min.js')}}"></script>

<script type="text/javascript">
    var projectLabel =[];
    var projectCount =[];
    @foreach($revenueResponse as $key)
        projectLabel.push("{{$key['label']}}");
        projectCount.push("{{$key['value']}}");
    @endforeach

    window.onload = function() {
        makeChart(projectLabel,projectCount);
    };

    function makeChart(projectLabel,projectCount){
        
        var chr = document.getElementById("revenueChart");      
        var ctx = chr.getContext("2d");       
        // ctx.canvas.width = 800;
        var data = {
            type: "bar",
            data: {
                labels: projectLabel,
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
</script>
</html>