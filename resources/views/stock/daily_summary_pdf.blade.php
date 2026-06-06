<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width:100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border:1px solid #000; padding:6px; text-align:center; }
        th { background:#ddd; }
        h2 { text-align:center; margin-bottom:10px; }
    </style>
</head>
<body>

<h2>Daily Stock Report</h2>
<p><strong>Date:</strong> {{ $date }}</p>

<table>
    <thead>
        <tr>
            <th>SL</th>
            <th>Category</th>
            <th>Qty</th>
            <th>Total Weight</th>
            <th>18K</th>
            <th>21K</th>
            <th>22K</th>
            <th>Stone</th>
        </tr>
    </thead>

    <tbody>
        @foreach($rows as $r)
        <tr>
            <td>{{ $r['sl'] }}</td>
            <td>{{ $r['category'] }}</td>
            <td>{{ $r['qty'] }}</td>
            <td>{{ $r['total_weight'] }}</td>
            <td>{{ $r['w18k'] }}</td>
            <td>{{ $r['w21k'] }}</td>
            <td>{{ $r['w22k'] }}</td>
            <td>{{ $r['stone'] }}</td>
        </tr>
        @endforeach

        <tr>
            <td colspan="2"><strong>TOTAL</strong></td>
            <td>{{ $totals['qty'] }}</td>
            <td>{{ $totals['total_weight'] }} gm ({{ $totals['total_weight_vori'] }} vori)</td>
            <td>{{ $totals['w18k'] }} gm ({{ $totals['w18k_vori'] }} vori)</td>
            <td>{{ $totals['w21k'] }} gm ({{ $totals['w21k_vori'] }} vori)</td>
            <td>{{ $totals['w22k'] }} gm ({{ $totals['w22k_vori'] }} vori)</td>
            <td>{{ $totals['stone'] }}</td>
        </tr>
    </tbody>
</table>


<h3>Diamond Products</h3>

<table>
    <thead>
        <tr>
            <th>SL</th>
            <th>Product</th>
            <th>Qty</th>
            <th>Total Weight</th>
            <th>18K</th>
        </tr>
    </thead>

    <tbody>
        @foreach($diamondRows as $dr)
        <tr>
            <td>{{ $dr['sl'] }}</td>
            <td>{{ $dr['product'] }}</td>
            <td>{{ $dr['qty'] }}</td>
            <td>{{ $dr['weight'] }}</td>
            <td>{{ $dr['w18k'] }}</td>
        </tr>
        @endforeach

        <tr>
            <td colspan="2"><strong>TOTAL</strong></td>
            <td>{{ $diamondTotals['qty'] }}</td>
            <td>{{ $diamondTotals['weight'] }}</td>
            <td>{{ $diamondTotals['w18k'] }}</td>
        </tr>
    </tbody>
</table>

</body>
</html>
