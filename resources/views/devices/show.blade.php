<!-- filepath: resources/views/devices/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Device Details') }}
        </h2>
    </x-slot>

    <div class="container">
        <h1>Device Details</h1>
        <p><strong>Name:</strong> {{ $device->name }}</p>
        <p><strong>Device ID:</strong> {{ $device->device_id }}</p>
        <p><strong>Type:</strong> {{ $device->type }}</p>
        <p><strong>Status:</strong> {{ $device->status }}</p>
        <p><strong>Battery Level:</strong> {{ $device->battery_level }}%</p>
        <p><strong>Location:</strong> {{ $device->location }}</p>
        <p><strong>Active:</strong> {{ $device->is_active ? 'Yes' : 'No' }}</p>
        <a href="{{ route('devices.index') }}" class="btn btn-primary">Back to Devices</a>
    </div>
</x-app-layout>