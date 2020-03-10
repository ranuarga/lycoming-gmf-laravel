@extends('layouts.index')

@section('title')
    Engineer
@endsection

@section('name')
    Engineer
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Engineer</li>
</ol>
<a href="{{ route('engineer.create') }}">
    <button class="btn btn-success float-right">
        Create Engineer
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
                    @foreach($engineers as $engineer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $engineer->engineer_user_name }}</td>
                        <td>{{ $engineer->engineer_full_name }}</td>
                        <td>{{ $engineer->created_at }}</td>
                        <td>{{ $engineer->updated_at }}</td>
                        <td>
                            <a href="{{ route('engineer.edit', ['id' => $engineer->engineer_id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route('engineer.delete', ['id' => $engineer->engineer_id]) }}">
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