<x-frontend.layouts.app>
    @section('title', 'How It Works - Win Together | Easy Steps to Start Investing')
    @section('header-title', 'Welcome ')

    @section('meta')
    <meta name="description" content="Learn how Win Together makes investing in stocks, crypto, and gold easy. Follow our simple steps to start your investment journey and grow your wealth.">
    <meta name="keywords" content="how it works, Win Together, investment process, crypto trading, stock market, gold investment, secure investing, financial growth">
    <meta name="author" content="Win Together">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Open Graph / Facebook -->
    <meta property="og:title" content="How It Works - Win Together | Easy Steps to Start Investing">
    <meta property="og:description" content="Understand the simple steps of how Win Together works. Start investing in stocks, crypto, and gold with our user-friendly platform.">
    <meta property="og:url" content="https://www.wintogetherplan.com/how-it-works">
    <meta property="og:type" content="website">
    <meta property="og:image" content="https://www.wintogetherplan.com/images/how-it-works.jpg">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="How It Works - Win Together | Easy Steps to Start Investing">
    <meta name="twitter:description" content="Start your investment journey with Win Together. Learn how our simple process makes investing in crypto, stocks, and gold accessible to everyone.">
    <meta name="twitter:image" content="https://www.wintogetherplan.com/images/how-it-works.jpg">
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
                    <h1 class="text-white  banner-txt">How it work</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>How it work</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB  ROW END -->

        <!-- HOW IT WORK  SECTION START -->
        <div class="section-full p-tb100 themecolor-2">
            <div class="container ">
                <div class="container ">
                    <!-- TITLE START-->
                    <div class="section-head text-center">

                        <p>wintogetherplan.com is a forex and cryptocurrency trading investment site that offers an opportunity
                            for investors to participate in trading activities and potentially earn a profit share.
                            Here's how it works:</p>
                        <div class="wt-separator-outer">
                            <div class="wt-separator bg-primary"></div>
                        </div>
                    </div>
                    <!-- TITLE END-->
                    <div class="section-content no-col-gap">
                        <div class="row">

                            @foreach ($how_it_work as $key => $section)
                            @if ($key%2 == 0)
                            <!-- COLUMNS 1 -->

                            <div class="col-md-12 col-sm-12 step-number-block hiw-cart-mb">
                                <div class="wt-icon-box-wraper  p-a30 center themecolor-1 m-a5">

                                    <div class="icon-content">
                                        <div class="step-number2">{{ $key+1 }}</div>
                                        <h4 class="wt-tilte text-uppercase font-weight-500">{{ $section->title }}</h4>
                                        <div class="hwt-content cml-60">
                                        {!! html_entity_decode($section->content) !!}
                                       </div>
                                    </div>
                                </div>
                            </div>

                            @else
                            <!-- COLUMNS 2 -->
                            <div class="col-md-12 col-sm-12 step-number-block hiw-cart-mb">
                                <div class="wt-icon-box-wraper  p-a30 center themecolor-3 m-a5 ">

                                    <div class="icon-content text-white">
                                        <div class="step-number2 active">{{ $key+1 }}</div>
                                        <h4 class="wt-tilte text-uppercase font-weight-500">{{ $section->title }}</h4>
                                        <div class="hwt-content">
                                        {!! html_entity_decode($section->content) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach


                        </div>
                    </div>

                </div>


            </div>
        </div>

        <!-- HOW IT WORK SECTION END -->


    </div>
    <!-- CONTENT END -->




    @push('scripts')
    <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
