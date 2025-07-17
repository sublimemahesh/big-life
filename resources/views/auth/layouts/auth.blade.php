<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
     <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="{{asset('assets/backend/images/favicon.png') }}">
    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @yield('meta')

    @include('frontend.layouts.style')

    <script type="text/javascript">
            const _TOKEN = "{!! csrf_token() !!}"
    </script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/css/app-jetstream.css'])
    {{-- <link href="{{ asset('assets/backend/vendor/swiper/css/swiper-bundle.min.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/backend/vendor/jquery-nice-select/css/nice-select.css') }}" rel="stylesheet"> --}}
    {{-- <link href="{{ asset('assets/backend/css/style.css') }}" rel="stylesheet"> --}}

    @yield('plugin-styles')
    <!-- Style css -->
    <link href="{{ asset('assets/backend/css/style-user.css?7654444567') }}" rel="stylesheet">
    <!-- Fonts -->

    @livewireStyles
    @powerGridStyles
    @livewireScripts

    @yield('styles')

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @yield('styles')
    @livewireStyles
    @livewireScripts

</head>


<body id="bg">
    @if (config('app.debug'))
    <div id="debug-warning" class="text-center p-2" style="position: fixed;bottom: 0;width: 100%;z-index: 999;background: #eab308;color: black;">
        <strong>⚠ Warning:</strong> The application is currently in <strong>DEBUG MODE</strong>.
        <button type="button" class="border-0 end-0 fa-2x m-2 position-absolute py-1 top-0" aria-label="Close" onclick="document.getElementById('debug-warning').style.display='none';" style="top: 0;right: 1px;">X
        </button>
    </div>
    @endif
<main class="main">
    <div class="dashboard-area py-120">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4">
                    @include('auth.layouts.sidebar')
                </div>
                <div class="col-lg-9 col-md-8">
                    <div class="dashboard-content">

                        @include('auth.layouts.header')


                        @yield('contents')

                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


    <!-- Template JS Files -->

    @include('frontend.layouts.script')

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

        <!-- Wrapper Ends -->

     @stack('scripts')



</body>

</html>
