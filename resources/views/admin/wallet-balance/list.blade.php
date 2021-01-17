@if($data->isNotEmpty())
    @php
        $i= ($data->currentPage() - 1) * $data->perPage() + 1;
    @endphp

    @foreach ($data as $row)
        <tr>
            <td>{{$i}}</td>
            <td>{{@$row->user->first_name}} {{@$row->user->last_name}}</td>
            <td>{{@$row->user->role}}</td>
            <td>{{@$row->mangopay_wallet_id ?? 'N/A'}}
            <td>{{@$row->mangopay_user_id ?? 'N/A'}}

             <td>{{@$row->walletInfo->Balance->Currency }}  {{@$row->walletInfo->Balance->Amount/100 }} </td>
            {{-- <td>{{$row->created_at}}</td> --}}
          
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