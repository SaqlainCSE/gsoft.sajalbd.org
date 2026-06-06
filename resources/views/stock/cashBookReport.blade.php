<x-admin-layout :title="__('Cash Book Report')">
    <div class="container-fluid">

        <h3 class="mb-4">Cash Book Report</h3>

        <form method="GET" action="{{ route('cash.book.report') }}" class="row g-3 align-items-center mb-4">
            <div class="col-auto">
                <label for="from_date" class="form-label">From Date</label>
                <input type="date" id="from_date" name="from_date" class="form-control"
                    value="{{ old('from_date', $from ?? '') }}">
            </div>
            <div class="col-auto">
                <label for="to_date" class="form-label">To Date</label>
                <input type="date" id="to_date" name="to_date" class="form-control"
                    value="{{ old('to_date', $to ?? '') }}">
            </div>
            <div class="col-auto align-self-end">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>

            @if (isset($from) && $from)
                <div class="col-auto align-self-end">
                    <a href="{{ route('cash.book.pdf', ['from_date' => $from, 'to_date' => $to]) }}" target="_blank"
                        class="btn btn-danger">
                        Download Report
                    </a>
                </div>
            @endif
        </form>

        @if ($stocksGrouped->isEmpty() && $bookings->isEmpty())
            <p>No data found for selected date range.</p>
        @else
            @foreach ($stocksGrouped as $date => $stocks)
                <h5 class="mt-4 mb-2">Sale Date: {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}</h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped text-center">
                        <thead>
                            <tr>
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
                                $totals = array_fill_keys(
                                    [
                                        '18k',
                                        '21k',
                                        '22k',
                                        'st',
                                        'd18k',
                                        'dia',
                                        'bill',
                                        'discount',
                                        'advance',
                                        'final',
                                        'gold',
                                        'cash',
                                        'dbbl',
                                        'city',
                                        'cbbl',
                                        'due',
                                    ],
                                    0,
                                );
                            @endphp
                            @foreach ($stocks as $stock)
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

                                    $paid = $gold + $cash + $dbbl + $city + $cbbl;
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
                                    <td class="text-end">{{ number_format($bill, 2) }}</td>
                                    <td class="text-end">{{ number_format($discount, 2) }}</td>
                                    <td class="text-end">{{ number_format($advance, 2) }}</td>
                                    <td class="text-end">{{ number_format($final, 2) }}</td>
                                    <td class="text-end">{{ number_format($gold, 2) }}</td>
                                    <td class="text-end">{{ number_format($cash, 2) }}</td>
                                    <td class="text-end">{{ number_format($dbbl, 2) }}</td>
                                    <td class="text-end">{{ number_format($city, 2) }}</td>
                                    <td class="text-end">{{ number_format($cbbl, 2) }}</td>
                                    <td class="text-end">{{ number_format($due, 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-primary fw-bold">
                                <td colspan="4">TOTAL</td>
                                <td>{{ $totals['18k'] }}</td>
                                <td>{{ $totals['21k'] }}</td>
                                <td>{{ $totals['22k'] }}</td>
                                <td>{{ $totals['st'] }}</td>
                                <td>{{ $totals['d18k'] }}</td>
                                <td>{{ $totals['dia'] }}</td>
                                <td class="text-end">{{ number_format($totals['bill'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['discount'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['advance'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['final'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['gold'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['cash'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['dbbl'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['city'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['cbbl'], 2) }}</td>
                                <td class="text-end">{{ number_format($totals['due'], 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            @endforeach

            {{-- ================= BOOKING REPORT ================= --}}
            @foreach ($bookings->groupBy('date') as $date => $bookingsGroup)
                <h5 class="mt-5 mb-2">
                    Booking Date: {{ \Carbon\Carbon::parse($date)->format('d-m-Y') }}
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped text-center">
                        <thead>
                            <tr>
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
                                <th>BILL</th>
                                <th>DISCOUNT</th>
                                <th>ADVANCE</th>
                                <th>FINAL</th>
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
                                $totals = array_fill_keys(
                                    [
                                        '18k',
                                        '21k',
                                        '22k',
                                        'st',
                                        'd18k',
                                        'dia',
                                        'bill',
                                        'discount',
                                        'advance',
                                        'final',
                                        'gold',
                                        'cash',
                                        'dbbl',
                                        'city',
                                        'cbbl',
                                        'due',
                                    ],
                                    0,
                                );
                            @endphp

                            @foreach ($bookingsGroup as $booking)
                                @php
                                    // ---------------- BASIC INFO ----------------
                                    $discount = $booking->discount ?? 0;
                                    $advance = $booking->paid ?? 0;

                                    // ---------------- PAYMENT ----------------
                                    $gold = $cash = $dbbl = $city = $cbbl = 0;

                                    foreach ($booking->payments as $pay) {
                                        if ($pay->payment == 'GOLD') {
                                            $gold += $pay->amount;
                                        }
                                        if ($pay->payment == 'CASH') {
                                            $cash += $pay->amount;
                                        }
                                        if ($pay->payment == 'DBBL') {
                                            $dbbl += $pay->amount;
                                        }
                                        if ($pay->payment == 'CITY QR') {
                                            $city += $pay->amount;
                                        }
                                        if ($pay->payment == 'CBBL') {
                                            $cbbl += $pay->amount;
                                        }
                                    }

                                    $paidTotal = $gold + $cash + $dbbl + $city + $cbbl + $advance;
                                @endphp

                                @foreach ($booking->meta as $meta)
                                    @php
                                        $product = $meta->product;

                                        $k18 = $k21 = $k22 = 0;
                                        if ($product) {
                                            if ($product->carat == 18) {
                                                $k18 = $meta->weight;
                                            }
                                            if ($product->carat == 21) {
                                                $k21 = $meta->weight;
                                            }
                                            if ($product->carat == 22) {
                                                $k22 = $meta->weight;
                                            }
                                        }

                                        $st = $meta->st_dia ?? 0;
                                        $d18k = 0;
                                        $dia = $meta->st_dia_price ?? 0;

                                        $bill = $meta->total ?? 0;
                                        $final = $bill - $discount;
                                        $due = $final - $paidTotal;

                                        // -------- TOTALS --------
                                        $totals['18k'] += $k18;
                                        $totals['21k'] += $k21;
                                        $totals['22k'] += $k22;
                                        $totals['st'] += $st;
                                        $totals['d18k'] += $d18k;
                                        $totals['dia'] += $dia;

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
                                        <td>{{ number_format($bill, 2) }}</td>
                                        <td>{{ number_format($discount, 2) }}</td>
                                        <td>{{ number_format($advance, 2) }}</td>
                                        <td>{{ number_format($final, 2) }}</td>
                                        <td>{{ number_format($gold, 2) }}</td>
                                        <td>{{ number_format($cash, 2) }}</td>
                                        <td>{{ number_format($dbbl, 2) }}</td>
                                        <td>{{ number_format($city, 2) }}</td>
                                        <td>{{ number_format($cbbl, 2) }}</td>
                                        <td>{{ number_format($due, 2) }}</td>
                                    </tr>
                                @endforeach
                            @endforeach

                            <tr class="table-primary fw-bold">
                                <td colspan="4">TOTAL</td>
                                <td>{{ $totals['18k'] }}</td>
                                <td>{{ $totals['21k'] }}</td>
                                <td>{{ $totals['22k'] }}</td>
                                <td>{{ $totals['st'] }}</td>
                                <td>{{ $totals['d18k'] }}</td>
                                <td>{{ $totals['dia'] }}</td>
                                <td>{{ number_format($totals['bill'], 2) }}</td>
                                <td>{{ number_format($totals['discount'], 2) }}</td>
                                <td>{{ number_format($totals['advance'], 2) }}</td>
                                <td>{{ number_format($totals['final'], 2) }}</td>
                                <td>{{ number_format($totals['gold'], 2) }}</td>
                                <td>{{ number_format($totals['cash'], 2) }}</td>
                                <td>{{ number_format($totals['dbbl'], 2) }}</td>
                                <td>{{ number_format($totals['city'], 2) }}</td>
                                <td>{{ number_format($totals['cbbl'], 2) }}</td>
                                <td>{{ number_format($totals['due'], 2) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            @endforeach

            {{-- ================= STOCK SUMMARY ================= --}}

            @if (isset($balances))
                <h5 class="mt-5 mb-2">
                    Stock:
                </h5>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm table-striped text-center">
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
                                <td>{{ bd_money_format($balances['gold']['18']['bf']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['21']['bf']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['22']['bf']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['ST']['bf']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['D18k']['bf']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['DIA']['bf']) }}</td>
                            </tr>

                            <tr>
                                <td>SALE</td>
                                <td>{{ bd_money_format($balances['gold']['18']['sale_today']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['21']['sale_today']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['22']['sale_today']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['ST']['sale_today']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['D18k']['sale_today']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['DIA']['sale_today']) }}</td>
                            </tr>

                            <tr class="table-primary fw-bold">
                                <td>BALANCE</td>
                                <td>{{ bd_money_format($balances['gold']['18']['balance']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['21']['balance']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['22']['balance']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['ST']['balance']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['D18k']['balance']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['DIA']['balance']) }}</td>
                            </tr>

                            @foreach (['NEW STOCK', 'EXCHANGE', 'OLD GOLD', 'S. RETURN'] as $type)
                                <tr>
                                    <td>{{ $type }}</td>
                                    <td>{{ bd_money_format($balances['gold']['18']['additions'][$type] ?? 0) }}</td>
                                    <td>{{ bd_money_format($balances['gold']['21']['additions'][$type] ?? 0) }}</td>
                                    <td>{{ bd_money_format($balances['gold']['22']['additions'][$type] ?? 0) }}</td>
                                    <td>{{ bd_money_format($balances['gold']['ST']['additions'][$type] ?? 0) }}</td>
                                    <td>{{ bd_money_format($balances['diamond']['D18k']['additions'][$type] ?? 0) }}
                                    </td>
                                    <td>{{ bd_money_format($balances['diamond']['DIA']['additions'][$type] ?? 0) }}
                                    </td>
                                </tr>
                            @endforeach

                            <tr class="table-primary fw-bold">
                                <td>CLOSING BALANCE</td>
                                <td>{{ bd_money_format($balances['gold']['18']['closing']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['21']['closing']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['22']['closing']) }}</td>
                                <td>{{ bd_money_format($balances['gold']['ST']['closing']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['D18k']['closing']) }}</td>
                                <td>{{ bd_money_format($balances['diamond']['DIA']['closing']) }}</td>
                            </tr>

                        </tbody>
                    </table>
                </div><br><br><br><br>
            @endif

        @endif

    </div>
</x-admin-layout>
