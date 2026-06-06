@if ($supplier)
    <div style="font-size:14px;font-family: math; font-weight: bold;">Supplier Transactions:</div>
    <div style="font-size:12px;">Name: {{ $supplier->name }}</div>
    <div style="font-size:12px;">Mobile: {{ $supplier->mobile_number }}</div>
@endif

<table id="datatable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="thead">
        <tr>
            <th style="width: 30px">SL:</th>
            <th style="width: 110px">Date</th>
            <th style="width: 110px">Ref.</th>
            @if (!$supplier)
                <th>Name</th>
                <th>Mobile</th>
            @endif
            <th>Description</th>
            <th>Bill</th>
            <th>Pay</th>
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

                <td style="width: 30px">{{ $i }}</td>
                <td style="width: 110px">{{ formatted_date($transaction->created_at) }}</td>
                <td style="width: 110px">{{ $transaction->reference_no }}</td>
                @if (!$supplier)
                    <td>{{ $transaction->supplier->name }}</td>
                    <td style="width: 125px">{{ $transaction->supplier->mobile_number }}</td>
                @endif
                <td>{{ $transaction->description }}</td>
                <td style="width: 110px" class="text-end">{{ bd_money_format($transaction->bill_amount) }}</td>
                <td style="width: 110px" class="text-end">{{ bd_money_format($transaction->payment_amount) }}</td>
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
                <th style="width: 110px" class="text-end">{{ bd_money_format($supplier->due_amount) }}</th>
            </tr>
        </tfoot>
    @else
    <tfoot>
        <tr>
            <th colspan="6" class="text-end">Total: </th>
            <th style="width: 110px" class="text-end">{{ bd_money_format($bill) }}</th>
            <th style="width: 110px" class="text-end">{{ bd_money_format($pay) }}</th>
        </tr>
        <tr>
            <th colspan="6" class="text-end">Total Due: </th>
            <th style="width: 110px" class="text-end">{{ bd_money_format($bill - $pay) }}</th>
            <th></th>
        </tr>
    </tfoot>
    @endif
</table>
