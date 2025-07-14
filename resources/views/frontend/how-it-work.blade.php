<x-frontend.layouts.app>

    @section('title', 'About Us - Win Together | Empowering Smart Investments')
    @section('header-title', 'Welcome ')

    @section('meta')
    @endsection

    @section('styles')
    <link rel="stylesheet" type="text/css" href="{{asset('assets/frontend/css/hiw.css')}}">
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


        <div class="row HIW">
            <ul>
                <li style="--accent-color:#f28b00">
                    <div class="date">Lorem ipsum</div>
                    <div class="title">Lorem, ipsum dolor</div>
                    <div class="descr">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Quos adipisci nobis nostrum vero nihil veniam.</div>
                </li>
                
            </ul>
        </div>
    </main>


    <!-- CONTENT END -->




    @push('scripts')
    <script src="{{ asset('assets/frontend/js/net.js') }}"></script>
    @endpush
</x-frontend.layouts.app>
