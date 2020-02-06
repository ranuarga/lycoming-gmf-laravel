@extends('layouts.index')

@section('title')
    Management
@endsection

@section('name')
    Management
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Management</li>
</ol>
<a href="{{ route('management.create') }}">
    <button class="btn btn-success float-right">
        Create Management
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
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($managements as $management)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $management->management_user_name }}</td>
                        <td>{{ $management->management_full_name }}</td>
                        <td>{{ $management->created_at }}</td>
                        <td>{{ $management->updated_at }}</td>
                        <td>
                            <a href="{{ route('management.edit', ['id' => $management->management_id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route('management.delete', ['id' => $management->management_id]) }}">
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