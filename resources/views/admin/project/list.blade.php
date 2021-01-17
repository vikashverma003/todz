@if($projects->isNotEmpty())
    @php
        $i= ($projects->currentPage() - 1) * $projects->perPage() + 1;
    @endphp

    @foreach ($projects as $project)
        <tr>
            <td>{{$i}}</td>
            <td><a href="{{url('admin/clients/'.$project->user_id.'/edit')}}">{{@$project->client->first_name}} {{@$project->client->last_name}}</a></td>
            <td>
                @if(@$project->status=='completed')
                <span class="badge badge-success">{{@$project->status}}</span>
                @elseif(@$project->status=='dispute')
                <span class="badge badge-danger">{{@$project->status}}</span>
                @else
                <span class="badge badge-warning">{{@$project->status}}</span>

                @endif

            </td>

            <td>{{$project->title}}</td>
        <td>
           <?php  $abc=$project->skills->pluck('name')->toArray(); ?>
            {{implode(',',$abc)}}
            {{-- @foreach($project->skills as $sk)
            {{$sk->name}}
            @endforeach --}}
        </td>
            <td >
                @if($project->duration_month > 0)
                {{$project->duration_month}} month
              @endif
              @if($project->duration_day > 0)
                {{$project->duration_day}} days
              @endif
            </td>
            <td>{{$project->cost}}</td>
            <td>{{$project->created_at}}</td>
            <td>
                <a class="action-button" href="{{route('projects.edit',[$project->id])}}" data-toggle="tooltip" title="Edit">
                    <i class=" icon-pencil menu-icon"></i>
                    <span class="menu-title"></span>
                </a>

                <a class="action-button" href="{{url('admin/projects/'.$project->id)}}" target="_blank" data-toggle="tooltip" title="View">
                    <i class=" icon-eye menu-icon"></i>
                    <span class="menu-title"></span>
                </a>

                <button type="button" class="action-button delete_user" data-id="{{$project->id}}">
                    <i class="icon-trash menu-icon"></i>
                    <span class="menu-title"></span>
                </button>

            </td>
        </tr>
        @php $i++; @endphp
    @endforeach
<tr>
    <td colspan="8">{{ $projects->links() }}</td>
</tr>
@else
    <tr>
        <td colspan="8" style="text-align: center;">No Data Available</td>
    </tr>
@endif