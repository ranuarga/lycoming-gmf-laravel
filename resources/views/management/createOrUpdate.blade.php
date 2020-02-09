<?php
    if(isset($management))
        $title = 'Update';
    else
        $title = 'Create';
?>
@extends('layouts.index')

@section('title')
    {{ $title }} Management
@endsection

@section('name')
    {{ $title }} Management
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('management') }}">Management</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
    @if(isset($management))
        {{ Form::model($management, ['route' => ['management.update', $management->management_id], 'method' => 'post']) }}
    @else
        {{ Form::open(['route' => 'management.store']) }}
    @endif
            {{ Form::label('management_user_name', 'Username') }}
            {{ Form::text('management_user_name', Request::old('management_user_name'), ['class' => 'form-control', 'placeholder' => 'Username', 'required']) }}
            {{ Form::label('password', 'Password') }}
            @if(!isset($management))
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) }}
            @else
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
            @endif
            {{ Form::label('management_full_name', 'Full Name') }}
            {{ Form::text('management_full_name', Request::old('management_full_name'), ['class' => 'form-control', 'placeholder' => 'Full Name', 'required']) }}
            <br>
            <button type="submit" class="btn btn-primary float-right">Done</button>
    {{ Form::close() }}
@endsection
