<x-admin-layout :title="__('Create Product')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a>
                                </li>
                                <li class="breadcrumb-item active">{{ __('Product') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <!-- App Search-->
                            <a href="{{ route('products.index') }}"
                                class="btn btn-outline-primary waves-effect waves-light">
                                <i class="fas fa-arrow-left align-middle me-2"></i> {{ __('Back') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Create Product') }}</h4>
                        </div>
                        <div class="card-body">
                            <form id="import-form" method="POST" action="{{ route('productsImport') }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3 row">
                                            <div class="col-md-3"></div>
                                            <div class="col-md-9">
                                                Click <a href="{{ asset('assets/product_upload.csv') }}">download</a> to
                                                download the sample file.
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            {{ Form::label('file', __('File'), ['class' => 'col-md-3 col-form-label text-end']) }}
                                            <div class="col-md-9">
                                                {{ Form::file('file', ['id' => 'file', 'class' => 'form-control' . ($errors->has('file') ? ' is-invalid' : ''), 'placeholder' => 'Product Nr']) }}
                                                {!! $errors->first('file', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="out">
                                            <table id="datatable"
                                                class="table table-bordered table-striped dt-responsive nowrap "
                                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead class="thead">
                                                    <tr>
                                                        <th>SL#</th>
                                                        <th>Product NR</th>
                                                        <th>Details</th>
                                                        <th>Weight</th>
                                                        <th>ST/DIA</th>
                                                        <th>ST/DIA Price</th>
                                                        <th>Wage</th>
                                                        <th>Wage Type</th>
                                                        <th>Supplier</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <div class="box-footer mt20 text-end">
                                            <button type="submit" class="btn btn-primary">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <x-datatable-js-css />
    @push('js')
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/d3@7.6.1/dist/d3.min.js"></script>
        <script>
            var dataSet = [];

            const fileInput = document.getElementById('file')
            const outElement = document.getElementById('out')

            var table = $('#datatable').DataTable({
                data: dataSet,
                bLengthChange: false,
                bInfo: false,
                bFilter: false,
                bPaginate: false,

                processing: true,
                ordering: false,

                paging: false,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 300,

                columns: [{
                        title: 'SL#'
                    },
                    {
                        title: 'Product NR'
                    },
                    {
                        title: 'Details'
                    },
                    {
                        title: 'Weight.'
                    },
                    {
                        title: 'ST/DIA'
                    },
                    {
                        title: 'ST/DIA Price'
                    },
                    {
                        title: 'Wage'
                    },
                    {
                        title: 'Wage Type'
                    },
                    {
                        title: 'supplier_id'
                    },
                    {
                        title: 'Action',
                        "data": "action",
                        defaultContent: "",
                        bSortable: false,
                        className: 'dt-body-right text-xs-align-left',
                        'render': function(data, type, row, meta) {
                            return '<button type="button" class="btn btn-danger btn-sm" onClick="window.deleteHandeler(' +
                                meta.row + ')">x</button>';
                        }
                    }
                ],
            });

            const previewCSVData = async dataurl => {
                const d = await d3.csv(dataurl)
                dataSet = [];
                var serial = 1;
                d.forEach(function(value, key) {
                    let st_dia_price = value['st_dia_price'] == "NULL" ? '' : value['st_dia_price'];
                    let st_dia = value['st_dia'] == "NULL" ? '' : value['st_dia'];
                    let purchase_price = value['purchase_price'] == "NULL" ? '' : value['purchase_price'];
                    let supplier_id = value['supplier_id'] == "NULL" ? null : value['supplier_id'];
                    let stock_type = value['stock_type'] == "NULL" ? null : value['stock_type'];
                    let type = value['type'] == "NULL" ? null : value['type'];
                    let carat = value['carat'] == "NULL" ? null : value['carat'];
                    
                    dataSet.push([
                        serial,
                        value['product_nr'],
                        value['product_details'],
                        value['weight'],
                        st_dia,
                        st_dia_price,
                        value['wage'],
                        value['wage_type'],
                        carat,
                        value['product_category_id'],
                        purchase_price,
                        value['status'],
                        supplier_id,
                        stock_type,
                        value['type'],
                    ]);


                    serial++;
                })
                table.clear();
                table.rows.add(dataSet).draw();
            }

            const readFile = e => {
                $("#out").removeClass('d-none');
                const file = fileInput.files[0]
                const reader = new FileReader()
                reader.onload = () => {
                    const dataUrl = reader.result;
                    previewCSVData(dataUrl)
                }
                reader.readAsDataURL(file)
            }

            fileInput.onchange = readFile

            $("#import-form").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                        url: "{{ route('productsImport') }}",
                        type: "POST",
                        data: {
                            products: JSON.stringify(dataSet),
                        }
                    }).done(function() {
                        Swal.fire("Imported!", "Your item has been imported.", "success")
                            .then(function(t) {
                                if (t.isConfirmed) {
                                    location.reload();
                                }
                            });
                    })
                    .fail(function(response) {
                        if (response.status === 419 || response.status === 422) {
                            Swal.fire("Cancelled!", response.responseJSON.message, "error")
                        } else {
                            console.log(response)
                            Swal.fire("Cancelled!", response.statusText, "error")
                        }
                    });

            });

            function deleteHandeler(elem) {
                Swal.fire({
                    title: '{{ __('Are you sure?') }}',
                    text: "{!! __("You won't be able to revert this!") !!}",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#1cbb8c",
                    cancelButtonColor: "#ff3d60",
                    confirmButtonText: '{{ __('Yes, delete it!') }}'
                }).then(function(t) {
                    if (t.isConfirmed) {
                        dataSet.splice(elem, 1);
                        table.clear();
                        console.log(elem, dataSet)
                        table.rows.add(dataSet).draw();
                    }
                });
            }
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
