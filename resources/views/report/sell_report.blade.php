<table id="datatable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; min-width: 100%;overflow: auto">
    <thead class="thead">
        <tr>
            <th style="width: 10px">SL#</th>
            <th style="width: 20px">Memo</th>
            <th style="width: 120px">Date</th>
            <th>Client</th>
            <th style="width: 70px">Client Mobile</th>
            <th style="width: 80px">Client Category</th>
            <th style="width: 70px">Sale Type</th>
            <th style="width: 55px">Item Total</th>
            <th style="width: 50px">WAGE</th>
            <th style="width: 50px">VAT</th>
            <th style="width: 55px">Discount</th>
            <th style="width: 55px">Total</th>
            <th style="width: 55px">Paid</th>
            <th style="width: 55px">Due</th>
            <th style="width: 55px">18K</th>
            <th style="width: 55px">21K</th>
            <th style="width: 55px">22K</th>
            <th style="width: 55px">ST.</th>
            <th style="width: 55px">D18K</th>
            <th style="width: 55px">DIA</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $alltotal = 0;
            $allwage = 0;
            $allpaid = 0;
            $alldue = 0;

            $k18total = 0;
            $k21total = 0;
            $k22total = 0;
            $sttotal = 0;
            $d18total = 0;
            $diatotal = 0;
        @endphp

        @foreach ($orders as $row)
            @php
                $vat_amount = $row->meta->sum('vat_amount');
                $wage_amount = $row->meta->sum('wage');
                $itemTotal = $row->meta->sum('total') - $vat_amount - $wage_amount;
                $subtotal = $row->meta->sum('total');
                $total = $itemTotal + $wage_amount + $vat_amount - $row->discount;
                $alltotal += $total;
                $allpaid += $row->paid;
                $alldue += $row->due;


                $order = $orders->first();

                $k18 = 0;
                $k21 = 0;
                $k22 = 0;
                $st = 0;
                $d18 = 0;
                $dia = 0;

                foreach($row->meta as $meta){
                    if($meta->product->carat == '18' && $meta->product->type == "gold"){
                        $k18 += $meta->product->weight;
                        $k18total += $meta->product->weight;
                    }elseif($meta->product->carat == '21' && $meta->product->type == "gold"){
                        $k21 += $meta->product->weight;
                        $k21total += $meta->product->weight;
                    }elseif($meta->product->carat == '22' && $meta->product->type == "gold"){
                        $k22 += $meta->product->weight;
                        $k22total += $meta->product->weight;
                    }
                    elseif($meta->product->carat == '18' && $meta->product->type == "diamond"){
                        $d18 += $meta->product->weight;
                        $d18total += $meta->product->weight;
                    }

                    if($meta->product->st_dia && $meta->product->type == "gold"){
                        $st += $meta->product->st_dia;
                        $sttotal += $meta->product->st_dia;
                    } elseif($meta->product->st_dia  && $meta->product->type == "diamond"){
                        $dia += $meta->product->st_dia;
                        $diatotal += $meta->product->st_dia;
                    }
                }
            @endphp

            <tr>
                <td>{{ $i }}</td>
                <td style="width: 20px">{{ $row->cash_memo_no }}</td>
                <td style="width: 120px">{{ $row->date }}</td>
                <td>{{ optional($row->client)->name }}</td>
                <td style="width: 70px">{!! $phone_numbers_with_break = str_replace('/', '<br>', @$row->client?->mobile_number) !!}</td>
                <td style="width: 80px">{{ @$row->client?->category?->name }}</td>
                <td style="width: 70px">{{ @$row->saleType?->name }}</td>
                <td class="text-end">{{ bd_money_format($itemTotal) }}</td>
                <td class="text-end">{{ bd_money_format($wage_amount) }}</td>
                <td class="text-end">{{ bd_money_format($vat_amount) }}</td>
                <td class="text-end">{{ bd_money_format($row->discount) }}</td>
                <td class="text-end">{{ bd_money_format($total) }}</td>
                <td class="text-end">{{ bd_money_format($row->paid) }}</td>
                <td class="text-end">{{ bd_money_format($row->due ?: 0) }}</td>

                <td style="width: 55px" class="text-end">{{$k18}}</td>
                <td style="width: 55px" class="text-end">{{$k21}}</td>
                <td style="width: 55px" class="text-end">{{$k22}}</td>
                <td style="width: 55px" class="text-end">{{$st}}</td>
                <td style="width: 55px" class="text-end">{{$d18}}</td>
                <td style="width: 55px" class="text-end">{{$dia}}</td>
            </tr>
            @php
                $i++;
                // $total += $supplier->due_amount;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="11" class="text-end">Total:</th>
            <th style="width: 55px" class="text-end">{{ bd_money_format($alltotal) }}</th>
            <th style="width: 55px" class="text-end">{{ bd_money_format($alltotal) }}</th>
            <th style="width: 55px" class="text-end">{{ bd_money_format($alldue) }}</th>
            <th style="width: 55px" class="text-end">{{$k18total}}</th>
            <th style="width: 55px" class="text-end">{{$k21total}}</th>
            <th style="width: 55px" class="text-end">{{$k22total}}</th>
            <th style="width: 55px" class="text-end">{{$sttotal}}</th>
            <th style="width: 55px" class="text-end">{{$d18total}}</th>
            <th style="width: 55px" class="text-end">{{$diatotal}}</th>
        </tr>
    </tfoot>
</table>
<style>
    th,
    td {
        font-size: 13px;
        padding: 10px 3px !important;
        border: 1px solid #000 !important;
        color: #000 !important;
    }

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
</style>
