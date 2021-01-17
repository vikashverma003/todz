
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
  integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
  crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script type="text/javascript" src="{{asset('web/js/site-cookie.js')}}"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-168936151-1"></script>

<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-168936151-1');
</script>

<!-- endinject -->
<script>
    $(document).ready(function () {
      $('.toggleDiv').click(function (e) {
          e.preventDefault();
          e.stopPropagation();
          $('.profileDiv').toggleClass("main");
      });
      // $('.registerDiv').click(function (e) {
      //   e.stopPropagation();
      // });
      $('body').click(function () {
          $('.profileDiv').removeClass("main");
      });
  });
  $(document).ready(function () {
      $('.togglebtn').click(function (e) {
          e.preventDefault();
          e.stopPropagation();
          $('.notificationDiv').toggleClass("new");
      });
      // $('.registerDiv').click(function (e) {
      //   e.stopPropagation();
      // });
      $('body').click(function () {
          $('.notificationDiv').removeClass("new");
      });
  });
function togglePasssword() {
    var x = document.getElementById("password");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}
$("#deactivateAc").click(function(e){
  e.preventDefault();
  swal({
        title: "Sure",
        text: "Do you want to deactivate account?",
        icon: "warning",
        buttons: true,
        dangerMode: false,
        })
        .then((willconfirm) => {
          if (willconfirm) {
            jQuery.ajax({
            type:'POST',
            url:'{{url("deactivate-account")}}',
            data:{ "_token": "{{ csrf_token() }}",
             },
            success:function(response){
                if(response.status==1){
            //    / swal("Accepted", response.message, "success");
                swal({title: "Success", text: response.msg, type: "success"}).then(function(){ 
   location.reload();
   }
);
            }else{
              swal({title: "Oops!", text: response.msg, type: "error"});
            }
            }
            
        });
    }
        });
    });
</script>
    @section('footerScript')
    @show

  