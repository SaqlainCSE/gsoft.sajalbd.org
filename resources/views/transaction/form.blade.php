<div class="row">
    <div class="col-12 col-md-8">
        <div class="mb-3 row">
            {{ Form::label('cash_memo_no', __('Cash Memo No'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('cash_memo_no', $transaction->cash_memo_no, ['class' => 'form-control' . ($errors->has('cash_memo_no') ? ' is-invalid' : ''), 'placeholder' => 'Cash Memo No']) }}
                {!! $errors->first('cash_memo_no', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('client_id', __('Client'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select('client_id', $clients, $transaction->client_id, ['required' => true, 'id' => 'client', 'class' => 'form-control' . ($errors->has('client') ? ' is-invalid' : ''), 'placeholder' => 'Select client']) }}
                {!! $errors->first('client_id', '<div class="invalid-feedback">:message</div>') !!}
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
            {{ Form::label('advance', __('Advance Amount'),['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('advance', $transaction->advance, ['id'=> 'advance','class' => 'form-control' . ($errors->has('advance') ? ' is-invalid' : ''), 'placeholder' => 'Advance Amount']) }}
                {!! $errors->first('advance', '<div class="invalid-feedback">:message</div>') !!}
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
            url: '{{ route('select2.client') }}',
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

</script>
@endpush