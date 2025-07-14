<x-frontend.layouts.app>
    @section('title', 'Win Together - Your Gateway to Smart Investments | wintogetherplan.com')
    @section('header-title', 'Welcome ')

    @section('meta')
    @endsection

    @section('header')
    @include('frontend.layouts.header')
    @endsection

    <!-- CONTENT START -->

    <main class="main">

        <!-- hero area -->
        <div class="hero-section">
            <div class="hero-wrapper">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-6 col-lg-6">
                            <div class="hero-content">
                                <h6 class="hero-sub-title wow animate__animated animate__fadeInUp"
                                    data-wow-duration="1s" data-wow-delay=".25s">
                                    Safe and secure investment
                                </h6>
                                <h1 class="hero-title wow animate__animated animate__fadeInUp" data-wow-duration="1s"
                                    data-wow-delay=".50s">
                                    Best Hyip Investment <span>Solutions</span> For You
                                </h1>
                                <p class="wow animate__animated animate__fadeInUp" data-wow-duration="1s"
                                    data-wow-delay=".75s">
                                    There are many variations of passages available but the majority have suffered
                                    alteration in some form by injected humour or randomised words.
                                </p>
                                <div class="hero-btn wow animate__animated animate__fadeInUp" data-wow-duration="1s"
                                    data-wow-delay="1s">
                                    <a href="index.html#" class="theme-btn">Get Started</a>
                                    <div class="video-btn">
                                        <a href="https://www.youtube.com/watch?v=jLS3DrTJrpI"
                                            class="play-btn popup-youtube"><i class="fas fa-play"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="hero-img wow animate__animated animate__fadeInRight"
                            data-wow-duration="1s" data-wow-delay=".25s">
                                <img src="assets/img/hero/hero.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="hero-shape">
                    <img src="assets/img/shape/shape-1.svg" alt="">
                </div>
            </div>
        </div>
        <!-- hero area end -->






        <!-- about area -->
        <div class="about-area py-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left">
                            <div class="about-img">
                                <img src="{{ storage('pages/' . $welcome->image) }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline">Welcome</span>
                                <h2 class="site-title">{{ $welcome->title }}</h2>
                            </div>
                                <div> {!! $welcome->content !!}</div>
                            <a href="{{ route('about') }}" class="theme-btn">Discover More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->


        <!-- choose area -->
        <div class="choose-area py-120">
            <div class="container">
                <div class="row align-items-center">

                     <div class="col-lg-12">
                        <div class="choose-content">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline">Our Benefit</span>
                                <h2 class="site-title my-3">Invest For Your <span>Future In Best</span> Platform</h2>
                            </div>
                            <div>
                                 {!! $benefits->content !!}
                            </div>

                        </div>
                    </div>

                </div>

                <div class="row">

                    <div class="col-lg-6">
                        <div class="choose-content">

                            <ul>

                                 @foreach ($benefits?->children as $key => $section)
                                    @if ($key % 2 == 0)

                                        <li>
                                            <div class="choose-content-wrapper">
                                                <i class="flaticon-management"></i>
                                                <div class="choose-content-item">
                                                    <h5>{{ $section->title }}</h5>
                                                        {!! $section->content !!}
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>

                        </div>
                    </div>

                      <div class="col-lg-6">
                        <div class="choose-content">

                            <ul>

                              @foreach ($benefits?->children as $key => $section)
                                    @if ($key % 2 != 0)
                                        <li>
                                            <div class="choose-content-wrapper">
                                                <i class="flaticon-management"></i>
                                                <div class="choose-content-item">
                                                    <h5>{{ $section->title }}</h5>
                                                    {!! $section->content !!}
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach

                            </ul>
                            <a href="index.html#" class="theme-btn">Get Started</a>
                        </div>
                    </div>

                </div>


                    <div class="col-lg-6">
                        <div class="choose-img">
                            <img src="assets/img/choose/01.png" alt="">
                        </div>
                    </div>

            </div>
        </div>
        <!-- choose area end -->


        <!-- process area -->
        <div class="process-area pb-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Working Process</span>
                            <h2 class="site-title">How It <span>Works</span></h2>
                            <div class="heading-divider"></div>
                                <div>{!! html_entity_decode($how_it_work->content) !!}</div>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-between">

                     @foreach ($how_it_work->children as $key => $section)
                        <div class="col-lg-3 col-md-6 text-center mb-30">
                            <div class="process-single">
                                <div class="icon">
                                    <span>{{ $key+1 }}</span>
                                    <i class="flaticon-management"></i>
                                </div>
                                <h4>{{ $section->title }}</h4>
                                <div>{!! html_entity_decode($section->content) !!}</div>
                            </div>
                        </div>
                     @endforeach

                </div>
            </div>
        </div>
        <!-- process area end -->

        <!-- cta area -->
        <div class="cta-area">
            <div class="container">
                <div class="row">
                    <div class="cta-content">
                        <h5>We Offer More Commission</h5>
                        <h2>Get <span>45%</span> Referral Commission</h2>
                        <p>It is a long established fact that a reader will be distracted by the readable content <br> of a page when looking at its layout.</p>
                        <a href="index.html#" class="theme-btn">Get Started</a>
                    </div>
                </div>
            </div>
            <div class="cta-shape">
                <img src="{{ asset('assets/frontend/img/shape/shape-3.png') }}" alt="">
            </div>
        </div>
        <!-- cta area end -->


    </main>



    <!-- CONTENT END -->


    @section('scripts')



    @endsection

</x-frontend.layouts.app>
