<!doctype html>
<html lang="en">

<head>
    <!--<![meta]-->
    <meta http-equiv="content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <title>{{ $meta['title'] }}</title>
    <meta name="description" content="{{ $meta['description'] }}" />
    <meta name="keywords" content="{{ $meta['keywords'] }}" />
    <meta name="author" content="{{ $meta['author'] }}" />
    <meta name="image" content="{{ $meta['image'] }}" />
    <meta name="copyright" content="{{ $meta['copyright'] }}" />
    <meta name="canonical" content="{{ $meta['canonical'] }}" />
    <meta name="robots" content="{{ $meta['robots'] }}" />
    <meta name="googlebot" content="{{ $meta['googlebot'] }}" />
    <meta name="googlebotnews" content="{{ $meta['googlebotnews'] }}" />
    <!--<![favicon]-->
    <link rel="shortcut icon" href="{{ $meta['favicon'] }}" type="image/x-icon" />
    <!--<![facebook]-->
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ $meta['title'] }}" />
    <meta property="og:description" content="{{ $meta['description'] }}" />
    <meta property="og:image" content="{{ $meta['image'] }}" />
    <meta property="og:url" content="{{ $meta['canonical'] }}" />
    <meta property="og:site_name" content="{{ $meta['sitename'] }}" />
    <!--<![twitter]-->
    <meta property="twitter:card" content="summary" />
    <meta property="twitter:site" content="website" />
    <meta property="twitter:title" content="{{ $meta['title'] }}" />
    <meta property="twitter:description" content="{{ $meta['description'] }}" />
    <meta property="twitter:image" content="{{ $meta['image'] }}" />
    <meta property="twitter:creator" content="{{ $meta['author'] }}" />
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap/css/blog.css') }}" rel="stylesheet">
</head>

<body>

    <div class="container">
        <header class="blog-header py-3">
            <div class="row flex-nowrap justify-content-between align-items-center">
                <div class="col-4 pt-1">
                    <a class="text-muted" href="{{ route('blog') }}">Blog</a>
                </div>
                <div class="col-4 text-center">
                    <a class="blog-header-logo text-dark" href="{{ route('/') }}">{{ $meta['title'] }}</a>
                </div>
                <div class="col-4 d-flex justify-content-end align-items-center">
                    <a class="text-muted" href="#" aria-label="Search">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="mx-3" role="img" viewBox="0 0 24 24" focusable="false">
                            <title>Search</title>
                            <circle cx="10.5" cy="10.5" r="7.5" />
                            <path d="M21 21l-5.2-5.2" />
                        </svg>
                    </a>
                    @if (Auth::user())
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('dashboard') }}">Dashboard</a>
                    @else
                    <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Login</a>
                    @endif
                </div>
            </div>
        </header>

        <div class="nav-scroller py-1 mb-2">
            <nav class="nav d-flex justify-content-between">
                @foreach ($categories as $row)
                <a class="p-2 text-muted" href="{{ route('blog.category', $row->slug) }}">{{ $row->category }}</a>
                @endforeach
            </nav>
        </div>

        <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark">
            <div class="col-md-6 px-0">
                <h1 class="display-4 font-italic">Title of a longer featured blog post</h1>
                <p class="lead my-3">Multiple lines of text that form the lede, informing new readers quickly and efficiently about what’s most interesting in this post’s contents.</p>
                <p class="lead mb-0"><a href="#" class="text-white font-weight-bold">Continue reading...</a></p>
            </div>
        </div>

    </div>

    @yield('content')

    <footer class="blog-footer">
        <p>Blog template built for <a href="https://getbootstrap.com/">Bootstrap</a> by <a href="https://twitter.com/mdo">@mdo</a>.</p>
        <p>
            <a href="#">Back to top</a>
        </p>
    </footer>
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>