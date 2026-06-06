<div class="box box-info padding-1">
    <div class="box-body">
        
        <div class="form-group mb-2">
            {{ Form::label('name') }}
            {{ Form::text('name', $user->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 'placeholder' => 'Name']) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-2">
            {{ Form::label('username') }}
            {{ Form::text('username', $user->username, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'placeholder' => 'Username']) }}
            {!! $errors->first('username', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        @hasanyrole('Super Admin')
            <div class="form-group mb-2">
                {{ Form::label('branch') }}
                {{  Form::select('branch_id', $branches, $user->branch_id, ['class' => 'form-control' . ($errors->has('branch_id') ? ' is-invalid' : ''), 'placeholder' => 'Branch']) }}
                {!! $errors->first('branch_id', '<div class="invalid-feedback">:message</p>') !!}
            </div>
        @endhasanyrole
        <div class="form-group mb-2">
            {{ Form::label('email') }}
            {{ Form::text('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-4">
            <div class="form-check form-switch form-switch-lg" dir="ltr">
                <label class="form-check-label" for="SwitchCheckSizelg">{{ __('Status') }}</label>
                <input name="is_active" class="form-check-input" type="checkbox" id="SwitchCheckSizelg"
                    @if (optional($user)->is_active || old('is_active')) checked @endif>
            </div>
        </div>
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>