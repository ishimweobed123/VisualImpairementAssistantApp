@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 w-100" style="max-width: 500px; border-radius: 1rem;">
        <div class="card-header bg-white border-0 text-center mb-3">
            <h3 class="mb-0"><i class="fas fa-tachometer-alt text-primary me-2"></i>{{ __('Dashboard') }}</h3>
        </div>
        <div class="card-body text-center">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="mb-3">
                <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                <div class="fw-bold fs-5">{{ __('You are logged in!') }}</div>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary mt-2">
                <i class="fas fa-arrow-right me-1"></i> Go to Admin Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
