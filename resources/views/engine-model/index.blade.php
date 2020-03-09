@extends('layouts.index')

@section('title')
    Engine Model
@endsection

@section('name')
    Engine Model
@endsection

@section('content')
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
    <li class="breadcrumb-item active">Engine Model</li>
</ol>
<a href="{{ route('engine-model.create') }}">
    <button class="btn btn-success float-right">
        Create Engine Model
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
                        <th>Engine Model</th>
                        <th>Reference</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Engine Model</th>
                        <th>Reference</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </tfoot>
                <tbody>
                    @foreach($engine_models as $engine_model)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $engine_model->engine_model_name }}</td>
                        <td>{{ $engine_model->engine_model_reference }}</td>
                        <td>{{ $engine_model->created_at }}</td>
                        <td>{{ $engine_model->updated_at }}</td>
                        <td>
                            <a href="{{ route('engine-model.edit', ['id' => $engine_model->engine_model_id]) }}">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <a href="{{ route('engine-model.delete', ['id' => $engine_model->engine_model_id]) }}">
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