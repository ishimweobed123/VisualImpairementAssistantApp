@extends('layouts.admin')
@section('title', __('Dashboard'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Admin Dashboard') }}</div>
    <div class="card-body">
        <h4>Welcome to the VisualImpairedAssistance Admin Dashboard</h4>
        <p>Manage devices, roles, permissions, and more from here.</p>
    </div>
</div>
@endsection