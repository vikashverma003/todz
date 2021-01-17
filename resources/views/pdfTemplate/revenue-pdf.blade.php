<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Revenues</title>
    
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
                    <th scope="col">Sr No.</th>
                    <th scope="col">date</th>
                    <th scope="col">project_name</th>
                    <th scope="col">from_name</th>
                    <th scope="col">todz_id</th>
                    <th scope="col">amount</th>
                    <th scope="col">transacton_id</th>
                    <th scope="col">commission_from</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach($data as $key=>$row)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                    <td>{{ Str::limit($row->title, 20) }}</td>
                    <td>{{$row->full_name}}</td>
                    <td>{{$row->todz_id}}</td>
                    <td>{{$row->amount}}</td>
                    <td>{{$row->transaction_id ?? 0}}</td>
                    <td>{{$row->commission_from}}</td>
                    
                </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</body>
</html>