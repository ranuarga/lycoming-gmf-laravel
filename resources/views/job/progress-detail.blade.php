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
    <li class="breadcrumb-item active">Detail</li>
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
                    <td>Job Sheet</td>
                    @if($progress_job->job_sheet)
                    <td>{{ $progress_job->job_sheet->job_sheet_name }}</td>
                    @else
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td>Engine</td>
                    @if($job->engine_model)
                    <td>{{ $job->engine_model->engine_model_name }}</td>
                    @else
                    <td></td>
                    @endif
                </tr>
                <tr>
                    <td>Engine Number</td>
                    <td>{{ $job->job_engine_number }}</td>
                </tr>
                <tr>
                    <td>Order</td>
                    @if($job->job_order)
                    <td>{{ $job->job_order->job_order_name }}</td>
                    @else
                    <td></td>
                    @endif
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
                    <td>
                        Remark by Engineer
                        @if($progress_job->engineer)
                            {{ $progress_job->engineer->engineer_full_name }}
                        @endif
                    </td>
                    <td>{{ $progress_job->progress_job_remark }}</td>
                </tr>
                <tr>
                    <td>
                    Note by Management 
                    @if($progress_job->management)
                        {{ $progress_job->management->management_full_name }}
                    @endif
                    </td>
                    <td>{{ $progress_job->progress_job_note }}</td>
                </tr>
                <tr>
                    <td>Date Start</td>
                    <td>
                    @if($progress_job->progress_job_date_start)
                        {{ $progress_job->progress_job_date_start->format('d-M-Y') }}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Date Completion</td>
                    <td>
                    @if($progress_job->progress_job_date_completion)
                        {{ $progress_job->progress_job_date_completion->format('d-M-Y') }}
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Attachment</td>
                    <td>
                    @if($progress_job->progress_attachment)
                        @foreach($progress_job->progress_attachment as $progress_attachment)
                            <a href="{{ $progress_attachment->cloudinary_secure_url }}" target="_blank" rel="noopener noreferrer">
                                Attachment {{ $loop->iteration }}
                            </a>
                            <br>
                        @endforeach
                    @endif
                    </td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                    @if($progress_job->progress_status)
                    {{ $progress_job->progress_status->progress_status_name }}
                    @endif
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
@endsection