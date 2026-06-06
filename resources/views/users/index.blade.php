<x-admin-layout :title="__('Users')">
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
                                <li class="breadcrumb-item active">{{ __('User') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            @can('Create User')
                                <a href="{{ route('users.create') }}" class="btn btn-soft-success waves-effect waves-light">
                                    {{ __('Add User') }}
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
                        <div class="card-body px-0">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Username</th>
                                        <th>Role</th>
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
    <x-datatable-js-css />

    @push('js')
        <script>
            var table = $('#datatable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.index') }}",
                    data: buildSearchData
                },
                columns: [{
                        "data": "no"
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "username"
                    },
                    {
                        "data": "role"
                    },
                    {
                        "data": "created_at"
                    },
                    {
                        "data": "status",
                        defaultContent: "",
                        render: function(data, type, row, meta) {
                            if (!row.status) {
                                return '<span class="badge bg-danger">Inactive</span>';
                            } else {
                                return '<span class="badge bg-success">Active</span>';
                            }
                        }
                    },
                    {
                        "data": "action",
                        defaultContent: "",
                        bSortable: false,
                        className: 'dt-body-right text-xs-align-left',
                        'render': function(data, type, row, meta) {
                            var html = '';
                            @can('Edit Users')
                                html += ' <a class="btn btn-sm btn-success" href="{{ route('users.index') }}/' +
                                    row
                                    .id + '/edit"><i class="fa fa-fw fa-edit"></i></a>';
                            @endcan
                            @can('Delete Users')
                                html += ' <button type="button" data-route="{{ route('users.index') }}/' + row
                                    .id +
                                    '" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i class="fa fa-fw fa-trash"></i></button>';
                            @endcan
                            return html;
                        }
                    },
                ],
            });
            $(table.table().container()).children().eq(0).addClass('px-2');
            $(table.table().container()).children().eq(2).addClass('px-2');
        </script>
    @endpush
</x-admin-layout>
