<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script>
    $(document).ready(function(){
        $(document).on('click','.AcceptButton',function(e){
            let project_id=$(this).data('id');
            $("#acceoptModel_project_id").val(project_id);
            $('#AcceptModel').modal('show');
        });
        $(document).on('submit','#accept_form',function(e){
            e.preventDefault();
            var formobject=$(this);
            $(".loader-icon").show();
          $(".btn-content").hide();
            $.ajax({
            type:'POST',
            url:'{{route("accept_action")}}',
            data:formobject.serialize(),
            success:function(response){
                $(".loader-icon").hide();
                $(".btn-content").show();
                if(response.status==1){
            //    / swal("Accepted", response.message, "success");
                swal({title: "Accepted", text: response.message, type: "success"}).then(function(){ 
   location.reload();
   }
);
            }else{
              swal({title: "Oops!", text: response.message, type: "error"});
            }
            }
        });
        })
    });
    </script>
