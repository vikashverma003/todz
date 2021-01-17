@if($data->isNotEmpty())
    @php
        $i= 1;
    @endphp

    @foreach ($data as $row)
        <tr>
            <td>{{$i}}</td>
            <td>{{$row->transaction_date}}</td>
            <td> {{@$row->total ?? 0}}</td>
            <td>{{@$row->total_transactions ?? 0}}</td>
            <td>{{@$row->total_projects ?? 0}}</td>
            <td>{{@$row->projects_id ?? 0}}</td>
        </tr>
        @php $i++; @endphp
    @endforeach
@else
    <tr>
        <td colspan="5" style="text-align: center;">No Data Available</td>
    </tr>
@endif