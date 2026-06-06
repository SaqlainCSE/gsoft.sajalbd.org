<div class="row">

    @if (request()->type === 'sale')
        {!! Form::hidden('trx_type', 'out') !!}
        {!! Form::hidden('type', \App\Models\Stock::TYPE_SALE) !!}
    @endif

    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('date', __('Date'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::date('date', $stock->date, [
                    'class' => 'form-control' . ($errors->has('date') ? ' is-invalid' : ''),
                    'placeholder' => 'Date',
                    'required' => true,
                ]) }}
                {!! $errors->first('date', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('memo', __('Memo'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('memo', $stock->memo, [
                    'class' => 'form-control' . ($errors->has('memo') ? ' is-invalid' : ''),
                    'placeholder' => 'Memo',
                    'required' => true,
                ]) }}
                {!! $errors->first('memo', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('unit_18k', __('Unit 18K'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('unit_18k', $stock->unit_18k, ['class' => 'form-control' . ($errors->has('unit_18k') ? ' is-invalid' : ''), 'placeholder' => 'Unit 18K']) }}
                {!! $errors->first('unit_18k', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('unit_21k', __('Unit 21K'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('unit_21k', $stock->unit_21k, ['class' => 'form-control' . ($errors->has('unit_21k') ? ' is-invalid' : ''), 'placeholder' => 'Unit 21K']) }}
                {!! $errors->first('unit_21k', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('unit_22k', __('Unit 22K'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('unit_22k', $stock->unit_22k, ['class' => 'form-control' . ($errors->has('unit_22k') ? ' is-invalid' : ''), 'placeholder' => 'Unit 22K']) }}
                {!! $errors->first('unit_22k', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('st', __('St'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('st', $stock->st, ['class' => 'form-control' . ($errors->has('st') ? ' is-invalid' : ''), 'placeholder' => 'St']) }}
                {!! $errors->first('st', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('d18k', __('D18K'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('d18k', $stock->d18k, ['class' => 'form-control' . ($errors->has('d18k') ? ' is-invalid' : ''), 'placeholder' => 'D18K']) }}
                {!! $errors->first('d18k', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="mb-3 row">
            {{ Form::label('dia', __('Dia'), ['class' => 'col-md-3 col-form-label text-end']) }}
            <div class="col-md-9">
                {{ Form::text('dia', $stock->dia, ['class' => 'form-control' . ($errors->has('dia') ? ' is-invalid' : ''), 'placeholder' => 'Dia']) }}
                {!! $errors->first('dia', '<div class="invalid-feedback">:message</div>') !!}
            </div>
        </div>
    </div>
    <div class="col-12 col-md-12">
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>
