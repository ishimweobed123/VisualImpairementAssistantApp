@extends('layouts.admin')
@section('title', __('Reports'))
@section('content')
<div class="card">
    <div class="card-header">{{ __('Activity Reports') }}</div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.reports.index') }}" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <label for="start_date">{{ __('Start Date') }}</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="end_date">{{ __('End Date') }}</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-3">
                    <label for="log_name">{{ __('Log Type') }}</label>
                    <select name="log_name" id="log_name" class="form-control">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($logNames as $name)
                            <option value="{{ $name }}" {{ request('log_name') == $name ? 'selected' : '' }}>{{ ucfirst($name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="causer_id">{{ __('User') }}</label>
                    <select name="causer_id" id="causer_id" class="form-control">
                        <option value="">{{ __('All') }}</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}" {{ request('causer_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">{{ __('Filter') }}</button>
                    <a href="{{ route('admin.reports.pdf', request()->query()) }}" class="btn btn-success">{{ __('Download PDF') }}</a>
                    <a href="{{ route('admin.reports.csv', request()->query()) }}" class="btn btn-info">{{ __('Download CSV') }}</a>
                </div>
            </div>
        </form>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Log Name</th>
                    <th>Description</th>
                    <th>User</th>
                    <th>Subject Type</th>
                    <th>Subject ID</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($logs as $log)
                    <tr>
                        <td>{{ $log->id }}</td>
                        <td>{{ $log->log_name }}</td>
                        <td>{{ $log->description }}</td>
                        <td>{{ $log->causer ? $log->causer->name : 'N/A' }}</td>
                        <td>{{ $log->subject_type ?? 'N/A' }}</td>
                        <td>{{ $log->subject_id ?? 'N/A' }}</td>
                        <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $logs->links() }}
    </div>
</div>
@endsection