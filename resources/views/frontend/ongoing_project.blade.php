<x-frontend.layouts.app>

   @section('title', 'About Us - Win Together | Empowering Smart Investments')
   @section('header-title', 'Welcome ')

   @section('meta')
   @endsection



    <!-- CONTENT START -->

    <main class="main">

        <!-- breadcrumb -->
        <div class="site-breadcrumb">
            <div class="container">
                <h2 class="breadcrumb-title">Our Project</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html"><i class="far fa-home"></i> Home</a></li>
                    <li class="active">Our Project</li>
                </ul>
            </div>
            <div class="breadcrumb-shape">
                <img src="assets/img/shape/shape-5.svg" alt="">
            </div>
        </div>
        <!-- breadcrumb end -->

        <!-- blog-area -->
        <div class="blog-area py-120">
            <div class="container">

                <div class="row">

                      @foreach ($projects as $key => $project)
                        <div class="col-md-6 col-lg-4">
                            <div class="blog-item">
                                <div class="blog-item-img">
                                    <img src="{{ storage('pages/' . $project->image) }}" alt="Thumb">
                                </div>
                                <div class="blog-item-info">
                                    <div class="blog-item-meta">
                                    </div>
                                    <h4 class="blog-title">
                                        <a href="blog.html#">{{ $project->title }}</a>
                                    </h4>
                                      {!! html_entity_decode($project->content) !!}

                                    <a class="theme-btn" href="blog.html#">Read More</a>
                                </div>
                            </div>
                        </div>
                     @endforeach

                </div>

             

            </div>
        </div>
        <!-- blog-area end -->


    </main>


    <!-- CONTENT END -->


</x-frontend.layouts.app>
