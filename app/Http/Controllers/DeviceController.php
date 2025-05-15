<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DeviceController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('device-list');
        
        $devices = Device::when(!Auth::user()->hasRole('admin'), function ($query) {
            return $query->where('user_id', Auth::id());
        })->get();

        return view('devices.index', compact('devices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('device-create');
        return view('devices.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('device-create');

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'device_id' => 'required|string|max:255|unique:devices',
            'type' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
        ]);

        $device = Device::create([
            ...$validated,
            'user_id' => Auth::id(),
            'status' => 'offline',
            'battery_level' => 100,
            'is_active' => true,
        ]);

        return redirect()->route('devices.index')
            ->with('success', 'Device created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Device $device)
    {
        $this->authorize('view', $device); // Optional authorization check
        return view('devices.show', compact('device'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Device $device)
    {
        $this->authorize('update', $device); // Optional authorization check
        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Device $device)
    {
        $this->authorize('device-edit');
        $this->authorize('update', $device);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_active' => 'boolean',
        ]);

        $device->update($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Device $device)
    {
        $this->authorize('device-delete');
        $this->authorize('delete', $device);

        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully.');
    }
}
