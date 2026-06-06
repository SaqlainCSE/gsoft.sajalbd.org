<x-admin-layout :title="__('Client')">
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
                                <li class="breadcrumb-item active">{{ __('Client') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <a href="{{ route('customerExport') }}"
                                class="btn btn-soft-secondary waves-effect waves-light">
                                {{ __('Export') }}
                            </a>
                            <a href="{{ route('customersImport') }}"
                                class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Import') }}
                            </a>
                            <a href="{{ route('clients.create') }}"
                                class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Add Client') }}
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
                            <h4 class="card-title ">{{ __('Client List') }}</h4>
                        </div>
                        <div class="card-body">
                        <table id="datatable" class="stripe row-border order-column table"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th>SL#</th>
                                        <th>Photo</th>
                                        <th>Client No</th>
                                        <th>Name</th>
                                        <th>FB Name</th>
                                        <th>Phone</th>
                                        <th>Category</th>
                                        <th>Address</th>
                                        <th>District</th>
                                        <th>Zone</th>
                                        <th>Created At</th>
                                        <th style="width: 75px;">Action</th>
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
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01" style="max-height: 90%;">
    </div>
    <x-datatable-js-css />
    @push('js')
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

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
                fixedColumns: {
                    left: 2,
                    right: 1
                },
                paging: true,
                scrollCollapse: true,
                scrollX: true,
                scrollY: 300,
                ajax:{ 
                    url: "{{ route('clients.index') }}",
                    data: buildSearchData
                },
                order: [
                    [1, "asc"]
                ],
                columns: [{
                        "data": "no"
                    },
                    {
                        "data": "photo",
                        render: function(data, type, row, meta) {
                            return "<img src='" + row.photo + "' width=30 height=30 onclick=showImage('"+row.photo+"')>";
                        }
                    },
                    {
                        "data": "client_no"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "fb_name"
                    },
                    {
                        "data": "mobile_number"
                    },
                    {
                        "data": "category"
                    },
                    {
                        "data": "address"
                    },
                    {
                        "data": "district"
                    },
                    {
                        "data": "zone"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        data: 'no',
                        class: 'text-center',
                        render: function(data, type, row, meta) {
                            var html = "";
                            @can('Edit Client')
                                html += " <a class='btn-warning btn-sm' href='{{ route('clients.index') }}/" + row.id + "/edit'><i class='fa fa-pen'></i></a>";
                            @endcan
                            @can('Delete Client')
                                html += ' <a href="javascript:void()" data-route="{{ route('clients.index') }}/' + row
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
    {{-- <x-datatable-js-css />
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

            /* The Modal (background) */
            .modal {
                display: none;
                /* Hidden by default */
                position: fixed;
                /* Stay in place */
                z-index: 9999;
                /* Sit on top */
                padding-top: 100px;
                /* Location of the box */
                left: 0;
                top: 0;
                width: 100%;
                /* Full width */
                height: 100%;
                /* Full height */
                overflow: auto;
                /* Enable scroll if needed */
                background-color: rgb(0, 0, 0);
                /* Fallback color */
                background-color: rgba(0, 0, 0, 0.6);
                /* Black w/ opacity */
            }

            /* Modal Content (image) */
            .modal-content {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
            }

            /* Caption of Modal Image */
            #caption {
                margin: auto;
                display: block;
                width: 80%;
                max-width: 700px;
                text-align: center;
                color: #ccc;
                padding: 10px 0;
                height: 150px;
            }

            /* Add Animation */
            .modal-content,
            #caption {
                -webkit-animation-name: zoom;
                -webkit-animation-duration: 0.6s;
                animation-name: zoom;
                animation-duration: 0.6s;
            }

            @-webkit-keyframes zoom {
                from {
                    -webkit-transform: scale(0)
                }

                to {
                    -webkit-transform: scale(1)
                }
            }

            @keyframes zoom {
                from {
                    transform: scale(0)
                }

                to {
                    transform: scale(1)
                }
            }

            /* The Close Button */
            .close {
                position: absolute;
                top: 15px;
                right: 35px;
                color: #f1f1f1;
                font-size: 40px;
                font-weight: bold;
                transition: 0.3s;
            }

            .close:hover,
            .close:focus {
                color: #bbb;
                text-decoration: none;
                cursor: pointer;
            }

            /* 100% Image Width on Smaller Screens */
            @media only screen and (max-width: 700px) {
                .modal-content {
                    width: 100%;
                }
            }
        </style>
    @endpush
    @push('js')
        <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
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
                ajax: {
                    url: "{{ route('clients.index') }}",
                    data: buildSearchData
                },
                scrollX: true,
                scrollY: 300,
                fixedColumns: {
                    left: 2,
                    right: 1
                },
                order: [
                    [1, "asc"]
                ],
                columns: [{
                        "data": "no"
                    },
                    {
                        "data": "photo",
                        render: function(data, type, row, meta) {
                            return "<img src='" + row.photo + "' width=30 height=30 onclick=showImage('"+row.photo+"')>";
                        }
                    },
                    {
                        "data": "client_no"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "fb_name"
                    },
                    {
                        "data": "mobile_number"
                    },
                    {
                        "data": "category"
                    },
                    {
                        "data": "address"
                    },
                    {
                        "data": "district"
                    },
                    {
                        "data": "zone"
                    },
                    {
                        "data": "created_at"
                    },
                    @can('Edit Client')
                        {
                            "data": "action",
                            defaultContent: "",
                            bSortable: false,
                            className: 'dt-body-right text-xs-align-left',
                            'render': function(data, type, row, meta) {
                                return '@can('Edit Client')<a class="btn btn-sm btn-success" \
                                                            href="{{ route('clients.index') }}/' + row.id +
                                    '/edit"><i \
                                                                    class="fa fa-fw fa-edit"></i></a>@endcan \
                                                        @can('Delete Client')<button type="button" data-route="{{ route('clients.index') }}/' +
                                    row.id + '" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i \
                                                                class="fa fa-fw fa-trash"></i> \
                                                        </button>@endcan';
                            }
                        },
                    @endcan
                ],
            });

            // Get the modal
            var modal = document.getElementById("myModal");

            // Get the image and insert it inside the modal - use its "alt" text as a caption
            var img = document.getElementById("myImg");
            var modalImg = document.getElementById("img01");
            var captionText = document.getElementById("caption");

            function showImage(src){
                modal.style.display = "block";
                modalImg.src = src;
            }

            // Get the <span> element that closes the modal
            var span = document.getElementsByClassName("close")[0];

            // When the user clicks on <span> (x), close the modal
            span.onclick = function() {
                modal.style.display = "none";
            }
        </script>
    @endpush --}}
</x-admin-layout>
