<div class="row">
    <div class="col-12 col-md-8">
        
<div class="mb-3 row">
    {{ Form::label('name', __('Name'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        {{ Form::text('name', $zone->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
        {!! $errors->first('name', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div><div class="mb-3 row">
    {{ Form::label('district_id', __('District Id'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        {{ Form::select('district_id', $districts,$zone->district_id, ['class' => 'select2 form-control' . ($errors->has('district_id') ? ' is-invalid' : ''), 'placeholder' => 'District Id']) }}
        {!! $errors->first('district_id', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div><div class="mb-3 row">
    {{ Form::label('note', __('Note'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        {{ Form::text('note', $zone->note, ['class' => 'form-control' . ($errors->has('note') ? ' is-invalid' : ''), 'placeholder' => 'Note']) }}
        {!! $errors->first('note', '<div class="invalid-feedback">:message</div>') !!}
    </div>
</div><div class="mb-3 row">
    {{ Form::label('status', __('Status'),['class' => 'col-md-3 col-form-label text-end']) }}
    <div class="col-md-9">
        <div class="form-check form-switch form-switch-lg" dir="ltr">
            <input name="status" class="form-check-input @if ($errors->has('status')) ? ' is-invalid' : '' @endif" type="checkbox" id="Switchsts"
                value="1" @if (isset($zone->status) ? $zone->status : old('status')) checked @endif>
            {!! $errors->first('status', '<div class="invalid-feedback">:message</div>') !!}
        </div>
    </div>
</div>
        <div class="box-footer mt20 text-end">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </div>
</div>