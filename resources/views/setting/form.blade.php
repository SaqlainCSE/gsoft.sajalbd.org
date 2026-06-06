<div class="row">
    <div class="col-12 col-md-8">
        <div class="mb-3 row">
            {{ Form::label('company_name', __('Company Name'), ['class' => 'col-md-3 col-form-label text-end required']) }}
            <div class="col-md-9">
                {{ Form::text('company_name', setting('company_name'), ['class' => 'form-control' . ($errors->has('company_name') ? ' is-invalid' : ''), 'placeholder' => __('Company Name'), 'required' => true]) }}
                {!! $errors->first('company_name', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('company_cell', __('Company Cell'), ['class' => 'col-md-3 col-form-label text-end required']) }}
            <div class="col-md-9">
                {{ Form::text('company_cell', setting('company_cell'), ['class' => 'form-control' . ($errors->has('company_cell') ? ' is-invalid' : ''), 'placeholder' => __('Company Cell'), 'required' => true]) }}
                {!! $errors->first('company_cell', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('bin', __('BIN'), ['class' => 'col-md-3 col-form-label text-end required']) }}
            <div class="col-md-9">
                {{ Form::text('bin', setting('bin'), ['class' => 'form-control' . ($errors->has('bin') ? ' is-invalid' : ''), 'placeholder' => __('Invoice Prefix'), 'required' => true]) }}
                {!! $errors->first('bin', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="mb-3 row">
            {{ Form::label('jakat_percentage', __('jakat(%)'), ['class' => 'col-md-3 col-form-label text-end required']) }}
            <div class="col-md-9">
                {{ Form::text('jakat_percentage', setting('jakat_percentage'), ['class' => 'form-control' . ($errors->has('jakat_percentage') ? ' is-invalid' : ''), 'placeholder' => __('Jakat(%)'), 'required' => true]) }}
                {!! $errors->first('jakat_percentage', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
