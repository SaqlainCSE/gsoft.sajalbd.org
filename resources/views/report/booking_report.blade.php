<table id="datatable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="thead">
        <tr>
            <th style="width: 10px">SL#</th>
            <th style="width: 20px">BK No</th>
            <th style="width: 55px">Date</th>
            <th>Client</th>
            <th style="width: 70px">Client Mobile</th>
            <th style="width: 80px">Client Category</th>
            <th style="width: 55px">Item Total</th>
            <th style="width: 50px">VAT</th>
            <th style="width: 55px">Discount</th>
            <th style="width: 55px">Total</th>
            <th style="width: 55px">Paid</th>
            <th style="width: 55px">Due</th>
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
                <td style="width: 20px">{{ $row->id }}</td>
                <td>{{ $row->date }}</td>
                <td>{{ optional($row->client)->name }}</td>
                <td style="width: 70px">{!! $phone_numbers_with_break = str_replace('/', '<br>', @$row->client?->mobile_number) !!}</td>
                <td style="width: 70px">{{ @$row->saleType?->name }}</td>
                <td class="text-end">{{ bd_money_format($itemTotal) }}</td>
                <td class="text-end">{{ bd_money_format($vat_amount) }}</td>
                <td class="text-end">{{ bd_money_format($row->discount) }}</td>
                <td class="text-end">{{ bd_money_format($total) }}</td>
                <td class="text-end">{{ bd_money_format($row->paid) }}</td>
                <td class="text-end">{{ bd_money_format($row->due ?: 0) }}</td>
            </tr>
            @php
                $i++;
                // $total += $supplier->due_amount;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="9" class="text-end">Total:</th>
            <th style="width: 55px" class="text-end">{{ bd_money_format($alltotal) }}</th>
            <th style="width: 55px" class="text-end">{{ bd_money_format($alltotal) }}</th>
            <th style="width: 55px" class="text-end">{{ bd_money_format($alldue) }}</th>
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
