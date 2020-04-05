<?php
    if(isset($job_order))
        $title = 'Update';
    else
        $title = 'Create';
?>
@extends('layouts.index')

@section('title')
    {{ $title }} Job Order
@endsection

@section('name')
    {{ $title }} Job Order
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job-order') }}">Job Order</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
    @if(isset($job_order))
        {{ Form::model($job_order, ['route' => ['job-order.update', $job_order->job_order_id], 'method' => 'post']) }}
    @else
        {{ Form::open(['route' => 'job-order.store']) }}
    @endif
            {{ Form::label('job_order_name', 'Job Order') }}
            {{ Form::text('job_order_name', Request::old('job_order_name'), ['class' => 'form-control', 'placeholder' => 'Job Order', 'required']) }}
            {{ Form::label(null, 'Job Sheets') }}
            @foreach($job_sheets as $job_sheet)
            <div class="form-check">
                {{ Form::checkbox('chosen_job_sheets[]', $job_sheet->job_sheet_id, false, ['class'=>'form-check-input']) }}
                {{ Form::label($job_sheet->job_sheet_id, $job_sheet->job_sheet_name, ['class'=>'form-check-label']) }}
            </div>
            @endforeach
            <br>
            <button type="submit" class="btn btn-primary float-right">Done</button>
        {{ Form::close() }}
@endsection
