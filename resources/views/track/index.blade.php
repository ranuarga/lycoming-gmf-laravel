@extends('layouts.track')

@section('title')
    Track Your Engine
@endsection

@section('content')
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
    @if($progress_jobs)
        <div class="container">
            @foreach($progress_jobs as $progress_job)
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        <div class="card-horizontal">
                            <div class="img-square-wrapper">
                                @if($progress_job->progress_status)
                                    <img class="" src="{{ asset('img/'. $progress_job->progress_status->progress_status_name .'.png' )}}">
                                @else
                                    <img class="" src="{{ asset('img/Null.png' )}}">
                                @endif
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">
                                @if($progress_job->job_sheet)
                                    {{ $progress_job->job_sheet->job_sheet_name }}
                                    @if($progress_job->progress_status)
                                        - {{ $progress_job->progress_status->progress_status_name }}
                                    @endif
                                @endif
                                </h4>
                                <p class="card-text">
                                    @if($progress_job->progress_job_date_start)
                                        {{ $progress_job->progress_job_date_start->format('d-M-Y') }}
                                        @if($progress_job->progress_job_date_completion)
                                        To {{ $progress_job->progress_job_date_completion->format('d-M-Y') }}
                                        @endif
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
    </section>
    @endif
@endsection