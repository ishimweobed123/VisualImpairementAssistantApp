@extends('layouts.app')
@section('content')
<div class="card-header">{{ __('Edit Device') }}</div>
<div class="card-body">
    <form method="POST" action="{{ route('user.devices.update', $device) }}">
        @csrf
        @method('PUT')
        <div class="form-group row">
            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Device Name') }}</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $device->name) }}" required>
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="type" class="col-md-4 col-form-label text-md-right">{{ __('Type') }}</label>
            <div class="col-md-6">
                <select id="type" class="form-control @error('type') is-invalid @enderror" name="type">
                    <option value="">Select Type</option>
                    <option value="Smart cane" {{ old('type', $device->type) == 'Smart cane' ? 'selected' : '' }}>Smart cane</option>
                    <option value="wearable device" {{ old('type', $device->type) == 'wearable device' ? 'selected' : '' }}>wearable device</option>
                    <option value="camera" {{ old('type', $device->type) == 'camera' ? 'selected' : '' }}>Camera</option>
                </select>
                @error('type')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group row">
            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
            <div class="col-md-6">
                <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                    <option value="active" {{ old('status', $device->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $device->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">{{ __('Update Device') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection