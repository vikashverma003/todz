@if($data->isNotEmpty())
    @php
        $i= 1;
    @endphp

    @foreach ($data as $row)
        <tr class="text-right">
            <td>{{$i}}</td>
            <td class="text-left">
                <a class="view" href="{{url('admin/projects/'.$row->id)}}" data-toggle="tooltip" title="View" target="_blank">
                    {{@$row->title ?? 'N/A'}}
                </a>
            </td>
            <td>{{@$row->created_at ? date('d/m/Y', strtotime($row->created_at)) : 'N/A'}}</td>
            <td>{{@$row->allocation_date ? date('d/m/Y', strtotime($row->allocation_date)) : 'N/A'}}</td>
            <td>
                @if($row->duration_month > 0)
                    {{$row->duration_month}} month
                @endif

                @if($row->duration_day > 0)
                    {{$row->duration_day}} days
                @endif
            </td>
            <td>
                
                {{@$row->no_of_hours*($row->main_talent->hourly_rate ?? 0) ?? 0}}
            </td>
            <td>{{@$row->transactions->sum('amount') ?? 0}}</td>
            <td>{{@$row->payments->sum('amount') ?? 0}}</td>
            <td>{{@$row->talent->todz_id ?? ""}} /<br> {{@$row->talent->first_name}} {{@$row->talent->last_name}}</td>
            
            <td>{{@$row->client->first_name}} {{@$row->client->last_name}}</td>
            <td>
                <button type="button" data-text="{{$row->client_dispute_reason ? $row->client_dispute_reason: 'N/A'}}" class="btn btn-primary viewReason" data-toggle="modal" data-target="#exampleModal">
                  View
                </button>
            </td>
            <td>
                <button type="button" data-text="{{$row->todder_dispute_reason ? $row->todder_dispute_reason: 'N/A'}}" class="btn btn-primary viewReason" data-toggle="modal" data-target="#exampleModal">
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