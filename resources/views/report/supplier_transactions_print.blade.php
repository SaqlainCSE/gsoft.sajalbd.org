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
    <div class="page" orientation="portrait" size="A4" pages="1" style="padding-top: 80px;">
        <div style="font-size:14px;font-family: math; font-weight: bold;">Supplier Transactions Due:</div>
        @if ($supplier)
            <div style="font-size:12px;">Name: {{ $supplier->name }}</div>
            <div style="font-size:12px;">Mobile: {{ $supplier->mobile_number }}</div>
        @endif
        <table class="table-fw table-border">
            <thead>
                <tr>
                    <th class="text-center" style="width: 20px; font-size:12px;font-weight: bold;font-family: math;">SL:
                    </th>
                    <th class="text-center" style="width: 70px;font-size:12px;font-weight: bold;font-family: math;">
                        Date</th>
                    <th class="text-center" style="width: 60px;font-size:12px;font-weight: bold;font-family: math;">
                        Ref.</th>
                    @if (!$supplier)
                        <th class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">Name
                        </th>
                        <th class="text-center" style="width:90px;font-size:12px;font-weight: bold;font-family: math;">
                            Mobile</th>
                    @endif
                    <th class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">
                        Description</th>
                    <th class="text-center" style="width:80px;font-size:12px;font-weight: bold;font-family: math;">Bill
                    </th>
                    <th class="text-center" style="width:80px;font-size:12px;font-weight: bold;font-family: math;">Pay
                    </th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $bill = 0;
                    $pay = 0;
                @endphp

                @foreach ($transactions as $transaction)
                    <tr>
                        @php
                            $bill += $transaction->bill_amount;
                            $pay += $transaction->payment_amount;
                        @endphp
                        <td style="font-size:12px;font-family: math; width: 20px">{{ $i }}</td>
                        <td style="font-size:12px;font-family: math; width: 70px">
                            {{ formatted_date($transaction->created_at) }}</td>
                        <td style="font-size:12px;font-family: math; width: 60px">{{ $transaction->reference_no }}</td>
                        @if (!$supplier)
                            <td style="font-size:12px;font-family: math;">{{ $transaction->supplier->name }}</td>
                            <td style="font-size:12px;font-family: math;" style="width: 90px">
                                {{ $transaction->supplier->mobile_number }}</td>
                        @endif
                        <td style="font-size:12px;font-family: math;">{{ $transaction->description }}</td>
                        <td style="font-size:12px;font-family: math; width: 80px" class="text-end">
                            {{ bd_money_format($transaction->bill_amount) }}</td>
                        <td style="font-size:12px;font-family: math; width: 80px" class="text-end">
                            {{ bd_money_format($transaction->payment_amount) }}</td>
                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            </tbody>
            @if ($supplier)
                <tfoot>
                    <tr>
                        <th colspan="5" class="text-end">Balance</th>
                        <th style="font-size:12px;font-family: math; width: 80px" class="text-end">
                            {{ bd_money_format($supplier->due_amount) }}</th>
                    </tr>
                </tfoot>
            @else
                <tfoot>
                    <tr>
                        <th colspan="6" class="text-end" style="font-size:12px;font-family: math;">Total: </th>
                        <th style="width: 110px;font-size:12px;font-family: math;" class="text-end">{{ bd_money_format($bill) }}</th>
                        <th style="width: 110px;font-size:12px;font-family: math;" class="text-end">{{ bd_money_format($pay) }}</th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-end" style="font-size:12px;font-family: math;">Total Due: </th>
                        <th style="width: 110px;font-size:12px;font-family: math;" class="text-end">{{ bd_money_format($bill - $pay) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            @endif

        </table>
    </div>
</body>

</html>
