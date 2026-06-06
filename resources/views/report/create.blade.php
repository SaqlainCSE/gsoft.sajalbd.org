<x-admin-layout :title="__('Report')">
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
                                <li class="breadcrumb-item active">{{ __('Report') }}</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">{{ __('Report') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('report') }}" role="form"
                                enctype="multipart/form-data" id="reportFilter">
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="mb-3 row">
                                            {{ Form::label('type', __('Type:'), ['class' => 'col-md-12 col-form-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::select('type', $type, '', ['id' => 'type', 'class' => 'form-control select2' . ($errors->has('type') ? ' is-invalid' : ''), 'placeholder' => 'Select Type']) }}
                                                {!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3" id="supplier">
                                        <div class="mb-3 row">
                                            {{ Form::label('supplier_id', __('Supplier:'), ['class' => 'col-md-12 col-form-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::select('supplier_id', [], null, ['id' => 'supplier_id', 'class' => 'form-control' . ($errors->has('supplier_id') ? ' is-invalid' : ''), 'placeholder' => 'Select supplier']) }}
                                                {!! $errors->first('supplier_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3 d-none" id="client">
                                        <div class="mb-3 row">
                                            {{ Form::label('client_id', __('Client:'), ['class' => 'col-md-12 col-form-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::select('client_id', [], null, ['id' => 'client_id', 'class' => 'form-control' . ($errors->has('client_id') ? ' is-invalid' : ''), 'placeholder' => 'Select supplier']) }}
                                                {!! $errors->first('client_id', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3" id="fromDate">
                                        <div class="mb-3 row">
                                            {{ Form::label('from_date', __('From Date:'), ['class' => 'col-md-12 col-form-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::date('from_date', null, ['id' => 'from_date', 'class' => 'form-control' . ($errors->has('from_date') ? ' is-invalid' : '')]) }}
                                                {!! $errors->first('from_date', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3" id="supplier">
                                        <div class="mb-3 row">
                                            {{ Form::label('to_date', __('To Date:'), ['class' => 'col-md-12 col-form-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::date('to_date', null, ['id' => 'to_date', 'class' => 'form-control' . ($errors->has('to_date') ? ' is-invalid' : ''), 'placeholder' => 'Select supplier']) }}
                                                {!! $errors->first('to_date', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-3" id="sellby">
                                        <div class="mb-3 row">
                                            {{ Form::label('sell_by', __('Sell By:'), ['class' => 'col-md-12 col-form-label']) }}
                                            <div class="col-md-12">
                                                {{ Form::select('sell_by', $users, null,['id' => 'sell_by', 'class' => 'form-control' . ($errors->has('sell_by') ? ' is-invalid' : ''), 'placeholder' => 'Select user']) }}
                                                {!! $errors->first('sell_by', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="mb-3 row">
                                            <div class="col-md-3">
                                                <button class="btn btn-primary" type="submit">Generate</button>
                                            </div>
                                            <div class="col-md-9 text-end">
                                                <a href="" class="btn btn-outline-primary" target="_blank"
                                                    id="print">Print</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div id="reportView" style="position: relative;">
                                <div class="loaderContainer"
                                    style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;z-index: 99;background: #dddddd52;">
                                    <div
                                        style="position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
                                        <div class="loader"></div>
                                    </div>
                                </div>
                                <div id="reportViewContent" style="overflow: scroll; height: 400px"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    @push('css')
        <style>
            .loaderContainer {
                display: none;
            }

            .loaderContainer.loadding {
                display: block;
            }

            .loader {
                width: 40px;
                --b: 8px;
                aspect-ratio: 1;
                border-radius: 50%;
                padding: 1px;
                background: conic-gradient(#0000 10%, #15602a) content-box;
                -webkit-mask:
                    repeating-conic-gradient(#0000 0deg, #000 1deg 20deg, #0000 21deg 36deg),
                    radial-gradient(farthest-side, #0000 calc(100% - var(--b) - 1px), #000 calc(100% - var(--b)));
                -webkit-mask-composite: destination-in;
                mask-composite: intersect;
                animation: l4 1s infinite steps(10);
            }

            @keyframes l4 {
                to {
                    transform: rotate(1turn)
                }
            }

            span.select2-selection__arrow {
                display: none;
            }
        </style>
    @endpush

    @push('js')
        <script>
            $('#client_id').select2({
                placeholder: "Select client",
                allowClear: true,
                ajax: {
                    url: '{{ route('select2.client') }}',
                    dataType: 'json'
                }
            });
            $('#supplier_id').select2({
                placeholder: "Select Supplier",
                allowClear: true,
                ajax: {
                    url: '{{ route('select2.supplier') }}',
                    dataType: 'json'
                }
            });

            function disableDate() {
                $("#from_date").attr('disabled', 'true');
                $("#to_date").attr('disabled', 'true');
            }

            function clearDisableDate() {
                $("#from_date").removeAttr('disabled');
                $("#to_date").removeAttr('disabled');
            }

            function customerCentricReport(){
                $("#supplier").addClass('d-none');
                $("#client").removeClass('d-none');
            }
            function supplierCentricReport(){
                $("#supplier").removeClass('d-none');
                $("#client").addClass('d-none');
            }
            $("#sellby").addClass('d-none');
            $("#type").on("change", function() {
                let val = $(this).val();
                if("sell_report" === val){
                    $("#sellby").removeClass('d-none');
                } else {
                    $("#sellby").addClass('d-none');
                }

                if (val === 'supplier_due' || val === 'customer_due') {
                    disableDate();
                } else {
                    clearDisableDate();
                }

                if (val === 'customer_due' || val === 'customer_transaction' || val ==='sell_report' || val === 'booking_report') {
                    customerCentricReport();
                } else {
                    supplierCentricReport();
                }

            });

            $("#reportFilter").on('submit', function(e) {

                e.preventDefault();
                $(".loaderContainer").addClass('loadding');

                var formData = $(this).serialize();

                var url = "{{ route('report') }}/view?" + formData;
                var printParam = 'print=1';
                $('#print').attr('href', url + '&' + printParam);

                $.ajax({
                        url: "{{ route('report') }}/view",
                        type: 'GET',
                        data: formData,
                        contentType: false,
                        processData: false,
                    })
                    .done(function(resp) {
                        console.log(resp);

                        $("#reportViewContent").html(resp.view);
                    })
                    .fail(function() {
                        console.log("error");
                    })
                    .always(function() {
                        console.log("complete");
                        $(".loaderContainer").removeClass('loadding');
                    });

            });
        </script>
    @endpush
</x-admin-layout>
