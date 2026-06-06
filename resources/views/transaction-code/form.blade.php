<div class="row">
    <div class="col-12 col-md-8">

        <div class="mb-3 row">
            {{ Form::label('name', __('Name'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('name', $transactionCode->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('type', __('Type'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::select('type', $types,$transactionCode->type, ['class' => 'form-control' . ($errors->has('type') ? ' is-invalid' : ''), 'placeholder' => 'Type']) }}
                {!! $errors->first('type', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('is_active', __('Is Active'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                <div class="col-md-9">
                    <div class="form-check form-switch form-switch-lg" dir="ltr">
                        <input name="is_active"
                            class="form-check-input @if ($errors->has('is_active')) ? ' is-invalid' : '' @endif"
                            type="checkbox" id="Switchsts" value="1"
                            @if (isset($transactionCode->is_active) ? $transactionCode->is_active : old('is_active')) checked @endif>
                        {!! $errors->first('is_active', '<div class="invalid-feedback">:message</div>') !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
