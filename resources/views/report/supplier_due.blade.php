<div style="font-size:14px;font-family: math; font-weight: bold;">Supplier Due:</div>
<table id="datatable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="thead">
        <tr>
            <th style="width: 30px">SL.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th style="width: 110px">Balance</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $total = 0;
        @endphp

        @foreach ($suppliers as $supplier)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $supplier->name }}</td>
                <td>{{ $supplier->mobile_number }}</td>
                <td style="width: 110px" class="text-end">{{ bd_money_format($supplier->due_amount) }}</td>
            </tr>
            @php
                $i++;
                $total += $supplier->due_amount;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end">Total Amount:</th>
            <th style="width: 110px" class="text-end">{{ bd_money_format($total) }}</th>
        </tr>
    </tfoot>
</table>
