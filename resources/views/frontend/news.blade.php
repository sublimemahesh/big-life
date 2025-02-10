<x-frontend.layouts.app>
    @section('title', 'News - Win Together | Latest Investment Updates and Insights')
    @section('header-title', 'Welcome ')
    @section('meta')
        <meta name="description" content="Stay updated with the latest news, trends, and insights in the world of investments. Follow Win Together for timely updates on stocks, crypto, and gold.">
        <meta name="keywords" content="news, Win Together, investment news, crypto trends, stock market news, gold investment, financial news, investment updates">
        <meta name="author" content="Win Together">
        <meta name="robots" content="index, follow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- Open Graph / Facebook -->
        <meta property="og:title" content="News - Win Together | Latest Investment Updates and Insights">
        <meta property="og:description" content="Get the latest news and updates from Win Together on stocks, crypto, gold, and the investment market. Stay informed with expert insights.">
        <meta property="og:url" content="https://www.wintogetherplan.com/news">
        <meta property="og:type" content="website">
        <meta property="og:image" content="https://www.wintogetherplan.com/images/news.jpg">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="News - Win Together | Latest Investment Updates and Insights">
        <meta name="twitter:description" content="Read the latest investment news from Win Together, covering trends in stocks, crypto, gold, and the financial markets.">
        <meta name="twitter:image" content="https://www.wintogetherplan.com/images/news.jpg">
    @endsection

    @section('header')
    @include('frontend.layouts.header-other')

    <!-- CONTENT START -->
    <div class="page-content">

        <!-- INNER PAGE BANNER -->
        <div class="wt-bnr-inr overlay-wraper" style="background-image:url({{asset('assets/frontend/images/banner/banner.png') }});">
            <div class="overlay-main themecolor-1 opacity-07"></div>
            <div class="container">
                <div class="wt-bnr-inr-entry">
                    <h1 class="text-white  banner-txt">News</h1>
                </div>
            </div>
        </div>
        <!-- INNER PAGE BANNER END -->

        <!-- BREADCRUMB ROW -->
        <div class="themecolor-1 p-tb20">
            <div class="container">
                <ul class="wt-breadcrumb breadcrumb-style-2">
                    <li><a href="{{ route('/') }}"><i class="fa fa-home"></i> Home</a></li>
                    <li>News</li>
                </ul>
            </div>
        </div>
        <!-- BREADCRUMB ROW END -->

        <!-- SECTION CONTENT START -->
        <div class="section-full p-t80 p-b50 themecolor-2">
            <div class="container">

                <!-- BLOG POST START -->

                @foreach ($all_news as $news)
                <!-- COLUMNS 4 -->
                <div class="blog-post blog-md date-style-1 clearfix">

                    <div class="wt-post-media wt-img-effect zoom-slow">
                        <a href="{{ route('news.show', $news) }}"><img src="{{ storage('blogs/' . $news->image) }}" alt=""></a>
                    </div>
                    <div class="wt-post-info">

                        <div class="wt-post-title ">
                            <h3 class="post-title"><a href="{{ route('news.show', $news) }}">{{ $news->title }}</a></h3>
                        </div>
                        <div class="wt-post-meta ">
                            <ul>
                                <li class="post-date"> <i class="fa fa-calendar"></i><strong>{{ date('d', strtotime($news->created_at)) }} {{ date('M', strtotime($news->created_at)) }}</strong> <span> {{ date('Y', strtotime($news->created_at)) }}</span> </li>
                                <li class="post-author"><i class="fa fa-user"></i><{{ route('news.show','news') }}>By <span>Admin</span></a> </li>
                                <li class="post-comment"><i class="fa fa-comments"></i> <a href="{{ route('news.show','news') }}">0</a> </li>
                            </ul>
                        </div>
                        <div class="wt-post-text">
                            <p>{{ $news->short_description }}</p>
                        </div>
                        <div class="clearfix">
                            <div class="wt-post-readmore pull-left">
                                <a href="{{ route('news.show', $news) }}" title="READ MORE" rel="bookmark" class="site-button-link">Read More</a>
                            </div>
                            <div class="widget_social_inks pull-right">
                                <ul class="social-icons social-radius social-dark m-b0">
                                    <li><a href="javascript:void(0);" class="fa fa-facebook"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-twitter"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-rss"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-youtube"></a></li>
                                    <li><a href="javascript:void(0);" class="fa fa-instagram"></a></li>
                                </ul>
                            </div>
                        </div>


                    </div>

                </div>
                <!-- BLOG POST END -->
                @endforeach
            </div>
        </div>
        <!-- SECTION CONTENT END -->

    </div>
    <!-- CONTENT END -->

</x-frontend.layouts.app>
