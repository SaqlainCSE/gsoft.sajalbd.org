<x-admin-layout :title="__('Booking')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Booking') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            @can('Add Booking')
                                <a href="{{ route('booking.create') }}" class="btn btn-soft-success waves-effect waves-light">
                                    {{ __('Add Booking') }}
                                </a>
                            @endcan
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Booking List') }}</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="stripe row-border order-column table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SL#</th>
                                        <th>BK No</th>
                                        <th>Date</th>
                                        <th>Client No</th>
                                        <th>Client Name</th>
                                        <th>Item Total</th>
                                        <th>VAT</th>
                                        <th>Subtotal</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                        <th>Paid</th>
                                        <th>Due</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <x-datatable-js-css />
    @push('js')
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

        <script>
            var table = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                'ordering': false,
                fixedColumns: {
                    left: 2,
                    right: 1
                },
                paging: true,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 300,
                ajax:{ 
                    url: "{{ route('booking.index') }}",
                    data: buildSearchData
                },
                order: [
                    [1, "asc"]
                ],
                columns: [{
                        "data": "no"
                    },
                    {
                        "data": "booking_id"
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "client_no"
                    },
                    {
                        "data": "client"
                    },
                    {
                        "data": "itemTotal"
                    },
                    {
                        "data": "vat"
                    },
                    {
                        "data": "subtotal"
                    },
                    {
                        "data": "discount"
                    },
                    {
                        "data": "total"
                    },
                    {
                        "data": "paid"
                    },
                    {
                        "data": "due"
                    },
                    {
                        data: 'no',
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            var html = "<a class='btn-info btn-sm' target='_blank' href='{{ route('booking.index') }}/" + row.id + "/print'><i class='fa fa-print'></i></a>";
                            @can('Edit Booking')
                                html += " <a class='btn-warning btn-sm' href='{{ route('booking.index') }}/" + row.id + "/edit'><i class='fa fa-pen'></i></a>";
                            @endcan
                            @can('Delete Booking')
                                html += ' <a href="javascript:void()" data-route="{{ route('booking.index') }}/' + row
                                    .id +
                                    '" class="btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i class="fa fa-fw fa-trash"></i></a>';
                            @endcan

                            return html;
                        }
                    }
                ],
            });
        </script>
    @endpush
    @push('css')
        <link href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css" rel="stylesheet"
            type="text/css" />
        <style>
            th,
            td {
                white-space: nowrap;
            }

            div.dataTables_wrapper {
                width: 100%;
                margin: 0 auto;
            }

            table.dataTable tbody tr>.dtfc-fixed-left,
            table.dataTable tbody tr>.dtfc-fixed-right {
                z-index: 1;
                background-color: #f9f9f9;
            }
        </style>
    @endpush
</x-admin-layout>
