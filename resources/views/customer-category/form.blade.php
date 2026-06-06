<div class="row">
    <div class="col-12 col-md-8">
        
<div class="mb-3 row">
    {{ Form::label('name', __('Name'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        {{ Form::text('name', $customerCategory->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div><div class="mb-3 row">
    {{ Form::label('status', __('Status'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        <div class="form-check form-switch form-switch-lg" dir="ltr">
            <input name="status" class="form-check-input @if ($errors->has('status')) ? ' is-invalid' : '' @endif" type="checkbox" id="Switchsts"
                value="1" @if (isset($customerCategory->status) ? $customerCategory->status : old('status')) checked @endif>
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>