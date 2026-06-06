<x-admin-layout :title="__('Create Customer')">
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
                                <li class="breadcrumb-item active">{{ __('Customer') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <!-- App Search-->
                            <a href="{{ route('clients.index') }}"
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
                            <h4 class="card-title ">{{ __('Create Customer') }}</h4>
                        </div>
                        <div class="card-body">
                            <form id="import-form" method="POST" action="{{ route('customerExport') }}" role="form"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <div class="mb-3 row">
                                            {{ Form::label('customer_category_id', __('Customer Category'), ['class' => 'col-md-3 col-form-label text-end']) }}
                                            <div class="col-md-9">
                                                {{ Form::select('customer_category_id', $categories, '', ['rows' => '2', 'class' => 'select2 form-control' . ($errors->has('customer_category_id') ? ' is-invalid' : ''), 'placeholder' => 'Customer Category']) }}
                                                {!! $errors->first('customer_category_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            {{ Form::label('district_id', __('District'), ['class' => 'col-md-3 col-form-label text-end']) }}
                                            <div class="col-md-9">
                                                {{ Form::select('district_id', $districts, '', ['id' => 'district_id', 'class' => 'select2 form-control' . ($errors->has('district_id') ? ' is-invalid' : ''), 'placeholder' => 'Customer Category']) }}
                                                {!! $errors->first('district_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            {{ Form::label('zone_id', __('Zone'), ['class' => 'col-md-3 col-form-label text-end']) }}
                                            <div class="col-md-9">
                                                {{ Form::select('zone_id', $zones, '', ['id' => 'zone_id', 'class' => 'select2 form-control' . ($errors->has('zone_id') ? ' is-invalid' : '')]) }}
                                                {!! $errors->first('zone_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="mb-3 row">
                                            {{ Form::label('prefix', __('Prefix'), ['class' => 'col-md-3 col-form-label text-end py-1']) }}
                                            <div class="col-md-9">
                                                {{ Form::checkbox('prefix', 'yes', false, ['id' => 'prefix', 'class' => '' . ($errors->has('prefix') ? ' is-invalid' : ''), 'style'=>"height: 30px;width: 20px;"]) }}
                                                {!! $errors->first('prefix', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                        <div class="box-footer mt20 text-end">
                                            <button type="submit" class="btn btn-primary" id="saveBtn">Export</button>
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
    @push('js')
        <script>
            var district_id = "";

            $("#district_id").on('change', function(e) {
                district_id = $(this).val();
                $("#zone_id").empty().trigger('change');
            });

            $('#zone_id').select2({
                placeholder: "Select Zone",
                allowClear: true,
                ajax: {
                    url: '{{ route('select2.zone') }}',
                    dataType: 'json',
                    district_id: district_id,
                    data: function(params) {
                        console.log(params)
                        params.district_id = district_id;
                        return params;
                    },
                },

            });
        </script>
    @endpush
    @push('css')
        <style>
            .select2-container .select2-selection--single .select2-selection__rendered {
                padding-right: 50px;
            }
        </style>
    @endpush
</x-admin-layout>
