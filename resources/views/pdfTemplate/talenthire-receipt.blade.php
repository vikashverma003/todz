<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
    xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta content="width=device-width, minimal-ui, initial-scale=1.0, maximum-scale=1.0, user-scalable=0;"
        name="viewport" />
    <meta content="telephone=no" name="format-detection" />

    <title>Receipt</title>

    <!--[if gte mso 9]>
        <xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG/>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
        <![endif]-->

    <!--[if mso]>
        <style> body,table tr,table td,a, span,table.MsoNormalTable {  font-family:Arial, Helvetica, sans-serif !important; mso-line-height-rule: exactly !important; }</style>
        <!--<![endif]-->

    <style type="text/css">
        body,
        body * {
            font-family: Arial, Helvetica, sans-serif !important;
        }

        textarea:focus {
            outline: none;
        }
    </style>

</head>

<body
    style="-webkit-font-smoothing: antialiased !important; -webkit-text-size-adjust: none !important; width: 100% !important; height: 100% !important; font-family:'Arial',Helvetica,sans-serif; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; margin: 0; padding: 0;">
    <table align="center" style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td style="background-color: #f8f8f8;" bgcolor="#f8f8f8">
                <table class="deviceWidth" align="center" width="750" style="width: 750px; min-width:750px;" border="0"
                    cellspacing="0" cellpadding="0">
                    <tr>
                        <td valign="top" style="vertical-align:top;border-collapse: collapse;">



                            <!-- logo -->
                            <table class="mktoModule" id="logo-module" mktoName="Logo Module" align="center"
                                style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="background-color: #ffffff;" bgcolor="#ffffff">
                                        <table class="deviceWidth1" width="700" style="margin: 0 auto;width: 700px;"
                                            align="center" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="font-size: 1px; line-height: 1px;" height="25">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table>
                                                        <tr>
                                                            <td style="color: #1D232E;
                                                            font-size: 23px;
                                                            font-weight: 600;
                                                            letter-spacing: 0;
                                                            line-height: 28px;">
                                                                Receipt from tod-Z
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1px; line-height: 1px;" height="15">
                                                                &nbsp;</td>
                                                        </tr>
<?php
    $digitRem = 11 - strlen($payment->id);
    $countriesCode = config('constants.invoice_country_codes');
    $countryCode = '';
    if(array_key_exists($logedInuser->invoice_country_code, $countriesCode)){
        $countryCode = $countriesCode[$logedInuser->invoice_country_code];
    }
?>
                                                        <tr>
                                                            <td style="color: #1D232E;
                                                                                font-size: 17px;
                                                                                font-weight: 600;
                                                                                letter-spacing: 0;
                                                                                line-height: 23px;">
                                                                Receipt No
                                                                <span style="font-weight: 400;">
                                                                    REC{{$countryCode}} {{str_repeat("0", $digitRem)}}{{$payment->id}}
                                                                </span>
                                                            </td>
                                                        </tr>
                                                        <!-- <tr>
                                                            <td style="font-size: 1px; line-height: 1px;" height="5">
                                                                &nbsp;</td>
                                                        </tr> -->
                                                        <tr>
                                                            <td style="color: #1D232E;
                                                                                font-size: 17px;
                                                                                font-weight: 600;
                                                                                letter-spacing: 0;
                                                                                line-height: 23px;">
                                                                Date
                                                                <span style="font-weight: 400;">{{date('d/m/Y', strtotime($payment->created_at))}}</span>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td valign="top" style="text-align: right;vertical-align: top;">
                                                    <a href="#" style="text-decoration: none;" target="_blank">
                                                        <img height=80 border="0" src="./web/images/header_logo.png" alt="" />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            <!-- logo ends -->



                            <!-- text -->
                            <table align="center" style="width: 100%;" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td style="background-color: #ffffff;" bgcolor="#ffffff">
                                        <table class="deviceWidth1" width="700" style="margin: 0 auto; width: 700px;"
                                            align="center" border="0" cellspacing="0" cellpadding="0">
                                            <tr>
                                                <td style="font-size: 1px; line-height: 1px;" height="30">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top;">
                                                    <table class="deviceWidth1" width="700"
                                                        style="width: 700px;border:1.5px solid #1D232E;margin-bottom: 20px;"
                                                        align="center" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table class="deviceWidth1" width="680"
                                                                    style="margin: 0 auto; width: 680px;" align="center"
                                                                    border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="20">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 24px;
                                                                        font-weight: 500;
                                                                        letter-spacing: 0;
                                                                        line-height: 31px;">
                                                                            Project information
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="15">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 600;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                                        Project ID</td>
                                                                                    <td width="20"></td>
                                                                                    <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 400;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                                        {{config('constants.PROJECT_ID_PREFIX')}}{{$project->id}}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 600;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                                        Project Owner ID</td>
                                                                                    <td width="20"></td>
                                                                                    <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 400;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                                        {{$logedInuser->todz_id}}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 600;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                                        Todder ID </td>
                                                                                    <td width="20"></td>
                                                                                    <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 400;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                                        {{$project->talents[0]->todz_id ?? ''}}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="10">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 600;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                            Project descripition</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="10">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            {{$project->description}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="20">&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                    <table class="deviceWidth1" width="700"
                                                        style="width: 700px;border:1.5px solid #1D232E;" align="center"
                                                        cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table class="deviceWidth1" width="680"
                                                                    style="margin: 0 auto; width: 680px;" align="center"
                                                                    border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="20">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 24px;
                                                                        font-weight: 500;
                                                                        letter-spacing: 0;
                                                                        line-height: 31px;">
                                                                            Payment
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="15">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 18px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 26px;">
                                                                        {{($payment->payment_type=='PAYIN') ? "CARD" : "WALLET"}} {{$payment->transaction_id}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 18px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 26px;">
                                                                            {{date('d/m/Y', strtotime($payment->created_at))}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="15">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 600;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;">
                                                                                        Amount Paid (USD)
                                                                                    </td>
                                                                                    <td width="20"></td>
                                                                                    <td
                                                                                        style="color: #1D232E;
                                                                                        font-size: 17px;
                                                                                        font-weight: 600;
                                                                                        letter-spacing: 0;
                                                                                        line-height: 23px;text-align: right;">
                                                                                        {{$payment->amount}}
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="20">&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1px; line-height: 1px;" height="20">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="deviceWidth1" width="700"
                                                        style="width: 700px;border:1.5px solid #1D232E;" align="center"
                                                        border="0" cellspacing="0" cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table class="deviceWidth1" width="680"
                                                                    style="margin: 0 auto; width: 680px;" align="center"
                                                                    border="0" cellspacing="0" cellpadding="0">
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="20">&nbsp;</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                    font-size: 24px;
                                                                    font-weight: 500;
                                                                    letter-spacing: 0;
                                                                    line-height: 31px;">
                                                                            Price breakdown
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="15">&nbsp;
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 600;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;">
                                                                                        Project duration
                                                                                    </td>
                                                                                    <td width="20">
                                                                                    </td>
                                                                                    <td
                                                                                        style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 400;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;text-align: right;">
                                                                                        {{$proTalent->no_of_hours}} Hours
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="10">&nbsp;
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 600;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;">
                                                                                        Stage of
                                                                                        project
                                                                                        completed
                                                                                    </td>
                                                                                    <td width="20">
                                                                                    </td>
                                                                                    <td
                                                                                        style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 400;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;text-align: right;">
                                                                                        Hired
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="10">&nbsp;
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 600;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;">
                                                                                        Todder
                                                                                        hours
                                                                                    </td>
                                                                                    <td width="20">
                                                                                    </td>
                                                                                    <td
                                                                                        style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 400;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;text-align: right;">
                                                                                        {{$proTalent->no_of_hours}}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="10">&nbsp;
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <table style="width: 100%;">
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 600;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;">
                                                                                        Todder
                                                                                        rate
                                                                                    </td>
                                                                                    <td width="20">
                                                                                    </td>
                                                                                    <td
                                                                                        style="color: #1D232E;
                                                                                    font-size: 17px;
                                                                                    font-weight: 400;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 23px;text-align: right;">
                                                                                        {{config('constants.APP_CURRENCY')}}{{$talent->hourly_rate}}</td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="10">&nbsp;</td>
                                                                    </tr>
@php
    $total_fee = ($talent->hourly_rate*$proTalent->no_of_hours);
    $todz_commission = $admincomission->project_comission/100*($total_fee);
    $payment_gateway_fee = (($admincomission->payment_gateway_fee/100)*($total_fee));

    $sub_total_before_coupon = $total_fee+$todz_commission+$payment_gateway_fee;
    $coupon_deduction = $payment->coupon_used/100*$todz_commission;
    $sub_total_after_coupon = $sub_total_before_coupon-$coupon_deduction;

    $vat_calc = ($talentUserGst*$sub_total_after_coupon)/100;
    $finalTotal = $vat_calc+$sub_total_after_coupon;
@endphp
                                                                    <tr>

                                                                        <td>
                                                                            <table class="deviceWidth1"
                                                                                style="width: 100%;">
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 600;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    Toder
                                                                                                    fee
                                                                                                </td>
                                                                                                <td width="20">
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 600;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$total_fee}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    tod-Z
                                                                                                    commission
                                                                                                </td>
                                                                                                <td width="20">
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$todz_commission}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    Payment
                                                                                                    gateway
                                                                                                    fee
                                                                                                    &
                                                                                                    administrative
                                                                                                    fees
                                                                                                    (3,5%)
                                                                                                </td>
                                                                                                <td width="20">
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;border-bottom: 1px solid #1D232E;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$payment_gateway_fee}}</td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    Subtotal
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$sub_total_before_coupon}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;width: 90%;">
                                                                                                    Coupon
                                                                                                    deduction
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;border-bottom: 1px solid #1D232E;">
                                                                                                    ({{config('constants.APP_CURRENCY')}}{{$coupon_deduction}})
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    Subtotal
                                                                                                    after
                                                                                                    coupon
                                                                                                    deduction
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$sub_total_after_coupon}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    VAT @ {{$talentUserGst}}%
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$vat_calc}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    Total invoiced amount
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$finalTotal}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                                    Foreign tax recoveries
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;">
                                                                                                    0
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="10">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>
                                                                                        <table style="width: 100%;">
                                                                                            <tr>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;width: 90%;">
                                                                                                    Total amount deposited
                                                                                                </td>
                                                                                                <td
                                                                                                    style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 400;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;text-align: right;border-bottom: 2px solid #1D232E;
                                                                                                border-top: 1px solid #1D232E;">
                                                                                                    {{config('constants.APP_CURRENCY')}}{{$finalTotal}}
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="20">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                                font-size: 17px;
                                                                                                font-weight: 600;
                                                                                                letter-spacing: 0;
                                                                                                line-height: 23px;">
                                                                                        Important to note
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="color: #1D232E;
                                                                                    font-size: 15px;
                                                                                        font-weight: 400;
                                                                                    letter-spacing: 0;
                                                                                    line-height: 21px;">
                                                                                        tod-Z acts as an
                                                                                        intermediary
                                                                                        and compliance with
                                                                                        VAT
                                                                                        regulations is the
                                                                                        responsibility of
                                                                                        the
                                                                                        contracting parties
                                                                                        as set out
                                                                                        in the <a href="#"
                                                                                            style="color: #4372C4;text-decoration: underline;font-weight: 500;">Terms
                                                                                            and
                                                                                            Conditions.</a>
                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td style="font-size: 1px; line-height: 1px;"
                                                                                        height="20">&nbsp;
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="font-size: 1px; line-height: 1px;"
                                                                            height="10">&nbsp;</td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1px; line-height: 1px;" height="20">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td style="border-bottom: 1.5px solid #1D232E;"></td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1px; line-height: 1px;" height="20">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table style="width: 100%;" border="0" cellspacing="0"
                                                        cellpadding="0">
                                                        <tr>
                                                            <td style="color: #1D232E;
                                                            font-size: 17px;
                                                            font-weight: 600;
                                                            letter-spacing: 0;
                                                            line-height: 23px;">
                                                                Escrow Account & Fees
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color: #1D232E;
                                                            font-size: 15px;
                                                                font-weight: 400;
                                                            letter-spacing: 0;
                                                            line-height: 21px;">
                                                                Kindly refer to our <a href="#" style="color: #4372C4;
                                                                text-decoration: underline;
                                                                font-weight: 500;">Terms and Conditions</a> for
                                                                information
                                                                and <b>contact us at support@tod-z.com</b> should you have any
                                                                further
                                                                queries.

                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="font-size: 1px; line-height: 1px;" height="20">
                                                                &nbsp;</td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color: #1D232E;
                                                            font-size: 17px;
                                                            font-weight: 600;
                                                            letter-spacing: 0;
                                                            line-height: 23px;">
                                                                tod-Z Payments
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td style="color: #1D232E;
                                                            font-size: 15px;
                                                                font-weight: 400;
                                                            letter-spacing: 0;
                                                            line-height: 21px;">
                                                                All payments to tod-Z are effected via MangoPay S.A. and
                                                                are subject to its <a href="#" style="color: #4372C4;
                                                                text-decoration: underline;
                                                                font-weight: 500;">Terms and Conditions</a>.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1px; line-height: 1px;" height="30">
                                                    &nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table style="width: 100%;" border="0" cellspacing="0"
                                                        cellpadding="0">
                                                        <tr>
                                                            <td>
                                                                <table class="deviceWidth1" width="290"
                                                                    style="width: 290px;" align="center" cellspacing="0"
                                                                    cellpadding="0">
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 17px;
                                                                        font-weight: 600;
                                                                        letter-spacing: 0;
                                                                        line-height: 23px;">
                                                                            Registered name: todZ OÜ
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 17px;
                                                                        font-weight: 600;
                                                                        letter-spacing: 0;
                                                                        line-height: 23px;">
                                                                            Company registration no: 14861771
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 17px;
                                                                        font-weight: 600;
                                                                        letter-spacing: 0;
                                                                        line-height: 23px;">
                                                                            Registered Address:
                                                                        </td>
                                                                    </tr>
                                                                    
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 15px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 21px;">
                                                                            Harju maakond
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 15px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 21px;">
                                                                            Tallinn
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 15px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 21px;">
                                                                            Kesklinna linnaosa
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 15px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 21px;">
                                                                            Ahtri tn 12
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 15px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 21px;">
                                                                            10151
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 15px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 21px;">
                                                                            Estonia
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="www.tod-z.com">
                                                                                www.tod-z.com
                                                                            </a>
                                                                        </td>
                                                                    </tr>
                                                                </table>
                                                            </td>
                                                            <td width="20"></td>
                                                            <td style="vertical-align: top;">
                                                                <table class="deviceWidth1" width="290"
                                                                    style="width: 290px;" align="center" cellspacing="0"
                                                                    cellpadding="0">
                                                                     <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 17px;
                                                                        font-weight: 600;
                                                                        letter-spacing: 0;
                                                                        line-height: 23px;">
                                                                            Client Name: {{$logedInuser->first_name ?? ''}}
                                                                        </td>
                                                                    </tr>
                                                                     <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 17px;
                                                                        font-weight: 600;
                                                                        letter-spacing: 0;
                                                                        line-height: 23px;">
                                                                            Company registration no: {{$logedInuser->registration_number ?? ''}}
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 17px;
                                                                        font-weight: 600;
                                                                        letter-spacing: 0;
                                                                        line-height: 23px;">
                                                                            Client Address
                                                                        </td>
                                                                    </tr>
                                                                    <?php
                                                                        $address = [];
                                                                        $address = explode(',', $logedInuser->address);
                                                                    ?>
                                                                    @foreach($address as $row)
                                                                    <tr>
                                                                        <td style="color: #1D232E;
                                                                        font-size: 15px;
                                                                            font-weight: 400;
                                                                        letter-spacing: 0;
                                                                        line-height: 21px;">
                                                                            {{$row}}
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                    
                                                                </table>
                                                            </td>
                                                            <td width="20"></td>
                                                            <td style="vertical-align: top;">
                                                                <a href="#" style="text-decoration: none;"
                                                                    target="_blank">
                                                                    <img height=80 border="0"
                                                                        src="./web/images/header_logo.png" alt="" />
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="font-size: 1px; line-height: 1px;" height="70">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>