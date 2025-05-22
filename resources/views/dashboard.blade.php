<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- Debug output for userSignupTrends --}}
            @if(isset($userSignupTrends))
                <pre style="background:#eee;padding:10px;overflow:auto;max-width:100vw;">{{ var_export($userSignupTrends, true) }}</pre>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Users</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalUsers }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Devices</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $totalDevices }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Active Devices</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $activeDevices }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-red-100">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Locations Today</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ $locationsToday }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Recent Activity</h3>
                            <div class="space-y-4">
                                @foreach($recentActivities as $activity)
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0">
                                            <div class="p-2 rounded-full {{ $activity['color'] }}">
                                                {!! $activity['icon'] !!}
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-medium text-gray-900">{{ $activity['title'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $activity['description'] }}</p>
                                            <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Quick Actions</h3>
                            <div class="space-y-3">
                                <a href="{{ route('devices.create') }}" class="block w-full text-left px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Add New Device
                                </a>
                                <a href="{{ route('devices.index') }}" class="block w-full text-left px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                                    View All Devices
                                </a>
                                @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('users.index') }}" class="block w-full text-left px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700">
                                        Manage Users
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Device Status -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mt-6">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-4">Device Status</h3>
                            <div class="space-y-4">
                                @foreach($deviceStatus as $status)
                                    <div>
                                        <div class="flex justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">{{ $status['name'] }}</span>
                                            <span class="text-sm font-medium text-gray-700">{{ $status['count'] }}</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="h-2.5 rounded-full {{ $status['color'] }}" style="width: {{ $status['percentage'] }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Locations -->
            <div class="mt-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Recent Locations</h3>
                            <a href="{{ route('locations.index', ['device' => $recentLocations->first()?->device->id ?? 1]) }}" class="text-sm text-blue-600 hover:text-blue-800">View All</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Device</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($recentLocations as $location)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $location->device->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $location->device->device_id }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $location->latitude }}, {{ $location->longitude }}</div>
                                                <div class="text-sm text-gray-500">Accuracy: {{ $location->accuracy }}m</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $location->timestamp->diffForHumans() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $location->device->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                    {{ $location->device->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Device Usage Trend Chart (last 7 days) -->
            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">Device Usage Trend (Last 7 Days)</h3>
                <canvas id="deviceTrendChart" height="100"></canvas>
            </div>
            @endif

            <!-- User Signup Trend Chart (last 7 days) -->
            @if(isset($userSignupTrends) && $userSignupTrends)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="text-lg font-semibold mb-4">User Signups Trend (Last 7 Days)</h3>
                <canvas id="userSignupTrendChart" height="100"></canvas>
            </div>
            @endif

            <!-- Notifications & System Health Widgets -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
                <!-- Notifications -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg class="w-5 h-5 text-yellow-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M12 20a8 8 0 100-16 8 8 0 000 16z" /></svg>
                            Notifications
                        </h3>
                        <ul class="space-y-3">
                            @forelse($notifications as $notification)
                                <li class="flex items-start bg-yellow-50 border-l-4 border-yellow-400 p-3 rounded">
                                    <div class="flex-shrink-0 mt-1">
                                        <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M8.257 3.099c.366-.446.957-.446 1.323 0l7.451 9.09c.329.401.034.911-.462.911H2.268c-.496 0-.791-.51-.462-.911l7.451-9.09z" /></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-800">{{ $notification['title'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $notification['time'] }}</p>
                                    </div>
                                </li>
                            @empty
                                <li class="text-gray-500 text-sm">No new notifications.</li>
                            @endforelse
                        </ul>
                    </div>
                </div>
                <!-- System Health -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            System Health
                        </h3>
                        <ul class="space-y-2">
                            <li class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Server Status</span>
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Online</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">API Latency</span>
                                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">{{ $systemHealth['api_latency'] ?? 'N/A' }} ms</span>
                            </li>
                            <li class="flex justify-between items-center">
                                <span class="text-sm text-gray-700">Database</span>
                                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">{{ $systemHealth['database'] ?? 'OK' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const deviceTrendLabels = {!! json_encode($deviceTrends ? collect($deviceTrends)->pluck('date')->values() : []) !!};
        const deviceTrendCounts = {!! json_encode($deviceTrends ? collect($deviceTrends)->pluck('count')->values() : []) !!};
        @if(isset($userSignupTrends) && $userSignupTrends)
        const userSignupTrendLabels = {!! json_encode(collect($userSignupTrends)->pluck('date')->values()) !!};
        const userSignupTrendCounts = {!! json_encode(collect($userSignupTrends)->pluck('count')->values()) !!};
        @endif
        const ctx = document.getElementById('deviceTrendChart')?.getContext('2d');
        if(ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: deviceTrendLabels,
                    datasets: [{
                        label: 'Devices Added',
                        data: deviceTrendCounts,
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision:0 } }
                    }
                }
            });
        }
        @if(isset($userSignupTrends) && $userSignupTrends)
        const ctxSignup = document.getElementById('userSignupTrendChart')?.getContext('2d');
        if(ctxSignup) {
            new Chart(ctxSignup, {
                type: 'line',
                data: {
                    labels: userSignupTrendLabels,
                    datasets: [{
                        label: 'User Signups',
                        data: userSignupTrendCounts,
                        borderColor: 'rgba(16, 185, 129, 1)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 5,
                        pointBackgroundColor: 'rgba(16, 185, 129, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false },
                        title: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true, ticks: { precision:0 } }
                    }
                }
            });
        }
        @endif
    </script>
    @endif
    @endpush
</x-app-layout>
