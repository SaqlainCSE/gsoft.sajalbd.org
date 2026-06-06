<x-admin-layout :title="__('Product')">
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
                                <li class="breadcrumb-item active">{{ __('Product') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            @can('Create Product')
                                <a href="{{ route('productsImport') }}"
                                    class="btn btn-soft-success waves-effect waves-light">
                                    {{ __('Import') }}
                                </a>
                                <a href="{{ route('products.create') }}"
                                    class="btn btn-soft-success waves-effect waves-light">
                                    {{ __('Add Product') }}
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
                            <h4 class="card-title ">{{ __('Product List') }}</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered"
                                style="border-collapse: collapse; border-spacing: 0;">
                                <thead class="thead">
                                    <tr>
                                        <th>SL#</th>
                                        <th>Product NR</th>
                                        <th>Details</th>
                                        <th>Category</th>
                                        <th>Weight</th>
                                        <th>ST/DIA</th>
                                        <th>ST/DIA Price</th>
                                        <th>Wage</th>
                                        <th>Status</th>
                                        <th>Supplier
                                            </th>
                                        <th>Purchase
                                            </th>
                                        <th>QTY
                                            </th>
                                        <th>Stock Type</th>
                                        <th>Purchase Date</th>
                                        <th style="width: 75px">Action</th>
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
                @if (request()->has('trash'))
                    object.trash = 1;
                @endif
                return object;
            }
            var table = $('#datatable').DataTable({
                "processing": true,
                "serverSide": true,
                'ordering': false,
                "scrollX": true, // Enable horizontal scrolling
            "scrollCollapse": true,
                ajax:{
                    url: "{{ route('products.index') }}",
                    data: buildSearchData
                },
                order: [
                    [1, "asc"]
                ],
                columns: [
                    {"data": "no"},
                    {"data": "product_nr"},
                    {"data": "product_details"},
                    {"data": "category"},
                    {"data": "weight"},
                    {"data": "st_dia"},
                    {"data": "st_dia_price"},
                    {"data": "wage"},
                    {"data": "status"},
                    {"data": "supplier"},
                    {"data": "purchase_price"},
                    {"data": "qty"},
                    {"data": "stock_type"},
                    {"data": "purchase_date"},
                    @can('Edit Product')
                        {
                            "data": "action",
                            defaultContent: "",
                            bSortable: false,
                            className: 'dt-body-right text-xs-align-left',
                            'render': function(data, type, row, meta) {
                                return '@can('Edit Product')<a class="btn btn-sm btn-success" \
                                            href="{{ route('products.index') }}/' + row.id + '/edit"><i \
                                                    class="fa fa-fw fa-edit"></i></a>@endcan \
                                        @can('Delete Product')<button type="button" data-route="{{ route('products.index') }}/' + row.id + '" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i \
                                                class="fa fa-fw fa-trash"></i> \
                                        </button>@endcan';
                            }
                        },
                    @endcan
                ],
            });
        </script>
    @endpush
</x-admin-layout>
