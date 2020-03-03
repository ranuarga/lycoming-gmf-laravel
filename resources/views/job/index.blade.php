<?php
    if(!isset($title))
        $title = '';
?>
@extends('layouts.index')

@section('title')
    Job {{ $title }}
@endsection

@section('name')
    Job {{ $title }}
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Job {{ $title }}</li>
</ol>
<a href="{{ route('job.create') }}">
    <button class="btn btn-success float-right">
        Create Job
    </button>
</a>
<br>
<br>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <!-- <th>#</th> -->
                        <th>Job Number</th>
                        <th>Engine</th>
                        <th>Engine Number</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Reference</th>
                        <th>Entry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <!-- <th>#</th> -->
                        <th>Job Number</th>
                        <th>Engine</th>
                        <th>Engine Number</th>
                        <th>Order</th>
                        <th>Customer</th>
                        <th>Reference</th>
                        <th>Entry Date</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($jobs as $job)
                    <tr>
                        <!-- <td>{{ $loop->iteration }}</td> -->
                        <td>{{ $job->job_number }}</td>
                        <td>
                        @if($job->engine_model)
                            {{ $job->engine_model->engine_model_name }}
                        @endif
                        </td>
                        <td>{{ $job->job_engine_number }}</td>
                        <td>
                        @if($job->job_order)
                            {{ $job->job_order->job_order_name }}
                        @endif
                        </td>
                        <td>{{ $job->job_customer }}</td>
                        <td>
                        @if($job->engine_model)
                            {{ $job->engine_model->engine_model_reference }}
                        @endif
                        </td>
                        <td>{{ $job->job_entry_date->format('d-M-Y') }}</td>
                        <td>
                            <a href="{{ route('job.progress', ['id' => $job->job_id]) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('job.edit', ['id' => $job->job_id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route('job.delete', ['id' => $job->job_id]) }}">
                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection