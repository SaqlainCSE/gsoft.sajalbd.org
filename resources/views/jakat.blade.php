<x-admin-layout :title="__('Admin Dashboard')">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0">Jakat Calculation</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="card p-4">
                <div class="row">
                    <div class="col-lg-12">
                        <form method="POST" action="{{ route('jakat.store') }}" id="order-form" role="form"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3 row">
                                <div class="col-md-4">
                                    {{ Form::label('client_id', __('Client'), ['class' => 'col-form-label text-start']) }}
                                    {{ Form::select('client_id', [], $jakat->client ? $order->client->id : '', [
                                        'required' => true,
                                        'id' => 'client_id',
                                        'class' => 'form-control' . ($errors->has('client_id') ? ' is-invalid' : ''),
                                        'placeholder' => 'Select client',
                                    ]) }}
                                    {!! $errors->first('client_id', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12">
                                    {{ Form::label('product_type', __('Product'), ['class' => 'col-form-label text-start']) }}
                                </div>
                                <div class="col-md-12">
                                    {{ Form::select('product_type', $categories, '', ['id' => 'product_type', 'class' => 'form-control' . ($errors->has('product_type') ? ' is-invalid' : ''), 'placeholder' => 'Product Type']) }}
                                    {!! $errors->first('product_type', '<div class="invalid-feedback">:message</div>') !!}
                                </div>
                            </div>

                            <table class="table-fw table-border mb-3">
                                <thead>
                                    <tr>
                                        <td class="text-center"
                                            style="width:52px;font-size:14px;font-weight: bold;font-family: math;">SL#
                                        </td>
                                        <td class="text-center"
                                            style="font-size:14px;font-weight: bold;font-family: math;">
                                            PRODUCT
                                            NAME
                                        </td>
                                        <td class="text-center"
                                            style="width:100px;font-size:14px;font-weight: bold;font-family: math;">
                                            KARAT
                                        </td>
                                        <td class="text-center"
                                            style="width:100px;font-size:14px;font-weight: bold;font-family: math;">
                                            WT/GM</td>
                                        <td class="text-center"
                                            style="width:100px;font-size:14px;font-weight: bold;font-family: math;">
                                            JAKAT (%)</td>
                                        <td class="text-center"
                                            style="width: 100px;font-size:14px;font-weight: bold;font-family: math;">
                                            TOTAL JAKAT</td>
                                    </tr>
                                </thead>
                                <tbody id="selected_product_list">

                                </tbody>
                                <tfoot>
                                    <tr>
                                        {{-- <td class="text-center" colspan="3"></td> --}}
                                        <td class="text-end" colspan="3"
                                            style="font-size:14px;font-weight: bold;font-family: math;">TOTAL
                                        </td>
                                        <td id="weightTotal" class="text-end" style="font-size:14px;font-family: math;"></td>
                                        <td class="text-end" style="font-size:14px;font-family: math;"></td>
                                        <td id="totalAmount" class="text-end" style="font-size:14px;font-family: math;">
                                        </td>
                                    </tr>
                                    
                                </tfoot>
                            </table>
                            <input type="hidden" name="jakat_percentage" value="{{setting('jakat_percentage')}}"/>
                            <div class="mb-3 row">
                                <div class="col-12">
                                    <div class="box-footer mt20 text-end">
                                        <button type="submit" class="btn btn-primary btn-lg">Save &amp; Preview</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div> <!-- container-fluid -->
    </div>
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
            $('#product_type').select2({});

            let products = {!! json_encode($categories) !!};
            let jakat_percentage = {{ setting('jakat_percentage') }};
            console.log(products[1])

            let rowindex = 1;

            $('#product_type').on('change', function(e) {
                console.log($(this).val())
                if (!$(this).val()) {
                    return;
                }

                let karat = `{!! Form::select('karat[]', $todayRates->pluck('name', 'name'), null, [
                    'class' => 'select',
                    'style' => 'width: 100%;height:35px',
                    'onchange' => 'recalculate()'
                ]) !!}`;
                let weight = `<input class="form-control weight"  
                    name="weight[]" 
                    value="" 
                    required="true" 
                    onkeyup="handelWeightUpdate('row_id_` + rowindex + `')"/>
                `;

                let row = `
                    <tr id="row_id_` + rowindex + `">
                        <td class="text-center" style="font-size:14px;font-family: math;"></td>
                        <td style="font-size:14px;font-family: math;">
                            <input type="hidden" name="product[]" value="`+$(this).val()+`"/>

                            ` + products[$(this).val()] + `
                        </td>
                        <td class="text-end" style="font-size:14px;font-family: math;">` + karat + `</td>
                        <td class="text-end numberonly" style="font-size:14px;font-family: math;">` + weight + `</td>
                        <td class="text-center" style="font-size:14px;font-family: math;">` + jakat_percentage + `
                            <input type="hidden" name="jakat_amount[]" class="jakat_amount" value=""/></td>
                        <td class="text-end total" style="font-size:14px;font-family: math;"></td>
                    </tr>
                `;
                $("#selected_product_list").append(row);
                $("#product_type").val('').trigger('change');
                rowindex++;
            });

            let todayPrice = {!! json_encode($todayRates->pluck('rate', 'name')) !!};

            function handelWeightUpdate(elem) {
                let karat = $(document).find('#' + elem + " .select").val();
                let weight = parseFloat($(document).find('#' + elem + " .weight").val());
                let rate = todayPrice[karat];

                let total = rate * weight;

                let jakatAble = total - (total * 0.20);

                let jakatAmount = jakatAble * (jakat_percentage / 100);
                
                if(jakatAmount){
                    $(document).find('#' + elem + " .total").html(bd_money_format(jakatAmount));
                    let jakatAmountVal = bd_money_format(jakatAmount);
                    jakatAmountVal = jakatAmountVal.replace(/,/g, '');

                    $(document).find('#' + elem + " .jakat_amount").val(jakatAmountVal);
                } else {
                    $(document).find('#' + elem + " .total").html(' ');
                    $(document).find('#' + elem + " .jakat_amount").val('');
                }

                calculateTotal();
            }

            function recalculate()
            {
                $("#selected_product_list").find("tr").each(function() {
                    var row = $(this);
                    // Perform necessary operations with each row
                    handelWeightUpdate(row.attr('id'));
                });
            }

            function calculateTotal() {
                let totalAmount = 0;
                let weightTotal = 0;
                $("#selected_product_list").find("tr").each(function() {
                    var row = $(this);
                    var weight =  parseFloat(row.find('.weight').val());

                    console.log(row.find('.weight').val())

                    if(weight){
                        weightTotal += weight;
                    }
                    var stringWithComma = row.find('.total').html();
                    var stringWithoutComma = stringWithComma.replace(/,/g, '');
                    var parseTotal = parseFloat(stringWithoutComma);
                    if(parseTotal){
                        totalAmount += parseTotal;
                    }
                });
                //
                
                $("#totalAmount").html(bd_money_format(totalAmount));
                $("#weightTotal").html(bd_money_format(weightTotal));
            }
        </script>
    @endpush
    @push('css')
        <style>
            .table-fw {
                width: 100%;
            }

            .table-border {
                border-collapse: collapse !important;
                border-spacing: 0;
            }

            .table-border td,
            .table-border th {
                border: 1px solid #000;
            }

            .table-border td.footer-row {
                border-left: 1px solid transparent;
                border-bottom: 1px solid transparent;
            }
        </style>
    @endpush
</x-admin-layout>
