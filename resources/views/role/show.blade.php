<x-admin-layout :title="__($role->name ? ltrim($role->name, auth()->user()->branch_id . '_') : 'Show Role')">
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
                                        href="{{ route('roles.index') }}">{{ __('Role') }}</a></li>
                                <li class="breadcrumb-item active">
                                    {{ $role->name ? ltrim($role->name, auth()->user()->branch_id . '_') : 'Show Role' }}
                                </li>
                            </ol>
                        </div>
                        <div class="page-title-right text-right">
                            <a href="{{ route('roles.index') }}"
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
                                <span class="card-title">Role</span>
                            </div>
                        </div>

                        <div class="card-body">

                            <form method="POST" action="{{ route('role.permission', $role->uuid) }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">{{ __('SL#') }}</th>
                                            <th>{{ __('Module') }}</th>
                                            <th>{{ __('Guard Name') }}</th>
                                            <th>{{ __('Permission') }}</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($modules as $module)
                                            <tr>
                                                <td>{{ $loop->index + 1 }}</td>
                                                <td>{{ $module->name }}</td>
                                                <td>web</td>
                                                <td>
                                                    @foreach ($module->permissions->where('guard_name', 'web') as $permission)
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                name="permission[{{ $module->id }}][]"
                                                                value="{{ $permission->id }}"
                                                                id="check{{ $permission->id }}"
                                                                @if ($role->hasPermissionTo($permission->name)) checked="" @endif>
                                                            <label class="form-check-label"
                                                                for="check{{ $permission->id }}">
                                                                {{ $permission->name }}
                                                            </label>
                                                        </div>
                                                    @endforeach
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-datatable-js-css />
    @push('js')
        <script>
            var table = $('#datatable').DataTable({
                paging: false,
                ordering: false,
                info: false,
                searching: false,
            });
        </script>
    @endpush
</x-admin-layout>
