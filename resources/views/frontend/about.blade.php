<x-frontend.layouts.app>
    @section('title', 'About Us - Win Together | Empowering Smart Investments')
    @section('header-title', 'Welcome ')

    @section('meta')
    @endsection

    @section('header')

     @include('frontend.layouts.header')

    @endsection

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
                                <img src="{{ storage('pages/' . $abouts->image) }}" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="about-right">
                            <div class="site-heading mb-3">
                                <span class="site-title-tagline">About Us</span>
                                <h2 class="site-title">{{ $abouts->title }}
                                </h2>
                            </div>
                            <div class="about-text">{!! $abouts->content !!}</div>
                            <div class="about-list-wrapper">

                            </div>
                            <a href="{{ route('contact') }}" class="theme-btn">Contact US</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- about area end -->


    </main>




    <!-- CONTENT END -->

    @push('scripts')

    @endpush
</x-frontend.layouts.app>
