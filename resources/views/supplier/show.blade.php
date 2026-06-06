<x-admin-layout :title="__($supplier->name ?? 'Show Supplier')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <div class="mb-3 mb-md-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active"><a
                                        href="{{ route('suppliers.index') }}">{{ __('Supplier') }}</a></li>
                                <li class="breadcrumb-item active">{{ $supplier->name ?? 'Show Supplier' }}</li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ url()->previous() }}"
                                class="d-none d-sm-inline-block btn btn-outline-primary waves-effect waves-light mb-2 mb-md-0">
                                <i class="fas fa-arrow-left align-middle me-2"></i> {{ __('Back') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="float-left">
                                <span class="card-title">Supplier Transactions</span>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <span>Name:</span>
                                <div>
                                    {{ $supplier->name }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Mobile Number:</span>
                                <div>
                                    {{ $supplier->mobile_number }}
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Due Amount:</span>
                                <div> 
                                    <strong>
                                    {{ bd_money_format($supplier->due_amount) }}
                                    </strong>
                                </div>
                            </div>
                        </div>
                        <table id="datatable" class="table table-bordered dt-responsive nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead class="thead">
                                <tr>
                                    <th>SL:</th>
                                    <th>Date</th>
                                    <th>Ref.</th>
                                    <th>Description</th>
                                    <th>Bill</th>
                                    <th>Pay</th>
                                    @canany(['Edit Supplier Transaction', 'Delete Supplier Transaction'])
                                        <th>Action</th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-datatable-js-css />
    @push('js')
        <script>
            function buildSearchData(object) {
                if (object.start > 0) {
                    object.page = (object.start / object.length) + 1;
                }

                object.supplier_id = {{ $supplier->id }};

                return object;
            }
            var table = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                searching: false, // Disable search bar
                lengthChange: false,
                ajax: {
                    url: "{{ route('supplier_transactions.index') }}",
                    data: buildSearchData
                },
                order: [
                    [1, "asc"]
                ],
                columns: [{
                        "data": "no",
                        bSortable: false
                    },
                    {
                        "data": "date"
                    },
                    {
                        "data": "reference_no"
                    },
                    {
                        "data": "description"
                    },
                    {
                        "data": "bill_amount"
                    },
                    {
                        "data": "payment_amount"
                    },
                    @canany(['Edit Supplier Transaction', 'Delete Supplier Transaction'])
                        {
                            data: 'no',
                            class: 'text-center',
                            render: function(data, type, row, meta) {
                                var html = "";
                                @can('Edit Due Transaction')
                                    html += " <a href='{{ route('supplier_transactions.index') }}/" + row.id +
                                        "/edit' class='btn-sm'><i class='fa fa-pen'></i></a>";
                                @endcan
                                @can('Delete Due Transaction')
                                    html +=
                                        `<span role="button" data-route="{{ route('supplier_transactions.index') }}/` +
                                        row.id +
                                        `" class="text-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i class="fa fa-fw fa-trash"></i></span>`;
                                @endcan
                                return html;
                            }
                        }
                    @endcanany
                ],
            });
        </script>
    @endpush
</x-admin-layout>
