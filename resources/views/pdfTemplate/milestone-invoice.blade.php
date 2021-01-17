<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice</title>
    
    <style>
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: left;
    }
    </style>
</head>

<body>
    <div class="invoice-box">
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                                <h3>Tod-Z</h3>
                            </td>
                            
                            <td>
                                <strong>Invoice #:</strong> {{$payment->id}}<br>
                                <strong>Created:</strong> {{date('d/m/Y', strtotime($payment->created_at))}}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td>
                                <strong>Client Details:</strong>
                                <br>
                                {{$project->client->first_name}} {{$project->client->last_name}}
                                <br>
                                {{$project->client->phone_code}}-<NOBR>{{$project->client->phone_number}}</NOBR>
                                <br>
                                {{$project->client->email}}
                            </td>
                            
                            <td>
                                <strong>Todder Details:</strong>
                                <br>
                                {{$project->talents[0]->first_name}} {{$project->talents[0]->last_name}}
                                <br>
                                {{$project->talents[0]->phone_code}}-<NOBR>{{$project->talents[0]->phone_number}}</NOBR>
                                <br>
                                {{$project->talents[0]->email}}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <!-- <tr class="heading">
                <td>
                    Payment Method
                </td>
                
                <td>
                    Check #
                </td>
            </tr> -->
            
            <!-- <tr class="details">
                <td>
                    Check
                </td>
                
                <td>
                    1000
                </td>
            </tr> -->
            
            <tr class="heading">
                <td>
                    Description
                </td>
                
                <td>
                    Amount
                </td>
            </tr>
            
            <tr class="item">
                <td>
                    Development Charges
                </td>
                
                <td>
                    ${{$payment->amount}}
                </td>
            </tr>
            <tr class="item last">
                <td>
                    Subtotal
                </td>
                
                <td>
                    $0
                </td>
            </tr>
            
            <tr class="total">
                <td>
                	
                </td>
                
                <td>
                   Total: ${{$payment->amount}}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>