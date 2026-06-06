<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}" />
    <style>
        .bl-0 td.text-end {
            border-left: none;
        }

        ul {
            padding: 0;
            margin: 0;
        }
        th, td {
            font-size:12px;
            font-family: math;
        }
        th{
            font-weight: bold;
        }
    </style>
</head>



<body onload="window.print()" onafterprint="window.close">
    <div class="page" orientation="portrait" size="A4" pages="1" style="padding-top: 80px;">
        <div style="font-size:14px;font-family: math; font-weight: bold;">Supplier Due:</div>
        <table class="table-fw table-border">
            <thead>
                <tr>
                    <th class="text-center" style="width: 30px">SL.</th>
                    <th class="text-center" >Name</th>
                    <th class="text-center" style="width: 100px">Mobile</th>
                    <th class="text-center" style="width:80px;font-size:12px;font-weight: bold;font-family: math;">Balance</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                    $total = 0;
                @endphp

                @foreach ($suppliers as $supplier)
                    <tr>
                        <td style="font-size:12px;font-family: math; width: 30px">{{ $i }}</td>
                        <td style="font-size:12px;font-family: math;">{{ $supplier->name }}</td>
                        <td style="font-size:12px;font-family: math;">{{ $supplier->mobile_number }}</td>
                        <td style="font-size:12px;font-family: math;" class="text-end">{{ bd_money_format($supplier->due_amount) }}</td>
                    </tr>
                    @php
                        $i++;
                        $total += $supplier->due_amount;
                    @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3" style="font-size:12px;font-family: math; text-align: right;">Total Amount:</th>
                    <td style="font-size:12px;font-family: math;" class="text-end">{{ bd_money_format($total) }}</td>
                </tr>
            </tfoot>

        </table>
    </div>
</body>

</html>
