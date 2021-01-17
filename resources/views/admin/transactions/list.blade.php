@if($data->isNotEmpty())
    @php
        $i= ($data->currentPage() - 1) * $data->perPage() + 1;
    @endphp

    @foreach ($data as $row)
        <tr>
            <td>{{$i}}</td>
            <td>{{@$row->project_id}}</td>
            <td>{{@$row->from_user_id ?? 'N/A'}}</td>
            <td>{{@$row->payment_type ?? 'N/A'}}</td>
            <td>{{@$row->to_user_id ?? 'N/A'}}</td>
            <td>{{@$row->amount ?? 0}}</td>
            <td>{{@$row->fee ?? 0}}</td>
            <td>{{@$row->transaction_id}}</td>
            <td>{{$row->created_at}}</td>
            <td>
                <a class="action-button" href="{{url('admin/transactions/'.$row->id)}}" data-toggle="tooltip" title="View">
                    <i class=" icon-eye menu-icon"></i>
                    <span class="menu-title"></span>
                </a>
            </td>
        </tr>
        @php $i++; @endphp
    @endforeach
<tr>
    <td colspan="10">{{ $data->links() }}</td>
</tr>
@else
    <tr>
        <td colspan="10" style="text-align: center;">No Data Available</td>
    </tr>
@endif