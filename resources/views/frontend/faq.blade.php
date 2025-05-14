<x-frontend.layouts.app>
    @section('title', 'FAQ - Win Together | Answers to Your Investment Questions')
    @section('header-title', 'Welcome')
    @section('meta')

        <meta name="description" content="Find answers to common questions about investing with Win Together. Learn more about our platform, investment process, and available opportunities.">
        <meta name="keywords" content="FAQ, Win Together, frequently asked questions, investment platform, crypto trading, stock market, gold investment, secure investing">
        <meta name="author" content="Win Together">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="FAQ - Win Together | Answers to Your Investment Questions">
        <meta property="og:description" content="Get answers to the most frequently asked questions about investing with Win Together. Learn how our platform helps you grow your financial future.">
        <meta property="og:url" content="https://www.wintogetherplan.com/faq">
        <meta property="og:type" content="website">
        <meta property="og:image" content="https://www.wintogetherplan.com/images/faq.jpg">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="FAQ - Win Together | Answers to Your Investment Questions">
        <meta name="twitter:description" content="Have questions? Find answers to frequently asked questions about investing with Win Together, including platform details and investment options.">
        <meta name="twitter:image" content="https://www.wintogetherplan.com/images/faq.jpg">

    @endsection

    @section('header')
    @include('frontend.layouts.header-other')

    @section('styles')
    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>
    @endsection
    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper"
            style="background-image:url({{asset('assets/frontend/images/banner/banner.png') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white  banner-txt">Frequently Asked Questions</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="javascript:void(0);"><i class="fa fa-home"></i> Home</a></li>
                    <li>Frequently Asked Questions </li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">
                <div class="row">
                    <div class="col-md-9">
                        <!-- TITLE  START -->
                        <div class="p-b30">
                            <h2 class="text-uppercase">FAQ</h2>
                            <div class="wt-separator-outer">
                                <div class="wt-separator bg-primary"></div>
                            </div>
                        </div>
                        <!-- TITLE START -->

                        <!-- ACCORDION START -->
                        <div class="wt-accordion acc-bg-gray" id="accordion5">





                            @foreach ($faqs as $key => $faq)
                            <div id="{{ $key }}">
                                <h3>{{ $faq->title }}</h3>

                                @foreach ($faq->children as $key1 => $child)

                                <div class="panel wt-panel">
                                    <div class="acod-head">
                                        <h3 class="acod-title">
                                            <a data-toggle="collapse" href="#collapseTwo{{ $key}}{{ $key1}}"
                                                class="collapsed" data-parent="#accordion5">
                                                {{ $child->title }}
                                                <span class="indicator"><i class="fa fa-plus"></i></span>
                                            </a>
                                        </h3>
                                    </div>
                                    <div id="collapseTwo{{ $key}}{{ $key1}}" class="acod-body collapse">
                                        <div class="acod-content p-tb15">
                                            {!! html_entity_decode($child->content) !!}
                                        </div>
                                    </div>
                                </div>

                                @endforeach
                            </div>

                            @endforeach
                        </div>
                        <!-- ACCORDION END -->
                    </div>
                    <div class="col-md-3 col-sm-3 p-tb15">
                        <!-- BROCHURES -->
                        <div class="wt-box m-b30 " id="faq-cat-holder">
                            <div class="text-left m-b20">
                                <h4>FAQ Menu</h4>
                                <div class="wt-separator-outer">
                                    <div class="wt-separator bg-primary"></div>
                                </div>
                            </div>


                            @foreach ($faqs as $key => $faq)
                            <div class="wt-icon-box-wraper left bdr-1 bdr-gray p-a15 m-b15">
                                <a href="#{{ $key }}" class="btn-block">
                                    <span class="text-black m-r10"></span>
                                    <strong class="text-uppercase text-black">{{ $faq->title }}</strong>
                                </a>
                            </div>
                            @endforeach


                        </div>

                        <!-- CONTACT US -->
                    </div>
                </div>
            </div>
        </div>
        <!-- SECTION CONTENT END -->

    </div>
    <!-- CONTENT END -->
</x-frontend.layouts.app>
