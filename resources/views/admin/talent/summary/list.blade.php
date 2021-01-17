@if($talents->isNotEmpty())
    @php
        $i= ($talents->currentPage() - 1) * $talents->perPage() + 1;
    @endphp

    @foreach ($talents as $com)
        <tr>
            <td class="sr_no">{{$i}}</td>
             <td>{{@$com->registration_date}}</td>
             <td>{{$com->count}}</td>
            {{--<td>{{@$com->first_name}} {{@$com->last_name}}</td>
            <td>{{@$com->todz_id}}</td>
            <td>{{@$com->email}}</td>
            <td>@if($com->phone_number!='') + @endif {{@$com->phone_code}} {{@$com->phone_number}}</td>
            <td>{{@$com->country??'N/A'}}</td>

            <td >
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
                @if(in_array(config('constants.test_status.DECLINED'),[$com->talent->is_technical_test,$com->talent->is_aptitude_test,$com->talent->is_profile_screened,$com->talent->is_interview]))
              <span class="badge badge-danger">Rejected</span>

              @elseif($com->test_status==config('constants.test_status.APPROVED'))
              <span class="badge badge-success">Approved</span>
              @elseif($com->talent->is_technical_test)
              <span class="badge badge-info">Technical Cleared</span>
              @elseif($com->talent->is_aptitude_test)
              <span class="badge badge-warning">Aptitude Cleared</span>
              @elseif($com->talent->is_profile_screened)
              <span class="badge badge-primary">Screening Cleared</span>
              @else
              <span class="badge badge-danger">Pending</span>
              @endif
            </td>
            <td>
                {{$com->talent->job_field }}
            </td>
            <td>
                <a class="action-button" href="{{route('talents.edit',[$com->id])}}" data-toggle="tooltip" title="Edit">
                    <i class=" icon-pencil menu-icon"></i>
                    <span class="menu-title"></span>
                </a>
                <a class="action-button" href="{{url('admin/talents/'.$com->id)}}" data-toggle="tooltip" title="View">
                    <i class=" icon-eye menu-icon"></i>
                    <span class="menu-title"></span>
                </a>
                <button type="button" class="action-button delete_user" data-id="{{$com->id}}">
                    <i class="icon-trash menu-icon"></i>
                    <span class="menu-title"></span>
                </button>
            </td>--}}
        </tr>
        @php $i++; @endphp
    @endforeach
<tr>
    <td colspan="11">{{ $talents->links() }}</td>
</tr>
@else
    <tr>
        <td colspan="11" style="text-align: center;">No Data Available</td>
    </tr>
@endif