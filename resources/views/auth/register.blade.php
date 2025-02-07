@extends('auth.layouts.auth')
@section('title', 'Register - Win Together | Create Your Investment Account')
@section('styles')
    <style>
        .loader {
            transform: rotateZ(45deg);
            perspective: 1000px;
            border-radius: 50%;
            width: 48px;
            height: 48px;
            color: #fff;
        }

        .loader:before,
        .loader:after {
            content: '';
            display: block;
            position: absolute;
            top: 0;
            left: 0;
            width: inherit;
            height: inherit;
            border-radius: 50%;
            transform: rotateX(70deg);
            animation: 1s spin linear infinite;
        }

        .loader:after {
            color: #FF3D00;
            transform: rotateY(70deg);
            animation-delay: .4s;
        }

        @keyframes rotate {
            0% {
                transform: translate(-50%, -50%) rotateZ(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotateZ(360deg);
            }
        }

        @keyframes rotateccw {
            0% {
                transform: translate(-50%, -50%) rotate(0deg);
            }
            100% {
                transform: translate(-50%, -50%) rotate(-360deg);
            }
        }

        @keyframes spin {
            0%,
            100% {
                box-shadow: .2em 0 0 0 currentcolor;
            }
            12% {
                box-shadow: .2em .2em 0 0 currentcolor;
            }
            25% {
                box-shadow: 0 .2em 0 0 currentcolor;
            }
            37% {
                box-shadow: -.2em .2em 0 0 currentcolor;
            }
            50% {
                box-shadow: -.2em 0 0 0 currentcolor;
            }
            62% {
                box-shadow: -.2em -.2em 0 0 currentcolor;
            }
            75% {
                box-shadow: 0 -.2em 0 0 currentcolor;
            }
            87% {
                box-shadow: .2em -.2em 0 0 currentcolor;
            }
        }

    </style>
@endsection


@section('meta')

        <meta name="description" content="Register with Win Together to start your investment journey. Create an account to access opportunities in stocks, crypto, and gold with expert guidance.">
        <meta name="keywords" content="register, Win Together, create account, investment registration, sign up, crypto trading, stock market, gold investment, financial growth">
        <meta name="author" content="Win Together">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="Register - Win Together | Create Your Investment Account">
        <meta property="og:description" content="Sign up for Win Together and unlock investment opportunities in stocks, crypto, and gold. Start your financial journey today.">
        <meta property="og:url" content="https://www.wintogetherplan.com/register">
        <meta property="og:type" content="website">
        <meta property="og:image" content="https://www.wintogetherplan.com/images/register.jpg">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="Register - Win Together | Create Your Investment Account">
        <meta name="twitter:description" content="Join Win Together today. Register to explore smart investment options in crypto, stocks, and gold.">
        <meta name="twitter:image" content="https://www.wintogetherplan.com/images/register.jpg">

@endsection







@section('contents')

    <div class="row justify-content-center main-register-form-style">
        <div class="col-md-10">
            <div class="authincation-content">
                <div class="row no-gutters">

                    <livewire:auth.register-steps :sponsor="$sponsor"/>

                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="{{ asset('assets/backend/vendor/jquery-mask-plugin/jquery.mask.min.js') }}"></script>
    @endpush
@endsection
