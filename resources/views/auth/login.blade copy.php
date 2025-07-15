@extends('auth.layouts.auth')
@section('title', 'Login - Win Together | Access Your Investment Account')
@section('meta')

    <meta name="description" content="Log in to your Win Together account to manage your investments in stocks, crypto, and gold. Securely access your investment portfolio anytime.">
    <meta name="keywords" content="login, Win Together, login to account, investment login, secure login, crypto trading, stock market, gold investment">
    <meta name="author" content="Win Together">
    <meta name="robots" content="noindex, nofollow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="Login - Win Together | Access Your Investment Account">
    <meta property="og:description" content="Log in to your Win Together account securely to view and manage your investments in stocks, crypto, and gold.">
    <meta property="og:url" content="https://www.wintogetherplan.com/login">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.wintogetherplan.com/images/login.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Login - Win Together | Access Your Investment Account">
    <meta name="twitter:description" content="Securely log in to your Win Together account to track and manage your investments in crypto, stocks, and gold.">
    <meta name="twitter:image" content="https://www.wintogetherplan.com/images/login.jpg">

@endsection


@section('contents')
    <div class="row justify-content-center main-register-form-style">
        <div class="col-md-6">
            <div class="authincation-content">
                <div class="row no-gutters">
                    <div class="col-xl-12">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <a href="{{ route('/') }}">
                                    <img class="m-auto" src="{{ asset('assets/backend/images/logo/logo-full.png') }}" alt="">
                                </a>
                            </div>
                            <h4 class="text-center mb-4">Login to Your Account</h4>

                            @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-success text-green-600">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <x-jet-validation-errors class="mb-4 text-danger" />

                            <form method="POST" action="{{ route('login') }}">
                                @csrf

                                <div class="col-lg-12  mt-4">
                                    <label class="mb-1" for="email">
                                        <strong class="main-register-form-text">{{ __('Username') }}
                                            <sup class="main-required">*</sup>
                                        </strong>
                                    </label>
                                    <x-jet-input id="username" class="block mt-1 w-full form-control" type="text" name="username" :value="old('username')" required autofocus/>
                                </div>

                                <div class="col-lg-12  mt-4">
                                    <label class="mb-1" for="password">
                                        <strong class="main-register-form-text">{{ __('Password') }}
                                            <sup class="main-required">*</sup>
                                        </strong>
                                    </label>
                                    <x-jet-input id="password" class="block mt-1 w-full form-control" type="password" name="password" required autocomplete="current-password"/>
                                </div>

                                <div class="col-lg-12  mt-4">
                                    <label for="remember_me" class="flex items-center">
                                        <x-jet-checkbox id="remember_me" name="remember"/>
                                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                                    </label>
                                </div>

                                <div class="col-lg-12  mt-4">
                                    <button type="submit" class="btn btn-primary btn-block">{{ __('Log in') }}</button>
                                </div>
                                <div class="col-lg-12  mt-4">
                                    <div class="flex  mt-4">
                                        @if (Route::has('password.request'))
                                            <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                                    href="{{ route('password.request') }}">
                                                {{ __('Forgot your password?') }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-lg-12  mt-4">
                                    <a class="underline text-sm text-gray-600 hover:text-gray-900"
                                            href="{{ route('register') }}">
                                        {{ __('Create Your Account ?') }}
                                    </a>
                                </div>
                            </form>

                            <div class="new-account mt-3">
                                {{-- <p>Already have an account? <a class="text-primary" href="page-login.html">Sign in</a></p> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
