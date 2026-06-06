<x-admin-layout :title="__('Admin Dashboard')">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">{{ __('Dashboard') }}</h4>
                    </div>
                </div>
            </div>
            
            <x-admin-dashboard-summary-cards />

            <div class="row">
                @canany(['Access Admin Dashboard', 'Create Bank'])
                    <div class="col-xl-8">
                        <x-finance-overview />
                        <!-- end card -->
                    </div>

                    <div class="col-xl-4">
                        <x-macr-overview />
                    </div>
                @endcanany
            </div>
            <!-- end row -->

            <div class="row">
                <div class="col-xl-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order Stats</h5>
                            <div>
                                <ul class="list-unstyled">
                                    <li class="py-3">
                                        <div class="d-flex">
                                            <div class="avatar-xs align-self-center me-3">
                                                <div
                                                    class="avatar-title rounded-circle bg-light text-primary font-size-18">
                                                    <i class="ri-checkbox-circle-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-2">Completed</p>
                                                <div class="progress progress-sm animated-progess">
                                                    <div class="progress-bar bg-success" role="progressbar"
                                                        style="width: 70%" aria-valuenow="70" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="py-3">
                                        <div class="d-flex">
                                            <div class="avatar-xs align-self-center me-3">
                                                <div
                                                    class="avatar-title rounded-circle bg-light text-primary font-size-18">
                                                    <i class="ri-calendar-2-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-2">Pending</p>
                                                <div class="progress progress-sm animated-progess">
                                                    <div class="progress-bar bg-warning" role="progressbar"
                                                        style="width: 45%" aria-valuenow="45" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="py-3">
                                        <div class="d-flex">
                                            <div class="avatar-xs align-self-center me-3">
                                                <div
                                                    class="avatar-title rounded-circle bg-light text-primary font-size-18">
                                                    <i class="ri-close-circle-line"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1">
                                                <p class="text-muted mb-2">Cancel</p>
                                                <div class="progress progress-sm animated-progess">
                                                    <div class="progress-bar bg-danger" role="progressbar"
                                                        style="width: 19%" aria-valuenow="19" aria-valuemin="0"
                                                        aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <hr>

                            <div class="text-center">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mt-2">
                                            <p class="text-muted mb-2">Completed</p>
                                            <h5 class="font-size-16 mb-0">70</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-2">
                                            <p class="text-muted mb-2">Pending</p>
                                            <h5 class="font-size-16 mb-0">45</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mt-2">
                                            <p class="text-muted mb-2">Cancel</p>
                                            <h5 class="font-size-16 mb-0">19</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Notifications</h4>

                            <div class="pe-3" data-simplebar style="max-height: 287px;">
                                <a href="#" class="text-body d-block">
                                    <div class="d-flex py-3">
                                        <div class="flex-shrink-0 me-3 align-self-center">
                                            <img class="rounded-circle avatar-xs" alt=""
                                                src="assets/images/users/avatar-2.jpg">
                                        </div>

                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-14 mb-1">Scott Elliott</h5>
                                            <p class="text-truncate mb-0">
                                                If several languages coalesce
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 font-size-13">
                                            20 min ago
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="text-body d-block">
                                    <div class="d-flex py-3">
                                        <div class="flex-shrink-0 me-3 align-self-center">
                                            <div class="avatar-xs">
                                                <span class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                    <i class="mdi mdi-account-supervisor"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-14 mb-1">Team A</h5>
                                            <p class="text-truncate mb-0">
                                                Team A Meeting 9:15 AM
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 font-size-13">
                                            9:00 am
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="text-body d-block">
                                    <div class="d-flex py-3">
                                        <div class="flex-shrink-0 me-3 align-self-center">
                                            <img class="rounded-circle avatar-xs" alt=""
                                                src="assets/images/users/avatar-3.jpg">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-14 mb-1">Frank Martin</h5>
                                            <p class="text-truncate mb-0">
                                                Neque porro quisquam est
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 font-size-13">
                                            8:54 am
                                        </div>
                                    </div>
                                </a>
                                <a href="#" class="text-body d-block">
                                    <div class="d-flex py-3">
                                        <div class="flex-shrink-0 me-3 align-self-center">
                                            <div class="avatar-xs">
                                                <span class="avatar-title bg-soft-primary rounded-circle text-primary">
                                                    <i class="mdi mdi-email-outline"></i>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-14 mb-1">Updates</h5>
                                            <p class="text-truncate mb-0">
                                                It will be as simple as fact
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 font-size-13">
                                            27-03-2020
                                        </div>
                                    </div>
                                </a>

                                <a href="#" class="text-body d-block">
                                    <div class="d-flex py-3">
                                        <div class="flex-shrink-0 me-3 align-self-center">
                                            <img class="rounded-circle avatar-xs" alt=""
                                                src="assets/images/users/avatar-4.jpg">
                                        </div>
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="font-size-14 mb-1">Terry Garrick</h5>
                                            <p class="text-truncate mb-0">
                                                At vero eos et accusamus et
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0 font-size-13">
                                            27-03-2020
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->

                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title mb-3">Revenue by Location</h5>

                            <div>
                                <div id="usa" style="height: 226px"></div>
                            </div>

                            <div class="text-center mt-4">
                                <a href="#" class="btn btn-primary btn-sm">View More</a>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
            @canany(['Access Admin Dashboard', 'Create Bank'])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-4">Latest Transaction</h4>

                            <div class="table-responsive">
                                <table id="datatable" class="table table-centered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead class="thead">
                                        <tr>
                                            <th scope="col" style="width: 30px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input"
                                                        id="customCheckall">
                                                    <label class="form-check-label" for="customCheckall"></label>
                                                </div>
                                            </th>
                                            <th scope="col" style="width: 50px;"></th>
                                            <th>TRX ID</th>
                                            <th>Date</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <!-- end card-body -->
                    </div>
                    <!-- end card -->
                </div>
                <!-- end col -->
            </div>
            @endcanany
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <x-datatable-js-css />
    @push('css')
        <style>
            .table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
            table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before {
                margin-top: -19px;
            }
        </style>
    @endpush
    @push('js')
        <script>
            function buildSearchData(object) {
                if (object.start > 0) {
                    object.page = (object.start / object.length) + 1;
                }
                object.length = 10;
                return object;
            }
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                paging: false,
                ordering: false,
                info: false,
                searching: false,
                ajax: {
                    url: "{{ route('transactions.index') }}",
                    data: buildSearchData
                },
                order: [],
                columns: [{
                        "data": "no",
                        bSortable: false,
                        'render': function(data, type, row, meta) {
                            return '<div class="form-check"><input type="checkbox" class="form-check-input" value="' +
                                row.id + '" id="' + row.id + '"><label class="form-check-label" for="' + row
                                .id + '">' + row.no + '</label>';
                        }
                    },
                    {
                        "data": "no",
                        bSortable: false,
                        'render': function(data, type, row, meta) {
                            var bankName = "";
                            if (row.bank_id) {
                                bankName = row.bank_id.substring(0, 1);
                            }
                            return '<div class="avatar-xs"><span class="avatar-title rounded-circle bg-soft-primary ' +
                                row.bank_id + ' text-success">' + bankName + '</span></div>';
                        }
                    },
                    {
                        "data": "transaction_number",
                        'render': function(data, type, row, meta) {
                            return '<p class="mb-1 font-size-12 text-uppercase">' + row.bank_id +
                                '</p><h5 class="font-size-15 mb-0 text-uppercase">#' + row.transaction_number +
                                '</h5>';
                        }
                    },
                    {
                        "data": "created_at",
                        'render': function(data, type, row, meta) {
                            return '<p class="mb-1 font-size-12">' + row.created_at_time +
                                '</p><h5 class="font-size-15 mb-0 text-uppercase">' + row.created_at + '</h5>';
                        }
                    },
                    {
                        "data": "type",
                        className: 'text-uppercase'
                    },
                    {
                        "data": "amount"
                    },
                    {
                        "data": "status",
                        className: 'text-uppercase',
                        'render': function(data, type, row, meta) {
                            if (row.status === parseInt(
                                    "{{ \App\Models\Transaction::TRANSCTION_STATUS_CONFIRM }}")) {
                                return '<i class="mdi mdi-checkbox-blank-circle text-success me-1"></i> Confirm';
                            } else if (row.status === parseInt(
                                    "{{ \App\Models\Transaction::TRANSCTION_STATUS_CANCEL }}")) {
                                return '<i class="mdi mdi-checkbox-blank-circle text-danger me-1"></i> Cancel';
                            }
                            return '<i class="mdi mdi-checkbox-blank-circle text-warning me-1"></i> Pending';
                        }
                    },
                    @can('Edit Transaction')
                        {
                            "data": "action",
                            defaultContent: "",
                            bSortable: false,
                            className: 'dt-body-right text-xs-align-left',
                            'render': function(data, type, row, meta) {
                                return '<button class="btn btn-sm btn-outline-info" onClick="window.onClickShowHandeler(this)" data-route="{{ route('transactions.index') }}/' +
                                    row.id + '">More</button>';
                            }
                        },
                    @endcan
                ],
            });
        </script>
    @endpush

</x-admin-layout>
