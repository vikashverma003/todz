@if($data->isNotEmpty())
    @php
        $i= 1;
    @endphp

    @foreach ($data as $row)
        <tr class="text-left">
            <td>{{$i}}</td>
            <td class="text-left">
                {{$row->name ?? 'N/A'}}
            </td>
            <td>
                {{@$row->total_talents ?? 0}}
            </td>
            <td>
                {{@$row->total_projects ?? 0}}
            </td>
            <td>{{@$row->total_countries ?? 0}}</td>
            
        </tr>
        @php $i++; @endphp
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="12">No Data Available</td>
    </tr>
@endif