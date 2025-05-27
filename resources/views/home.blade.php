@extends('layouts.app')
@section('title', 'Home')
@section('content')
<div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg p-4 w-100" style="max-width: 520px; border-radius: 1rem;">
        <div class="card-header bg-white border-0 text-center mb-3">
            <h3 class="mb-0">
                <i class="fas fa-home text-primary me-2"></i>Welcome Home
            </h3>
        </div>
        <div class="card-body text-center">
            <div class="mb-3">
                <i class="fas fa-user fa-2x text-success mb-2"></i>
                <div class="fw-bold fs-4">Hi, {{ Auth::user()->name }}!</div>
                <div>
                    <span class="fw-opacity-75 text-muted">Role: 
                        @if(Auth::user()->roles->count())
                            @foreach(Auth::user()->roles as $role)
                                <span class="badge bg-primary">{{ ucfirst($role->name) }}</span>
                            @endforeach
                        @else
                            <span class="badge bg-secondary">User</span>
                        @endif
                    </span> 
                </div>
            </div>

            <div class="mb-3">
                <strong class="text-success">
                    @if(Auth::user()->hasRole('admin'))
                        You are an <span class="text-danger">Administrator</span> 🤝 – Everything is unlocked!
                        <br>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-primary.2 btn-block mt-3">
                            <i class="fas fa-tachometer-alt me-1"></i> Go to Admin Dashboard
                        </a>
                    @else
                        <span>Below is what you are allowed to access so far:</span>
                        <div class="mt-2">
                            <ul class="list-group mb-2 text-start shadow lead">
                                @forelse(Auth::user()->getAllPermissions() as $permission)
                                    @php $perm = $permission->name; @endphp
                                    <li class="list-group-item py-2 d-flex align-items-center justify-content-between">
                                        <div>
                                            <i class="fas fa-check-circle text-success"></i>
                                            <span class="ms-1 fst-normal">{{ ucfirst(str_replace('_',' ', $perm)) }}</span>
                                            <span class="badge bg-info ms-2">{{ $permission->guard_name ?? 'web' }}</span>
                                        </div>
                                        @if($perm == 'device-list')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.devices.index') : route('user.devices.index') }}" class="btn btn-outline-primary btn-sm">View Devices</a>
                                        @elseif($perm == 'device-create')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.devices.create') : route('user.devices.create') }}" class="btn btn-outline-success btn-sm">Add Device</a>
                                        @elseif($perm == 'device-edit')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.devices.index') : route('user.devices.index') }}" class="btn btn-outline-warning btn-sm">Edit Device</a>
                                        @elseif($perm == 'device-delete')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.devices.index') : route('user.devices.index') }}" class="btn btn-outline-danger btn-sm">Delete Device</a>
                                        @elseif($perm == 'zone-list')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.danger-zones.index') : '#' }}" class="btn btn-outline-primary btn-sm">View Zones</a>
                                        @elseif($perm == 'zone-create')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.danger-zones.create') : '#' }}" class="btn btn-outline-success btn-sm">Add Zone</a>
                                        @elseif($perm == 'zone-edit')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.danger-zones.index') : '#' }}" class="btn btn-outline-warning btn-sm">Edit Zone</a>
                                        @elseif($perm == 'zone-delete')
                                            <a href="{{ Auth::user()->hasRole('admin') ? route('admin.danger-zones.index') : '#' }}" class="btn btn-outline-danger btn-sm">Delete Zone</a>
                                        @elseif($perm == 'role-list')
                                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary btn-sm">View Roles</a>
                                        @elseif($perm == 'role-create')
                                            <a href="{{ route('admin.roles.create') }}" class="btn btn-outline-success btn-sm">Add Role</a>
                                        @elseif($perm == 'role-edit')
                                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-warning btn-sm">Edit Role</a>
                                        @elseif($perm == 'role-delete')
                                            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-danger btn-sm">Delete Role</a>
                                        @elseif($perm == 'user-list')
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">View Users</a>
                                        @elseif($perm == 'user-create')
                                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-success btn-sm">Add User</a>
                                        @elseif($perm == 'user-edit')
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-warning btn-sm">Edit User</a>
                                        @elseif($perm == 'user-delete')
                                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-danger btn-sm">Delete User</a>
                                        @elseif($perm == 'danger-zone-list')
                                            <a href="{{ route('admin.danger-zones.index') }}" class="btn btn-outline-primary btn-sm">View Danger Zones</a>
                                        @elseif($perm == 'danger-zone-create')
                                            <a href="{{ route('admin.danger-zones.create') }}" class="btn btn-outline-success btn-sm">Add Danger Zone</a>
                                        @elseif($perm == 'danger-zone-edit')
                                            <a href="{{ route('admin.danger-zones.index') }}" class="btn btn-outline-warning btn-sm">Edit Danger Zone</a>
                                        @elseif($perm == 'danger-zone-delete')
                                            <a href="{{ route('admin.danger-zones.index') }}" class="btn btn-outline-danger btn-sm">Delete Danger Zone</a>
                                        @elseif($perm == 'obstacle-view')
                                            <a href="#" class="btn btn-outline-info btn-sm">View Obstacles</a>
                                        @elseif($perm == 'settings-edit')
                                            <a href="#" class="btn btn-outline-info btn-sm">Edit Settings</a>
                                        @elseif($perm == 'report-view')
                                            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-primary btn-sm">View Reports</a>
                                        @elseif($perm == 'report-generate')
                                            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-success btn-sm">Generate Report</a>
                                        @else
                                            <span class="text-muted small">No direct action</span>
                                        @endif
                                    </li>
                                @empty
                                    <li class="list-group-item">
                                        <i class="fas fa-exclamation-circle text-danger"></i>
                                        No permissions assigned. Please contact your administrator.
                                    </li>
                                @endforelse
                            </ul>
                        </div>
                    @endif
                </strong>
            </div>
        </div>
    </div>
</div>
@endsection
