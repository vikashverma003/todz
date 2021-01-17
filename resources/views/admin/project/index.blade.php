@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',@$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
@php
$type = isset($data['type'])?$data['type']:'';
@endphp
<div class="content-wrapper">
   <ul class="nav nav-tabs">
      <li class="nav-item">
        <a class="nav-link active" data-toggle=tab  href="#ongoing" id="ongoing_projects">Ongoing</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle=tab  href="#upcoming" id="upcoming_projects">Upcoming</a>
      </li>
      <li class="nav-item">
         <a class="nav-link" data-toggle=tab  href="#past" id="past_projects">Past Jobs</a>
       </li>
    </ul>
    <div class="tab-content" style="margin:0;padding:0">

 <input type="hidden" name="project_type" id="project_type" value="{{$type}}">
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
               <h4 class="card-title">Ongoing Project List</h4>
           
               {{-- <div class="table-responsive"> --}}
                  <div >
                  <table class="table">
                     <thead>
                        <tr>
                           <th width="2%">#</th>
                           <th width="15%">Client</th>
                           <th width="10%">Status</th>
                           <th width="20%">Project Title</th>
                           <th width="20%">Duration period</th>
                           <th width="10%">Cost</th>
                           <th width="15%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @if(!$ongoing_projects->isEmpty())
                        @foreach ($ongoing_projects as $project)
                        <tr>
                            <td>{{$key++}}</td>
                            <td><a href="{{url('admin/clients/'.$project->user_id.'/edit')}}">{{@$project->client->first_name}} {{@$project->client->last_name}}</a></td>
                            <td><span class="badge badge-danger">{{@$project->status}}</span></td>
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
                              <a class="action-button" href="{{url('admin/projects/'.$project->id)}}" data-toggle="tooltip" title="View">
                                <i class=" icon-eye menu-icon"></i>
                                <span class="menu-title"></span>
                              </a>
                               <form style="display:inline" action="{{url('admin/projects/'.$project->id.'?page='.app('request')->input('page'))}}" onsubmit="return confirm('Do you really want to Delete this Project?');" method="POST">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="action-button" ><i class="  icon-trash menu-icon"></i>
                            <span class="menu-title"></span></button>
                              </form>
                               <!-- <a class="action-button" href="{{url('admin/projects/'.$project->id)}}" data-toggle="tooltip" title="Edit">
                                <i class=" icon-trash menu-icon"></i>
                                <span class="menu-title"></span>
                              </a> -->
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
                  {{ $ongoing_projects->appends(['type'=>'ongoing'])->render() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
.
<div id="upcoming" class="container tab-pane"><br>
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
               <h4 class="card-title">Upcoming project List</h4>
               {{-- <a class="nav-link add_button" href="{{url('admin/parts/create')}}">
                <i class=" icon-plus menu-icon"></i>
                <span class="menu-title">Add</span>
              </a> --}}
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                            <th width="2%">#</th>
                           <th width="15%">Client</th>
                           <th width="10%">Status</th>
                           <th width="20%">Project Title</th>
                           <th width="20%">Duration period</th>
                           <th width="10%">Cost</th>
                           <th width="15%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @if(!$upcoming_projects->isEmpty())
                        @foreach ($upcoming_projects as $project)
                        <tr>
                            <td>{{$key++}}</td>
                           <td><a href="{{url('admin/clients/'.$project->user_id.'/edit')}}">{{@$project->client->first_name}} {{@$project->client->last_name}}</a></td>
                            <td><span class="badge badge-danger">{{@$project->status}}</span></td>
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
                              <a class="action-button" href="{{url('admin/projects/'.$project->id)}}" data-toggle="tooltip" title="View">
                                <i class=" icon-eye menu-icon"></i>
                                <span class="menu-title"></span>
                              </a>
                              <form style="display:inline" action="{{url('admin/projects/'.$project->id.'?page='.app('request')->input('page'))}}" onsubmit="return confirm('Do you really want to Delete this Project?');" method="POST">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="action-button" ><i class="  icon-trash menu-icon"></i>
                            <span class="menu-title"></span></button>
                              </form>
                             <!--   <a class="action-button" href="{{route('projects.destroy',$project->id)}}" data-toggle="tooltip" title="Edit">
                                <i class=" icon-trash menu-icon"></i>
                                <span class="menu-title"></span>
                              </a> -->
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
                  {{ $upcoming_projects->appends(['type'=>'upcoming'])->render() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="past" class="container tab-pane"><br>
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
               <h4 class="card-title">Past Project List</h4>
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th width="2%">#</th>
                           <th width="15%">Client</th>
                           <th width="10%">Status</th>
                           <th width="20%">Project Title</th>
                           <th width="20%">Duration period</th>
                           <th width="10%">Cost</th>
                           <th width="15%">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @php $key=1
                        @endphp
                        @if(!$past_projects->isEmpty())
                        @foreach ($past_projects as $project)
                        <tr>
                            <td>{{$key++}}</td>
                            <td><a href="{{url('admin/clients/'.$project->user_id.'/edit')}}">{{@$project->client->first_name}} {{@$project->client->last_name}}</a></td>
                            <td><span class="badge badge-danger">{{@$project->status}}</span></td>
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
                              <a class="action-button" href="{{url('admin/projects/'.$project->id)}}" data-toggle="tooltip" title="View">
                                <i class=" icon-eye menu-icon"></i>
                                <span class="menu-title"></span>
                              </a>
                               <form style="display:inline" action="{{url('admin/projects/'.$project->id.'?page='.app('request')->input('page'))}}" onsubmit="return confirm('Do you really want to Delete this Project?');" method="POST">
                              @method('DELETE')
                              @csrf
                              <button type="submit" class="action-button" ><i class="  icon-trash menu-icon"></i>
                            <span class="menu-title"></span></button>
                              </form>
                               <!-- <a class="action-button" href="{{url('admin/projects/'.$project->id)}}" data-toggle="tooltip" title="Edit">
                                <i class=" icon-trash menu-icon"></i>
                                <span class="menu-title"></span>
                              </a> -->
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
                  {{ $past_projects->appends(['type'=>'past'])->render() }}
               </div>
            </div>
         </div>
      </div>
   </div>
</div>


</div>
</div>

@endsection
@section('footerScript')
@parent

<script>
     $(document).ready(function(){
     var type = $('#project_type').val();
     if(type == 'ongoing')
     {
      $( "#ongoing_projects" ).trigger( "click" );
     }
      else if(type == 'upcoming')
      {
        $( "#upcoming_projects" ).trigger( "click" );
      }
      else if(type == 'past')
      {
        $( "#past_projects" ).trigger( "click" );
      }
   });
   $(document).ready(function(){
     $(".nav-tabs a").click(function(){
       $(this).tab('show');
     });
   });
</script>

   @endsection