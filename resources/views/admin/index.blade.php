@extends('layouts.index')

@section('title')
    Admins
@endsection

@section('name')
    Admins
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Admins</li>
</ol>
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
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th>Full Name</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($admins as $admin)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $admin->admin_user_name }}</td>
                        <td>{{ $admin->admin_full_name }}</td>
                        <td>{{ $admin->created_at }}</td>
                        <td>{{ $admin->updated_at }}</td>
                        <td>
                            <a href="#">
                                <i class="fas fa-eye"></i>
                            </a>
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