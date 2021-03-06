@extends('layouts.index')

@section('title')
    {{ $title }}
@endsection

@section('name')
    {{ $title }}
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">{{ $title }}</li>
</ol>
<a href="{{ route($route . '.create') }}">
    <button class="btn btn-success float-right">
        Create {{ $title }}
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
                        <td>{{ $admin->created_at }}</td>
                        <td>{{ $admin->updated_at }}</td>
                        <td>
                            <a href="{{ route($route . '.edit', ['id' => $admin->admin_id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route($route . '.delete', ['id' => $admin->admin_id]) }}">
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