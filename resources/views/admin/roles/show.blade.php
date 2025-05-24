@extends('layouts.admin')
@section('title', __('Role Details'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Role Details') }}</div>
    <div class="card-body">
        <h4>{{ $role->name }}</h4>
        <p><strong>Permissions:</strong> {{ $role->permissions->pluck('name')->implode(', ') ?: 'None' }}</p>
        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection