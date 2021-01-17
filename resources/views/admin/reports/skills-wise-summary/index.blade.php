@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">

<div class="content-wrapper">
    
   <div class="row">
      <div class="col-lg-12 stretch-card">

         <div class="card">
            <div class="card-body">
               <div class="row">
                    <div class="col-md-6">
                        <h4 class="card-title">Skills Wise Summary</h4>
                    </div>
                    <!-- <div class="col-md-6 float-right text-right">
                        <a href="javascript:demoFromHTML()" class="btn btn-primary mb-3 float mr-2 print-hide" >
                            <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                            
                            PDF
                        </a>
                    </div> -->
                </div>
                
                <div class="table-responsive mt-0">
                    <table id="summary_datatable" class="table table-striped table-bordered table-hover dataTable no-footer" aria-describedby="datatable_ajax_info" role="grid" style="width:100%">
                        <thead>
                            <tr class="text-left">
                                <th >Sr. No.</th>
                                <th class="text-left">Skill</th>
                                <th class="text-left">No of Talents</th>
                                <th class="text-left">No. of Projects</th>
                                <th class="text-left">Project's Countries</th>
                            </tr>
                        </thead>
                        <tbody id="dynamicContent">
                            @include('admin.reports.skills-wise-summary.list')
                        </tbody>
                    </table>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<div class="modal-dialog" role="document">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="exampleModalLabel">Reason</h5>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
<span aria-hidden="true">&times;</span>
</button>
</div>
<div class="modal-body">
    <p class="close_reason">
        
    </p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

@endsection

@section('footerScript')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    var start = moment().subtract(30, 'days');
    var end = moment();
     var jqxhr = {abort: function () {  }};
     var full_path = "{{url('admin')}}";

    $(document).ready(function() {

        $(document).on('click','.viewReason', function(){
            $('.close_reason').html($(this).data('text'));
        });

        $('#summary_datatable').DataTable({
            // sDom: 'lrtip',
            dom: 'Bfrtip',
            buttons: [
                'print', 'pdf'
            ]
        });
        $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

        function cb(start, end) {
            $('#dashboard-report-range span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
            
            $('input[name="start"]').val(start.format('DD/MM/YYYY'))
            $('input[name="end"]').val(end.format('DD/MM/YYYY'))
            loadListings(full_path + '/skills-wise-summary/?page=');
            
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
                    // data = data.trim();
                    $("#dynamicContent").empty().html(data.html);
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
<script>
    function demoFromHTML() {
        window.print();
        return;
    }
</script>
@endsection