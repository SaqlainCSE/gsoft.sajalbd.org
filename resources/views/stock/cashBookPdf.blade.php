<!DOCTYPE html>
<html>
<head>
    <title>Cash Book</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 9px;
        }
        h3 {
            text-align: center;
            margin-bottom: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid #000;
            padding: 3px;
            text-align: center;
        }
        th {
            background: #e6e6e6;
        }
        .total {
            background: #f8c8dc;
            font-weight: bold;
        }
        .text-right {
            text-align: right;
        }
        .page-break {
            page-break-after: always; /* Each date in separate page for PDF */
        }
    </style>
</head>
<body>

@php
    // Merge all dates from SALE & BOOKING, unique and sorted
    $allDates = $stocksGrouped->keys()->merge($bookingsGrouped->keys())->unique()->sort();
@endphp

@foreach($allDates as $date)
    <div class="page-break">
        @php
            $stocksForDate = $stocksGrouped->get($date, collect());
            $bookingsForDate = $bookingsGrouped->get($date, collect());
        @endphp

        {{-- SALE Table --}}
        @if($stocksForDate->count())
            <h3>SALE - {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>DATE</th>
                        <th>MEMO</th>
                        <th>TOKEN</th>
                        <th>PRODUCT</th>
                        <th>CUSTOMER</th>
                        <th>18K</th>
                        <th>21K</th>
                        <th>22K</th>
                        <th>ST.</th>
                        <th>D18K</th>
                        <th>DIA</th>
                        <th>BILL AMOUNT</th>
                        <th>DISCOUNT</th>
                        <th>ADVANCE</th>
                        <th>FINAL BILL</th>
                        <th>GOLD</th>
                        <th>CASH</th>
                        <th>DBBL</th>
                        <th>CITY QR</th>
                        <th>CBBL</th>
                        <th>DUE</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totals = array_fill_keys(['18k','21k','22k','st','d18k','dia','bill','discount','advance','final','gold','cash','dbbl','city','cbbl','due'], 0);
                    @endphp

                    @foreach($stocksForDate as $stock)
                        @php
                            $payment = $stock->payment;
                            $bill = $payment->bill_amount ?? 0;
                            $discount = $payment->discount ?? 0;
                            $advance = $payment->advance ?? 0;
                            $final = $payment->final_bill ?? 0;
                            $gold = $payment->gold ?? 0;
                            $cash = $payment->cash ?? 0;
                            $dbbl = $payment->dbbl ?? 0;
                            $city = $payment->city_qr ?? 0;
                            $cbbl = $payment->cbbl ?? 0;
                            $paid = $gold+$cash+$dbbl+$city+$cbbl;
                            $due = $final - $paid;

                            $totals['18k'] += $stock->unit_18k ?? 0;
                            $totals['21k'] += $stock->unit_21k ?? 0;
                            $totals['22k'] += $stock->unit_22k ?? 0;
                            $totals['st'] += $stock->st ?? 0;
                            $totals['d18k'] += $stock->d18k ?? 0;
                            $totals['dia'] += $stock->dia ?? 0;
                            $totals['bill'] += $bill;
                            $totals['discount'] += $discount;
                            $totals['advance'] += $advance;
                            $totals['final'] += $final;
                            $totals['gold'] += $gold;
                            $totals['cash'] += $cash;
                            $totals['dbbl'] += $dbbl;
                            $totals['city'] += $city;
                            $totals['cbbl'] += $cbbl;
                            $totals['due'] += $due;
                        @endphp
                        <tr>
                            <td>{{ $stock->date }}</td>
                            <td>{{ $stock->memo }}</td>
                            <td>{{ $stock->token }}</td>
                            <td>{{ $stock->product->category->name ?? '' }}</td>
                            <td>{{ $stock->client->name ?? '' }}</td>
                            <td>{{ $stock->unit_18k }}</td>
                            <td>{{ $stock->unit_21k }}</td>
                            <td>{{ $stock->unit_22k }}</td>
                            <td>{{ $stock->st }}</td>
                            <td>{{ $stock->d18k }}</td>
                            <td>{{ $stock->dia }}</td>
                            <td class="text-right">{{ number_format($bill,2) }}</td>
                            <td class="text-right">{{ number_format($discount,2) }}</td>
                            <td class="text-right">{{ number_format($advance,2) }}</td>
                            <td class="text-right">{{ number_format($final,2) }}</td>
                            <td class="text-right">{{ number_format($gold,2) }}</td>
                            <td class="text-right">{{ number_format($cash,2) }}</td>
                            <td class="text-right">{{ number_format($dbbl,2) }}</td>
                            <td class="text-right">{{ number_format($city,2) }}</td>
                            <td class="text-right">{{ number_format($cbbl,2) }}</td>
                            <td class="text-right">{{ number_format($due,2) }}</td>
                        </tr>
                    @endforeach
                    <tr class="total">
                        <td colspan="5">TOTAL</td>
                        <td>{{ $totals['18k'] }}</td>
                        <td>{{ $totals['21k'] }}</td>
                        <td>{{ $totals['22k'] }}</td>
                        <td>{{ $totals['st'] }}</td>
                        <td>{{ $totals['d18k'] }}</td>
                        <td>{{ $totals['dia'] }}</td>
                        <td>{{ number_format($totals['bill'],2) }}</td>
                        <td>{{ number_format($totals['discount'],2) }}</td>
                        <td>{{ number_format($totals['advance'],2) }}</td>
                        <td>{{ number_format($totals['final'],2) }}</td>
                        <td>{{ number_format($totals['gold'],2) }}</td>
                        <td>{{ number_format($totals['cash'],2) }}</td>
                        <td>{{ number_format($totals['dbbl'],2) }}</td>
                        <td>{{ number_format($totals['city'],2) }}</td>
                        <td>{{ number_format($totals['cbbl'],2) }}</td>
                        <td>{{ number_format($totals['due'],2) }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        {{-- BOOKING Table --}}
@if($bookingsForDate->count())
    <h3>BOOKING - {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h3>
    <table>
        <thead>
            <tr>
                <th>DATE</th>
                <th>MEMO</th>
                <th>TOKEN</th>
                <th>PRODUCT</th>
                <th>CUSTOMER</th>
                <th>18K</th>
                <th>21K</th>
                <th>22K</th>
                <th>ST.</th>
                <th>D18K</th>
                <th>DIA</th>
                <th>BILL AMOUNT</th>
                <th>DISCOUNT</th>
                <th>ADVANCE</th>
                <th>FINAL BILL</th>
                <th>GOLD</th>
                <th>CASH</th>
                <th>DBBL</th>
                <th>CITY QR</th>
                <th>CBBL</th>
                <th>DUE</th>
            </tr>
        </thead>
        <tbody>
            @php
                $bookingTotals = array_fill_keys([
                    '18k','21k','22k','st','d18k','dia',
                    'bill','discount','advance','final',
                    'gold','cash','dbbl','city','cbbl','due'
                ],0);
            @endphp

            @foreach($bookingsForDate as $booking)

                @php
                    // -------- BASIC DATA --------
                    $discount = $booking->discount ?? 0;
                    $advance  = $booking->paid ?? 0;

                    // -------- PAYMENT CALCULATION --------
                    $gold=$cash=$dbbl=$city=$cbbl=0;

                    foreach($booking->payments as $pay){
                        if($pay->payment=='GOLD')     $gold += $pay->amount;
                        if($pay->payment=='CASH')     $cash += $pay->amount;
                        if($pay->payment=='DBBL')     $dbbl += $pay->amount;
                        if($pay->payment=='CITY QR')  $city += $pay->amount;
                        if($pay->payment=='CBBL')     $cbbl += $pay->amount;
                    }

                    $paidTotal = $gold + $cash + $dbbl + $city + $cbbl + $advance;
                @endphp

                @foreach($booking->meta as $meta)

                    @php
                        $product = $meta->product;

                        $k18=$k21=$k22=0;
                        if($product){
                            if($product->carat==18) $k18=$meta->weight;
                            if($product->carat==21) $k21=$meta->weight;
                            if($product->carat==22) $k22=$meta->weight;
                        }

                        $st   = $meta->st_dia ?? 0;
                        $d18k = 0;
                        $dia  = $meta->st_dia_price ?? 0;

                        $bill  = $meta->total ?? 0;
                        $final = $bill - $discount;
                        $due   = $final - $paidTotal;

                        // -------- TOTALS --------
                        $bookingTotals['18k'] += $k18;
                        $bookingTotals['21k'] += $k21;
                        $bookingTotals['22k'] += $k22;
                        $bookingTotals['st']  += $st;
                        $bookingTotals['d18k']+= $d18k;
                        $bookingTotals['dia'] += $dia;

                        $bookingTotals['bill']     += $bill;
                        $bookingTotals['discount'] += $discount;
                        $bookingTotals['advance']  += $advance;
                        $bookingTotals['final']    += $final;

                        $bookingTotals['gold'] += $gold;
                        $bookingTotals['cash'] += $cash;
                        $bookingTotals['dbbl'] += $dbbl;
                        $bookingTotals['city'] += $city;
                        $bookingTotals['cbbl'] += $cbbl;

                        $bookingTotals['due'] += $due;
                    @endphp

                    <tr>
                        <td>{{ $booking->date }}</td>
                        <td>{{ $booking->id }}</td>
                        <td>{{ $product->product_nr ?? '' }}</td>
                        <td>{{ $product->category->name ?? '' }}</td>
                        <td>{{ $booking->client->name ?? '' }}</td>
                        <td>{{ $k18 }}</td>
                        <td>{{ $k21 }}</td>
                        <td>{{ $k22 }}</td>
                        <td>{{ $st }}</td>
                        <td>{{ $d18k }}</td>
                        <td>{{ $dia }}</td>
                        <td class="text-right">{{ number_format($bill,2) }}</td>
                        <td class="text-right">{{ number_format($discount,2) }}</td>
                        <td class="text-right">{{ number_format($advance,2) }}</td>
                        <td class="text-right">{{ number_format($final,2) }}</td>
                        <td class="text-right">{{ number_format($gold,2) }}</td>
                        <td class="text-right">{{ number_format($cash,2) }}</td>
                        <td class="text-right">{{ number_format($dbbl,2) }}</td>
                        <td class="text-right">{{ number_format($city,2) }}</td>
                        <td class="text-right">{{ number_format($cbbl,2) }}</td>
                        <td class="text-right">{{ number_format($due,2) }}</td>
                    </tr>

                @endforeach
            @endforeach

            <tr class="total">
                <td colspan="5">TOTAL</td>
                <td>{{ $bookingTotals['18k'] }}</td>
                <td>{{ $bookingTotals['21k'] }}</td>
                <td>{{ $bookingTotals['22k'] }}</td>
                <td>{{ $bookingTotals['st'] }}</td>
                <td>{{ $bookingTotals['d18k'] }}</td>
                <td>{{ $bookingTotals['dia'] }}</td>
                <td>{{ number_format($bookingTotals['bill'],2) }}</td>
                <td>{{ number_format($bookingTotals['discount'],2) }}</td>
                <td>{{ number_format($bookingTotals['advance'],2) }}</td>
                <td>{{ number_format($bookingTotals['final'],2) }}</td>
                <td>{{ number_format($bookingTotals['gold'],2) }}</td>
                <td>{{ number_format($bookingTotals['cash'],2) }}</td>
                <td>{{ number_format($bookingTotals['dbbl'],2) }}</td>
                <td>{{ number_format($bookingTotals['city'],2) }}</td>
                <td>{{ number_format($bookingTotals['cbbl'],2) }}</td>
                <td>{{ number_format($bookingTotals['due'],2) }}</td>
            </tr>

        </tbody>
    </table>
@endif

{{-- ================= STOCK SUMMARY ================= --}}
@if(isset($balancesByDate[$date]))
<h3>STOCK - {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h3>

<table>
    <thead>
        <tr>
            <th>DETAILS</th>
            <th>18K</th>
            <th>21K</th>
            <th>22K</th>
            <th>ST.</th>
            <th>D 18K</th>
            <th>DIA</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>BALANCE B/F</td>
            <td>{{ $balancesByDate[$date]['gold']['18']['bf'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['21']['bf'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['22']['bf'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['ST']['bf'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['D18k']['bf'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['DIA']['bf'] }}</td>
        </tr>

        <tr>
            <td>SALE</td>
            <td>{{ $balancesByDate[$date]['gold']['18']['sale_today'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['21']['sale_today'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['22']['sale_today'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['ST']['sale_today'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['D18k']['sale_today'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['DIA']['sale_today'] }}</td>
        </tr>

        <tr class="total">
            <td>BALANCE</td>
            <td>{{ $balancesByDate[$date]['gold']['18']['balance'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['21']['balance'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['22']['balance'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['ST']['balance'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['D18k']['balance'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['DIA']['balance'] }}</td>
        </tr>

        @foreach(['NEW STOCK','EXCHANGE','OLD GOLD','S. RETURN'] as $type)
        <tr>
            <td>{{ $type }}</td>
            <td>{{ $balancesByDate[$date]['gold']['18']['additions'][$type] ?? 0 }}</td>
            <td>{{ $balancesByDate[$date]['gold']['21']['additions'][$type] ?? 0 }}</td>
            <td>{{ $balancesByDate[$date]['gold']['22']['additions'][$type] ?? 0 }}</td>
            <td>{{ $balancesByDate[$date]['gold']['ST']['additions'][$type] ?? 0 }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['D18k']['additions'][$type] ?? 0 }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['DIA']['additions'][$type] ?? 0 }}</td>
        </tr>
        @endforeach

        <tr class="total">
            <td>CLOSING BALANCE</td>
            <td>{{ $balancesByDate[$date]['gold']['18']['closing'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['21']['closing'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['22']['closing'] }}</td>
            <td>{{ $balancesByDate[$date]['gold']['ST']['closing'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['D18k']['closing'] }}</td>
            <td>{{ $balancesByDate[$date]['diamond']['DIA']['closing'] }}</td>
        </tr>

    </tbody>
</table>
@endif

    </div> {{-- page-break --}}
@endforeach



</body>
</html>
