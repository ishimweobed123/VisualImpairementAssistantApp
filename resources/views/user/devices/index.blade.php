@extends('layouts.app')
@section('content')
<div class="card-header">{{ __('My Devices') }}</div>
<div class="card-body">
    <a href="{{ route('user.devices.create') }}" class="btn btn-primary mb-3">Add Device</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Status</th>
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
                    <td>{{ $device->mac_address }}</td>
                    <td>
                        <a href="{{ route('user.devices.show', $device) }}" class="btn btn-sm btn-info">View</a>
                        <a href="{{ route('user.devices.edit', $device) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('user.devices.destroy', $device) }}" method="POST" style="display:inline;">
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
@endsection