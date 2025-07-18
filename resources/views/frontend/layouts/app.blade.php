<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8"/>
        <title>@yield('title')</title>
        <!-- FAVICONS ICON -->
        <link rel="shortcut icon" type="image/png" href="{{asset('assets/backend/images/favicon.png') }}">
        <!-- MOBILE SPECIFIC -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @yield('meta')

        @include('frontend.layouts.style')


        @yield('styles')
    </head>


    <body id="bg">
        @if (config('app.debug'))
            <div id="debug-warning" class="text-center p-2" style="position: fixed;bottom: 0;width: 100%;z-index: 999;background: #eab308;color: black;">
                <strong>⚠ Warning:</strong> The application is currently in <strong>DEBUG MODE</strong>.
                <button type="button" class="border-0 end-0 fa-2x m-2 position-absolute py-1 top-0" aria-label="Close" onclick="document.getElementById('debug-warning').style.display='none';" style="top: 0;right: 1px;">X
                </button>
            </div>
        @endif

        <div class="page-wraper">


        @include('frontend.layouts.header')

            {{ $slot }}

        @include('frontend.layouts.footer')

        </div>
        <!-- Template JS Files -->

        @include('frontend.layouts.script')

        <!-- Wrapper Ends -->

        @yield('scripts')



    </body>

</html>
