@extends('layouts.admin')
@section('title', __('Add Danger Zone'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Add Danger Zone') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.danger-zones.store') }}">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="latitude" class="col-md-4 col-form-label text-md-right">{{ __('Latitude') }}</label>
                <div class="col-md-6">
                    <input id="latitude" type="number" step="any" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" required>
                    @error('latitude')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="longitude" class="col-md-4 col-form-label text-md-right">{{ __('Longitude') }}</label>
                <div class="col-md-6">
                    <input id="longitude" type="number" step="any" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}" required>
                    @error('longitude')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="radius" class="col-md-4 col-form-label text-md-right">{{ __('Radius (meters)') }}</label>
                <div class="col-md-6">
                    <input id="radius" type="number" class="form-control @error('radius') is-invalid @enderror" name="radius" value="{{ old('radius') }}" required>
                    @error('radius')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>
                <div class="col-md-6">
                    <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="is_active" class="col-md-4 col-form-label text-md-right">{{ __('Active') }}</label>
                <div class="col-md-6">
                    <input id="is_active" type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', true) ? 'checked' : '' }}>
                </div>
            </div>
              <button onclick="window.history.back()" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('Add Danger Zone') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection