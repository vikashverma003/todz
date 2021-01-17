@if($data->isNotEmpty())
    @php
        $i= ($data->currentPage() - 1) * $data->perPage() + 1;
    @endphp

    @foreach ($data as $row)
        <tr>
            <td class="sr_no">{{$i}}</td>
            <td>{{$row->transaction_date}}</td>

             <td class="sr_no"> {{number_format(@$row->total * $comission->project_comission / 100,3)}}</td>
            
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