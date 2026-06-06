<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}" />
    <style>
        .bl-0 td.text-end {
            border-left: none;
        }

        ul {
            padding: 0;
            margin: 0;
        }
    </style>
</head>


<body onload="window.print()" onafterprint="window.close()">

<div class="page card" orientation="portrait" size="A4" pages="1" style="padding-top: 20px;margin:0 auto;color: #000;">
    <table class="table-fw">
        <thead>
            <tr>
                <td style="width: 33.33%;vertical-align: bottom;text-align:left">
                    <table style="width: 100%;">
                        <tbody><tr>
                            <td style="font-size:14px;"><span style="font-size:14px;font-family: math; font-weight: bold;">CUSTOMER
                                    DETAILS:</span></td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $client->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $client->address }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $client->mobile_number }}</td>
                        </tr>
                    </tbody></table>
                </td>
                
            </tr>
        </thead>
    </table>

    <table class="table-fw table-border">
        <thead>
            <tr>
                <td class="text-center" style="width:52px;font-size:12px;font-weight: bold;font-family: math;">SL:</td>
                <td class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">Date</td>
                <td class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">Memo No</td>
                <td class="text-center" style="width:100px;font-size:12px;font-weight: bold;font-family: math;">Bill</td>
                <td class="text-center" style="width:100px;font-size:12px;font-weight: bold;font-family: math;">Pay</td>
            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
            @endphp
            @foreach ($transactions as $transaction)
                <tr>
                    <td class="text-center" style="width:52px;font-size:12px;font-family: math;">
                        {{ $i }}
                    </td>
                    <td style="font-size:12px;font-family: math;">
                        {{ formatted_date($transaction->created_at) }}
                    </td>
                    <td style="font-size:12px;font-family: math;">
                        {{ $transaction->cash_memo_no }}
                    </td>
                    <td style="width:59px;font-size:12px;font-family: math;">{{ bd_money_format($transaction->bill_amount) }}</td>
                    <td style="width:59px;font-size:12px;font-family: math;">{{ bd_money_format($transaction->payment_amount) }}</td>    
                </tr>
                @php
                    $i++;
                @endphp
            @endforeach
            <tr>
                <td colspan="3" style="border: none"></td>
                <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Due:</td>
                <td style="width:59px;font-size:12px;font-family: math;font-weight: bold;">{{ bd_money_format($client->due_amount) }}</td>
            </tr>
        </tbody>
    </table>
</div>

</body>

</html>
