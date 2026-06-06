<x-admin-layout :title="__('Update Role')">
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
                                <li class="breadcrumb-item active">{{ __('Role') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <!-- App Search-->
                            <a href="{{ route('roles.index') }}"
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
                            <h4 class="card-title ">{{ __('Update  Role') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('roles.update', $role->uuid) }}" role="form"
                                enctype="multipart/form-data">
                                {{ method_field('PATCH') }}
                                @csrf

                                @include('role.form')

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
</x-admin-layout>
