@extends('auth.layouts.auth')
@section('title', 'Login - Win Together | Access Your Investment Account')
@section('meta')
@endsection


@section('contents')

<main class="main">

        <!-- login area -->
        <div class="login-area py-120">
            <div class="container">
                <div class="col-md-5 mx-auto">
                    <div class="login-form">


                        <div class="login-header">
                            <img src="{{ asset('assets/frontend/img/logo/logo.png') }}" alt="">
                            <!-- <h3>Login</h3> -->
                            <p>Login to Your Account</p>
                        </div>

                         @if (session('status'))
                                <div class="mb-4 font-medium text-sm text-success text-green-600">
                                    {{ session('status') }}
                                </div>
                        @endif

                        <x-jet-validation-errors class="mb-4 text-danger" />




                        <form method="POST" action="{{ route('login') }}">
                              @csrf

                            <div class="form-group">
                                <label>{{ __('Username') }}</label>
                                <input id="username"  class="form-control" type="text" name="username" :value="old('username')" required autofocus>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Password') }}</label>
                                <input  class="form-control" id="password" type="password" name="password" required autocomplete="current-password">
                            </div>

                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember me') }}
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="forgot-pass">{{ __('Forgot your password ?') }}</a>
                            </div>
                            <div class="d-flex align-items-center">
                                <button type="submit" class="theme-btn">{{ __('Log in') }} <i class="far fa-sign-in"></i></button>
                            </div>
                        </form>



                        <div class="login-footer">
                            <p>Don't have an account? <a href="{{ route('register') }}">{{ __('Create Your Account ?') }}.</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- login area end -->


    </main>


@endsection
