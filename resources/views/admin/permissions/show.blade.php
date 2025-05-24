@extends('layouts.admin')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Permission: {{ $permission->name }}</h3>
        </div>
        <div class="card-body">
            <p><strong>ID:</strong> {{ $permission->id }}</p>
            <p><strong>Name:</strong> {{ $permission->name }}</p>
            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection