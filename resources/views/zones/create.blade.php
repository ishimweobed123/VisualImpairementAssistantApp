@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create Zone</h1>
    <form action="{{ route('user.zones.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="number" step="any" name="latitude" id="latitude" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="number" step="any" name="longitude" id="longitude" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="radius" class="form-label">Radius (meters)</label>
            <input type="number" name="radius" id="radius" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" name="is_active" id="is_active" class="form-check-input" checked>
            <label for="is_active" class="form-check-label">Active</label>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
</div>
@endsection
