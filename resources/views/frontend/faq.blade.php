<x-frontend.layouts.app>
    @section('title', 'FAQ - Win Together | Answers to Your Investment Questions')
    @section('header-title', 'Welcome')
    @section('meta')

    @endsection


    @section('styles')

    @endsection

    <!-- CONTENT START -->
    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb">
            <div class="container">
                <h2 class="breadcrumb-title">Faq</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html"><i class="far fa-home"></i> Home</a></li>
                    <li class="active">Faq</li>
                </ul>
            </div>
            <div class="breadcrumb-shape">
                <img src="assets/img/shape/shape-5.svg" alt="">
            </div>
        </div>
        <!-- breadcrumb end -->


        <!-- faq area -->
        <div class="faq-area faq-area2 py-120">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="faq-left">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline">Faq's</span>
                                <h2 class="site-title my-3">General frequently <span>asked questions</span></h2>
                            </div>
                            <p class="about-text">There are many variations of passages of Lorem Ipsum available,
                                but the majority have suffered alteration in some form, by injected humour, or
                                randomised words which don't look even.</p>
                            <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. </p>
                            <a href="faq.html#" class="theme-btn mt-5">Ask Question</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="accordion" id="accordionExample">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        <span><i class="far fa-question"></i></span> Do I Need A Business Plan ?
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        We denounce with righteous indignation and dislike men who
                                        are so beguiled and demoralized by the charms of pleasure of the moment, so
                                        blinded by desire.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        <span><i class="far fa-question"></i></span> How Long Should A Business Plan Be
                                        ?
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                       We denounce with righteous indignation and dislike men who
                                        are so beguiled and demoralized by the charms of pleasure of the moment, so
                                        blinded by desire.
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        <span><i class="far fa-question"></i></span> What Payment Gateway You Support ?
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                       We denounce with righteous indignation and dislike men who
                                        are so beguiled and demoralized by the charms of pleasure of the moment, so
                                        blinded by desire.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- faq area end -->



    </main>
    <!-- CONTENT END -->


</x-frontend.layouts.app>
