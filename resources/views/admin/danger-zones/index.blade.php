@extends('layouts.admin')
@section('title', __('Danger Zones'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('All Danger Zones') }}</div>
    <div class="card-body">
        <a href="{{ route('admin.danger-zones.create') }}" class="btn btn-primary mb-3">Add Danger Zone</a>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Latitude</th>
                    <th>Longitude</th>
                    <th>Radius (m)</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($zones as $zone)
                    <tr>
                        <td>{{ $zone->name }}</td>
                        <td>{{ $zone->latitude }}</td>
                        <td>{{ $zone->longitude }}</td>
                        <td>{{ $zone->radius }}</td>
                        <td>{{ $zone->is_active ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <a href="{{ route('admin.danger-zones.show', $zone) }}" class="btn btn-sm btn-info">View</a>
                            <a href="{{ route('admin.danger-zones.edit', $zone) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.danger-zones.destroy', $zone) }}" method="POST" style="display:inline;">
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