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
                        
                        <div class="accordion" id="accordionExample">



                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne1">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne1" aria-expanded="false" aria-controls="collapseOne">
                                        <span><i class="far fa-question"></i></span> Do I Need A Business Plan ?
                                    </button>
                                </h2>
                                <div id="collapseOne1" class="accordion-collapse collapse show"
                                    aria-labelledby="headingOne1" data-bs-parent="#accordionExample">
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
