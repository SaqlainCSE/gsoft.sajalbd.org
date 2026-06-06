<x-auth-layout :title="__('Login')">
    <div class="col-md-6 offset-1 offset-sm-2 align-self-center">
        <h3 style="font-size: 44px;font-weight: 700;color: #0f7873;font-family: 'Noto Sans JP', sans-serif">
            {{ __('Welcome Back!') }}</h3>
        <p>{{ __('Please login to your account.') }}</p>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="my-4" :errors="$errors" />

        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="mb-2">
                <x-label for="username" :value="__('Username')" />
                <x-input id="username" type="text" name="username" :value="old('username')" required autofocus
                    :placeholder="__('Enter your username')" />
            </div>
            <div class="mb-2">
                <x-label for="password" :value="__('Password')" />
                <x-input id="password" type="password" name="password" required autocomplete="current-password"
                    :placeholder="__('Enter your password')" />
            </div>

            <div class="row">
                <div class="col">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember_me">
                        <label class="form-label" class="form-check-label" for="remember_me">Remember
                            me</label>
                    </div>
                </div>
                @if (Route::has('password.request'))
                    <div class="col-7">
                        <div class="text-md-end mt-1 mt-md-0">
                            <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i>
                                Forgot your password?</a>
                        </div>
                    </div>
                @endif
            </div>
            <div class="d-grid mt-2">
                <button class="btn btn-primary waves-effect waves-light" type="submit"
                    style="background: #0f7873; border-color:#0f7873;">Log
                    In</button>
            </div>
        </form>
    </div>
</x-auth-layout>
