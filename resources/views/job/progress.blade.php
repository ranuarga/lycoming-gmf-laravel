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
                        <td>{{ $progress_job->job_sheet->job_sheet_name }}</td>
                        <td>{{ $progress_job->progress_status->progress_status_name }}</td>
                        <td>{{ $progress_job->progress_job_date_start }}</td>
                        <td>{{ $progress_job->progress_job_date_completion }}</td>
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