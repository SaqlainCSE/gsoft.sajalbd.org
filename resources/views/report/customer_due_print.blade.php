<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <link rel="stylesheet" href="{{ asset('assets/css/print.css') }}" />
    <style>
        @page {
            .bl-0 td.text-end {
                border-left: none;
            }

            ul {
                padding: 0;
                margin: 0;
            }


            thead>tr>th {
                font-weight: bold;
            }

            tr>th,
            tr>td {
                font-size: 12px;
                font-family: math;
            }
        }
    </style>
</head>



<body onload="window.print()" onafterprint="window.close()">
    <div class="page" orientation="portrait" size="A4" pages="1" style="padding-top: 80px;">
        <table class="table-fw table-border">
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
                        <td style="width: 100px">{{ $client->mobile_number }}</td>
                        <td style="width: 100px" class="text-end">{{ bd_money_format($client->due_amount) }}</td>
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
                    <th style="text-align: left;">{{ bd_money_format($total) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
