@extends('layouts.admin')
@section('title', __('Add Role'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Add Role') }}</div>
    <div class="card-body">
        <form method="POST" action="{{ route('admin.roles.store') }}">
            @csrf
            <div class="form-group row">
                <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Role Name') }}</label>
                <div class="col-md-6">
                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required>
                    @error('name')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <label for="permissions" class="col-md-4 col-form-label text-md-right">{{ __('Permissions') }}</label>
                <div class="col-md-6">
                    @foreach ($permissions as $permission)
                        <div class="form-check">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $permission->name }}</label>
                        </div>
                    @endforeach
                    @error('permissions')
                        <span class="invalid-feedback d-block">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">{{ __('Add Role') }}</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection