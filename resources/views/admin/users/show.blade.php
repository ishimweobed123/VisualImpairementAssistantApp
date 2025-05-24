@extends('layouts.admin')
@section('title', __('User Details'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('User Details') }}</div>
    <div class="card-body">
        <h4>{{ $user->name }}</h4>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Phone Number:</strong> {{ $user->phone_number ?? 'N/A' }}</p>
        <p><strong>Roles:</strong> {{ $user->roles->pluck('name')->implode(', ') ?: 'None' }}</p>
        <h5 class="mt-4">Devices</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>MAC Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($user->devices as $device)
                    <tr>
                        <td>{{ $device->name }}</td>
                        <td>{{ $device->type ?? 'N/A' }}</td>
                        <td>{{ ucfirst($device->status) }}</td>
                        <td>{{ $device->mac_address }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">No devices assigned.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection