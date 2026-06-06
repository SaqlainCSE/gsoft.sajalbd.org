<table>
    <thead>
        <tr>
            <th>SL</th>
            <th>Date</th>
            <th>Head</th>
            <th>Payment Method</th>
            <th>Reference</th>
            <th>Expense By</th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
        @php
            $totalAmount = 0;
            $sl = 1;
        @endphp

        @foreach($expenses as $expense)
            @php
                $totalAmount += $expense->amount;
            @endphp
            <tr>
                <td>{{ $sl++ }}</td>
                <td>{{ $expense->date }}</td>
                <td>{{ $expense->trxHead?->name }}</td>
                <td>{{ $expense->paymentMethod?->name }}</td>
                <td>{{ $expense->reference_no }}</td>
                <td>{{ $expense->expenseBy?->name }}</td>
                <td class="text-right">{{ bd_money_format($expense->amount) }}</td>
            </tr>
        @endforeach

        <tr class="total-row">
            <td colspan="6" class="text-right">Total</td>
            <td class="text-right">{{ bd_money_format($totalAmount) }}</td>
        </tr>
    </tbody>
</table>