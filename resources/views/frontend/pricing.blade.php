<x-frontend.layouts.app>
    @section('title', 'Our Investment Packages - Win Together | Explore Smart Investment Options')
    @section('header-title', 'Welcome ')
    @section('meta')

        <meta name="description" content="Learn about Win Together's mission to make investing accessible to everyone. Join us to explore investment opportunities in stocks, crypto, and gold.">
        <meta name="keywords" content="About Win Together, investment platform, crypto trading, stock market, gold investment, secure investing, financial growth">
        <meta name="author" content="Win Together">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="About Us - Win Together | Empowering Smart Investments">
        <meta property="og:description" content="Discover how Win Together is making investments accessible for all. Join us and grow your financial future.">
        <meta property="og:url" content="https://www.wintogetherplan.com/about-us">
        <meta property="og:type" content="website">
        <meta property="og:image" content="https://www.wintogetherplan.com/images/about-us.jpg">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="About Us - Win Together | Empowering Smart Investments">
        <meta name="twitter:description" content="Win Together is dedicated to helping individuals invest in stocks, crypto, and gold. Learn more about our mission.">
        <meta name="twitter:image" content="https://www.wintogetherplan.com/images/about-us.jpg">

    @endsection

    @section('header')
        @include('frontend.layouts.header-other')
    @endsection

    @section('styles')
        <link href="{{ asset('assets/frontend/css/pricing.css') }}" rel="stylesheet">
        <!-- BOOTSTRAP STYLE SHEET -->
    @endsection

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{asset('assets/frontend/images/banner/banner.png') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white  banner-txt">Packages</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li>
                        <a href="{{ route('/') }}"><i class="fa fa-home"></i> Home</a>
                    </li>
                    <li>Packages</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">
                <div class="row">
                    @foreach ($packages as $package)
                        <div class="col-sm-4">
                            <div class="card text-center">
                                <div class="title">
                                    <img src="{{asset('assets/frontend/images/tether-usdt-icon.svg') }}" class="img-pricin">
                                    <h2>{{ $package->name }}</h2>
                                </div>
                                <div class="price">
                                    <h4><sup class='price-txt'>{{ $package->currency }}</sup>{{ $package->amount }}</h4>
                                </div>
                                <div class="option">
                                    <ul>
                                        <li><i class="fa fa-check" aria-hidden="true"></i>Within Investment Period</li>
                                        <li><i class="fa fa-check" aria-hidden="true"></i>Gas Fee USDT {{ $package->gas_fee }}</li>
                                        <li><i class="fa fa-check" aria-hidden="true"></i>{{-- {{ $package->daily_leverage }}--}} 0.4% - 1.3% Daily Profit</li>
                                    </ul>
                                </div>
                                <a href="{{ route('user.packages.index') }}">Order Now</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <!-- SECTION CONTENT END -->
        </div>
    </div>
    <!-- CONTENT END -->


</x-frontend.layouts.app>
