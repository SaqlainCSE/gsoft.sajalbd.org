<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Stock Report</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width:100%; border-collapse: collapse; margin-top:10px; }
        th, td { border:1px solid #000; padding:4px; text-align:center; }
        th { background:#e9e9e9; }
        .total-row { background:#f6f6f6; font-weight:bold; }
        h2 { text-align:center; margin:0 0 8px 0; }
        .filter-table td { border: none; text-align: left; padding: 2px 4px; }
    </style>
</head>
<body>

    <h2>Stock Report</h2>

    <!-- ====================== FILTER INFORMATION ====================== -->
    @php
        $hasFilter = collect($filters)->filter(fn($v) => !empty($v))->count() > 0;
    @endphp

    @if($hasFilter)
    <table class="filter-table" style="width: 100%; margin-bottom: 5px;">
        <tr>
            @if(!empty($filters['start_date']))
                <td><strong>Start Date:</strong> {{ $filters['start_date'] }}</td>
            @endif
            @if(!empty($filters['end_date']))
                <td><strong>End Date:</strong> {{ $filters['end_date'] }}</td>
            @endif
        </tr>
        <tr>
            @if(!empty($filters['type']))
                <td><strong>Product Type:</strong> {{ ucfirst($filters['type']) }}</td>
            @endif
            @if(!empty($filters['product_category_id']))
                @php
                    $categoryName = $categories->firstWhere('id', $filters['product_category_id'])->name ?? '';
                @endphp
                <td><strong>Product:</strong> {{ $categoryName }}</td>
            @endif
        </tr>
        <tr>
            @if(!empty($filters['token_number']))
                <td><strong>Token Number:</strong> {{ $filters['token_number'] }}</td>
            @endif
            <td><strong>Total:</strong> {{ $rows->count() }}</td>
        </tr>
    </table>
    @endif

    <!-- ====================== MAIN TABLE ====================== -->
    <table>
        <thead>
            <tr>
                <th>SL</th>
                <th>Token</th>
                <th>PO</th>
                <th>P.Date</th>
                <th>Supplier</th>
                <th>Qty</th>
                <th>18K</th>
                <th>21K</th>
                <th>22K</th>
                <th>Stone</th>
                <th>Total Weight</th>
                <th>P/Rate</th>
                <th>S/Rate</th>
                <th>Selling Date</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            <!-- TOTAL ROW -->
            <tr class="total-row">
                <td colspan="5">TOTAL</td>
                <td>{{ $totals['qty'] }}</td>
                <td>{{ number_format($totals['w18k'], 2) }}</td>
                <td>{{ number_format($totals['w21k'], 2) }}</td>
                <td>{{ number_format($totals['w22k'], 2) }}</td>
                <td>{{ number_format($totals['stone'], 2) }}</td>
                <td>{{ number_format($totals['total_weight'], 2) }}</td>
                <!--<td>{{ number_format($totals['p_rate'], 2) }}</td>-->
                <!--<td>{{ number_format($totals['s_rate'], 2) }}</td>-->
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <!-- DATA ROWS -->
            @foreach($rows as $i => $r)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $r['new_token'] }}</td>
                    <td>{{ $r['po_number'] }}</td>
                    <td>{{ $r['p_date'] }}</td>
                    <td>{{ $r['supplier'] }}</td>
                    <td>{{ $r['qty'] }}</td>
                    <td>{{ number_format($r['w18k'],2) }}</td>
                    <td>{{ number_format($r['w21k'],2) }}</td>
                    <td>{{ number_format($r['w22k'],2) }}</td>
                    <td>{{ number_format($r['stone'],2) }}</td>
                    <td>{{ number_format($r['total_weight'],2) }}</td>
                    <td>{{ number_format($r['p_rate'],2) }}</td>
                    <td>{{ number_format($r['s_rate'],2) }}</td>
                    <td>{{ $r['selling_date'] }}</td>
                    <td>{{ $r['status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
