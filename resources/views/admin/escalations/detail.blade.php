@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)

@section('content')
<style>
    .modal-content{
        width: 400px !important;
    }
</style>
<div class="content-wrapper">
    <div class="row">
        <div class="profile-data" style="border-radius: 8px;margin:auto;width:90% !important;">
            <div class="col-md-12  grid-margin stretch-card">
                <div class="row col-md-12">
                    <div class="col-md-12">
                        <h4>Escalation Details
                            @if($data->status == config('constants.ESCLARATION_STATUS.PENDING'))
                            <button class="btn own_btn_background btn  btn-sm" data-id="{{$data->id}}" onclick="resolve_issue(this)">Resolve</button>
                            @endif
                        </h4>
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Talent Name</h3>
                                <p>{{@$data->talent->first_name}} {{@$data->talent->last_name}}</p>
                            </div>
                            <div class="col-md-4">
                                <h3>Project Name</h3>
                                <p>{{@$data->project->title}}</p>
                            </div>
                            <div class="col-md-4">
                                <h3>Milestone </h3>
                                <p>{{$data->milestone->title ?? 'N/A'}}</p>
                            </div>
                            <div class="col-md-4">
                                <h3>Owner Name</h3>
                                <p>{{@$data->client->first_name}} {{@$data->client->last_name}}</p>
                            </div> 
                            <div class="col-md-4">
                                <h3>Status</h3>
                                
                                @if(!$data->status)
                                   <p> Pending</p>
                                @else
                                   <p> Resolved </p>
                                @endif
                                
                            </div> 
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Comment</h3>
                                <p>{{$data->comment ?? 'N/A'}}</p>
                            </div>
                        @if($data->status)
                            <div class="col-md-4">
                                <h3>Admin Comment</h3>
                                <p>{{$data->admin_comment ?? 'N/A'}}</p>
                            </div>
                        @endif
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <h3>Esclaration Raised On</h3>
                                <p>{{date('d F Y',strtotime($data->created_at))}}</p>
                            </div>
                        @if($data->status)
                            <div class="col-md-4">
                                <h3>Escalaration Resolved On</h3>
                                <p>{{date('d F Y',strtotime($data->updated_at))}}</p>
                            </div>
                        @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
  <div class="modal fade" id="resolveIssueModel" role="dialog">
   <div class="modal-dialog modal-sm">
     <div class="modal-content">
       <div class="modal-header">
          <h2>Resolve Issue</h2>
         <button type="button" class="close" data-dismiss="modal">&times;</button>
       </div>
       <div class="modal-body">
         <form id="RsolveIssueForm" action="{{route('resolve_esclaration_issue')}}" method="post">
            @csrf
            <input type="hidden" name="esclaration_id" id="esclaration_id" value="" required/>
            <div class="form-group">
                <label for="admin_comment">Comment :</label>
               <textarea class="form-control" id="admin_comment" name="admin_comment" placeholder="Enter Comment Here..." required></textarea>
            </div>
            <div class="form-group">
                <label for="in_favour">In Favor :</label>
                <select id="in_favour" name="in_favour" class="form-control" required>
                    <option value="{{config('constants.role.CLIENT')}}">Client</option>
                    <option value="{{config('constants.role.TALENT')}}">Talent</option>
                </select>
            </div>
            <br>
            <input type="submit" class="btn btn-danger mt-2" >
         </form>
       </div>
    
     </div>
   </div>
 </div> 
@endsection
@section('footerScript')
@parent
<script type="text/javascript">
    function resolve_issue(obj)
    {
        var id = $(obj).data('id');
        $('#esclaration_id').val(id);
        $('#resolveIssueModel').modal({ show: true });

    }
    $(document).ready(function(){ 
    var success = "{!! $success !!}";
    if(success == 1)
    {
      alert('Issue Resolved Successfully');
    }
  });
</script>

   @endsection