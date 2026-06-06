<div class="row">
    <div class="col-12 col-md-12">
        <div class="mb-3 row">
            <div class="col-md-4">
                {{ Form::label('client', __('Client'), ['class' => 'col-form-label text-start']) }}

                @php
                    $clients = [];
                    if ($booking->client) {
                        $clients[$booking->client->id] = $booking->client->name;
                    }
                @endphp

                {{ Form::select('client', $clients, $booking->client ? $booking->client->id : '', ['required' => true, 'id' => 'client', 'class' => 'form-control' . ($errors->has('client') ? ' is-invalid' : ''), 'placeholder' => 'Select client']) }}
                {!! $errors->first('client', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="col-md-4">
                {{ Form::label('booked_by', __('Client'), ['class' => 'col-form-label text-start']) }}
                {{ Form::select('booked_by', $users, $booking->booked_by, ['required' => true, 'id' => 'client', 'class' => 'form-control' . ($errors->has('client') ? ' is-invalid' : ''), 'placeholder' => 'Select Booked By']) }}
                {!! $errors->first('booked_by', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="col-md-12 mt-4">
                <table>
                    <tbody id="selected_client">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="mb-3 row">
            <div class="col-md-12">
                {{ Form::label('product_nr', __('Product Nr'), ['class' => 'col-form-label text-start']) }}
            </div>
            <div class="col-md-12">
                {{ Form::select('product_nr', [], '', ['id' => 'product_nr', 'class' => 'form-control' . ($errors->has('product_nr') ? ' is-invalid' : ''), 'placeholder' => 'Product Nr']) }}
                {!! $errors->first('product_nr', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="col-md-12 mt-4">
                <table class="table table-bordered nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                            <td style="width: 80px">Nr</td>
                            <td>Details</td>
                            <td style="width: 50px">Weight</td>
                            <td style="width: 50px">ST/DIA</td>
                            <td style="width: 100px">ST/DIA Price</td>
                            <td style="width: 100px">Unit Price</td>
                            <td style="width: 100px">Wage</td>
                            <td style="width: 80px;">Subtotal</td>
                            <td style="width: 40px"></td>
                        </tr>
                    </thead>
                    <tbody id="selected_product_list">
                        @if ($booking->meta)
                            @foreach ($booking->meta as $key => $meta)
                                <tr id="row_id_{{ $key + 1 }}">
                                    <td>
                                        {{ $meta->product?->product_nr }}
                                        <input name="product_id[]" value="{{ $meta->product_id }}" type="hidden"
                                            class="product_id" />
                                    </td>
                                    <td>{{ $meta->product?->product_details }}</td>
                                    <td>
                                        {{ $meta->product?->weight }}
                                        <input name="weight[]" value="{{ $meta->product?->weight }}" type="hidden"
                                            class="weight" />
                                    </td>
                                    <td>
                                        {{ $meta->st_dia }}
                                        <input name="st_dia[]" value="{{ $meta->st_dia }}" type="hidden"
                                            class="st_dia" />
                                    </td>
                                    <td style="padding: 2px 2px 3px;">
                                        <input class="form-control st_dia_price" name="st_dia_price[]"
                                            value="{{ $meta->st_dia_price }}"
                                            {{ $meta->st_dia ? 'required="true"' : 'readonly="true"' }}
                                            onkeyup="calculateUnitPrice('row_id_{{ $key + 1 }}')" />
                                    </td>
                                    <td style="padding: 2px 2px 3px;">
                                        <input class="form-control unit_price" name="unit_price[]"
                                            value="{{ $meta->unit_price }}" required="true"
                                            onkeyup="calculateUnitPrice('row_id_{{ $key + 1 }}" />
                                    </td>
                                    <td style="padding: 2px 2px 3px;">
                                        <input class="form-control wage" data-wage="{{ $meta->wage }}"
                                            data-wage-type="{{ $meta->wage_type }}" name="wage[]"
                                            value="{{ $meta->wage }}" required="true"
                                            onkeyup="handleChangeWage('row_id_{{ $key + 1 }}')" />
                                    </td>
                                    <td class="subtotal">{subtotal}</td>
                                    <td style="padding: 2px 2px 3px;">
                                        <button onclick="removeRow({{ $key + 1 }})" type="button"
                                            class="btn btn-danger glyphicon glyphicon-remove row-remove">
                                            <span aria-hidden="true">×</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                        @endif
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-end">Total Weight</td>
                            <td id="total_weight"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td colspan="2" id="subtotal_without_vat"></td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end justify-end" style="padding: 1px;">
                                <div style="width: 90px; float:right">
                                    {{ Form::select('vat', $vats, 5, ['id' => 'vat', 'required' => true, 'class' => 'form-control']) }}
                                </div>
                            </td>
                            <td colspan="2" id="vat_amount"></td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end">Subtotal</td>
                            <td colspan="2" id="subtotal_with_vat"></td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end">Discount</td>
                            <td colspan="2" style="padding: 1px;">
                                {{ Form::text('discount', '', ['id' => 'discount', 'class' => 'form-control']) }}
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="text-end">Total</td>
                            <td colspan="2" id="total"></td>
                        </tr>
                        <tr>
                            <td colspan="7">
                                @if ($booking->payments)
                                    @foreach ($booking->payments as $key => $payment)
                                        @if ($key > 0)
                                            <div id="payments_container">
                                        @endif
                                        <div class="row" id="payment_row_id_{{ $key }}">
                                            <div class="col-md-3" id="payment_type_{{ $key }}">
                                                {{ Form::label('payment_type', __('Payment type'), ['class' => 'col-form-label text-start']) }}
                                                {{ Form::select('payment[]', $payment_type, $payment->payment_type, ['required' => true, 'class' => 'form-control', 'onchange' => 'paymentTypeChange(this,'.$key.')']) }}
                                                {!! $errors->first('payment', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="col-md-3 paymentinfo_{{ $key }}">
                                                {{ Form::label('payment_info', __('Payment Info'), ['class' => 'col-form-label text-start']) }}
                                                {{ Form::select('payment_info[]', $payment_methods, $payment->payment_info, ['required' => true, 'class' => 'form-control', 'placeholder' => 'Payment Info']) }}
                                                {!! $errors->first('payment_info', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="col-md-3 reference_{{ $key }}">
                                                {{ Form::label('reference', __('Reference'), ['class' => 'col-form-label text-start']) }}
                                                {{ Form::text('reference[]', $payment->reference, ['class' => 'form-control']) }}
                                                {!! $errors->first('reference', '<div class="invalid-feedback">:message</div>') !!}
                                            </div>
                                            <div class="col-md-3">
                                                {{ Form::label('amount', __('Amount'), ['class' => 'col-form-label text-start']) }}
                                                <div class="d-flex">
                                                    {{ Form::text('amount[]', $payment->amount, ['required' => true, 'class' => 'form-control numberonly payment_amount', 'onkeyup' => 'calculatePaid()']) }}
                                                    @if ($key > 0)
                                                    <button onclick="removePaymentRow({{ $key }})" type="button"
                                                        class="btn btn-danger glyphicon glyphicon-remove row-remove"
                                                        style="margin-left: 5px;">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                         @if ($key > 0)
                                            </div>
                                        @endif
                                    @endforeach                                    
                                @endif
                                
                                @if (count($booking->payments) == 0)
                                        
                                <div class="row">
                                    <div class="col-md-3" id="payment_type_0">
                                        {{ Form::label('payment_type', __('Payment type'), ['class' => 'col-form-label text-start']) }}
                                        {{ Form::select('payment[]', $payment_type, null, ['required' => true, 'class' => 'form-control', 'onchange' => 'paymentTypeChange(this, 0)']) }}
                                        {!! $errors->first('payment', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>

                                    <div class="col-md-3 paymentinfo_0">
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
                                        {{ Form::text('amount[]', null, ['required' => true, 'class' => 'form-control numberonly payment_amount', 'onkeyup' => 'calculatePaid()']) }}
                                        {!! $errors->first('amount', '<div class="invalid-feedback">:message</div>') !!}
                                    </div>
                                </div>
                                @endif
                                    @if (count($booking->payments) <= 1)
                                        <div id="payments_container">
                                        </div>
                                    @endif
                                <div class="row mt-2">
                                    <div class="col-md-3">
                                        <a href="#" id="addNewPayment" class="btn btn-info">Add</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="7">
                                Paid
                            </td>
                            <td id="paid" style="padding: 1px;" colspan="2">
                                {{ Form::text('paid', '', ['id' => 'paidAmount', 'required' => true, 'readonly' => true, 'class' => 'form-control']) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end" colspan="7">
                                Due
                            </td>
                            <td id="due" style="padding: 1px;" colspan="2">
                                {{ Form::text('due', '', ['id' => 'dueAmount', 'required' => false, 'readonly' => true, 'class' => 'form-control']) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary btn-lg">Save</button>
            <button id="preview" class="btn btn-primary btn-lg">Preview</button>
        </div>
    </div>
</div>
<a href="" id="preview-link"></a>
@push('js')
    <script>
        var selectedProduct = [];

        $('#client').select2({
            placeholder: "Select client",
            allowClear: true,
            ajax: {
                url: '{{ route('select2.client') }}',
                dataType: 'json'
            }
        });

        $('#client').on('change', function(e) {
            if ($(this).val()) {
                $.ajax({
                        url: "{{ route('clients.index') }}/" + $(this).val(),
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .done(function(resp) {
                        var template = $("#client-template").html();
                        template = template.replace(/{name}/g, resp.name);
                        template = template.replace(/{client_no}/g, resp.client_no);
                        template = template.replace(/{mobile_number}/g, resp.mobile_number);
                        template = template.replace(/{address}/g, resp.address);
                        $("#selected_client").html(template);
                    })
                    .fail(function(response) {
                        if (response.status === 419) {
                            Swal.fire("Error!", response.responseJSON.message, "error")
                        } else {
                            Swal.fire("Error!", response.statusText, "error")
                        }
                    });
            } else {
                $("#selected_client").html("");
            }
        });

        $('#product_nr').select2({
            placeholder: "Select Product",
            allowClear: true,
            ajax: {
                url: '{{ route('select2.product') }}',
                dataType: 'json',
                data: function(params) {
                    var query = {
                        term: params.term,
                        selectedProduct: selectedProduct
                    }
                    return query;
                }
            }
        });


        $('#product_nr').on('change', function(e) {
            if (!$(this).val()) {
                return;
            }
            $.ajax({
                    url: "{{ route('products.index') }}/" + $(this).val(),
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .done(function(resp) {
                    selectedProduct.push(resp.id);
                    addRow(resp)
                    $("#product_nr").val('').trigger('change')
                })
                .fail(function(response) {
                    if (response.status === 419) {
                        Swal.fire("Error!", response.responseJSON.message, "error")
                    } else {
                        Swal.fire("Error!", response.statusText, "error")
                    }
                });
        });

        @if ($booking->payments)
            var row = {{ count($booking->payments) + 1 }};
        @else
            var row = 1;
        @endif
        var dirtyWage = [];

        function addRow(resp) {
            console.log(resp.st_dia ? resp.st_dia : '');

            var template = $("#template").html();
            template = template.replace(/{product_id}/g, resp.id);
            template = template.replace(/{product_nr}/g, resp.product_nr);
            template = template.replace(/{product_details}/g, resp.product_details);
            template = template.replace(/{weight}/g, resp.weight);
            template = template.replace(/{weight_class}/g, 'weight');
            template = template.replace(/{st_dia}/g, resp.st_dia ? resp.st_dia : '');
            template = template.replace(/{st_dia_price_required}/g, resp.st_dia ? 'required="true"' : '');
            template = template.replace(/{st_dia_class}/g, 'st_dia');
            template = template.replace(/{unit_price}/g, resp.price ? resp.price : '');
            template = template.replace(/{st_dia_price}/g, resp.st_dia_price ? resp.st_dia_price : '');

            var wage;
            var wage_type = 'fixed';

            if (parseFloat(resp.wage) > 0) {
                if (resp.wage_type == 'Percentage') {
                    wage = parseFloat(resp.wage) / 100;
                    wage_type = "Percentage";
                } else {
                    wage = resp.wage;
                }
            }

            template = template.replace(/{wage}/g, resp.wage ? wage : '');
            template = template.replace(/{wage_type}/g, wage_type);
            template = template.replace(/{subtotal}/g, '');
            $("#selected_product_list").append(template.replace(/{index}/g, row));

            if (!resp.st_dia) {
                $(document).find('#row_id_' + row + ' .st_dia_price').attr('readonly', true);
            }

            row++;
            recalculate()
        }

        function removeRow(id) {
            var elem = $("#row_id_" + id + " .product_id").val();
            selectedProduct = selectedProduct.filter(function(e) {
                return e != elem
            })
            $("#row_id_" + id).remove();
            delete dirtyWage["row_id_" + id];
            recalculate()
        }

        $("#discount").on('keyup', function() {
            recalculate()
        })

        var subtotal_without_vat = 0;
        var vat = 0;

        function recalculate() {
            calculateWeight();
            cal_subtotal_without_vat();
        }

        function cal_subtotal_without_vat() {
            var subtotal = 0;
            
            $("#selected_product_list .subtotal").each(function(e) {
                var v = $(this).text();
                subtotal += parseFloat(v ? v.replace(/,/g, '') : 0)
            })
            subtotal_without_vat = subtotal;

            $("#subtotal_without_vat").text(subtotal_without_vat ? bd_money_format(subtotal_without_vat.toFixed(0)) : '--');

            var vat_percent = parseFloat($('#vat').val());
            vat = subtotal_without_vat * (vat_percent / 100);

            $("#vat_amount").text(vat ? bd_money_format(vat.toFixed(0)) : '--');

            var total = subtotal_without_vat + vat;

            $("#subtotal_with_vat").text(total ? bd_money_format(total.toFixed(0)) : '--');

            var discount = parseFloat($("#discount").val() ? $("#discount").val() : 0);

            var payable = total - discount;

            $("#total").text(payable ? bd_money_format(payable.toFixed(0)) : '--');
            calculatePaid();
        }

        function calculateWeight() {
            var weight = 0;
            $('.weight').each(function() {
                weight += parseFloat($(this).val())
            })
            $("#total_weight").text(weight);
        }

        function handleChangeWage(row) {
            dirtyWage[row] = 1;
            calculateUnitPrice(row);
        }

        function calculateUnitPrice(row) {
            var weight = $("#" + row + " .weight").val();
            var unitprice = $("#" + row + " .unit_price").val();
            var stDiaPrice = $("#" + row + " .st_dia_price").val();

            if (!dirtyWage[row]) {
                var wage = $("#" + row + " .wage").data('wage');
                var wage_type = $("#" + row + " .wage").data('wage-type');

                if (wage_type == 'Percentage') {
                    wage = (parseFloat(weight) * parseFloat(unitprice)) * parseFloat(wage ? wage : 0);
                    wage = wage.toFixed(0);
                }

                $("#" + row + " .wage").val(wage);
            } else {
                var wage = $("#" + row + " .wage").val();
                wage = parseFloat(wage);
            }

            //var wage = $("#" + row + " .wage").val();
            var subtotal = (parseFloat(weight) * parseFloat(unitprice)) + parseFloat(wage ? wage : 0) + parseFloat(
                stDiaPrice ? stDiaPrice : 0);
            $("#" + row + " .subtotal").text(subtotal ? bd_money_format(subtotal.toFixed(0)) : '--')

            cal_subtotal_without_vat();
        }

        var paymentRow = 1;
        $("#addNewPayment").on('click', function(e) {
            e.preventDefault();
            var template = $("#payment-template").html();
            $("#payments_container").append(template.replace(/{index}/g, paymentRow));
            paymentRow++;
            calculatePaid();
        });

        function removePaymentRow(id) {
            $("#payment_row_id_" + id).remove();
            calculatePaid();
        }

        function calculatePaid() {
            var paid = 0;

            var total = parseFloat($("#total").text().replace(/,/g, ''));

            $('.payment_amount').each(function() {
                if ($(this).val().length > 0) {
                    paid += parseFloat($(this).val() ? $(this).val() : 0);
                }
            });

            $("#paidAmount").val(bd_money_format(paid));

            if (!isNaN(total)) {
                $("#dueAmount").val(bd_money_format((total - paid).toFixed(2)))
            } else {
                if($("#total").text() === '--'){
                    $("#dueAmount").val(bd_money_format(-1 * paid))
                }
            }
        }

        function paymentTypeChange(elem, id) {
            if ($(elem).val() === 'mobile_banking') {
                var template = $("#paymentinfo-template-mobile-banking").html();
            } else if ($(elem).val() === 'bank') {
                var template = $("#paymentinfo-template-banks").html();
            } else if ($(elem).val() === 'other') {
                var template = $("#paymentinfo-template-others").html();
            } else if ($(elem).val() === 'gold') {
                var template = $("#paymentinfo-template-golds").html();
            } else if ($(elem).val() === 'card') {
                var template = $("#paymentinfo-template-cards").html();
            } else {
                var template = $("#paymentinfo-template-cash").html();
            }
            $(".paymentinfo_" + id).remove();
            $("#payment_type_" + id).after(template.replace(/{index}/g, id));
        }

        $("#preview").on("click", function(e) {
            e.preventDefault();
            var formData = $("#order-form").serialize();
            openWindow("{{ route('booking-preview') }}?" + formData);
        });

        function openWindow(url, title) {
            var left = (screen.width - 900) / 2;
            var top = (screen.height - 500) / 2;
            return window.open(url, title, 'width=900,height=500,left=' + left + ',top=' + top + ',screenX=' + left +
                ',screenY=' + top + ',status=no,scrollbars=yes');
        }
        @if ($booking->meta)
            @foreach ($booking->meta as $key => $meta)
                calculateUnitPrice('row_id_{{ $key + 1 }}');
            @endforeach
        @endif
    </script>
@endpush
