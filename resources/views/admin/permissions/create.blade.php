@extends('layouts.admin')
@section('title', __('Add Permission'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Add Permission') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.permissions.store') }}">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Permission Name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('Add Permission') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection