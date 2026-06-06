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
        footer {
            position: absolute;
            bottom: 50px;
            width: 194mm;
        }
    </style>
</head>

<body>
    <div class="page" orientation="portrait" size="A4" pages="1" style="padding-top: 80px;">
        <table class="table-fw">
            <thead>
                <tr>
                    <td style="width: 33.33%;vertical-align: bottom;">
                        <span style="font-size:14px;font-family: math; font-weight: bold;">CUSTOMER
                            DETAILS:</span>
                    </td>
                    <td class="text-center" style="width: 33.33%">
                        <span style="font-size:24px;font-family: math; font-weight: bold;">CASH MEMO</span>
                    </td>
                    <td class="text-end" style="width: 33.33%"></td>
                </tr>
                <tr>
                    <td style="width: 33.33%;vertical-align: baseline;" colspan="2">
                        <span style="font-size: 14px" colspan="2"
                            rowspan="2">{{ $client->name }}</span><br />
                        <span style="font-size: 14px" colspan="2"
                            rowspan="2">{{ $client->address }}</span><br />
                        <span style="font-size: 14px" colspan="2"
                            rowspan="2">{{ $client->mobile_number }}</span><br />
                    </td>
                    <td class="text-end" style="width: 33.33%">
                        <table style="width: 100%;">
                            <tr>
                                <td style="font-size:14px;">BIN NO:</td>
                                <td style="width: 100px;font-size:14px;">{{ setting('bin') }}</td>
                            </tr>
                            <tr>
                                <td style="font-size:14px;">DATE :</td>
                                <td style="width: 100px;font-size:14px;">--</td>
                            </tr>
                            <tr>
                                <td style="font-size:14px;">MEMO NO :</td>
                                <td style="width: 100px;font-size:14px;">--</td>
                            </tr>
                        </table>
                    </td>
                </tr>

            </thead>
        </table>

        <table class="table-fw table-border">
            <thead>
                <tr>
                    <td class="text-center" style="width:52px;font-size:12px;font-weight: bold;font-family: math;">TOKEN
                        NO</td>
                    <td class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">PRODUCT DETAILS
                    </td>
                    <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">GOLD
                        WT/GM</td>
                    <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">GOLD
                        RATE</td>
                    <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                        ST/DIA WT</td>
                    <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                        ST/DIA RATE</td>
                    {{-- <td class="text-center" style="width: 80px;font-size:12px;font-weight: bold;font-family: math;">TAXABLE TOTAL</td> --}}
                    <td class="text-center" style="width: 85px;font-size:12px;font-weight: bold;font-family: math;">
                        TOTAL TAKA</td>
                </tr>
            </thead>
            <tbody>
                @php
                    $taxableTotal = 0;
                    $totalAmount = 0;
                    $totalWage = 0;
                    $vat=0;
                @endphp
                @foreach (request()->product_id as $key => $product_id)
                    @php
                        $product = $products->where('id', $product_id)->first();
                    @endphp
                    <tr>
                        <td class="text-center" style="font-size:12px;font-family: math;">
                            {{ $product->product_nr }}</td>
                        <td style="font-size:12px;font-family: math;">{{ $product->product_details }}</td>
                        <td class="text-end" style="font-size:12px;font-family: math;">{{ $product->weight }}</td>
                        <td class="text-end" style="font-size:12px;font-family: math;">
                            {{ bd_money_format(request()->unit_price[$key]) }}</td>
                        <td class="text-end" style="font-size:12px;font-family: math;">{{ request()->st_dia[$key] }}</td>
                        <td class="text-end" style="font-size:12px;font-family: math;">
                            {{ bd_money_format(request()->st_dia_price[$key]) }}</td>
                        @php
                            $txTotal = $product->weight * request()->unit_price[$key] + request()->st_dia_price[$key];
                            $taxableTotal += round($txTotal);

                            $totalAmount += round($txTotal);
                            $totalWage += (int) request()->wage[$key];
                        @endphp
                        <td class="text-end" style="font-size:12px;font-family: math;">
                            {{ bd_money_format(round($txTotal)) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td class="text-center"></td>
                    <td class="text-end" style="font-size:12px;font-weight: bold;font-family: math;">TOTAL</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">{{ $products->sum('weight') }}
                    </td>
                    <td class="text-end" style="font-size:12px;font-family: math;"></td>
                    <td class="text-end" style="font-size:12px;font-family: math;">{{ $products->sum('st_dia') }}
                    </td>
                    <td class="text-end" style="font-size:12px;font-family: math;"></td>
                    <td class="text-end" style="font-size:12px;font-family: math;">
                        {{ bd_money_format(round($totalAmount)) }}</td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 0;border: none; vertical-align: initial;">
                        <div style="visibility: hidden;">..........</div>
                        <table class="table-border" style="width: 80%;">
                            <tr>
                                <td style="font-size:11px;font-weight: bold;font-family: math;width:90px">PAYMENT TYPE</td>
                                <td style="font-size:11px;font-weight: bold;font-family: math;">PAYMENT INFO</td>
                                <td style="font-size:11px;font-weight: bold;font-family: math; text-transform:uppercase">reference</td>
                                <td style="font-size:11px;font-weight: bold;font-family: math;text-align:right;width:90px">AMOUNT</td>
                            </tr>
                            @foreach (request()->payment as $key => $payments)
                                <tr>
                                    <td style="font-size:11px;font-family: math;width:90px">{{ strtoupper($payments) }}</td>
                                    <td style="font-size:11px;font-family: math;">{{ request()->payment_info[$key] }}</td>
                                    <td style="font-size:11px;font-family: math;">{{ request()->reference[$key] }}</td>
                                    <td style="font-size:11px;font-family: math;text-align:right;width:90px">
                                        {{ bd_money_format(request()->amount[$key]) }}</td>
                                </tr>
                            @endforeach
                        </table>
                        @if ($sale_type)
                            <p style="font-size:12px;font-family: math;"><strong>Remark:</strong> {{ $sale_type->name }}</p>
                        @endif
                    </td>
                    <td colspan="2" style="padding: 0;border: none; vertical-align: initial;">
                        <table class="table-fw table-border"
                            style="margin-top: -1px;margin-left: -1px;width: calc(100% - -1px);">
                            <tr>
                                <td class="text-end" colspan="2"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">WAGE</td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="2"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">VAT</td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="2"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">ADJUSTABLE
                                    AMOUNT</td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="2"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">DISCOUNT
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="2"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">TOTAL TAKA
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="2"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">PAYMENTS
                                </td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="2"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">FINAL DUE
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td style="padding: 0;border: none; vertical-align: initial;" class="bl-0">
                        <table class="table-fw table-border" style="margin-top: -1px;">
                            <tr>
                                <td class="text-end"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                    {{ bd_money_format(round($totalWage)) }}</td>
                            </tr>
                            <tr>
                                @php
                                    $vat = round( ($totalAmount + $totalWage) * (request()->vat / 100) );
                                @endphp
                                <td class="text-end"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                    {{ bd_money_format($vat) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                    {{ bd_money_format($totalAmount + $totalWage + $vat) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                    {{ bd_money_format(request()->discount ?: 0) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                    {{ bd_money_format($totalAmount + $totalWage + $vat - request()->discount) }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                    {{ request()->paid }}</td>
                            </tr>
                            <tr>
                                <td class="text-end"
                                    style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                    {{ request()->due }}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </tfoot>
        </table>

        <table class="table-fw table-border" style="margin-top: 30px;">
            <tr>
                <td style="font-family: math; border: none">
                    {!! setting('terms') !!}
                </td>
            </tr>
        </table>

        <footer style="font-size: 14px;">
            <table class="table-fw">
                <tr>
                    <td>
                        <div style="text-align: center;width: 115px;">
                            ----------------------
                            <br />
                            Buyer's signature
                        </div>
                    </td>
                    <td>
                        <div style="text-align: center;">
                            --------------------------------
                            <br />
                            Audit/Account signature
                        </div>
                    </td>
                    <td>
                        <div style="text-align: center;width: 115px;margin-left: auto;">
                            ---------------------- <br /> Seller Signature
                        </div>
                    </td>
                </tr>
            </table>
        </footer>
    </div>
</body>

</html>
