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

        th,
        td {
            font-size: 12px;
            padding: 4px 3px !important;
            border: 1px solid #000 !important;
            color: #000 !important;
            font-family: math;
        }

        td {
            font-size: 10px;
        }
    </style>
</head>

<body onload="window.print()" onafterprint="window.close">
    <div class="page" orientation="portrait" size="A4" pages="1" style="padding-top: 80px;">
        @if ($client)
            <div style="font-size:10px;font-family: math; font-weight: bold;">CUSTOMER DETAILS:</div>
            <div style="font-size:10px;">{{ $client->name }}</div>
            <div style="font-size:10px;">{{ $client->address ?: '' }}</div>
            <div style="font-size:10px;">{{ $client->mobile_number }}</div>
        @else
        <div style="font-size:14px;font-family: math; font-weight: bold;">Customer Due Transactions:</div>
        @endif

        <table class="table-fw table-border table table-bordered">
            <thead>
                <tr>
                    <td class="text-center" style="width: 30px">SL:</td>
                    <td class="text-center" style="width: 80px">Date</td>
                    <td class="text-center" style="width: 80px">Memo No</td>
                    @if (!$client)
                        <td>Name</td>
                    @endif
                    <td class="text-center">Description</td>
                    <td class="text-center" class="text-center" style="width: 80px">Bill</td>
                    <td class="text-center" class="text-center" style="width: 80px">Pay</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $bill = 0;
                    $pay = 0;
                @endphp
                @if ($transactions)
                    @foreach ($transactions as $transaction)
                        <tr>
                            @php
                                $bill += $transaction->bill_amount;
                                $pay += $transaction->payment_amount;
                            @endphp

                            <td class="text-center">{{ $i }}</td>
                            <td>
                                {{ formatted_date($transaction->created_at) }}
                            </td>
                            <td>
                                {{ $transaction->cash_memo_no }}
                            </td>
                            @if (!$client)
                                <td>{{ @$transaction->client->name }}</td>
                            @endif
                            <td>
                                {{ $transaction->description }}
                            </td>
                            <td class="text-end">
                                {{ bd_money_format($transaction->bill_amount) }}</td>
                            <td class="text-end">
                                {{ bd_money_format($transaction->payment_amount) }}</td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @endforeach
                @endif
                @if ($client)
                    <tr>
                        <td colspan="5" class="text-end"
                            style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                            Total Due:
                        </td>
                        <td style="width:59px;font-size:12px;font-family: math;font-weight: bold;" class="text-end">
                            {{ bd_money_format($client->due_amount) }}</td>
                    </tr>
                @else
                    <tr>
                        <td colspan="6" class="text-end"
                            style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Bill:
                        </td>
                        <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                            {{ bd_money_format($bill) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end"
                            style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Pay:
                        </td>
                        <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                            {{ bd_money_format($pay) }}</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="text-end"
                            style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Due:
                        </td>
                        <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                            {{ bd_money_format($bill - $pay) }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</body>

</html>
