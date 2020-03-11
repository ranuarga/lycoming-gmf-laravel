<?php
    if(isset($job))
        $title = 'Update';
    else
        $title = 'Create';
?>
@extends('layouts.index')

@section('title')
    {{ $title }} Job
@endsection

@section('name')
    {{ $title }} Job
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job') }}">Job</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
    @if(isset($job))
        {{ Form::model($job, ['route' => ['job.update', $job->job_id], 'method' => 'post', 'files' => true]) }}
    @else
        {{ Form::open(['route' => 'job.store', 'files' => true]) }}
    @endif
            {{ Form::label('job_wo_file', 'Work Order File') }}
            @if(!isset($job))
                {{ Form::file('job_wo_file', ['class' => 'form-control', 'required']) }}
            @else
                {{ Form::file('job_wo_file', ['class' => 'form-control']) }}
            @endif
            {{ Form::label('job_number', 'Job Number') }}
            {{ Form::text('job_number', Request::old('job_number'), ['class' => 'form-control', 'placeholder' => 'Job Number', 'required']) }}
            @if(!isset($job))
                {{ Form::label('job_order_id', 'Order') }}
                {{ Form::select('job_order_id', [null=>'Select Order'] + $job_orders, Request::old('job_order_id'), ['class' => 'form-control', 'required']) }}
            @endif
            {{ Form::label('engine_model_id', 'Engine') }}
            {{ Form::select('engine_model_id', [null=>'Select Engine'] + $engine_models, Request::old('engine_model_id'), ['class' => 'form-control', 'required']) }}
            {{ Form::label('job_engine_number', 'Engine Serial Number (ESN)') }}
            {{ Form::text('job_engine_number', Request::old('job_engine_number'), ['class' => 'form-control', 'placeholder' => 'Engine Number', 'required']) }}
            {{ Form::label('job_customer', 'Customer') }}
            {{ Form::text('job_customer', Request::old('job_customer'), ['class' => 'form-control', 'placeholder' => 'Customer', 'required']) }}
            {{ Form::label('job_entry_date', 'Entry Date') }}
            {{ Form::date('job_entry_date', Request::old('job_entry_date'), ['class' => 'form-control', 'placeholder' => 'Entry Date']) }}
            <br>
            <button type="submit" class="btn btn-primary float-right">Done</button>
    {{ Form::close() }}
@endsection
