@extends('layouts.app')
@section('content')
<div class="card-header">{{ __('Add Device') }}</div>
<div class="card-body">
    <form method="POST" action="{{ route('user.devices.store') }}">
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
                    <option value="ultrasonic" {{ old('type') == 'ultrasonic' ? 'selected' : '' }}>Ultrasonic</option>
                    <option value="infrared" {{ old('type') == 'infrared' ? 'selected' : '' }}>Infrared</option>
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
        <div class="form-group row mb-0">
            <div class="col-md-6 offset-md-4">
                <button type="submit" class="btn btn-primary">{{ __('Add Device') }}</button>
            </div>
        </div>
    </form>
</div>
@endsection