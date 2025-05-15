<!-- filepath: resources/views/devices/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Device</h1>
        <form method="POST" action="{{ route('devices.update', $device->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $device->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <input type="text" name="type" id="type" class="form-control" value="{{ old('type', $device->type) }}" required>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" name="location" id="location" class="form-control" value="{{ old('location', $device->location) }}">
            </div>

            <div class="mb-3">
                <label for="is_active" class="form-label">Active</label>
                <select name="is_active" id="is_active" class="form-control">
                    <option value="1" {{ $device->is_active ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ !$device->is_active ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Update Device</button>
            <a href="{{ route('devices.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection