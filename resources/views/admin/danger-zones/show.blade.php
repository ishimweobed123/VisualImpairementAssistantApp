@extends('layouts.admin')
@section('title', __('Danger Zone Details'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Danger Zone Details') }}</div>
    <div class="card-body">
        <h4>{{ $dangerZone->name }}</h4>
        <p><strong>Latitude:</strong> {{ $dangerZone->latitude }}</p>
        <p><strong>Longitude:</strong> {{ $dangerZone->longitude }}</p>
        <p><strong>Radius:</strong> {{ $dangerZone->radius }} meters</p>
        <p><strong>Description:</strong> {{ $dangerZone->description ?? 'N/A' }}</p>
        <p><strong>Status:</strong> {{ $dangerZone->is_active ? 'Active' : 'Inactive' }}</p>
        <a href="{{ route('admin.danger-zones.index') }}" class="btn btn-secondary">Back</a>
        <a href="{{ route('admin.danger-zones.edit', $dangerZone) }}" class="btn btn-warning">Edit</a>
    </div>
</div>
@endsection