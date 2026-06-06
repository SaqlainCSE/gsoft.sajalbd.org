<div class="row">

    @if (request()->type === 'sale')
        {!! Form::hidden('trx_type', 'out') !!}
        {!! Form::hidden('type', \App\Models\Stock::TYPE_SALE) !!}
    @endif

    <div class="col-6 col-md-3">
        <div class="mb-3 row">
            {{ Form::label('date', __('Date'), ['class' => 'col-md-12 col-form-label']) }}
            <div class="col-md-12">
                {{ Form::text('date', $stock->date ?: date('Y-m-d'), [
                    'class' => 'form-control' . ($errors->has('date') ? ' is-invalid' : ''),
                    'required' => true,
                    'id'=>'datepicker',
                    'autocomplete' => 'off'
                ]) }}
                {!! $errors->first('date', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mb-3 row">
            {{ Form::label('memo', __('Memo'), ['class' => 'col-md-12 col-form-label']) }}
            <div class="col-md-12">
                {{ Form::text('memo', $stock->memo, [
                    'class' => 'form-control' . ($errors->has('memo') ? ' is-invalid' : ''),
                    'placeholder' => 'Memo',
                    'required' => true,
                    'id'=>'cash_memo_no',
                ]) }}
                {!! $errors->first('memo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mb-3 row">
            {{ Form::label('client', __('Client'), ['class' => 'col-form-label text-start']) }}
            <div class="col-md-12">
                {{ Form::select('client', [], $stock->client, ['required' => true, 'id' => 'client', 'class' => 'form-control' . ($errors->has('client') ? ' is-invalid' : ''), 'placeholder' => 'Select client']) }}
                {!! $errors->first('client', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="mb-3 row">
            {{ Form::label('client', __('Client Phone'), ['class' => 'col-form-label text-start']) }}
            <div class="col-md-12">
                {{ Form::text('client_phone', '', [
                    'readonly' => true,
                    'id' => 'client_phone',
                    'class' => 'form-control' . ($errors->has('client') ? ' is-invalid' : ''),
                ]) }}
                {!! $errors->first('client_phone', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-12 p-0">
        <div class="mb-3 row">
            <div class="col-md-12">
                <table class="table table-bordered padding-less-table" id="productTable">
                    <thead class="thead-success">
                        <tr>
                            <th style="width: 200px">Token</th>
                            <th style="width: 200px">Product</th>
                            <th>{{ __('Unit 18K') }}</th>
                            <th>{{ __('Unit 21K') }}</th>
                            <th>{{ __('Unit 22K') }}</th>
                            <th>{{ __('St') }}</th>
                            <th>{{ __('D18K') }}</th>
                            <th>{{ __('Dia') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="repeatable">
                    </tbody>
                    <tfoot>
                        <tr class="field-group controls-row">
                            <td colspan="9">
                                <div class="form-group" style="text-align:right">
                                    <button type="button" class="btn btn-success add"><i
                                            class="fas fa-plus"></i></button>
                                </div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-12 p-0">
        <div class="mb-3 row">
            <div class="col-md-12">
                <table class="table table-bordered padding-less-table">
                    <thead class="thead-success">
                        <tr>
                            <th>BILL AMOUNT</th>
                            <th>DISCOUNT</th>
                            <th>ADVANCE</th>
                            <th>FINAL BILL</th>
                            <th>GOLD</th>
                            <th>CASH</th>
                            <th>DBBL</th>
                            <th>CITY - QR</th>
                            <th>CBBL</th>
                            <th>DUE</th>
                        </tr>
                    </thead>
                    <tbody class="amount">
                        <tr class="field-group controls-row">
                            <td>
                                {{ Form::text('bill_amount', '', [
                                    'id' => 'bill_amount', 'class' => 'form-control' . ($errors->has('bill_amount') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('bill_amount', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('discount', '', [
                                    'id' => 'discount', 'class' => 'form-control' . ($errors->has('discount') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('discount', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('advance', '', [
                                    'id' => 'advance', 'class' => 'form-control' . ($errors->has('advance') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('advance', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('final_bill', '', [
                                    'id' => 'final_bill', 'class' => 'form-control' . ($errors->has('final_bill') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('final_bill', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('gold', '', [
                                    'id' => 'gold', 'class' => 'form-control' . ($errors->has('gold') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('gold', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('cash', '', [
                                    'id' => 'cash', 'class' => 'form-control' . ($errors->has('cash') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('cash', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('dbbl', '', [
                                    'id' => 'dbbl', 'class' => 'form-control' . ($errors->has('dbbl') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('dbbl', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('city_qr', '', [
                                    'id' => 'city_qr', 'class' => 'form-control' . ($errors->has('city_qr') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('city_qr', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('cbbl', '', [
                                    'id' => 'cbbl', 'class' => 'form-control' . ($errors->has('cbbl') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('cbbl', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                            <td>
                                {{ Form::text('due', '', [
                                    'id' => 'due', 'class' => 'form-control' . ($errors->has('due') ? ' is-invalid' : ''),
                                    'required' => true,
                                ]) }}

                                {!! $errors->first('dbbl', '<div class="invalid-feedback">:message</div>') !!}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>

@push('js')
    <script>
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
                        $("#client_phone").val(resp.mobile_number);
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
    </script>
@endpush
@push('js')
    <script src="{{ asset('assets/js/jquery.repeatable.js') }}"></script>
    <script type="text/template" id="productTableTemplate">
        <tr class="field-group controls-row" id="row_{?}">
            <td>
                {{ Form::text('product_nr[{?}]', '', [
                    'id' => 'product_nr', 'class' => 'form-control' . ($errors->has('product_nr') ? ' is-invalid' : ''),
                    'placeholder' => 'Product Nr',
                    'onChange' => 'changeProductNr(this,"{?}")',
                    'required' => true,
                ]) }}

                {!! $errors->first('product_nr[{?}]', '<div class="invalid-feedback">:message</div>') !!}
            </td>
            <td class="product_name"></td>
            <td style="width: 120px">
                {!! Form::text("unit_18k[{?}]", null, [
                    'class' => 'form-control unit_18k' . ($errors->has('unit_18k[?]') ? ' is-invalid' : ''),
                    'placeholder' => '',
                ]) !!}
                {!! $errors->first('unit_18k[{?}]', '<div class="invalid-feedback">:message</div>') !!}
            </td>
            <td style="width: 120px">
                {!! Form::text("unit_21k[{?}]", null, [
                    'class' => 'form-control unit_21k' . ($errors->has('products[?]') ? ' is-invalid' : ''),
                    'placeholder' => '',
                ]) !!}
                {!! $errors->first('unit_21k[{?}]', '<div class="invalid-feedback">:message</div>') !!}
            </td>
            <td style="width: 120px">
                {!! Form::text("unit_22k[{?}]", null, [
                    'class' => 'form-control unit_22k' . ($errors->has('products[?]') ? ' is-invalid' : ''),
                    'placeholder' => '',
                ]) !!}
                {!! $errors->first('unit_22k[{?}]', '<div class="invalid-feedback">:message</div>') !!}
            </td>
            <td style="width: 120px">
                {!! Form::text("st[{?}]", null, [
                    'class' => 'form-control st' . ($errors->has('products[?]') ? ' is-invalid' : ''),
                    'placeholder' => '',
                ]) !!}
                {!! $errors->first('products[{?}]', '<div class="invalid-feedback">:message</div>') !!}
            </td>
            <td style="width: 120px">
                {!! Form::text("d18k[{?}]", null, [
                    'class' => 'form-control rate' . ($errors->has('products[?]') ? ' is-invalid' : ''),
                    'placeholder' => '',
                ]) !!}
                {!! $errors->first('d18k[{?}]', '<div class="invalid-feedback">:message</div>') !!}
            </td>
            <td style="width: 120px">
                {!! Form::text("dia[{?}]", null, [
                    'class' => 'form-control rate' . ($errors->has('products[?]') ? ' is-invalid' : ''),
                    'placeholder' => '',
                ]) !!}
                {!! $errors->first('dia[{?}]', '<div class="invalid-feedback">:message</div>') !!}
            </td>
            <td style="width: 30px">
                <input type="button" class="btn btn-danger span-2 delete" value="X" />
            </td>
        </tr>
    </script>


    <script>
        $(function() {
            $('#datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });
        });
        $(function() {
            $("#productTable .repeatable").repeatable({
                addTrigger: "#productTable .add",
                deleteTrigger: "#productTable .delete",
                template: "#productTableTemplate",
                min: 1,
            });
        });
        function changeProductNr(val, index){
            if (!$(val).val()) {
                return;
            }
            $.ajax({
                url: "{{ route('products.index') }}/" + $(val).val() +"/bynr",
                headers: {
                    'Accept': 'application/json'
                }
            })
            .done(function(resp) {
                $("#row_" + index + " .product_name").text(resp.product_details);
            })
            .fail(function(response) {
                if (response.status === 419) {
                    Swal.fire("Error!", response.responseJSON.message, "error")
                } else {
                    Swal.fire("Error!", response.statusText, "error")
                }
            });
        }
    </script>

    <script>
            $('#cash_memo_no').on('change', function() {
            let memo = $(this).val();
            if (!memo) return;

            $.ajax({
                url: "{{ route('stocks.byCashMemo', '') }}/" + memo,
                headers: { "Accept": "application/json" }
            })
            .done(function(resp) {
                $("#datepicker").val(resp.date);

                // Client select2
                let opt = new Option(resp.client_name, resp.client_id, true, true);
                $("#client").empty().append(opt).trigger("change");

                $("#client_phone").val(resp.client_phone);

                // Reset Product Table
                $("#productTable .repeatable").html("");

                resp.products.forEach((product, index) => {
                    $(".add").click(); // create new row

                    // last inserted row
                    let row = $("#productTable .repeatable tr").last();

                    row.find("input[name^='product_nr']").val(product.product_nr);
                    row.find(".product_name").text(product.product_name);
                    row.find("input[name^='unit_18k']").val(product.unit_18k);
                    row.find("input[name^='unit_21k']").val(product.unit_21k);
                    row.find("input[name^='unit_22k']").val(product.unit_22k);
                    row.find("input[name^='st']").val(product.st);
                    row.find("input[name^='d18k']").val(product.d18k);
                    row.find("input[name^='dia']").val(product.dia);
                    row.find("input[name^='rate']").val(product.rate);
                });


                // Billing fields
                $("#bill_amount").val(resp.bill_amount);
                $("#discount").val(resp.discount);
                $("#advance").val(resp.advance);
                $("#final_bill").val(resp.final_bill);
                $("#gold").val(resp.gold);
                $("#cash").val(resp.cash);
                $("#dbbl").val(resp.dbbl);
                $("#city_qr").val(resp.city_qr);
                $("#cbbl").val(resp.cbbl);
                $("#due").val(resp.due);
            })
            .fail(function() {
                Swal.fire("Error", "Cash memo not found", "error");
            });
        });

    </script>
@endpush

@push('css')
    <style>
        .select2-container .select2-selection--single .select2-selection__arrow {
            display: none;
        }
        thead.thead-success {
            background: #ddd;
        }
        .field-group.controls-row td {
            padding: 0;
        }
        .amount input {
            text-align: right;
        }
    </style>
@endpush
