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

                    <div class="col-lg-8">

                        @foreach ($faqs as $key => $faq)

                                <div class="accordion" id="accordionExample">
                                <h4 class="site-title">{{ $faq->title }}</h4>
                                    @foreach ($faq->children as $key1 => $child)

                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="heading-{{ $key }}-{{ $key1 }}">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#collapse-{{ $key }}-{{ $key1 }}" aria-expanded="false" aria-controls="collapseOne">
                                                        <span><i class="far fa-question"></i></span>{{ $child->title }}
                                                    </button>
                                                </h2>
                                                <div id="collapse-{{ $key }}-{{ $key1 }}" class="accordion-collapse collapse"
                                                    aria-labelledby="heading-{{ $key }}-{{ $key1 }}" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        {!! html_entity_decode($child->content) !!}
                                                    </div>
                                                </div>
                                            </div>

                                     @endforeach

                                </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
        <!-- faq area end -->



    </main>
    <!-- CONTENT END -->


</x-frontend.layouts.app>
