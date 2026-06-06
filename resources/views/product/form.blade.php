<div class="row">
    <div class="col-12 col-md-8">
        <div class="mb-3 row">
            {{ Form::label('purchase_date', __('Purchase Date'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::date(
                    'purchase_date',
                    optional($product->purchase_date)->format('Y-m-d'),
                    ['class' => 'form-control' . ($errors->has('purchase_date') ? ' is-invalid' : '')]
                ) }}
                {!! $errors->first('purchase_date', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('product_nr', __('Product Nr'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('product_nr', $product->product_nr, ['class' => 'form-control' . ($errors->has('product_nr') ? ' is-invalid' : ''), 'placeholder' => 'Product Nr']) }}
                {!! $errors->first('product_nr', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('product_details', __('Product Details'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('product_details', $product->product_details, ['class' => 'form-control' . ($errors->has('product_details') ? ' is-invalid' : ''), 'placeholder' => 'Product Details']) }}
                {!! $errors->first('product_details', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="mb-3 row">
            {{ Form::label('product_category_id', __('Product Category'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {!! Form::select('product_category_id', $categories, $product->product_category_id, [
                    'class' => 'form-control' . ($errors->has('product_category_id') ? ' is-invalid' : ''),
                    'placeholder' => 'Select Category',
                ]) !!}
                {!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('type', __('Product Type'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {!! Form::select('type', ['gold' => 'Gold', 'diamond' => 'Diamond'], $product->type, [
                    'class' => 'form-control' . ($errors->has('type') ? ' is-invalid' : ''),
                    'placeholder' => 'Select Type',
                ]) !!}
                {!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="mb-3 row">
            {{ Form::label('weight', __('Weight'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                <div class="row">
                    <div class="col-6">
                        {{ Form::text('weight', $product->weight, ['class' => 'col-6  form-control' . ($errors->has('weight') ? ' is-invalid' : ''), 'placeholder' => 'Weight']) }}
                    </div>
                    <div class="col-6">
                        {!! Form::select('carat', ['18' => '18K', '21' => '21K', '22' => '22K'], $product->carat, [
                            'class' => 'form-control' . ($errors->has('carat') ? ' is-invalid' : ''),
                            'placeholder' => 'Select carat',
                        ]) !!}
                    </div>
                </div>
                {!! $errors->first('weight', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        {{-- <div class="mb-3 row">
            {{ Form::label('price', __('Price'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('price', $product->price, ['class' => 'form-control' . ($errors->has('price') ? ' is-invalid' : ''), 'placeholder' => 'Price']) }}
                {!! $errors->first('price', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div> --}}
        <div class="mb-3 row">
            {{ Form::label('qty', __('Quantity'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('qty', $product->qty, ['class' => 'form-control number_only' . ($errors->has('qty') ? ' is-invalid' : '')]) }}
                {!! $errors->first('qty', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('st_dia', __('St/Dia'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('st_dia', $product->st_dia, ['class' => 'form-control number_only' . ($errors->has('st_dia') ? ' is-invalid' : '')]) }}
                {!! $errors->first('st_dia', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('st_dia_price', __('ST/Dia Price'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('st_dia_price', $product->st_dia_price, ['class' => 'form-control' . ($errors->has('st_dia_price') ? ' is-invalid' : ''), 'placeholder' => 'St/dia price']) }}
                {!! $errors->first('st_dia_price', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>

        <div class="mb-3 row">
            {{ Form::label('wage', __('Wage'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                <div class="row">
                    <div class="col-6">
                        {{ Form::text('wage', $product->wage, ['class' => 'form-control' . ($errors->has('wage') ? ' is-invalid' : ''), 'placeholder' => 'Wage']) }}
                        {!! $errors->first('wage', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                    <div class="col-6">
                        {{ Form::select('wage_type', ['Percentage' => 'Percentage', 'Fixed' => 'Fixed'], $product->wage_type, ['class' => 'form-control' . ($errors->has('wage_type') ? ' is-invalid' : ''), 'placeholder' => 'Select Wage Type']) }}
                        {!! $errors->first('wage_type', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('supplier_id', __('Supplier'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select('supplier_id', $suppliers, $product->supplier_id, ['class' => 'select2 form-control' . ($errors->has('supplier_id') ? ' is-invalid' : ''), 'placeholder' => 'Supplier']) }}
                {!! $errors->first('supplier_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('purchase_price', __('Purchase Price'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('purchase_price', $product->purchase_price, ['class' => 'form-control' . ($errors->has('purchase_price') ? ' is-invalid' : ''), 'placeholder' => 'Purchase Price']) }}
                {!! $errors->first('purchase_price', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('stock_type', __('Stock Type'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select(
                    'stock_type',
                    ['NEW STOCK' => 'NEW STOCK', 'EXCHANGE' => 'EXCHANGE', 'OLD GOLD' => 'OLD GOLD', 'S. RETURN' => 'S. RETURN'],
                    $product->stock_type,
                    [
                        'class' => 'select2 form-control' . ($errors->has('stock_type') ? ' is-invalid' : ''),
                    ],
                ) }}
                {!! $errors->first('stock_type', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
