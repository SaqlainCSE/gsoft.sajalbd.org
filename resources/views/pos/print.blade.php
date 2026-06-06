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


@if (request()->show == 1)

    <body>
    @else

        <body onload="window.print()" onafterprint="window.close()">
@endif

<div class="page" orientation="portrait" size="A4" pages="1" style="padding-top: 80px;">
    <table class="table-fw">
        <thead>
            <tr>
                <td style="width: 33.33%;vertical-align: bottom;text-align:left">
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size:14px;"><span
                                    style="font-size:14px;font-family: math; font-weight: bold;">CUSTOMER
                                    DETAILS:</span></td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $order->client->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $order->client->address }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $order->client->mobile_number }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 33.33%;vertical-align: top;text-align:center">
                    <table style="width: 100%;">
                        <tr>
                            <td><span style="font-size:24px;font-family: math; font-weight: bold;">CASH
                                    MEMO</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-size:12px;">(MUSOK-6.3)</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="font-size: 14px">FB/REF: {{ $order->client?->fb_name }}</span>
                            </td>
                        </tr>
                    </table>

                </td>
                <td style="width: 33.33%;vertical-align: bottom;text-align:right">
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size:14px;">BIN NO:</td>
                            <td style="width: 100px;font-size:14px;">{{ setting('bin') }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">DATE :</td>
                            <td style="width: 100px;font-size:14px;">
                                {{ formatted_date($order->created_at) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">MEMO NO :</td>
                            <td style="width: 100px;font-size:14px;">{{ $order->cash_memo_no }}</td>
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
                    PRICE</td>
                <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                    ST/DIA WT</td>
                <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                    ST/DIA PRICE</td>
                <td class="text-center" style="width: 85px;font-size:12px;font-weight: bold;font-family: math;">
                    TOTAL TAKA</td>
            </tr>
        </thead>
        <tbody>
            @php
                $taxableTotal = 0;
                $totalAmount = 0;
                $totalWage = 0;
            @endphp
            @foreach ($order->meta as $meta)
                <tr>
                    <td class="text-center" style="font-size:12px;font-family: math;">
                        {{ $meta->product->product_nr }}</td>
                    <td style="font-size:12px;font-family: math;">{{ $meta->product->product_details }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">{{ $meta->product->weight }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">
                        {{ bd_money_format($meta->unit_price) }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">{{ $meta->st_dia }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">
                        {{ bd_money_format($meta->st_dia_price) }}</td>
                    @php
                        $txTotal = $meta->product->weight * $meta->unit_price + $meta->st_dia_price;
                        $taxableTotal += round($txTotal);

                        $totalAmount += round($txTotal);
                        $totalWage += $meta->wage;
                    @endphp

                    <td class="text-end" style="font-size:14px;font-family: math;">
                        {{ bd_money_format(round($txTotal)) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center"></td>
                <td class="text-end" style="font-size:12px;font-weight: bold;font-family: math;">TOTAL</td>
                <td class="text-end" style="font-size:12px;font-family: math;">{{ $order->meta->sum('weight') }}
                </td>
                <td class="text-end" style="font-size:12px;font-family: math;"></td>
                <td class="text-end" style="font-size:12px;font-family: math;">{{ $order->meta->sum('st_dia') }}
                </td>
                <td class="text-end" style="font-size:12px;font-family: math;">{{-- bd_money_format($order->meta->sum('st_dia_price')) --}}</td>
                {{-- <td class="text-end" style="font-size:14px;font-family: math;">{{ bd_money_format(round($taxableTotal)) }}</td> --}}
                <td class="text-end" style="font-size:12px;font-family: math;">
                    {{ bd_money_format(round($totalAmount)) }}</td>
            </tr>
            <tr>
                <td colspan="4" style="padding: 0;border: none; vertical-align: initial;">
                    <div style="visibility: hidden;">..........</div>
                    
                    <table class="table-border" style="width: 95%;">
                        <tr>
                            <td style="font-size:11px;font-weight: bold;font-family: math;">PAYMENT TYPE</td>
                            <td style="font-size:11px;font-weight: bold;font-family: math; width:170px">PAYMENT INFO</td>
                            <td style="font-size:11px;font-weight: bold;font-family: math; text-transform:uppercase;  width:140px;">
                                reference</td>
                            <td style="font-size:11px;font-weight: bold;font-family: math;text-align:right;width:90px">
                                AMOUNT</td>
                        </tr>
                        @foreach ($order->payments as $payments)
                            <tr>
                                <td style="font-size:11px;font-family: math;">
                                    {{ strtoupper($payments['payment']) }}</td>
                                <td style="font-size:11px;font-family: math; width:170px">{{ $payments['payment_info'] }}</td>
                                <td style="font-size:11px;font-family: math; width:140px;">{{ $payments['reference'] }}</td>
                                <td style="font-size:11px;font-family: math;text-align:right;width:90px">
                                    {{ bd_money_format($payments['amount']) }}</td>
                            </tr>
                        @endforeach
                    </table>
                    
                    <table border="0" style="width: 80%;border: none">
                        <tr>
                            <td style="padding: 0;border: none; vertical-align: initial;">
                                @if ($sale_type)
                                    <span style="font-size:12px;font-family: math;"><strong>Remark:</strong>
                                        {{ $sale_type->name }}</span>
                                @endif
                            </td>
                            <td style="text-align:right;padding: 0;border: none; vertical-align: initial;"><span
                                    style="font-size:12px;font-family: math;">Sell By:
                                    {{ $order->sellBy?->name }}</span></td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" style="padding: 0;border: none; vertical-align: initial; width: 128px;">
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
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">CASHBACK
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
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->meta->sum('vat_amount'))) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->total)) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format($order->discount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->total - $order->discount)) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format($order->paid) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format($order->return_amount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->total + $order->return_amount - $order->discount - $order->paid)) }}
                            </td>
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
<div class="page" orientation="portrait" size="A4" pages="1" style="padding-top: 80px;">
    <table class="table-fw">
        <thead>
            <tr>
                <td style="width: 33.33%;vertical-align: bottom;text-align:left">
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size:14px;"><span
                                    style="font-size:14px;font-family: math; font-weight: bold;">CUSTOMER
                                    DETAILS:</span></td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $order->client->name }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $order->client->address }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">{{ $order->client->mobile_number }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 33.33%;vertical-align: top;text-align:center">
                    <table style="width: 100%;">
                        <tr>
                            <td><span style="font-size:24px;font-family: math; font-weight: bold;">CASH
                                    MEMO</span></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="font-size:12px;">(MUSOK-6.3)</div>
                            </td>
                        </tr>
                        <tr>
                            <td><span style="font-size: 14px">FB/REF: {{ $order->client?->fb_name }}</span>
                            </td>
                        </tr>
                    </table>

                </td>
                <td style="width: 33.33%;vertical-align: bottom;text-align:right">
                    <table style="width: 100%;">
                        <tr>
                            <td style="font-size:14px;">BIN NO:</td>
                            <td style="width: 100px;font-size:14px;">{{ setting('bin') }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">DATE :</td>
                            <td style="width: 100px;font-size:14px;">
                                {{ formatted_date($order->created_at) }}</td>
                        </tr>
                        <tr>
                            <td style="font-size:14px;">MEMO NO :</td>
                            <td style="width: 100px;font-size:14px;">{{ $order->cash_memo_no }}</td>
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
                    PRICE</td>
                <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                    ST/DIA WT</td>
                <td class="text-center" style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                    ST/DIA PRICE</td>
                <td class="text-center" style="width: 85px;font-size:12px;font-weight: bold;font-family: math;">
                    TOTAL TAKA</td>
            </tr>
        </thead>
        <tbody>
            @php
                $taxableTotal = 0;
                $totalAmount = 0;
                $totalWage = 0;
            @endphp
            @foreach ($order->meta as $meta)
                <tr>
                    <td class="text-center" style="font-size:12px;font-family: math;">
                        {{ $meta->product->product_nr }}</td>
                    <td style="font-size:12px;font-family: math;">{{ $meta->product->product_details }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">{{ $meta->product->weight }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">
                        {{ bd_money_format($meta->unit_price) }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">{{ $meta->st_dia }}</td>
                    <td class="text-end" style="font-size:12px;font-family: math;">
                        {{ bd_money_format($meta->st_dia_price) }}</td>
                    @php
                        $txTotal = $meta->product->weight * $meta->unit_price + $meta->st_dia_price;
                        $taxableTotal += round($txTotal);

                        $totalAmount += round($txTotal);
                        $totalWage += $meta->wage;
                    @endphp

                    <td class="text-end" style="font-size:14px;font-family: math;">
                        {{ bd_money_format(round($txTotal)) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td class="text-center"></td>
                <td class="text-end" style="font-size:12px;font-weight: bold;font-family: math;">TOTAL</td>
                <td class="text-end" style="font-size:12px;font-family: math;">{{ $order->meta->sum('weight') }}
                </td>
                <td class="text-end" style="font-size:12px;font-family: math;"></td>
                <td class="text-end" style="font-size:12px;font-family: math;">{{ $order->meta->sum('st_dia') }}
                </td>
                <td class="text-end" style="font-size:12px;font-family: math;">{{-- bd_money_format($order->meta->sum('st_dia_price')) --}}</td>
                {{-- <td class="text-end" style="font-size:14px;font-family: math;">{{ bd_money_format(round($taxableTotal)) }}</td> --}}
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
                            <td style="font-size:11px;font-weight: bold;font-family: math; text-transform:uppercase">
                                reference</td>
                            <td style="font-size:11px;font-weight: bold;font-family: math;text-align:right;width:90px">
                                AMOUNT</td>
                        </tr>
                        @foreach ($order->payments as $payments)
                            <tr>
                                <td style="font-size:11px;font-family: math;width:90px">
                                    {{ strtoupper($payments['payment']) }}</td>
                                <td style="font-size:11px;font-family: math;">{{ $payments['payment_info'] }}</td>
                                <td style="font-size:11px;font-family: math;">{{ $payments['reference'] }}</td>
                                <td style="font-size:11px;font-family: math;text-align:right;width:90px">
                                    {{ bd_money_format($payments['amount']) }}</td>
                            </tr>
                        @endforeach
                    </table>
                    <table border="0" style="width: 80%;border: none">
                        <tr>
                            <td style="padding: 0;border: none; vertical-align: initial;">
                                @if ($sale_type)
                                    <span style="font-size:12px;font-family: math;"><strong>Remark:</strong>
                                        {{ $sale_type->name }}</span>
                                @endif
                            </td>
                            <td style="text-align:right;padding: 0;border: none; vertical-align: initial;"><span
                                    style="font-size:12px;font-family: math;">Sell By:
                                    {{ $order->sellBy?->name }}</span></td>
                        </tr>
                    </table>
                </td>
                <td colspan="2" style="padding: 0;border: none; vertical-align: initial;width: 128px;">
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
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">CASHBACk
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
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->meta->sum('vat_amount'))) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->total)) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format($order->discount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->total - $order->discount)) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format($order->paid) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format($order->return_amount) }}</td>
                        </tr>
                        <tr>
                            <td class="text-end"
                                style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                {{ bd_money_format(round($order->total + $order->return_amount - $order->discount - $order->paid)) }}
                            </td>
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
