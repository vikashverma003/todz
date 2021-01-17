@if($data->isNotEmpty())
    @php
        $i= 1;
    @endphp

    @foreach ($data as $row)
        <tr class="text-right">
            <td>{{$i}}</td>
            <td class="text-left">
                {{@$row->title ?? 'N/A'}}
            </td>
            <td>{{@$row->created_at ? date('d/m/Y', strtotime($row->created_at)) : 'N/A'}}</td>
            
            <td>
                @if($row->duration_month > 0)
                    {{$row->duration_month}} month
                @endif

                @if($row->duration_day > 0)
                    {{$row->duration_day}} days
                @endif
            </td>
            <td>
                
                {{@$row->cost ?? 0}}
            </td>
            
            <td>{{@$row->client->todz_id ?? "N/A"}}</td>
            
            <td>{{@$row->client->first_name}} {{@$row->client->last_name}}</td>
            <td>
                <button type="button" data-text="{{$row->close_reason ? $row->close_reason: 'N/A'}}" class="btn btn-primary viewReason" data-toggle="modal" data-target="#exampleModal">
                  View
                </button>
            </td>
            
        </tr>
        @php $i++; @endphp
    @endforeach
@else
    <tr>
        <td class="text-center" colspan="12">No Data Available</td>
    </tr>
@endif