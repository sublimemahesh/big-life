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
                <h2 class="breadcrumb-title">Our Blog</h2>
                <ul class="breadcrumb-menu">
                    <li><a href="index.html"><i class="far fa-home"></i> Home</a></li>
                    <li class="active">Our Blog</li>
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

                <!-- pagination -->
                <div class="pagination-area">
                    <div aria-label="Page navigation example">
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="blog.html#" aria-label="Previous">
                                    <span aria-hidden="true"><i class="far fa-angle-double-left"></i></span>
                                </a>
                            </li>
                            <li class="page-item active"><a class="page-link" href="blog.html#">1</a></li>
                            <li class="page-item"><a class="page-link" href="blog.html#">2</a></li>
                            <li class="page-item"><a class="page-link" href="blog.html#">3</a></li>
                            <li class="page-item">
                                <a class="page-link" href="blog.html#" aria-label="Next">
                                    <span aria-hidden="true"><i class="far fa-angle-double-right"></i></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <!-- blog-area end -->


    </main>


    <!-- CONTENT END -->


</x-frontend.layouts.app>
