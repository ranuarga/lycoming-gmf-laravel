@extends('layouts.index')

@section('title')
    Job Order
@endsection

@section('name')
    Job Order
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Job Order</li>
</ol>
<a href="{{ route('job-order.create') }}">
    <button class="btn btn-success float-right">
        Create Job Order
    </button>
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
                        <th>Job Order</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Job Order</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($job_orders as $job_order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $job_order->job_order_name }}</td>
                        <td>{{ $job_order->created_at }}</td>
                        <td>{{ $job_order->updated_at }}</td>
                        <td>
                            <a href="{{ route('job-order.job-sheet', ['id' => $job_order->job_order_id]) }}">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('job-order.edit', ['id' => $job_order->job_order_id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route('job-order.delete', ['id' => $job_order->job_order_id]) }}">
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