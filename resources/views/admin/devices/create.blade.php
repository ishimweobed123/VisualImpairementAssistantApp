@extends('layouts.admin')
@section('title', __('Add Device'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Add Device') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.devices.store') }}">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Device Name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
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
                        <option value="Smart cane" {{ old('type') == 'Smart cane' ? 'selected' : '' }}>Smart cane</option>
                        <option value="wearable device" {{ old('type') == 'wearable device' ? 'selected' : '' }}>wearable device</option>
                        <option value="camera" {{ old('type') == 'camera' ? 'selected' : '' }}>Camera</option>
                    </select>
                    @error('type')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="mac_address" class="col-md-4 col-form-label text-md-right">{{ __('MAC Address') }}</label>
                <div class="col-md-6">
                    <input id="mac_address" type="text" class="form-control @error('mac_address') is-invalid @enderror" name="mac_address" value="{{ old('mac_address') }}" required>
                    @error('mac_address')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="user_id" class="col-md-4 col-form-label text-md-right">{{ __('User') }}</label>
                <div class="col-md-6">
                    <select id="user_id" class="form-control @error('user_id') is-invalid @enderror" name="user_id" required>
                        <option value="">Select User</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                    @error('user_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                <div class="col-md-6">
                    <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
                        <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('Add Device') }}</button>
                </div>
            </div>
              <button onclick="window.history.back()" class="btn btn-outline-secondary me-2">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
        </form>
    </div>
</div>
@endsection