@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
    <div class="tab-content" style="margin:0;padding:0">
        <div id="ongoing" class="container tab-pane active"><br>
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
                       <h4 class="card-title">Project List</h4>
                   
                       {{-- <div class="table-responsive"> --}}
                          <div >
                          <table class="table table-responsive">
                                <thead>
                                    <tr>
                                       <th width="2%">#</th>
                                       <th width="15%">ID</th>
                                       <th width="20%">Title</th>
                                       <th width="20%">Period</th>
                                       <th width="10%">Cost</th>
                                       
                                       <th width="10%">Client Reason</th>
                                       <th width="10%">Talent Reason</th>
                                       <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $key=1
                                    @endphp
                                    @if(!$projects->isEmpty())
                                    @foreach ($projects as $project)
                                    <tr>
                                        <td>{{$key++}}</td>
                                        <td>PR_{{$project->id}}</td>
                                        <td>{{$project->title}}</td>
                                        <td>
                                            @if($project->duration_month > 0)
                                                {{$project->duration_month}} month
                                            @endif
                                            @if($project->duration_day > 0)
                                                {{$project->duration_day}} days
                                            @endif
                                        </td>

                                        <td>{{$project->cost}}</td>
                                        
                                        <td>
                                            <button type="button" data-text="{{$project->client_dispute_reason ? $project->client_dispute_reason: 'N/A'}}" class="btn btn-primary viewReason" data-toggle="modal" data-target="#exampleModal">
                                              View
                                            </button>
                                        </td>
                                        <td>
                                            <button type="button" data-text="{{$project->todder_dispute_reason ? $project->todder_dispute_reason: 'N/A'}}" class="btn btn-primary viewReason" data-toggle="modal" data-target="#exampleModal">
                                              View
                                            </button>
                                        </td>
                                        
                                        <td>
                                            N/A
                                        </td>
                                      </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                       <td colspan="7" style="text-align:center">No project record exist</td>
                                    </tr>
                                    @endif
                                 </tbody>
                            </table>
                            {{ $projects->render() }}
                       </div>
                    </div>
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
@parent
<script>
    $(document).ready(function(){
        $(document).on('click','.viewReason', function(){
            $('.close_reason').html($(this).data('text'));
        });
    });
</script>

   @endsection