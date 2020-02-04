<?php
    if(isset($admin))
        $title = 'Update';
    else
        $title = 'Create';
?>
@extends('layouts.index')

@section('title')
    {{ $title }} Admin
@endsection

@section('name')
    {{ $title }} Admin
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Admin</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
@endsection
