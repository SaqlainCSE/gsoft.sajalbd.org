<div class="row">
    <div class="col-12 col-md-8">

        <div class="mb-3 row">
            {{ Form::label('name', __('Name'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('name', $todayRate->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
                {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('rate', __('Rate'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('rate', $todayRate->rate, ['class' => 'form-control' . ($errors->has('rate') ? ' is-invalid' : ''), 'placeholder' => 'Rate']) }}
                {!! $errors->first('rate', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('SwitchCheckSizelg', __('Status'), ['class' => 'col-md-3 form-check-label text-end']) }}
           
            <div class="col-md-9">
                <div class="form-check form-switch form-switch-lg" dir="ltr">
                
                    {!! Form::checkbox('is_active', 1, optional($todayRate)->is_active, [
                        'class' => 'form-check-input',
                        'id' => 'SwitchCheckSizelg',
                    ]) !!}
    
                    {!! $errors->first('is_active', '<div class="invalid-feedback">:message</div>') !!}
                </div>
            </div>
        </div>

        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
