<?php
    if(isset($admin))
        $operation = 'Update';
    else
        $operation = 'Create';
?>
@extends('layouts.index')

@section('title')
    {{ $operation }} {{ $title }}
@endsection

@section('name')
    {{ $operation }} {{ $title }}
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route($route) }}">{{ $title }}</a></li>
    <li class="breadcrumb-item active">{{ $operation }}</li>
</ol>
    @if(isset($admin))
        {{ Form::model($admin, ['route' => [$route . '.update', $admin->admin_id], 'method' => 'post']) }}
    @else
        {{ Form::open(['route' => $route . '.store']) }}
    @endif
            {{ Form::label('admin_user_name', 'Username') }}
            {{ Form::text('admin_user_name', Request::old('admin_user_name'), ['class' => 'form-control', 'placeholder' => 'Username', 'required']) }}
            {{ Form::label('password', 'Password') }}
            @if(!isset($admin))
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password', 'required']) }}
            @else
                {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
            @endif
            {{ Form::label('admin_full_name', 'Full Name') }}
            {{ Form::text('admin_full_name', Request::old('admin_full_name'), ['class' => 'form-control', 'placeholder' => 'Full Name', 'required']) }}
            <br>
            <button type="submit" class="btn btn-primary float-right">Done</button>
    {{ Form::close() }}
@endsection
