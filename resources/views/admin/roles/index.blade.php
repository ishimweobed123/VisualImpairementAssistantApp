@extends('layouts.admin')
@section('title', __('Roles'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('All Roles') }}</div>
    <div class="card-body">
        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary mb-3">Add Role</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->permissions->pluck('name')->implode(', ') ?: 'None' }}</td>
                        <td>
                            <a href="{{ route('admin.roles.show', $role) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" style="display:inline;">
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