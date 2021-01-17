@if($data->isNotEmpty())
    @php
        $i= ($data->currentPage() - 1) * $data->perPage() + 1;
    @endphp

    @foreach ($data as $row)
        <tr>
            <td class="sr_no">{{$i}}</td>
            <td>{{$row->created_at}}</td>
            <td>{{@$row->project->title}}</td>
            <td >{{@$row->fromUser->first_name ?? 'N/A'}}
            <td>{{@$row->fromUser->todz_id ?? 'N/A'}}

             <td class="sr_no"> {{@$row->amount ?? 0}}</td>
            <td>{{@$row->commission_from ?? 'N/A'}}</td>
            <td>{{@$row->transaction_id}}</td>
            
            <td>
                <a class="action-button" href="{{url('admin/revenue/'.$row->id)}}" data-toggle="tooltip" title="View">
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