<div>
    @if ($client)
        <table style="width: 100%;">
            <tbody>
                <tr>
                    <td style="font-size:14px;"><span
                            style="font-size:14px;font-family: math; font-weight: bold;">CUSTOMER
                            DETAILS:</span></td>
                </tr>
                <tr>
                    <td style="font-size:14px;">{{ $client->name }}</td>
                </tr>
                <tr>
                    <td style="font-size:14px;">{{ $client->address }}</td>
                </tr>
                <tr>
                    <td style="font-size:14px;">{{ $client->mobile_number }}</td>
                </tr>
            </tbody>
        </table>
    @else
    <div style="font-size:14px;font-family: math; font-weight: bold;">Customer Due Transactions:</div>
    @endif

    <table class="table-fw table-border table table-bordered">
        <thead>
            <tr>
                <td class="text-center">SL:</td>
                <td class="text-center">Date</td>
                <td class="text-center">Memo No</td>
                @if (!$client)
                    <td class="text-center">Name</td>
                @endif
                <td class="text-center">Description</td>
                <td class="text-center">Bill</td>
                <td class="text-center">Pay</td>

            </tr>
        </thead>
        <tbody>
            @php
                $i = 1;
                $bill = 0;
                $pay = 0;
            @endphp
            @if ($transactions)
                @foreach ($transactions as $transaction)
                    @php
                        $bill += $transaction->bill_amount;
                        $pay += $transaction->payment_amount;
                    @endphp
                    <tr>
                        <td class="text-center" style="width: 30px">{{ $i }}</td>
                        <td style="width: 120px">
                            {{ formatted_date($transaction->created_at) }}
                        </td>
                        <td style="width: 120px">
                            {{ $transaction->cash_memo_no }}
                        </td>
                        @if (!$client)
                            <td>{{ @$transaction->client->name }}</td>
                        @endif
                        <td>
                            {{ $transaction->description }}
                        </td>
                        <td style="width: 110px" class="text-end">
                            {{ bd_money_format($transaction->bill_amount) }}</td>
                        <td style="width: 110px" class="text-end">
                            {{ bd_money_format($transaction->payment_amount) }}</td>

                    </tr>
                    @php
                        $i++;
                    @endphp
                @endforeach
            @endif
            @if ($client)
                <tr>
                    <td colspan="5" class="text-end"
                        style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Due:
                    </td>
                    <td style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                        {{ bd_money_format($client->due_amount) }}</td>
                </tr>
            @else
                <tr>
                    <td colspan="6" class="text-end"
                        style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Bill:
                    </td>
                    <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                        {{ bd_money_format($bill) }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-end"
                        style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Pay:
                    </td>
                    <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                        {{ bd_money_format($pay) }}</td>
                </tr>
                <tr>
                    <td colspan="6" class="text-end"
                        style="width:59px;font-size:12px;font-family: math;font-weight: bold;">Total Due:
                    </td>
                    <td class="text-end" style="width:59px;font-size:12px;font-family: math;font-weight: bold;">
                        {{ bd_money_format($bill - $pay) }}</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>
