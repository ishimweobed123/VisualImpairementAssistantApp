@extends('layouts.admin')
@section('title', __('Edit Device'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Edit Device') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.devices.update', $device) }}">
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
                        <option value="ultrasonic" {{ old('type', $device->type) == 'ultrasonic' ? 'selected' : '' }}>Ultrasonic</option>
                        <option value="infrared" {{ old('type', $device->type) == 'infrared' ? 'selected' : '' }}>Infrared</option>
                        <option value="camera" {{ old('type', $device->type) == 'camera' ? 'selected' : '' }}>Camera</option>
                    </select>
                    @error('type')
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
                            <option value="{{ $user->id }}" {{ old('user_id', $device->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
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
</div>
@endsection