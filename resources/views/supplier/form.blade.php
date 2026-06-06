<div class="row">
    <div class="col-12 col-md-8">

        <div class="mb-3 row">
            {{ Form::label('name', __('Name'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('name', $supplier->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('mobile_number', __('Mobile Number'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('mobile_number', $supplier->mobile_number, ['class' => 'form-control' . ($errors->has('mobile_number') ? ' is-invalid' : ''), 'placeholder' => 'Mobile Number']) }}
                {!! $errors->first('mobile_number', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        @if (!$supplier->due_amount)
            <div class="mb-3 row">
                {{ Form::label('due_amount', __('Due Amount'), ['class' => 'col-md-3 col-form-label text-end']) }}
                <div class="col-md-9">
                    {{ Form::text('due_amount', $supplier->due_amount, ['class' => 'form-control' . ($errors->has('due_amount') ? ' is-invalid' : ''), 'placeholder' => 'Due Amount']) }}
                    {!! $errors->first('due_amount', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        @endif
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
