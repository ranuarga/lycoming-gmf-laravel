@extends('layouts.index')

@section('title')
    Progress Attachment
@endsection

@section('name')
    Progress Attachment
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job') }}">Job</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job.progress', ['id' => $progress_job->job_id]) }}">Progress</a></li>
    <li class="breadcrumb-item">
        <a href="{{ route('job.progress.detail', ['id' => $progress_job->job_id, 'pid' => $progress_job->progress_job_id]) }}">
            @if($progress_job->job_sheet->job_sheet_name)
                {{ $progress_job->job_sheet->job_sheet_name }}
            @endif
        </a>
    </li>
    <li class="breadcrumb-item active">Attachment</li>
</ol>
{{ Form::open(['route' => 'attachment.store', 'files' => true]) }}
    {{ Form::label('progress_attachment_file', 'Attachment') }}
    {{ Form::file('progress_attachment_file', ['class' => 'form-control']) }}
    {{ Form::hidden('progress_job_id', $progress_job->progress_job_id) }}
    <br>
    <button type="submit" class="btn btn-success float-right">
        Add Attachment
    </button>
{{ Form::close() }}
</a>
<br>
<br>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Attachment</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Attachment</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($progress_attachments as $progress_attachment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <a href="{{ $progress_attachment->cloudinary_secure_url }}" target="_blank" rel="noopener noreferrer">
                                {{ $progress_attachment->cloudinary_public_id }}
                            </a>
                        </td>
                        <td>{{ $progress_attachment->created_at }}</td>
                        <td>
                            <a href="{{ $progress_attachment->cloudinary_secure_url }}" target="_blank" rel="noopener noreferrer">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('attachment.delete', ['id' => $progress_attachment->progress_attachment_id]) }}">
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