@extends('layouts.admin')
@section('title', __('Devices'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('All Devices') }}</div>
    <div class="card-body">
        <a href="{{ route('admin.devices.create') }}" class="btn btn-primary mb-3">Add Device</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>User</th>
                    <th>MAC Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($devices as $device)
                    <tr>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->type ?? 'N/A' }}</td>
                        <td>{{ ucfirst($device->status) }}</td>
                        <td>{{ $device->user->name }}</td>
                        <td>{{ $device->mac_address }}</td>
                        <td>
                            <a href="{{ route('admin.devices.show', $device) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.devices.edit', $device) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.devices.destroy', $device) }}" method="POST" style="display:inline;">
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