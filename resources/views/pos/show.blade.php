<x-admin-layout :title="__('POS')">

    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <a href="{{ route('pos.show', $order->id) }}" target="_blank"
                                class="btn btn-soft-success waves-effect waves-light">
                                {{ __('PRINT') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page card" orientation="portrait" size="A4" pages="1"
                style="padding-top: 20px;margin:0 auto;color: #000;">
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
                            <td class="text-center"
                                style="width:52px;font-size:12px;font-weight: bold;font-family: math;">TOKEN
                                NO</td>
                            <td class="text-center" style="font-size:12px;font-weight: bold;font-family: math;">PRODUCT
                                DETAILS
                            </td>
                            <td class="text-center"
                                style="width:59px;font-size:12px;font-weight: bold;font-family: math;">GOLD
                                WT/GM</td>
                            <td class="text-center"
                                style="width:59px;font-size:12px;font-weight: bold;font-family: math;">GOLD
                                PRICE</td>
                            <td class="text-center"
                                style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                                ST/DIA WT</td>
                            <td class="text-center"
                                style="width:59px;font-size:12px;font-weight: bold;font-family: math;">
                                ST/DIA PRICE</td>
                            <td class="text-center"
                                style="width: 85px;font-size:12px;font-weight: bold;font-family: math;">
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
                                <td style="font-size:12px;font-family: math;">{{ $meta->product->product_details }}
                                </td>
                                <td class="text-end" style="font-size:12px;font-family: math;">
                                    {{ $meta->product->weight }}</td>
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
                            <td class="text-end" style="font-size:12px;font-family: math;">
                                {{ $order->meta->sum('weight') }}
                            </td>
                            <td class="text-end" style="font-size:12px;font-family: math;"></td>
                            <td class="text-end" style="font-size:12px;font-family: math;">
                                {{ $order->meta->sum('st_dia') }}
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
                                        <td style="font-size:11px;font-weight: bold;font-family: math;">
                                            PAYMENT TYPE</td>
                                        <td style="font-size:11px;font-weight: bold;font-family: math; width:170px">PAYMENT INFO
                                        </td>
                                        <td
                                            style="font-size:11px;font-weight: bold;font-family: math; text-transform:uppercase; width:140px;">
                                            reference</td>
                                        <td
                                            style="font-size:11px;font-weight: bold;font-family: math;text-align:right;width:90px">
                                            AMOUNT</td>
                                    </tr>
                                    @foreach ($order->payments as $payments)
                                        <tr>
                                            <td style="font-size:11px;font-family: math;">
                                                {{ strtoupper($payments['payment']) }}</td>
                                            <td style="font-size:11px;font-family: math; width:170px;">
                                                {{ $payments['payment_info'] }}</td>
                                            <td style="font-size:11px;font-family: math;  width:140px;">{{ $payments['reference'] }}
                                            </td>
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
                                        <td style="text-align:right;padding: 0;border: none; vertical-align: initial;">
                                            <span style="font-size:12px;font-family: math;">Sell By:
                                                {{ $order->sellBy?->name }}</span>
                                        </td>
                                    </tr>
                                </table>

                            </td>
                            <td colspan="2" style="padding: 0;border: none; vertical-align: initial; width: 128px;">
                                <table class="table-fw table-border"
                                    style="margin-top: -1px;margin-left: -1px;width: calc(100% - -2px);">
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            WAGE</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            VAT</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            ADJUSTABLE
                                            AMOUNT</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            DISCOUNT
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            TOTAL TAKA
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            PAYMENTS
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            CASHBACK
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" colspan="2"
                                            style="font-size:11px;font-weight: bold;font-family: math;padding: 3px;">
                                            FINAL DUE
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
                                            @php
                                             $thisbilldue = round($order->total + $order->return_amount - $order->paid - $order->discount);
                                            @endphp
                                            {{ $thisbilldue == '0' ? bd_money_format(0) : bd_money_format($thisbilldue)}}
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
        </div>
    </div>
    @push('css')
        <style>
            @font-face {
                font-family: 'SutonnyMJ';
                src: url('../fonts/SutonnyMJ.woff2') format('woff2'),
                    url('../fonts/SutonnyMJ.woff') format('woff');
                font-weight: normal;
                font-style: italic;
                font-display: swap;
            }

            @font-face {
                font-family: 'SutonnyMJ';
                src: url('../fonts/SutonnyMJ-Bold.woff2') format('woff2'),
                    url('../fonts/SutonnyMJ-Bold.woff') format('woff');
                font-weight: bold;
                font-style: italic;
                font-display: swap;
            }

            @font-face {
                font-family: 'SutonnyMJ';
                src: url('../fonts/SutonnyMJ-BoldItalic.woff2') format('woff2'),
                    url('../fonts/SutonnyMJ-BoldItalic.woff') format('woff');
                font-weight: bold;
                font-style: italic;
                font-display: swap;
            }

            @font-face {
                font-family: 'SutonnyMJ';
                src: url('../fonts/SutonnyMJ-Italic.woff2') format('woff2'),
                    url('../fonts/SutonnyMJ-Italic.woff') format('woff');
                font-weight: normal;
                font-style: italic;
                font-display: swap;
            }

            @font-face {
                font-family: 'SutonnyOMJ';
                src: url('../fonts/SutonnyOMJ.woff2') format('woff2'),
                    url('../fonts/SutonnyOMJ.woff') format('woff');
                font-weight: normal;
                font-style: normal;
                font-display: swap;
            }

            div.page {
                width: 210mm;
                box-sizing: border-box;
                overflow: hidden;
                padding: 1.4173228346em;
                /* page-break-after: always; */
                position: relative;
            }



            @media print {
                div.page {
                    width: 210mm;
                }

                div.page[orientation=landscape] {
                    width: 297mm;
                }

                div.page[size=A0] {
                    width: 841mm;
                }

                div.page[size=A0][orientation=landscape] {
                    width: 1189mm;
                }

                div.page[size=A1] {
                    width: 594mm;
                }

                div.page[size=A1][orientation=landscape] {
                    width: 841mm;
                }

                div.page[size=A2] {
                    width: 420mm;
                }

                div.page[size=A2][orientation=landscape] {
                    width: 594mm;
                }

                div.page[size=A3] {
                    width: 297mm;
                }

                div.page[size=A3][orientation=landscape] {
                    width: 420mm;
                }

                div.page[size=A4] {
                    width: 210mm;
                }

                div.page[size=A4][orientation=landscape] {
                    width: 297mm;
                }

                div.page[size=A5] {
                    width: 148mm;
                }

                div.page[size=A5][orientation=landscape] {
                    width: 210mm;
                }

                div.page[size=A6] {
                    width: 105mm;
                }

                div.page[size=A6][orientation=landscape] {
                    width: 148mm;
                }

                div.page[size=A7] {
                    width: 74mm;
                }

                div.page[size=A7][orientation=landscape] {
                    width: 105mm;
                }

                div.page[size=A8] {
                    width: 52mm;
                }

                div.page[size=A8][orientation=landscape] {
                    width: 74mm;
                }

                div.page[size=A9] {
                    width: 37mm;
                }

                div.page[size=A9][orientation=landscape] {
                    width: 52mm;
                }

                div.page[size=A10] {
                    width: 26mm;
                }

                div.page[size=A10][orientation=landscape] {
                    width: 37mm;
                }

                footer {
                    position: fixed;
                    bottom: 50px;
                    width: 194mm;
                }
            }


            .table-fw {
                width: 100%;
            }

            .text-end {
                text-align: right;
            }

            .text-center {
                text-align: center;
            }

            .table-border {
                border-collapse: collapse !important;
                border-spacing: 0;
            }

            .table-border td,
            .table-border th {
                border: 1px solid #000;
            }

            @media screen {
                .page {
                    background: radial-gradient(#d0d0d0, #909090) fixed;
                    font-family: 'SutonnyOMJ';
                    font-size: 20px;
                }

                div.page {
                    background: white;
                    margin: 1.4173228346em auto;
                }
            }

            @page {
                margin: 1.4173228346em;
            }
        </style>
    @endpush
</x-admin-layout>