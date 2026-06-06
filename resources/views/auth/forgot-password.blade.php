<x-auth-layout :title="__('Password Reset')">
    <div class="col-md-6 offset-1 offset-sm-2 align-self-center">
        <h3 style="font-size: 44px;font-weight: 700;color: #0f7873;font-family: 'Noto Sans JP', sans-serif">
            {{ __('Welcome Back!') }}</h3>
        <div class="mb-4 text-sm text-gray-600">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>
        <!-- Validation Errors -->
        <x-auth-validation-errors class="my-4" :errors="$errors" />


        <form class="form-horizontal mt-4" method="POST" action="{{ route('password.email') }}">
            @csrf
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <x-label for="email" :value="__('Email')" />
                        <x-input id="email" type="email" name="email" :value="old('email')" required autofocus />
                    </div>

                    <div class="d-grid mt-4">
                        <button class="btn btn-primary waves-effect waves-light"
                            type="submit">{{ __('Email Password Reset Link') }}</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

</x-auth-layout>
