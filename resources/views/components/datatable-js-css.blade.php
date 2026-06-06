@push('vendor_css')
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />
    {{-- <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" /> --}}
    <link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet"
        type="text/css" />
    <style>
        table.table-bordered.dataTable tbody th,
        table.table-bordered.dataTable tbody td {
            white-space: inherit;
        }

        .table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
        table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before {
            top: 44%;
            background-color: #31b131;
        }

        table.dataTable>tbody>tr.child ul.dtr-details {
            width: 100%;
        }

        table.dataTable>tbody>tr.child ul.dtr-details>li {
            display: flex;
        }

        table.dataTable>tbody>tr.child span.dtr-title {
            margin-right: 20px;
        }

        li.dt-body-right {
            text-align: left;
        }

        table.dataTable>tbody>tr.child ul.dtr-details>li {
            justify-content: space-between;
        }
        th, td { white-space: nowrap; }
    </style>
@endpush
@push('vendorjs')
    <!-- Required datatable js -->
    <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js') }}"></script> --}}
    <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
@endpush
