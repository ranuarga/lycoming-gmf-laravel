@extends('layouts.index')

@section('title')
    Admin
@endsection

@section('name')
    Admin
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Admin</li>
</ol>
<a href="{{ route('admin.create') }}">
    <button class="btn btn-success float-right">
        Create Admin
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
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $admin->admin_user_name }}</td>
                        <td>{{ $admin->admin_full_name }}</td>
                        <td>{{ date("Y-m-d H:i:s T", strtotime($admin->created_at.' UTC')) }}</td>
                        <td>{{ date("Y-m-d H:i:s T", strtotime($admin->updated_at.' UTC')) }}</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="#">
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