@extends('layouts.index')

@section('title')
    Progress
@endsection

@section('name')
    Progress
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job') }}">Job</a></li>
    <li class="breadcrumb-item active">Progress</li>
</ol>
<br>
<br>
<div class="card mb-4">
    <div class="card-body">
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
                <tr>
                    <td>Completion Percentage</td>
                    <td>{{ number_format((float)$completion_percentage, 2, '.', '') }} % </td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Sheet</th>
                        <th>Status</th>
                        <th>Date Start</th>
                        <th>Date Completion</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Job Sheet</th>
                        <th>Status</th>
                        <th>Date Start</th>
                        <th>Date Completion</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($progress_jobs as $progress_job)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                        @if($progress_job->job_sheet)
                            {{ $progress_job->job_sheet->job_sheet_name }}
                        @endif
                        </td>
                        <td>
                        @if($progress_job->progress_status)
                            {{ $progress_job->progress_status->progress_status_name }}
                            @endif
                        </td>
                        <td>
                        @if($progress_job->progress_job_date_start)
                            {{ $progress_job->progress_job_date_start->format('d-M-Y') }}
                        @endif
                        </td>
                        <td>
                        @if($progress_job->progress_job_date_completion)
                            {{ $progress_job->progress_job_date_completion->format('d-M-Y') }}
                        @endif
                        </td>
                        <td>
                            <a href="{{ route('job.progress.detail', ['id' => $progress_job->job_id, 'pid' => $progress_job->progress_job_id]) }}">
                                <i class="fas fa-eye"></i>
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