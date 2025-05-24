<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
        $this->middleware('permission:device-list|device-create|device-edit|device-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:device-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:device-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:device-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $devices = Device::with('user')->latest()->get();
        return view('admin.devices.index', compact('devices'));
    }

    public function create()
    {
        $users = User::all();
        return view('admin.devices.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'mac_address' => 'required|string|unique:devices,mac_address',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        $device = Device::create([
            'name' => $request->name,
            'type' => $request->type,
            'mac_address' => $request->mac_address,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ]);

        Activity::create([
            'log_name' => 'device',
            'description' => 'Device created by admin',
            'subject_type' => Device::class,
            'subject_id' => $device->id,
            'causer_type' => User::class,
            'causer_id' => Auth::user()?->id, // Fixed
        ]);

        return redirect()->route('admin.devices.index')->with('success', 'Device added successfully.');
    }

    public function show(Device $device)
    {
        $obstacles = $device->obstacles()->latest()->take(10)->get();
        return view('admin.devices.show', compact('device', 'obstacles'));
    }

    public function edit(Device $device)
    {
        $users = User::all();
        return view('admin.devices.edit', compact('device', 'users'));
    }

    public function update(Request $request, Device $device)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:active,inactive',
        ]);

        $device->update([
            'name' => $request->name,
            'type' => $request->type,
            'user_id' => $request->user_id,
            'status' => $request->status,
        ]);

        Activity::create([
            'log_name' => 'device',
            'description' => 'Device updated by admin',
            'subject_type' => Device::class,
            'subject_id' => $device->id,
            'causer_type' => User::class,
            'causer_id' => Auth::user()?->id, // Fixed
        ]);

        return redirect()->route('admin.devices.index')->with('success', 'Device updated successfully.');
    }

    public function destroy(Device $device)
    {
        $device->delete();

        Activity::create([
            'log_name' => 'device',
            'description' => 'Device deleted by admin',
            'subject_type' => Device::class,
            'subject_id' => $device->id,
            'causer_type' => User::class,
            'causer_id' => Auth::user()?->id, // Fixed
        ]);

        return redirect()->route('admin.devices.index')->with('success', 'Device deleted successfully.');
    }
}