<!-- header area -->
    <header class="header">
        <div class="main-navigation">
            <nav class="navbar navbar-expand-lg">
                <div class="container">
                    <a class="navbar-brand" href="index.html">
                        <img src="{{ asset('assets/frontend/img/logo/logo.png') }}" alt="logo">
                    </a>
                    <div class="mobile-menu-right">
                        <a href="index.html#" class="mobile-search-btn search-box-outer"><i class="far fa-search"></i></a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#main_nav" aria-expanded="false" aria-label="Toggle navigation">
                            <i class="far fa-stream"></i>
                        </button>
                    </div>
                    <div class="collapse navbar-collapse" id="main_nav">
                        <ul class="navbar-nav ms-auto">

                            <li class="nav-item"><a class="nav-link" href="{{ route('/') }}"> Home </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('about') }}"> About Us </a></li>

                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="index.html#" data-bs-toggle="dropdown">Projects</a>
                                <ul class="dropdown-menu fade-up">
                                    <li><a class="dropdown-item" href="{{ route('project') }}">Existing Projects</a></li>
                                    <li><a class="dropdown-item" href="{{ route('Upcoming-project') }}">Upcoming Projects</a></li>
                                </ul>
                            </li>



                            <li class="nav-item"><a class="nav-link" href="{{ route('how-it-work') }}"> How It Works </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}"> FAQ </a></li>
                            <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}"> Contact Us </a></li>

                        </ul>
                        <div class="header-nav-right">
                            <div class="header-nav-search">
                                <a href="index.html#" class="search-box-outer"><i class="far fa-search"></i></a>
                            </div>
                            <div class="header-btn">
                                <a href="index.html#" class="theme-btn">GET QUOTE</a>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    <!-- header area end -->
