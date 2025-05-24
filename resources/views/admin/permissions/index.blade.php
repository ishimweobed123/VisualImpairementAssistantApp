@extends('layouts.admin')
@section('title', __('Permissions'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('All Permissions') }}</div>
    <div class="card-body">
        <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary mb-3">Add Permission</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection