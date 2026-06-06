<x-admin-layout :title="__('Role')">
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
                                <li class="breadcrumb-item active">{{ __('Role') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <a href="{{ route('roles.create') }}" class="btn btn-soft-success waves-effect waves-light">
                                {{ __('Add Role') }}
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
                            <h4 class="card-title ">{{ __('Role List') }}</h4>
                        </div>
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap"
                                style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead class="thead">
                                    <tr>
                                        <th>Role ID</th>
                                        <th>Role Name</th>
                                        <th>Guard</th>
                                        @if (\Auth::user()->hasRole('Super Admin'))
                                            <th>{{ __('Subscriber') }}</th>
                                        @endif
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
                ajax: "{{ route('roles.index') }}",
                order: [
                    [1, "asc"]
                ],
                columns: [{
                        "data": "no",
                        bSortable: false
                    },
                    {
                        "data": "name"
                    },
                    {
                        "data": "guard_name"
                    },
                    @if (\Auth::user()->hasRole('Super Admin'))
                        {
                            "data": "branch_id"
                        },
                    @endif {
                        "data": "is_active",
                        'render': function(data, type, row, meta) {
                            if (row.is_active) {
                                return '<span class="badge bg-success">Active</span>';
                            }
                            return '<span class="badge bg-danger">Inactive</span>';
                        }
                    },
                    @can('Edit Role')
                        {
                            "data": "action",
                            defaultContent: "",
                            bSortable: false,
                            className: 'dt-body-right text-xs-align-left',
                            'render': function(data, type, row, meta) {
                                var html = '';

                                if (row.is_delete_able) {
                                    html +=
                                        '<a class="btn btn-sm btn-warning " href="{{ route('roles.index') }}/' +
                                        row.id + '"><i class="fa fa-fw fa-key"></i></a> ';
                                    html +=
                                        '<a class="btn btn-sm btn-success" href="{{ route('roles.index') }}/' +
                                        row.id +
                                        '/edit"><i class="fa fa-fw fa-edit"></i></a> <button type="button" data-route="{{ route('roles.index') }}/' +
                                        row.id +
                                        '" class="btn btn-danger btn-sm" onClick="window.onClickDeleteHandeler(this)"><i class="fa fa-fw fa-trash"></i></button>';
                                }
                                return html;
                            }
                        },
                    @endcan
                ],
            });
        </script>
    @endpush
</x-admin-layout>
