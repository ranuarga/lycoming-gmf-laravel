<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Track Your Engine</title>
        <!-- Bootstrap core CSS -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
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
    <!-- Masthead -->
    <header class="masthead text-white text-center">
        <div class="overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-xl-9 mx-auto">
                    <h1 class="mb-5">Enter Job Number Then Click Search</h1>
                </div>
                <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                @if(isset($job))
                    {{ Form::model($job, ['route' => ['track.search'], 'method' => 'post']) }}
                @else
                    {{ Form::open(['route' => 'track.search']) }}
                @endif
                    <div class="form-row">
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        {{ Form::text('job_number', Request::old('job_number'), ['class' => 'form-control form-control-lg', 'placeholder' => 'Enter Job Number...']) }}
                    </div>
                    <div class="col-12 col-md-3">
                        <button type="submit" class="btn btn-block btn-lg btn-primary">Search!</button>
                    </div>
                    </div>
                {{ Form::close() }}
                </div>
            </div>
        </div>
    </header>
    @if(isset($message))
    <section class="testimonials text-center bg-light">
        <div class="container-fluid">
            <h2 class="mb-5">{{ $message }}</h2>
        </div>
    </section>
    @elseif(isset($job))
    <section class="testimonials text-center bg-light">
        <div class="container">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <tr>
                        <td>Job Number</td>
                        <td>{{ $job->job_number }}</td>
                    </tr>
                    <tr>
                        <td>Engine</td>
                        <td>{{ $job->engine_model->engine_model_name }}</td>
                    </tr>
                    <tr>
                        <td>Engine Number</td>
                        <td>{{ $job->job_engine_number }}</td>
                    </tr>
                    <tr>
                        <td>Order</td>
                        <td>{{ $job->job_order->job_order_name }}</td>
                    </tr>
                    <tr>
                        <td>Customer</td>
                        <td>{{ $job->job_customer }}</td>
                    </tr>
                    <tr>
                        <td>Reference</td>
                        <td>{{ $job->job_reference }}</td>
                    </tr>
                    <tr>
                        <td>Entry Date</td>
                        <td>{{ $job->job_entry_date->format('d-M-Y') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </section>
    @if($progress_jobs)
    @endif
    @endif
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