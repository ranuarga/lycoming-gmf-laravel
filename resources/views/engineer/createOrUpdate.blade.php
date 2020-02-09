<?php
    if(isset($engineer))
        $title = 'Update';
    else
        $title = 'Create';
?>
@extends('layouts.index')

@section('title')
    {{ $title }} Engineer
@endsection

@section('name')
    {{ $title }} Engineer
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('engineer') }}">Engineer</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
    @if(isset($engineer))
        {{ Form::model($engineer, ['route' => ['engineer.update', $engineer->engineer_id], 'method' => 'post']) }}
    @else
        {{ Form::open(['route' => 'engineer.store']) }}
    @endif
            {{ Form::label('engineer_user_name', 'Username') }}
            {{ Form::text('engineer_user_name', Request::old('engineer_user_name'), ['class' => 'form-control', 'placeholder' => 'Username', 'required']) }}
            {{ Form::label('password', 'Password') }}
            @if(!isset($admin))
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) }}
            @else
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
            @endif
            {{ Form::label('engineer_full_name', 'Full Name') }}
            {{ Form::text('engineer_full_name', Request::old('engineer_full_name'), ['class' => 'form-control', 'placeholder' => 'Full Name', 'required']) }}
            <br>
            <button type="submit" class="btn btn-primary float-right">Done</button>
    {{ Form::close() }}
@endsection
