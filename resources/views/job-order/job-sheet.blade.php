@extends('layouts.index')

@section('title')
    Job Sheet of Job Order
@endsection

@section('name')
    Job Sheet of Job Order
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('job-order') }}">Job Order</a></li>
    <li class="breadcrumb-item active">Job Sheet</li>
</ol>
<br>
<br>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" width="100%" cellspacing="0">
                <tr>
                    <td>Job Order</td>
                    <td>{{ $job_order->job_order_name }}</td>
                </tr>
            </table>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Sheet</th>
                        <th>Man Hours</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Job Sheet</th>
                        <th>Man Hours</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($job_sheet_orders as $job_sheet_order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                        @if($job_sheet_order->job_sheet)
                            {{ $job_sheet_order->job_sheet->job_sheet_name }}
                        @endif
                        </td>
                        <td>
                        @if($job_sheet_order->job_sheet)
                            {{ $job_sheet_order->job_sheet->job_sheet_man_hours }}
                        @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection