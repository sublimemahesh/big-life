<x-frontend.layouts.app>
    @section('title', 'About Us - Win Together | Empowering Smart Investments')
    @section('header-title', 'Welcome ')

    @section('meta')

    @endsection

    @section('header')
    @include('frontend.layouts.header-other')


    <!-- CONTENT START -->

        <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb">
            <div class="container">
                <h2 class="breadcrumb-title">About Us</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html"><i class="far fa-home"></i> Home</a></li>
                    <li class="active">About Us</li>
                </ul>
            </div>
            <div class="breadcrumb-shape">
                <img src="assets/img/shape/shape-5.svg" alt="">
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- about area -->
        <div class="about-area py-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="about-left">
                            <div class="about-img">
                                <img src="assets/img/about/01.png" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline">About Us</span>
                                <h2 class="site-title">We Offer Best <span>Investment Solutions</span> For Your Profit
                                </h2>
                            </div>
                            <p class="about-text">There are many variations of passages of Lorem Ipsum available,
                                but the majority have suffered alteration in some form, by injected humour, or
                                randomised words which don't look even.</p>
                            <div class="about-list-wrapper">
                                <ul class="about-list list-unstyled">
                                    <li>
                                        <div class="icon"><span class="fas fa-check-circle"></span></div>
                                        <div class="text">
                                            <p>Take a look at our round up of the best shows</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon"><span class="fas fa-check-circle"></span></div>
                                        <div class="text">
                                            <p>It has survived not only five centuries</p>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="icon"><span class="fas fa-check-circle"></span></div>
                                        <div class="text">
                                            <p>Lorem Ipsum has been the ndustry standard dummy text</p>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <a href="about.html" class="theme-btn">Discover More</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->



        <!-- counter area -->
        <div class="counter-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon"><i class="flaticon-reward"></i></div>
                            <div><span class="counter" data-count="+" data-to="500" data-speed="3000">500</span><span
                                    class="counter-sign">K</span></div>
                            <h6 class="title">Active Members</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon"><i class="flaticon-graph"></i></div>
                            <div><span class="counter" data-count="+" data-to="150" data-speed="3000">150</span><span
                                    class="counter-sign">M</span></div>
                            <h6 class="title">Total Deposit</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon"><i class="flaticon-wallet"></i></div>
                            <div><span class="counter" data-count="+" data-to="120" data-speed="3000">120</span><span
                                    class="counter-sign">M</span></div>
                            <h6 class="title">Total Withdraw</h6>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="counter-box">
                            <div class="icon"><i class="flaticon-world"></i></div>
                            <div><span class="counter" data-count="+" data-to="170" data-speed="3000">170</span><span
                                    class="counter-sign">+</span></div>
                            <h6 class="title">Our Cover Area</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- counter area end -->


        <!-- download area -->
        <div class="download-area py-120">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="download-img">
                            <img src="assets/img/download/01.png" alt="">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="download-content">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline">Hyiptox App</span>
                                <h2 class="site-title my-3">Download Our <span>App</span></h2>
                            </div>
                            <p class="about-text">There are many variations of passages of Lorem Ipsum available,
                                but the majority have suffered alteration in some form, by injected humour, or
                                randomised words which don't look even.</p>
                            <p class="mt-3">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>

                            <div class="download-btn">
                                <a href="about.html#" class="theme-btn">
                                    <span class="download-btn-content">
                                        <span class="fab fa-google-play download-btn-icon"></span>
                                        <span class="download-text">
                                            <span class="download-text-subtitle">Get It On</span>
                                            <span class="download-text-title">Google Play</span>
                                        </span>
                                    </span>
                                </a>
                                <a href="about.html#" class="theme-btn theme-btn2">
                                    <span class="download-btn-content">
                                        <span class="fab fa-apple download-btn-icon"></span>
                                        <span class="download-text">
                                            <span class="download-text-subtitle">Get It On</span>
                                            <span class="download-text-title">App Store</span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- download area end -->



        <!-- testimonial-area -->
        <div class="testimonial-area bg py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Testimonials</span>
                            <h2 class="site-title">What Client <span>Say's</span></h2>
                            <div class="heading-divider"></div>
                            <p>
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="testimonial-slider owl-carousel owl-theme">
                    <div class="testimonial-single">
                        <div class="testimonial-quote">
                            <span class="testimonial-quote-icon"><i class="fal fa-quote-left"></i></span>
                            <p>
                                There are many variations of passages available but the majority have suffered
                                alteration in some form by injected.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/01.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Sylvia H Green</h4>
                                <p>Founder & CEO</p>
                                <div class="testimonial-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-single">
                        <div class="testimonial-quote">
                            <span class="testimonial-quote-icon"><i class="fal fa-quote-left"></i></span>
                            <p>
                                There are many variations of passages available but the majority have suffered
                                alteration in some form by injected.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/04.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Gordon D Novak</h4>
                                <p>Founder & CEO</p>
                                <div class="testimonial-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-single">
                        <div class="testimonial-quote">
                            <span class="testimonial-quote-icon"><i class="fal fa-quote-left"></i></span>
                            <p>
                                There are many variations of passages available but the majority have suffered
                                alteration in some form by injected.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/05.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Reid E Butt</h4>
                                <p>Founder & CEO</p>
                                <div class="testimonial-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="testimonial-single">
                        <div class="testimonial-quote">
                            <span class="testimonial-quote-icon"><i class="fal fa-quote-left"></i></span>
                            <p>
                                There are many variations of passages available but the majority have suffered
                                alteration in some form by injected.
                            </p>
                        </div>
                        <div class="testimonial-content">
                            <div class="testimonial-author-img">
                                <img src="assets/img/testimonial/02.jpg" alt="">
                            </div>
                            <div class="testimonial-author-info">
                                <h4>Parker Jimenez</h4>
                                <p>Founder & CEO</p>
                                <div class="testimonial-rate">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- testimonial-area end -->


        <!-- team-area -->
        <div class="team-area py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto">
                        <div class="site-heading text-center">
                            <span class="site-title-tagline">Our Team</span>
                            <h2 class="site-title">Meet With <span>Experts</span></h2>
                            <div class="heading-divider"></div>
                            <p>
                                It is a long established fact that a reader will be distracted by the readable content
                                of a page when looking at its layout.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <img src="assets/img/team/01.jpg" alt="thumb">
                            <div class="team-social">
                                <a href="about.html#"><i class="fab fa-facebook-f"></i></a>
                                <a href="about.html#"><i class="fab fa-x-twitter"></i></a>
                                <a href="about.html#"><i class="fab fa-instagram"></i></a>
                                <a href="about.html#"><i class="fab fa-linkedin"></i></a>
                                <a href="about.html#"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="about.html#">Malissa Fierro</a></h5>
                                    <span>Developer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <img src="assets/img/team/02.jpg" alt="thumb">
                            <div class="team-social">
                                <a href="about.html#"><i class="fab fa-facebook-f"></i></a>
                                <a href="about.html#"><i class="fab fa-x-twitter"></i></a>
                                <a href="about.html#"><i class="fab fa-instagram"></i></a>
                                <a href="about.html#"><i class="fab fa-linkedin"></i></a>
                                <a href="about.html#"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="about.html#">Arron Rodri</a></h5>
                                    <span>Senior Designer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item active">
                            <img src="assets/img/team/03.jpg" alt="thumb">
                            <div class="team-social">
                                <a href="about.html#"><i class="fab fa-facebook-f"></i></a>
                                <a href="about.html#"><i class="fab fa-x-twitter"></i></a>
                                <a href="about.html#"><i class="fab fa-instagram"></i></a>
                                <a href="about.html#"><i class="fab fa-linkedin"></i></a>
                                <a href="about.html#"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="about.html#">Chad Smith</a></h5>
                                    <span>Digital Marketer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 col-xl-3">
                        <div class="team-item">
                            <img src="assets/img/team/04.jpg" alt="thumb">
                            <div class="team-social">
                                <a href="about.html#"><i class="fab fa-facebook-f"></i></a>
                                <a href="about.html#"><i class="fab fa-x-twitter"></i></a>
                                <a href="about.html#"><i class="fab fa-instagram"></i></a>
                                <a href="about.html#"><i class="fab fa-linkedin"></i></a>
                                <a href="about.html#"><i class="fab fa-youtube"></i></a>
                            </div>
                            <div class="team-content">
                                <div class="team-bio">
                                    <h5><a href="about.html#">Tony Pinto</a></h5>
                                    <span>CEO & Founder</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- team-area end -->



    </main>




    <!-- CONTENT END -->



    @push('scripts')

    @endpush
</x-frontend.layouts.app>
