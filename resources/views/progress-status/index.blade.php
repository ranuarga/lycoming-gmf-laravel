@extends('layouts.index')

@section('title')
    Progress Status
@endsection

@section('name')
    Progress Status
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Progress Status</li>
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
                        <th>Progress Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Progress Status</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($progress_statuses as $progress_status)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $progress_status->progress_status_name }}</td>
                        <td>{{ $progress_status->created_at }}</td>
                        <td>{{ $progress_status->updated_at }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection