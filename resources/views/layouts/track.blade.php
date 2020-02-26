<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>@yield('title')</title>
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/track.css') }}" rel="stylesheet">
        <!-- Custom fonts for this template -->
        <link href="{{ asset('css/all.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/simple-line-icons.css') }}" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
        <!-- Custom styles for this template -->
        <link href="{{ asset('css/landing-page.min.css') }}" rel="stylesheet">
    </head>
    <body>
    <!-- Navigation -->
    <nav class="navbar navbar-light bg-light static-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('track') }}">Track Your Engine</a>
            <!-- <a class="btn btn-primary" href="#">Sign In</a> -->
        </div>
    </nav>
    @yield('content')
    <!-- Footer -->
    <footer class="footer bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 h-100 text-center text-lg-left my-auto">
                    <p class="text-muted small mb-4 mb-lg-0">
                        &copy; Joint Operation GMF &middot; MMF 2020. All Rights Reserved.
                    </p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    </body>
</html>