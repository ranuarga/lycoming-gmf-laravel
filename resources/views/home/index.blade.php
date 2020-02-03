@extends('layouts.index')

@section('title')
    Home
@endsection

@section('name')
    Home
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item active">Home</li>
</ol>
<div class="row">
    <div class="col-xl-4 col-md-12">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body">
                <h1>0</h1>
                Job(s)
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">
                    View Details
                </a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12">
        <div class="card bg-warning text-white mb-4">
            <div class="card-body">
                <h1>0</h1>
                Job(s) On Progress
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">
                    View Details
                </a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-12">
        <div class="card bg-success text-white mb-4">
            <div class="card-body">
                <h1>0</h1>
                Job(s) Done
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="#">
                    View Details
                </a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
