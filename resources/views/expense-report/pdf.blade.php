<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <style>
        body {
            width: 100%;
            margin: 0;
            font-size: 12px;
            padding-top: 100px;
        }

        .header,
        .header-space,
        .footer,
        .footer-space {
            height: 100px;
        }

        .header {
            position: fixed;
            top: 0;
        }

        .footer {
            position: fixed;
            bottom: 0;
        }

        table {
            width: 100%;

        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        thead td {
            background: #ddd;
            font-weight: 900;
            text-align: center;
        }

        @page {
            header: page-header;
            footer: page-footer;
        }

        table.footer-table,
        .footer-table th,
        .footer-table td,
        {
        border: none;
        border-collapse: collapse;
        }
    </style>
</head>

<body>
    <htmlpageheader name="page-header">
        <div style="display: inline-block; width: 100%; height: 60px; padding-top: 10px">
            <div style="display:inline-block; float: left; width: 50%">
                <div class="td" style="display: table-cell;vertical-align: bottom;height: 50px;">
                    {{ __('Report') }} : {{ __('Expense Report') }}
                    <br/>
                    {{ __('Date') }} :  {{ $start_date }} - {{ $end_date }}

                    @if (request('client_type') === 'macr')
                        <br />{{ __('MAC') }} : {{ $macr->name }}
                    @endif
                </div>
            </div>
        </div>
    </htmlpageheader>
    @include('expense-report.excel')
    <htmlpagefooter name="page-footer">
        <table class="footer-table" cellspacing="0" cellpadding="0">
            <tr>
                <td>Date: {{ Carbon\Carbon::parse()->format('d-m-Y') }}</td>
                <td style="text-align:right">idesk.deslogy.com</td>
            </tr>
        </table>
    </htmlpagefooter>
</body>

</html>
