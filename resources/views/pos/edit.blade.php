<x-admin-layout :title="__('POS')">
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
                                <li class="breadcrumb-item active">{{ __('POS') }}</li>
                            </ol>
                        </div>

                        <div class="page-title-right">
                            <!-- App Search-->
                            <a href="{{ route('dashboard') }}" class="btn btn-outline-primary waves-effect waves-light">
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
                            <h4 class="card-title ">{{ __('Create Order') }}</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('pos.update', $order->id) }}" id="order-form" role="form" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('pos.form')
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
    <table style="display:none">
        <tbody id="template">
            <tr id="row_id_{index}">
                <td>
                    {product_nr}
                    <input name="product_id[]" value="{product_id}" type="hidden" class="product_id"/>
                </td>
                <td>{product_details}</td>
                <td>
                    {weight}
                    <input name="weight[]" value="{weight}" type="hidden" class="{weight_class}"/>
                </td>
                <td>
                    {st_dia}
                    <input name="st_dia[]" value="{st_dia}" type="hidden" class="{st_dia_class}"/>
                </td>
                <td style="padding: 2px 2px 3px;">
                    <input class="form-control st_dia_price"  name="st_dia_price[]" value="{st_dia_price}" {st_dia_price_required} onkeyup="calculateUnitPrice('row_id_{index}')"/>
                </td>
                <td style="padding: 2px 2px 3px;">
                    <input class="form-control unit_price"  name="unit_price[]" value="{unit_price}" required="true" onkeyup="calculateUnitPrice('row_id_{index}')"/>
                </td>
                <td style="padding: 2px 2px 3px;">
                    <input class="form-control wage" data-wage="{wage}" data-wage-type="{wage_type}"  name="wage[]" value="" required="true" onkeyup="handleChangeWage('row_id_{index}')"/>
                </td>
                <td class="subtotal">{subtotal}</td>
                <td style="padding: 2px 2px 3px;">
                    <button onclick="removeRow({index})" type="button"
                        class="btn btn-danger glyphicon glyphicon-remove row-remove">
                        <span aria-hidden="true">×</span>
                    </button>
                </td>
            </tr>
        </tbody>
    </table>

    <table style="display:none">
        <tbody id="client-template">
            <tr>
                <th>Name</th>
                <td>: </td>
                <td style="padding-left: 5px">{name}</td>
            </tr>
            <tr>
                <th>Client No</th>
                <td>: </td>
                <th style="padding-left: 5px">{client_no}</th>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>: </td>
                <th style="padding-left: 5px">{mobile_number}</th>
            </tr>
            <tr>
                <th>Address</th>
                <td>: </td>
                <td style="padding-left: 5px">{address}</td>
            </tr>
        </tbody>
    </table>

    <div id="payment-template" style="display:none">
        <div class="row" id="payment_row_id_{index}">
            <div class="col-md-3" id="payment_type_{index}">
                {{ Form::label('payment_type', __('Payment type'), ['class' => 'col-form-label text-start']) }}
                {{ Form::select('payment[]', $payment_type, null, ['required' => true, 'class' => 'form-control', 'onchange' => 'paymentTypeChange(this,{index})']) }}
                {!! $errors->first('payment', '<div class="invalid-feedback">:message</div>') !!}
            </div>            
            <div class="col-md-3 paymentinfo_{index}">
                {{ Form::label('payment_info', __('Payment Info'), ['class' => 'col-form-label text-start']) }}
                {{ Form::select('payment_info[]', $payment_methods, null, ['required' => true, 'class' => 'form-control', 'placeholder' => 'Payment Info']) }}
                {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="col-md-3 reference_{index}">
                {{ Form::label('reference', __('Reference'), ['class' => 'col-form-label text-start']) }}
                {{ Form::text('reference[]', null, ['class' => 'form-control']) }}
                {!! $errors->first('reference', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="col-md-3">
                {{ Form::label('amount', __('Amount'), ['class' => 'col-form-label text-start']) }}
                <div class="d-flex">
                    {{ Form::text('amount[]', null, ['required' => true, 'class' => 'form-control numberonly payment_amount','onkeyup' => 'calculatePaid()']) }}
                    <button onclick="removePaymentRow({index})" type="button"
                        class="btn btn-danger glyphicon glyphicon-remove row-remove"
                        style="margin-left: 5px;">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="paymentinfo-template-cash" style="display:none">
        <div class="col-md-3 paymentinfo_{index}">
            {{ Form::label('payment_info', __('Payment Info'), ['class' => 'col-form-label text-start']) }}
            {{ Form::select('payment_info[]', $payment_methods, null, ['required' => true, 'class' => 'form-control']) }}
            {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

    <div id="paymentinfo-template-mobile-banking" style="display:none">
        <div class="col-md-3 paymentinfo_{index}">
            {{ Form::label('payment_info', __('Mobile Banking'), ['class' => 'col-form-label text-start']) }}
            {{ Form::select('payment_info[]', $mobile_banking, null, ['required' => true, 'class' => 'form-control', 'placeholder' => 'Select Operator']) }}
            {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div id="paymentinfo-template-banks" style="display:none">
        <div class="col-md-3 paymentinfo_{index}">
            {{ Form::label('payment_info', __('Bank'), ['class' => 'col-form-label text-start']) }}
            {{ Form::select('payment_info[]', $banks, null, ['required' => true, 'class' => 'form-control', 'placeholder' => 'Select Operator']) }}
            {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div id="paymentinfo-template-others" style="display:none">
        <div class="col-md-3 paymentinfo_{index}">
            {{ Form::label('payment_info', __('Payment Info'), ['class' => 'col-form-label text-start']) }}
            {{ Form::select('payment_info[]', $others, null, ['required' => true, 'class' => 'form-control', 'placeholder' => 'Select']) }}
            {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div id="paymentinfo-template-golds" style="display:none">
        <div class="col-md-3 paymentinfo_{index}">
            {{ Form::label('payment_info', __('Payment Info'), ['class' => 'col-form-label text-start']) }}
            {{ Form::select('payment_info[]', $golds, null, ['required' => true, 'class' => 'form-control', 'placeholder' => 'Select']) }}
            {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
    <div id="paymentinfo-template-cards" style="display:none">
        <div class="col-md-3 paymentinfo_{index}">
            {{ Form::label('payment_info', __('Payment Info'), ['class' => 'col-form-label text-start']) }}
            {{ Form::select('payment_info[]', $cards, null, ['required' => true, 'class' => 'form-control', 'placeholder' => 'Select']) }}
            {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>

    @push('css')
        <style>
            .table-bordered {
                border: 1px solid #000000;
            }
            .select2-container .select2-selection--single .select2-selection__rendered {
                padding-right: 40px;
            }
        </style>
    @endpush
</x-admin-layout>
