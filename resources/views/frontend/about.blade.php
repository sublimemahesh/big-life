<x-frontend.layouts.app>
    @section('title', 'About Us - Win Together | Empowering Smart Investments')
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

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{ asset('assets/frontend/images/banner/banner.png') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white banner-txt">About Us</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>About Us </li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB  ROW END -->

        <!-- ABOUT COMPANY SECTION START -->


        <div class="section-full p-tb100 themecolor-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="section-head text-left">
                            <span class="wt-title-subline text-gray-dark font-16 m-b15">What is Win Together</span>
                            <h2 class="text-uppercase">{{ $abouts->title }}</h2>
                            <div class="wt-separator-outer">
                                <div class="wt-separator bg-primary"></div>
                            </div>
                             {!! $abouts->content !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="wt-media">
                            <img src="{{ storage('pages/' . $abouts->image) }} " alt="" class="img-responsive about-pt" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- ABOUT COMPANY SECTION END -->

        <!-- WHY CHOOSE US SECTION START  -->
        <div class="section-full  p-t80 p-b80 themecolor-1">
            <div class="container">
                <!-- TITLE START-->
                <div class="section-head text-center">
                    <h2 class="text-uppercase">Why Choose Win Together</h2>
                    <div class="wt-separator-outer">
                        <div class="wt-separator bg-primary"></div>
                    </div>
                </div>
                <!-- TITLE END-->
                <div class="section-content no-col-gap">
                    <div class="row">

                        <!-- COLUMNS  -->
                        @foreach ($benefits as $key => $section)
                        <div class="col-md-4 col-sm-6 animate_line">
                            <div class="wt-icon-box-wraper  p-a30 center themecolor-2 m-a5">
                                <div class="icon-lg text-primary m-b20">
                                    <a href="" class="icon-cell"><img src="{{ storage('pages/' . $section->image) }}" alt=""></a>
                                </div>
                                <div class="icon-content">
                                    <h4 class="wt-tilte text-uppercase font-weight-500">{{ $section->title }}</h4>
                                    <p>{!! $section->content !!}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <!-- WHY CHOOSE US SECTION END -->
    </div>
    <!-- CONTENT END -->
    @push('scripts')
    <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
