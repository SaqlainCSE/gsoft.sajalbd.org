<table id="datatable" class="table table-bordered dt-responsive nowrap"
    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead class="thead">
        <tr>
            <th>SL.</th>
            <th>Name</th>
            <th>Mobile</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $total = 0;
        @endphp

        @foreach ($clients as $client)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $client->name }}</td>
                <td>{{ $client->mobile_number }}</td>
                <td class="text-end">{{ bd_money_format($client->due_amount) }}</td>
            </tr>
            @php
                $i++;
                $total += $client->due_amount;
            @endphp
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th colspan="3" class="text-end">Total Amount:</th>
            <th class="text-end">{{ bd_money_format($total) }}</th>
        </tr>
    </tfoot>
</table>
