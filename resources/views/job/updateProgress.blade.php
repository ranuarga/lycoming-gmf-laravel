@extends('layouts.index')

@section('title')
    Update Progress
@endsection

@section('name')
    Update Progress
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
    <li class="breadcrumb-item active">Update</li>
</ol>
{{ Form::model($progress_job, ['route' => ['job.progress.update', $progress_job->progress_job_id], 'method' => 'post']) }}
    {{ Form::label('progress_status_id', 'Status') }}
    {{ Form::select('progress_status_id', [null=>'Select Status'] + $progress_statuses, Request::old('progress_status_id'), ['class' => 'form-control select2', 'required']) }}
    {{ Form::label('progress_job_remark', 'Remark') }}
    {{ Form::textarea('progress_job_remark', Request::old('progress_job_remark'), ['class' => 'form-control', 'placeholder' => 'Some Remark']) }}
    <br>
    <button type="submit" class="btn btn-primary float-right">Done</button>
{{ Form::close() }}
@endsection