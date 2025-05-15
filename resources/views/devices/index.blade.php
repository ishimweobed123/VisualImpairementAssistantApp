<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Devices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @can('device-create')
                        <div class="mb-4">
                            <a href="{{ route('devices.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Add New Device
                            </a>
                        </div>
                    @endcan

                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Device ID
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Type
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Battery
                                    </th>
                                    <th class="px-6 py-3 border-b-2 border-gray-300 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($devices as $device)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                            {{ $device->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                            {{ $device->device_id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                            {{ $device->type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $device->status === 'online' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($device->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $device->battery_level }}%"></div>
                                            </div>
                                            <span class="text-xs">{{ $device->battery_level }}%</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300 text-sm font-medium">
                                            <a href="{{ route('devices.show', $device) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            @can('device-edit')
                                                <a href="{{ route('devices.edit', $device) }}" class="text-yellow-600 hover:text-yellow-900 mr-3">Edit</a>
                                            @endcan
                                            @can('device-delete')
                                                <form action="{{ route('devices.destroy', $device) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this device?')">Delete</button>
                                                </form>
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 whitespace-nowrap border-b border-gray-300 text-center">
                                            No devices found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 