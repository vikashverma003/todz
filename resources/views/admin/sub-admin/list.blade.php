@if($users->isNotEmpty())
    @php
        $i= ($users->currentPage() - 1) * $users->perPage() + 1;
    @endphp

    @foreach ($users as $com)
        <tr>
            <td>{{$i}}</td>
            <td>{{@$com->first_name}} {{@$com->last_name}}</td>
            <td>{{@$com->email}}</td>
            <td>+ {{@$com->phone_code}} {{@$com->phone_number}}</td>
            <td >
              @if($com->account_status==config('constants.account_status.ACTIVE'))
              <span class="badge badge-success">Active</span>
              @else
              <span class="badge badge-danger">Inactive</span>
              @endif
            </td>
            
            <td>{{$com->created_at}}</td>
            <td>
                <a class="action-button" href="{{route('sub-admins.edit',[$com->id])}}" data-toggle="tooltip" title="Edit">
                    <i class=" icon-pencil menu-icon"></i>
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
    <td colspan="8">{{ $users->links() }}</td>
</tr>
@else
    <tr>
        <td colspan="8" style="text-align: center;">No Data Available</td>
    </tr>
@endif