<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="keywords" content="">
        <meta name="author" content="">
        <meta name="robots" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta property="og:title" content="">
        <meta property="og:description" content="">
        <meta property="og:image" content="">
        <meta name="format-detection" content="telephone=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script type="text/javascript">
            const _TOKEN = "{!! csrf_token() !!}"
        </script>
        <!-- PAGE TITLE HERE -->
        <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

        <!-- FAVICONS ICON -->
        <link rel="shortcut icon" type="image/png" href="{{ asset('assets/backend/images/favicon.png') }}">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/app-jetstream.css'])

        <link href="{{ asset('assets/backend/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet">

        @yield('plugin-styles')
        <!-- Style css -->
        <link href="{{ asset('assets/backend/css/style.css?7654444567') }}" rel="stylesheet">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- OWL CAROUSEL STYLE SHEET -->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/owl.carousel.min.css') }}">

        <style>
            img:not(.nav-header .brand-logo, .nav-header .logo-color, .color-title, .swal2-image),
            svg,
            video,
            canvas,
            audio,
            iframe,
            embed,
            object {
                display: unset !important;
            }

            .collapse {
                visibility: unset !important;
            }


            .sidebar-pending-notification {
                position: absolute !important;
                text-align: center !important;
                background-color: #c11515 !important;
                border-radius: 50% !important;
                width: 22px;
                height: 22px;
                top: -7px;
                right: 0;
            }
        </style>

        <!-- Styles -->
        @yield('styles')

        @livewireStyles
        @powerGridStyles
        @livewireScripts

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/plugins/confirmDate/confirmDate.min.css" integrity="sha512-i4miv4uj4m8CwmH7M2HfUr2BXzyLTmexzQi+e27yE+aXivR5iQ2urKV34j3rqNeZcesfmXAtSeLuFuaERTxgEA==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/style.css">


    </head>

    <body class="font-sans antialiased dark" style="background:var(--bg-color)">
        <!--******************* Preloader start ********************-->

        <!--******************* Preloader end ********************-->

        <!--**********************************  Main wrapper start ***********************************-->
        <div id="main-wrapper">
            @if (config('app.debug'))
                <div id="debug-warning"
                     class="fixed bottom-0 left-0 w-full bg-yellow-500 text-black text-center py-2 z-50 shadow-lg">
                    <strong>⚠ Warning:</strong> The application is currently in <strong>DEBUG MODE</strong>.
                    <button onclick="document.getElementById('debug-warning').style.display='none';"
                            class="absolute fs-2 hover:bg-yellow-400 lh-1 px-2 py-0 right-2 text-black top-1">
                        &times;
                    </button>
                </div>
            @endif

            @include('backend.layouts.header')

            @include('backend.' . $folder .'.sidebar')

            <!--********************************** Content body start ***********************************-->
            <div class="content-body">
                <!-- row -->
                <div class="container-fluid">

                    <div class="page-titles">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('/') }}">
                                    <i class="material-icons">home</i>
                                </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ !request()->is('*/dashboard') ? route($folder . '.dashboard') : 'javascript:void(0)' }}">Dashboard</a>
                            </li>
                            @yield('breadcrumb-items')
                        </ol>
                    </div>
                    <div id="alert-container">
                        <x-jet-validation-errors class="alert alert-danger mb-4"/>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('info'))
                            <div class="alert alert-info">
                                {{ session('info') }}
                            </div>
                        @endif
                        @if (session('warning'))
                            <div class="alert alert-warning">
                                {{ session('warning') }}
                            </div>
                        @endif
                    </div>

                    {{ $slot }}

                </div>


            </div>
            <!--**********************************  Footer start   ***********************************-->
            <div class="footer out-footer rounded-3">
                <div class="copyright">
                    <p>© {{ date('Y') }} Win Together. All Rights Reserved.</p>
                </div>
            </div>
            <!--********************************** Footer end  ***********************************-->
            <!--********************************** Content body end ***********************************-->
        </div>
        <!--********************************** Main wrapper end ***********************************-->


        @stack('modals')
        <!--**********************************  Scripts ***********************************-->
        <!-- Required vendors -->
        <script src="{{ asset('assets/backend/vendor/global/global.min.js') }}"></script>

        @powerGridScripts

        <script src="{{ asset('assets/backend/vendor/chart.js/chart.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels/dist/chartjs-plugin-datalabels.min.js"></script>
        <script src="{{ asset('assets/backend/vendor/apexchart/apexchart.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/jquery-nice-select/js/jquery.nice-select.min.js') }}"></script>
        <script src="{{ asset('assets/backend/vendor/swiper/js/swiper-bundle.min.js') }}"></script>

        <!-- Dashboard 1 -->
        <script src="{{ asset('assets/backend/js/custom.js') }}"></script>
        <script src="{{ asset('assets/backend/js/deznav-init.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/plugins/confirmDate/confirmDate.min.js" integrity="sha512-4WKKGGTnWlxFaoURIEl1as1Jv26hz56uc3WZMusBlx7JBO9NjYv7Cq1ThArvJ0fMSEY72YYr0AK0GyJHUC3mvw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/plugins/monthSelect/index.js"></script>
        {{--    <script src="{{ asset('assets/backend/js/dashboard/tradingview-2.js') }}"></script> --}}

        <script src="{{ asset('assets/frontend/js/owl.carousel.min.js') }}"></script><!-- OWL  SLIDER  -->

        @yield('scripts')
        @stack('scripts')
        <!-- Google tag (gtag.js) -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-XNCT9N2XLP"></script>
        <script>

            window.dataLayer = window.dataLayer || [];

            function gtag() {
                dataLayer.push(arguments);
            }

            gtag('js', new Date());

            gtag('config', 'G-XNCT9N2XLP');
        </script>
        <script>
            $(document).ready(function () {
                setTimeout(function () {
                    dzSettingsOptions.version = 'dark';
                    new dzSettings(dzSettingsOptions);
                }, 1500)
            });
        </script>
    </body>

</html>
