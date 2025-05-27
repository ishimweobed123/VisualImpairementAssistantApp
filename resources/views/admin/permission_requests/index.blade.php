@extends('layouts.admin')
@section('title', 'Permission Requests')
@section('content')
<div class="container">
    <h2 class="mb-4">Permission Requests</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Permission</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Reviewed By</th>
                <th>Reviewed At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $request)
                <tr>
                    <td>{{ $request->user->name ?? 'N/A' }}</td>
                    <td>{{ $request->permission }}</td>
                    <td>{{ $request->reason }}</td>
                    <td>
                        @if($request->status == 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @elseif($request->status == 'approved')
                            <span class="badge bg-success">Approved</span>
                        @else
                            <span class="badge bg-danger">Rejected</span>
                        @endif
                    </td>
                    <td>{{ $request->reviewer->name ?? '-' }}</td>
                    <td>{{ $request->reviewed_at ? $request->reviewed_at->format('Y-m-d H:i') : '-' }}</td>
                    <td>
                        @if($request->status == 'pending')
                            <form method="POST" action="{{ route('admin.permission-requests.approve', $request) }}" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.permission-requests.reject', $request) }}" style="display:inline-block;">
                                @csrf
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <span class="text-muted">No actions</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center">No permission requests found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
