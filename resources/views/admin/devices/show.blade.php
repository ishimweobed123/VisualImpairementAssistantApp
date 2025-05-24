@extends('layouts.admin')
@section('title', __('Device Details'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Device Details') }}</div>
    <div class="card-body">
        <h4>{{ $device->name }}</h4>
        <p><strong>Type:</strong> {{ $device->type ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ ucfirst($device->status) }}</p>
        <p><strong>User:</strong> {{ $device->user->name }}</p>
        <p><strong>MAC Address:</strong> {{ $device->mac_address }}</p>
        <h5 class="mt-4">Recent Obstacle Detections</h5>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Distance (m)</th>
                    <th>Type</th>
                    <th>Location</th>
                    <th>Detected At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($obstacles as $obstacle)
                    <tr>
                        <td>{{ $obstacle->distance ?? 'N/A' }}</td>
                        <td>{{ $obstacle->type ?? 'N/A' }}</td>
                        <td>{{ $obstacle->latitude && $obstacle->longitude ? "{$obstacle->latitude}, {$obstacle->longitude}" : 'N/A' }}</td>
                        <td>{{ $obstacle->detected_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.devices.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection