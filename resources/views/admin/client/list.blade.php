@if($clients->isNotEmpty())
    @php
        $i= ($clients->currentPage() - 1) * $clients->perPage() + 1;
    @endphp

    @foreach ($clients as $com)
        <tr>
            <td class="sr_no">{{$i}}</td>
            <td class="sr_no">{{$com->projects->count() ?? 0}}</td>
            <td>{{@$com->first_name}} {{@$com->last_name}}</td>
            <td>{{@$com->todz_id}}</td>
            
            <td>{{@$com->email}}</td>
            <td>+ {{@$com->phone_code}} {{@$com->phone_number}}</td>
            <td>{{@$com->country??'N/A'}}</td>
            <td>
                @if($com->account_status==config('constants.account_status.ACTIVE'))
                    <span class="badge badge-success">Active</span>
                @elseif($com->account_status==config('constants.account_status.DEACTIVATE_ACCOUNT'))
                <span class="badge badge-danger">Deactivated</span>
                @elseif($com->account_status==config('constants.account_status.BLOCK'))
                <span class="badge badge-danger">Blocked</span>
                @else
                    <span class="badge badge-danger">Inactive</span>
                @endif
            </td>
            <td >
                @if($com->entity==config('constants.entity.CORPORATE'))
                    <span class="badge badge-success">Corporate</span>
                @elseif($com->entity==config('constants.entity.INDIVIDUAL'))
                    <span class="badge badge-warning">Individual</span>
                @elseif($com->entity==config('constants.entity.PRIVATE'))
                    <span class="badge badge-danger">Private</span>
                @endif
            </td>
            <td>{{$com->created_at}}</td>
            <td>
                <a class="action-button" href="{{route('clients.edit',[$com->id])}}" data-toggle="tooltip" title="Edit"><i class=" icon-pencil menu-icon"></i><span class="menu-title"></span></a>

                <a class="action-button" href="{{url('admin/clients/'.$com->id)}}" data-toggle="tooltip" title="View">
                    <i class=" icon-eye menu-icon"></i>
                    <span class="menu-title"></span>
                </a>
                
                <button type="button" class="action-button delete_user" data-id="{{$com->id}}">
                    <i class="icon-trash menu-icon"></i>
                    <span class="menu-title"></span>
                </button>
            
            </td>
        </tr>
        @php $i++; @endphp
    @endforeach
<tr>
    <td colspan="8">{{ $clients->links() }}</td>
</tr>
@else
    <tr>
        <td colspan="8" style="text-align: center;">No Data Available</td>
    </tr>
@endif