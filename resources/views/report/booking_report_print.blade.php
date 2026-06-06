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
            word-wrap: break-word;
        }

        td {
            font-size: 10px;
        }


        @media print {
            @page {
                size: landscape;
            }
        }
    </style>
</head>



<body onload="window.print()" onafterprint="window.close()">
    <div class="page" orientation="landscape" size="A4" pages="1" style="padding-top: 80px;">
        <div style="font-size: 10px; font-weight: bold;">
            Booking Report : {{ request()->from_date ?request()->from_date : '' }} - {{ request()->to_date ?request()->to_date : ''}}
        </div>
        <table class="table-fw table-border">
            <thead>
                <tr>
                    <th style="width: 10px">SL#</th>
                    <th style="width: 20px">BK NO</th>
                    <th style="width: 60px">Date</th>
                    <th>Client</th>
                    <th style="width: 70px">Client Mobile</th>
                    <th style="width: 80px">Client Category</th>
                    <th style="width: 70px">Item Total</th>
                    <th>VAT</th>
                    <th>Discount</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Due</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $alltotal = 0;
                    $allpaid = 0;
                    $alldue = 0;
                @endphp

                @foreach ($orders as $row)
                    @php
                        $vat_amount = $row->meta->sum('vat_amount');
                        $itemTotal = $row->meta->sum('total') - $vat_amount;
                        $subtotal = $row->meta->sum('total');
                        $total = $itemTotal + $vat_amount - $row->discount;
                        $alltotal += $total;
                        $allpaid += $row->paid;
                        $alldue += $row->due;
                    @endphp

                    <tr>
                        <td>{{ $i }}</td>
                        <td>{{ $row->id }}</td>
                        <td>{{ $row->date }}</td>
                        <td>{{ optional($row->client)->name }}</td>
                        <td style="width: 70px">{!! $phone_numbers_with_break = str_replace("/", "<br>", @$row->client?->mobile_number) !!}</td>
                        <td style="width: 80px">{{ @$row->client?->category?->name }}</td>
                        <td class="text-end" style="width: 55px">{{ bd_money_format($itemTotal) }}</td>
                        <td class="text-end" style="width: 55px">{{ bd_money_format($vat_amount) }}</td>
                        <td class="text-end" style="width: 55px">{{ bd_money_format($row->discount) }}</td>
                        <td class="text-end" style="width: 55px">{{ bd_money_format($total) }}</td>
                        <td class="text-end" style="width: 55px">{{ bd_money_format($row->paid) }}</td>
                        <td class="text-end" style="width: 55px">{{ bd_money_format($row->due ?: 0) }}</td>
                    </tr>
                    @php
                        $i++;
                        // $total += $supplier->due_amount;
                    @endphp
                @endforeach
                <tr>
                    <th colspan="9" class="text-end">Total:</th>
                    <th style="width: 55px" class="text-end">{{ bd_money_format($alltotal) }}</th>
                    <th style="width: 55px" class="text-end">{{ bd_money_format($alltotal) }}</th>
                    <th style="width: 55px;text-align: right;">{{ bd_money_format($alldue) }}</th>
                </tr>
            </tbody>
            <tfoot>

            </tfoot>

        </table>
    </div>
</body>

</html>
