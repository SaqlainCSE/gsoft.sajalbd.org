<div class="row">
    <div class="col-12 col-md-8">
        
<div class="mb-3 row">
    {{ Form::label('name', __('Name'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        {{ Form::text('name', $role->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div><div class="mb-3 row">
    {{ Form::label('guard_name', __('Guard Name'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        {{ Form::text('guard_name', $role->guard_name, ['class' => 'form-control' . ($errors->has('guard_name') ? ' is-invalid' : ''), 'placeholder' => 'Guard Name']) }}
        {!! $errors->first('guard_name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>