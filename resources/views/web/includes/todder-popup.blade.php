 <!-- Congras modal -->
 <div class="modal fade" id="AcceptModel" tabindex="-1" role="dialog" aria-labelledby="basicModal"
 aria-hidden="true">
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-body">
       <h2>Feedback</h2>
         <form action="{{route('accept_action')}}" id="accept_form" method="post">
            @csrf
            <input type="hidden" id="acceoptModel_project_id" name="project_id" value="">
            <div class="form-group mb-4">
            <input class="form-control custom" type="text" name="no_of_days" placeholder="Number of Days" required="" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
            </div>
            <div class="form-group mb-4">
            <input class="form-control custom" type="text" name="no_of_hours" placeholder="Number of hours" required="" onkeyup="this.value=this.value.replace(/[^\d]/,'')">
            </div>
            {{-- <button type="button" class="acceptBtn" >Accept</button> --}}
            <button type="submit"  class="theme-button hover-ripple full-width mb-3"><i class="fa fa-circle-o-notch fa-spin loader-icon" style="display:none"></i><span class="btn-content">Accept</span></button>                                
        </form>        
     </div>
   </div>
 </div>
</div>

