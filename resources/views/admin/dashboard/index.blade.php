@extends('layouts.admin')
@section('content')
    <div class="container-fluid">
        <!-- Widgets -->
        <div class="row">
            <div class="col-lg-3 col-6">
                <div class="small-box bg-info">
                    <div class="inner">
                        <h3>{{ $userCount }}</h3>
                        <p>Total Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>{{ $deviceCount }}</h3>
                        <p>Devices</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-microchip"></i>
                    </div>
                    <a href="{{ route('admin.devices.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-warning">
                    <div class="inner">
                        <h3>{{ $zoneCount }}</h3>
                        <p>Danger Zones</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <a href="{{ route('admin.danger-zones.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="small-box bg-primary">
                    <div class="inner">
                        <h3>{{ $activeUsers }}</h3>
                        <p>Active Users</p>
                    </div>
                    <div class="icon">
                        <i class="fas fa-user-check"></i>
                    </div>
                    <a href="{{ route('admin.users.index') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>

        <!-- User Stats -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">User Statistics</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Active Users:</strong> {{ $activeUsers }}</p>
                        <p><strong>Inactive Users:</strong> {{ $inactiveUsers }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activities -->
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Recent Activities</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group">
                            @forelse ($recentActivities as $activity)
                                <li class="list-group-item">
                                    <strong>{{ $activity->description }}</strong> by
                                    @if ($activity->causer)
                                        {{ $activity->causer->name }}
                                    @else
                                        Unknown
                                    @endif
                                    <br>
                                    <small>{{ $activity->created_at->diffForHumans() }}</small>
                                </li>
                            @empty
                                <li class="list-group-item">No recent activities.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart -->
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Devices and Danger Zones (Last 7 Days)</h3>
                    </div>
                    <div class="card-body">
                        <canvas id="activityChart" height="100"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            window.chartData = {
                labels: @json($days),
                deviceData: @json(array_values($deviceData)),
                zoneData: @json(array_values($zoneData))
            };
        </script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const chartLabels = window.chartData.labels;
                const deviceData = window.chartData.deviceData;
                const zoneData = window.chartData.zoneData;

                const ctx = document.getElementById('activityChart').getContext('2d');
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [
                            {
                                label: 'Devices Created',
                                data: deviceData,
                                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                borderColor: 'rgba(54, 162, 235, 1)',
                                borderWidth: 1
                            },
                            {
                                label: 'Danger Zones Created',
                                data: zoneData,
                                backgroundColor: 'rgba(255, 206, 86, 0.5)',
                                borderColor: 'rgba(255, 206, 86, 1)',
                                borderWidth: 1
                            }
                        ]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Count'
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Date'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                position: 'top'
                            }
                        }
                    }
                });
            });
        </script>
    @endpush
@endsection