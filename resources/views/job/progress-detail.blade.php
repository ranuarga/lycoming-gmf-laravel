@extends('layouts.index')

@section('title')
    Progress Detail
@endsection

@section('name')
    Progress Detail
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job') }}">Job</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job.progress', ['id' => $progress_job->job_id]) }}">Progress</a></li>
    <li class="breadcrumb-item active">{{ $progress_job->job_sheet->job_sheet_name }}</li>
</ol>
<br>
<br>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tr>
                    <td>Job Number</td>
                    <td>{{ $progress_job->job->job_number }}</td>
                </tr>
                <tr>
                    <td>Job Sheet</td>
                    <td>{{ $progress_job->job_sheet->job_sheet_name }}</td>
                </tr>
                <tr>
                    <td>Engine</td>
                    <td>{{ $progress_job->job->engine_model->engine_model_name }}</td>
                </tr>
                <tr>
                    <td>Engine Number</td>
                    <td>{{ $progress_job->job->job_engine_number }}</td>
                </tr>
                <tr>
                    <td>Order</td>
                    <td>{{ $progress_job->job->job_order->job_order_name }}</td>
                </tr>
                <tr>
                    <td>Customer</td>
                    <td>{{ $progress_job->job->job_customer }}</td>
                </tr>
                <tr>
                    <td>Reference</td>
                    <td>{{ $progress_job->job->job_reference }}</td>
                </tr>
                <tr>
                    <td>Entry Date</td>
                    <td>{{ $progress_job->job->job_entry_date }}</td>
                </tr>
                <tr>
                    <td>Remark by Engineer {{ $progress_job->engineer->engineer_full_name }}</td>
                    <td>{{ $progress_job->progress_job_remark }}</td>
                </tr>
                <tr>
                    <td>Note by Management {{ $progress_job->management->management_full_name }}</td>
                    <td>{{ $progress_job->progress_job_note }}</td>
                </tr>
                <tr>
                    <td>Date Start</td>
                    <td>{{ $progress_job->progress_job_date_start }}</td>
                </tr>
                <tr>
                    <td>Date Completion</td>
                    <td>{{ $progress_job->progress_job_date_completion }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>{{ $progress_job->progress_status->progress_status_name }}</td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection