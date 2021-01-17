<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reports</title>
    
    <style>
    .invoice-box {
        max-width: 900px;
        margin: auto;
        padding: 3px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 12px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    .invoice-box table tbody td, .invoice-box table th{
        border: 1px solid #eee;
        text-align: left;
    }
    .invoice-box table {
        width: 100%;
        /*line-height: inherit;*/
        text-align: left;
    }
    
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: left;
            border: 1px solid #eee;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: left;
            border: 1px solid #eee;
        }
    }
    
   
    </style>
</head>

<body>
    <div class="invoice-box">
        <table class="table table-bordered" width="100%">
            <thead>
                <tr>
                    <th scope="col" >Sr. No.</th>
                    <th scope="col" class="text-left">Project</th>
                    <th scope="col" >Creation Date</th>
                    <th scope="col" >Allocation Date</th>
                    <th scope="col" >Project Duration</th>
                    <th scope="col" >Agreed Amount</th>
                    <th scope="col" >Recieved Amount</th>
                    <th scope="col" >Paid Amount</th>
                    <th scope="col" >Talent ID</th>
                    <th scope="col" >Talent Name</th>
                    <th scope="col" >Client Name</th>
                    <th scope="col" >Status</th>
                    
                </tr>
            </thead>
            <tbody>
                @if($data->isNotEmpty())
                    @php
                        $i= 1;
                    @endphp

                    @foreach ($data as $row)
                        <tr class="text-left">
                            <td>{{$i}}</td>
                            <td class="text-left">
                                {{@$row->title ?? 'N/A'}}
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
                            <td>{{@$row->talent->todz_id ?? "N/A"}}</td>
                            <td>{{@$row->talent->first_name}} {{@$row->talent->last_name}}</td>
                            <td>{{@$row->client->first_name}} {{@$row->client->last_name}}</td>
                            <td>
                                @if(@$row->status=='completed')
                                    <span >Completed</span>
                                @elseif(@$row->status=='dispute')
                                    <span >{{@$row->status}}</span>
                                @elseif(@$row->status=='hired')
                                    <span>In-Progress</span>
                                @else
                                    <span>{{@$row->status}}</span>
                                @endif
                            </td>
                        </tr>
                        @php $i++; @endphp
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="12">No Data Available</td>
                    </tr>
                @endif
            </tbody>
        </table>
        
    </div>
</body>
</html>