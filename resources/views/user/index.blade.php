<x-admin-layout :title="__('User')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <div class="mb-sm-0">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);"><i class="fas fa-home"></i></a></li>
                                <li class="breadcrumb-item active">{{__('User')}}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                           <a href="{{ route('users.create') }}" class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Add User') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">

                            <h4 class="card-title">{{__('User List')}}</h4>


                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        @hasanyrole('Super Admin')
                                        <th>Branch</th>
                                        @endhasanyrole
                                        <th>Created</th>
                                        <th>Status</th>
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
    @push('vendor_css')
        <!-- DataTables -->
        <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
    @endpush
    @push('js')
        <!-- Required datatable js -->
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <!-- Buttons examples -->
        <script src="{{ asset('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
        <script>
            var table = $('#datatable').DataTable( {
                "processing": true,
                "serverSide": true,
                ajax: "{{ route('users.dataTable') }}",
                order: [[ 1, "asc" ]],
                columns: [
                    { "data": "no", bSortable: false},
                    { "data": "name"},
                    { "data": "username"},
                    @hasanyrole('Super Admin')
                        { "data": "branch_id"},
                    @endhasanyrole
                    { "data": "created_at"},
                    { "data": "is_active"},
                    { "data": "action", defaultContent: "", className: 'dt-body-right' },
                ],
                columnDefs: [ {
                    targets : -1,
                    createdCell: function(td, cellData, rowData, row, col) {
                        $(td).html(
                            '<a class="btn btn-sm btn-primary " \
                                href="{{ route('users.index') }}/'+rowData.id+'"><i \
                                        class="fa fa-fw fa-eye"></i></a> \
                            @can('Edit User')<a class="btn btn-sm btn-success" \
                                href="{{ route('users.index') }}/'+rowData.id+'/edit"><i \
                                        class="fa fa-fw fa-edit"></i></a>@endcan \
                             @can('Edit User')<button type="button" data-route="{{ route('users.index') }}/'+rowData.id+'" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i \
                                    class="fa fa-fw fa-trash"></i> \
                            </button>@endcan'
                        );
                    }
                } ],
                
            } );
        </script>
    @endpush
</x-admin-layout>
