 <!-- plugins:js -->
 <script src="{{asset('admin/node_modules/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('admin/node_modules/popper.js/dist/umd/popper.min.js')}}"></script>
  <script src="{{asset('admin/node_modules/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('admin/node_modules/perfect-scrollbar/dist/js/perfect-scrollbar.jquery.min.js')}}"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="{{asset('admin/js/off-canvas.js')}}"></script>
  <script src="{{asset('admin/js/hoverable-collapse.js')}}"></script>
  <script src="{{asset('admin/js/misc.js')}}"></script>
  <script src="{{asset('admin/js/settings.js')}}"></script>
  <script src="{{asset('admin/js/todolist.js')}}"></script>
  <script src="{{asset('admin/js/file-upload.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/waitme.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('web/js/loader.js')}}"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
        $('.Notificationtogglebtn').click(function (e) {
            e.preventDefault();
            e.stopPropagation();
            $('.notificationDiv').toggleClass("new");
        });
      
        $('body').click(function () {
            $('.notificationDiv').removeClass("new");
        });
    });
  </script>
  @section('footerScript')
  @show
  <!-- endinject -->