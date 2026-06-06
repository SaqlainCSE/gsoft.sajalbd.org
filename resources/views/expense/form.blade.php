<div class="row">
    <div class="col-12 col-md-8 mx-auto">
        <div class="row">
            <div class="col-md-6">
                {{ Form::label('date', __('Date'), ['class' => 'col-form-label']) }}
                {{ Form::date('date', $expense->date, [
                    'class' => 'form-control' . ($errors->has('date') ? ' is-invalid' : ''),
                    'placeholder' => 'Date',
                ]) }}
                {!! $errors->first('date', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="col-md-6">
                {{ Form::label('expense_by_id', __('Expense By'), ['class' => 'col-form-label']) }}
                {{ Form::select('expense_by_id', $users, $expense->expense_by_id, [
                    'class' => 'form-control' . ($errors->has('expense_by_id') ? ' is-invalid' : ''),
                    'placeholder' => 'Select user',
                    'id' => 'expense_by_id',
                ]) }}
                {!! $errors->first('expense_by_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="col-md-6">
                {{ Form::label('amount', __('Amount'), ['class' => 'col-form-label']) }}
                {{ Form::text('amount', $expense->amount, ['class' => 'form-control' . ($errors->has('amount') ? ' is-invalid' : ''), 'placeholder' => 'Amount']) }}
                {!! $errors->first('amount', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="col-md-6">
                {{ Form::label('trx_head_id', __('Expense Head'), ['class' => 'col-form-label']) }}
                {{ Form::select('trx_head_id', $expense_head, $expense->trx_head_id, [
                    'class' => 'form-control' . ($errors->has('trx_head_id') ? ' is-invalid' : ''),
                    'placeholder' => 'Select Head',
                    'id' => 'trx_head_id',
                ]) }}
                {!! $errors->first('trx_head_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="col-md-6">
                {{ Form::label('payment_method_id', __('Payment Method'), ['class' => 'col-form-label']) }}
                {{ Form::select('payment_method_id', $payment_methods, $expense->payment_method_id, [
                    'class' => 'form-control' . ($errors->has('payment_method_id') ? ' is-invalid' : ''),
                    'placeholder' => 'Select Payment Method',
                    'id' => 'payment_method_id',
                ]) }}
                {!! $errors->first('payment_method_id', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            <div class="col-md-6">
                {{ Form::label('reference_no', __('Reference No'), ['class' => 'col-form-label']) }}
                {{ Form::text('reference_no', $expense->reference_no, ['class' => 'form-control' . ($errors->has('reference_no') ? ' is-invalid' : ''), 'placeholder' => 'Reference No']) }}
                {!! $errors->first('reference_no', '<div class="invalid-feedback">:message</div>') !!}
            </div>
            

            <div class="mb-3 col-md-12">
                {{ Form::label('note', __('Note'), ['class' => 'col-form-label']) }}
                {{ Form::text('note', $expense->note, ['class' => 'form-control' . ($errors->has('note') ? ' is-invalid' : ''), 'placeholder' => 'Note']) }}
                {!! $errors->first('note', '<div class="invalid-feedback">:message</div>') !!}
            </div>

            <div class="box-footer mt20 text-end">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>


@push('js')
<script>
    $('#expense_by_id').select2();
    $('#payment_method_id').select2();
    $('#trx_head_id').select2();
</script>
@endpush