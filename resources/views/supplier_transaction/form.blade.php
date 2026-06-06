<div class="row">
    <div class="col-12 col-md-8">
        <div class="mb-3 row">
            {{ Form::label('reference_no', __('Reference'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('reference_no', $transaction->reference_no, ['class' => 'form-control' . ($errors->has('reference_no') ? ' is-invalid' : ''), 'placeholder' => 'reference no']) }}
                {!! $errors->first('reference_no', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('supplier_id', __('Supplier'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select('supplier_id', $clients, $transaction->supplier_id, ['required' => true, 'id' => 'client', 'class' => 'form-control' . ($errors->has('client') ? ' is-invalid' : ''), 'placeholder' => 'Select supplier']) }}
                {!! $errors->first('supplier_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('description', __('Description'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::textarea('description', $transaction->description, ['class' => 'form-control' . ($errors->has('description') ? ' is-invalid' : ''), 'placeholder' => 'Description', "rows"=>"2"]) }}
                {!! $errors->first('description', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        {{-- <div class="mb-3 row">
            {{ Form::label('advanced', __('Advanced Amount'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('advanced', $transaction->advanced, ['id'=> 'advanced','class' => 'form-control' . ($errors->has('advanced') ? ' is-invalid' : ''), 'placeholder' => 'Advanced Amount']) }}
                {!! $errors->first('advanced', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div> --}}
        <div class="mb-3 row">
            {{ Form::label('bill_amount', __('Bill Amount'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('bill_amount', $transaction->bill_amount, ['id'=> 'bill_amount','class' => 'form-control' . ($errors->has('bill_amount') ? ' is-invalid' : ''), 'placeholder' => 'Bill Amount']) }}
                {!! $errors->first('bill_amount', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('payment_amount', __('Payment Amount'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('payment_amount', $transaction->payment_amount, ['id'=> 'payment_amount', 'class' => 'form-control' . ($errors->has('payment_amount') ? ' is-invalid' : ''), 'placeholder' => 'Payment Amount']) }}
                {!! $errors->first('payment_amount', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('due', __('Due'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9" id="due" style="display: table-cell;line-height: 38px;font-weight: 700;font-size: 18px;">
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
            url: '{{ route('select2.supplier') }}',
            dataType: 'json'
        }
    });

    function calculateDue()
    {
        let bill_amount = parseFloat($("#bill_amount").val());
        let payment_amount = parseFloat($("#payment_amount").val());

        if(isNaN(bill_amount)){ bill_amount = 0 }

        if(isNaN(payment_amount)){ payment_amount = 0 }

        if(bill_amount > 0){
            const due = bill_amount - payment_amount;
            $("#due").html(bd_money_format(due.toFixed(0)));
        }
    }

    $("#bill_amount").on('keyup', function(){
        calculateDue();
    });
    $("#payment_amount").on('keyup', function(){
        calculateDue();
    });
    calculateDue();
</script>
@endpush