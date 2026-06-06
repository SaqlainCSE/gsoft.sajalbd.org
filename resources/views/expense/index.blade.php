<x-admin-layout :title="__('Expense')">
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
                                <li class="breadcrumb-item active">{{ __('Expense') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <a href="{{ route('expenses.create') }}"
                                class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Add Expense') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Expense List') }}</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead">
                                    <tr>
                                        <th>SL</th>
                                        <th>Date</th>
                                        <th>Head</th>
                                        <th>Payment Method</th>
                                        <th>Reference</th>
                                        <th>Expense By</th>
                                        <th>Amount</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
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
        <script>
            function buildSearchData(object) {
                if (object.start > 0) {
                    object.page = (object.start / object.length) + 1;
                }
                return object;
            }


            var table = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,

                ajax: {
                    url: "{{ route('expenses.index') }}",
                    data: buildSearchData
                },
                order: [
                    [1, "asc"]
                ],
                columns: [{
                        "data": "id",
                        bSortable: false
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "trx_head"
                    },
                    {
                        "data": "payment_method"
                    },
                    {
                        "data": "reference_no"
                    },
                    {
                        "data": "expense_by"
                    },
                    {
                        "data": "amount",
                        className: 'text-end',
                    },
                    {
                        "data": "action",
                        defaultContent: "",
                        bSortable: false,
                        className: 'dt-body-right text-xs-align-left',
                        'render': function(data, type, row, meta) {
                            let action = '';
                            action += '<a class="btn btn-sm btn-success" href="{{ route('expenses.index') }}/' +
                                row.id + '"><i class="fa fa-fw fa-eye"></i></a> ';

                            @can('Edit Expense')
                                action +=
                                    '<a class="btn btn-sm btn-primary" href="{{ route('expenses.index') }}/' +
                                    row.id + '/edit"><i class="fa fa-fw fa-edit"></i></a> ';
                            @endcan
                            @can('Delete Expense')
                                action += '<button type="button" data-route="{{ route('expenses.index') }}/' +
                                    row.id +
                                    '" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i class="fa fa-fw fa-trash"></i></button>';
                            @endcan
                            return action;
                        }
                    },

                ],
            });
        </script>
    @endpush
</x-admin-layout>
