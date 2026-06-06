<x-admin-layout :title="__('Profile')">
    <div class="page-content">
        <div class="container-fluid">
            <x-toast-message />
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title ">User Profile</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Profile Information</h5>
                                    <p>Update your account's profile information and email address</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <form class="card-body" action="{{ route('update_info') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <h5 class="card-title">Photo</h5>
                                                <p class="card-text">
                                                    <img class="rounded-circle" alt="200x200"
                                                        src="assets/images/users/avatar-4.jpg"
                                                        data-holder-rendered="true">
                                                </p>
                                            </div>
                                            <div class="form-group">
                                                <label class="card-title">Name</label>
                                                <div class="input-group">
                                                    {{ Form::text('name', $user->name, ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : '')]) }}
                                                    {!! $errors->first('name', '<div class="invalid-feedback">:message</p>') !!}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="card-title">Email</label>
                                                <div class="input-group">
                                                    {{ Form::text('email', $user->email, ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : '')]) }}
                                                    {!! $errors->first('email', '<div class="invalid-feedback">:message</p>') !!}
                                                </div>
                                            </div>
                                            <p class="card-text mt-2"
                                                style="display: flex;justify-content: space-between;align-items: center;">
                                                <small class="text-muted">Last updated {{ $user->updated_at->diffForHumans() }}</small>
                                                <button type="submit" class="btn btn-primary text-end">SAVE</button>
                                            </p>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Update Secrect</h5>
                                    <p>Update your account's username and password</p>
                                </div>
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <form class="card-body" action="{{ route('update_password') }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                                <label class="card-title">Username</label>
                                                <div class="input-group">
                                                    {{ Form::text('username', $user->username, ['class' => 'form-control' . ($errors->has('username') ? ' is-invalid' : '')]) }}
                                                    {!! $errors->first('username', '<div class="invalid-feedback">:message</p>') !!}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="card-title">Old Password</label>
                                                <div class="input-group">
                                                    {{ Form::password('old_password', ['class' => 'form-control' . ($errors->has('old_password') ? ' is-invalid' : '')]) }}
                                                    {!! $errors->first('old_password', '<div class="invalid-feedback">:message</p>') !!}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="card-title">New Password</label>
                                                <div class="input-group">
                                                    {{ Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : '')]) }}
                                                    {!! $errors->first('password', '<div class="invalid-feedback">:message</p>') !!}
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="card-title">Confirm Password</label>
                                                <div class="input-group">
                                                    {{ Form::password('password_confirmation', ['class' => 'form-control' . ($errors->has('password_confirmation') ? ' is-invalid' : '')]) }}
                                                    {!! $errors->first('password_confirmation', '<div class="invalid-feedback">:message</p>') !!}
                                                </div>
                                            </div>

                                            <p class="card-text mt-2"
                                                style="display: flex;justify-content: space-between;align-items: center;">
                                                <small class="text-muted">Last updated {{ $user->updated_at->diffForHumans() }}</small>
                                                <button type="submit" class="btn btn-primary text-end">CHANGE</button>
                                            </p>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</x-admin-layout>
