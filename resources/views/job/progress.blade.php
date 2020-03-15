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
                    <td>Work Order</td>
                    <td>
                    @if($job->job_wo_secure_url)
                        <a href="{{ $job->job_wo_secure_url }}" target="_blank" rel="noopener noreferrer">
                            {{ $job->job_wo_public_id }}
                        </a>
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Job Number</td>
                    <td>{{ $job->job_number }}</td>
                </tr>
                <tr>
                    <td>Order</td>
                    <td>
                    @if($job->job_order)
                        {{ $job->job_order->job_order_name }}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Tracking Code</td>
                    <td>{{ $job->job_track_code }}</td>
                </tr>
                <tr>
                    <td>Engine</td>
                    <td>
                    @if($job->engine_model)
                        {{ $job->engine_model->engine_model_name }}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Engine Number</td>
                    <td>{{ $job->job_engine_number }}</td>
                </tr>
                <tr>
                    <td>Reference</td>
                    <td>
                    @if($job->engine_model)
                        {{ $job->engine_model->engine_model_reference }}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Customer</td>
                    <td>{{ $job->job_customer }}</td>
                </tr>
                <tr>
                    <td>Entry Date</td>
                    <td>{{ $job->job_entry_date->format('d-M-Y') }}</td>
                </tr>
                <tr>
                    <td>
                        Days Passed / Estimated Time to Complete
                        <br>
                        (Counted From First Process & Based on Workdays)
                    </td>
                    <td>{{ $days_passed }} / {{ $days_to_complete }} </td>
                </tr>
                <tr>
                    <td>
                        Completion Percentage
                        <br>
                        (Based on Man Hours Each Process)
                    </td>
                    <td>{{ $completion_percentage }} %</td>
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
                            <a href="{{ route('job.progress.edit', ['id' => $progress_job->job_id, 'pid' => $progress_job->progress_job_id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route('job.progress.attachment', ['id' => $progress_job->job_id, 'pid' => $progress_job->progress_job_id]) }}">
                                <i class="fas fa-paperclip"></i>
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