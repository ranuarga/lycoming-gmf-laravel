@extends('layouts.index')

@section('title')
    Job Sheet
@endsection

@section('name')
    Job Sheet
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Job Sheet</li>
</ol>
<br>
<br>
<div class="card mb-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Job Sheet</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Job Sheet</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($job_sheets as $job_sheet)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $job_sheet->job_sheet_name }}</td>
                        <td>{{ $job_sheet->created_at }}</td>
                        <td>{{ $job_sheet->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection