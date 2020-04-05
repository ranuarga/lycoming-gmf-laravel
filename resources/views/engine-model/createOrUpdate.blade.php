<?php
    if(isset($engine_model))
        $title = 'Update';
    else
        $title = 'Create';
?>
@extends('layouts.index')

@section('title')
    {{ $title }} Engine Model
@endsection

@section('name')
    {{ $title }} Engine Model
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('engine-model') }}">Engine Model</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
    @if(isset($engine_model))
        {{ Form::model($engine_model, ['route' => ['engine-model.update', $engine_model->engine_model_id], 'method' => 'post']) }}
    @else
        {{ Form::open(['route' => 'engine-model.store']) }}
    @endif
            {{ Form::label('engine_model_name', 'Engine Model') }}
            {{ Form::text('engine_model_name', Request::old('engine_model_name'), ['class' => 'form-control', 'placeholder' => 'Engine Model', 'required']) }}
            {{ Form::label('engine_model_reference', 'Reference') }}
            {{ Form::text('engine_model_reference', Request::old('engine_model_reference'), ['class' => 'form-control', 'placeholder' => 'Reference', 'required']) }}
            <br>
            <button type="submit" class="btn btn-primary float-right">Done</button>
    {{ Form::close() }}
@endsection
