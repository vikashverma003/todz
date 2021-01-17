@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
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
                    <h4 class="card-title">Escalations List</h4>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Talent Name</th>
                                    <th>Project Name</th>
                                    <th>Milestone</th>
                                    <th>Client Name</th>
                                    <th>Escalation Date</th>
                                    <th>Status</th>
                                    <th>Resolution Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $key=1 @endphp
                                @if($data->isNotEmpty())
                                    @foreach ($data as $com)
                                        <tr>
                                            <td>{{$key++}}</td>
                                            <td><a href="{{url('admin/talents/'.$com->talent_id.'/edit')}}"><span class="badge badge-success">{{@$com->talent->first_name}} {{@$com->talent->last_name}}</span></a></td>
                                            <td><a href="{{url('admin/projects/'.$com->project_id)}}"><span class="badge badge-danger">{{@$com->project->title}}</span></a></td>
                                            <td>{{@$com->milestone->title}}</td>
                                             <td><a href="{{url('admin/clients/'.$com->owner_id.'/edit')}}"><span class="badge badge-warning">{{@$com->client->first_name}} {{@$com->client->last_name}}</span></a></td>
                                             <td>{{date('d F Y',strtotime(@$com->created_at))}}</td>
                                            <td >
                                                @if(!$com->status)
                                                <span class="badge badge-danger">Pending</span>
                                                @else
                                                <span class="badge badge-success">Resolved</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($com->status)
                                                {{date('d F Y',strtotime(@$com->updated_at))}}
                                                @else
                                                -
                                                @endif
                                            </td>
                                            <td>
                                                <a class="action-button" href="{{url('admin/escalations/'.$com->id)}}" data-toggle="tooltip" title="View">
                                                    <i class=" icon-eye menu-icon"></i>
                                                    <span class="menu-title"></span>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9" style="text-align:center">No Record Exist</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection