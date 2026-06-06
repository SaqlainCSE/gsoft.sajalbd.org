<div class="box box-info padding-1">
    <div class="box-body">
        <div class="form-group mb-2">
            {{ Form::label('name') }}
            {{ Form::text('name', $user->name, [
                'class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : ''), 
                'placeholder' => 'Name'
            ]) }}
            {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-2">
            {{ Form::label('username') }}
            {{ Form::text('username', $user->username, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : ''), 'placeholder' => 'Username']) }}
            {!! $errors->first('username', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-2">
            {{ Form::label('email') }}
            {{ Form::text('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : ''), 'placeholder' => 'Email']) }}
            {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-2">
            {{ Form::label('Role') }}
            {{ Form::select('role', $roles, $user->getRoleNames(), ['class' => 'form-control' . ($errors->has('role') ? ' is-invalid' : ''), 'placeholder' => 'Select User Role']) }}
            {!! $errors->first('role', '<div class="invalid-feedback">:message</p>') !!}
        </div>
        <div class="form-group mb-4">
            <div class="form-check form-switch form-switch-lg" dir="ltr">
                <label class="form-check-label" for="SwitchCheckSizelg">{{ __('Status') }}</label>
                <input name="is_active" class="form-check-input" type="checkbox" id="SwitchCheckSizelg"
                    @if (optional($user)->is_active || old('is_active')) checked @endif>
            </div>
        </div>
        @if(request()->route()->getName() === "users.edit")
            <div class="form-group mb-4">
                <div class="form-check form-switch form-switch-lg" dir="ltr">
                    <label class="form-check-label" for="set_new_password">{{ __('Set New Password') }}</label>
                    <input name="set_new_password" class="form-check-input" type="checkbox" id="set_new_password"
                        @if (optional($user)->set_new_password || old('set_new_password')) checked @endif>
                </div>
            </div>
        @endif
    </div>
    <div class="box-footer mt20">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>