<?php
namespace App\Http\Controllers;
use App\Models\Device;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('permission:device-list|device-create|device-edit|device-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:device-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:device-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:device-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $devices = Auth::user()->devices()->latest()->get();
        return view('user.devices.index', compact('devices'));
    }

    public function create()
    {
        return view('user.devices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'mac_address' => 'required|string|unique:devices,mac_address',
        ]);

        $device = Auth::user()->devices()->create([
            'name' => $request->name,
            'type' => $request->type,
            'mac_address' => $request->mac_address,
            'status' => 'active',
        ]);

        Activity::create([
            'log_name' => 'device',
            'description' => 'Device created',
            'subject_type' => Device::class,
            'subject_id' => $device->id,
            'causer_type' => User::class,
            'causer_id' => Auth::id(),
        ]);

        return redirect()->route('user.devices.index')->with('success', 'Device added successfully.');
    }

    public function show(Device $device)
    {
        $this->authorize('view', $device);
        $obstacles = $device->obstacles()->latest()->take(10)->get();
        return view('user.devices.show', compact('device', 'obstacles'));
    }

    public function edit(Device $device)
    {
        $this->authorize('update', $device);
        return view('user.devices.edit', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        $this->authorize('update', $device);
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'nullable|string|max:100',
            'status' => 'required|in:active,inactive',
        ]);

        $device->update([
            'name' => $request->name,
            'type' => $request->type,
            'status' => $request->status,
        ]);

        Activity::create([
            'log_name' => 'device',
            'description' => 'Device updated',
            'subject_type' => Device::class,
            'subject_id' => $device->id,
            'causer_type' => User::class,
            'causer_id' => Auth::id()
                ]);

        return redirect()->route('user.devices.index')->with('success', 'Device updated successfully.');
    }

    public function destroy(Device $device)
    {
        $this->authorize('delete', $device);
        $device->delete();

        Activity::create([
            'log_name' => 'device',
            'description' => 'Device deleted',
            'subject_type' => Device::class,
            'subject_id' => $device->id,
            'causer_type' => User::class,
            'causer_id' => Auth::id(),
        ]);

        return redirect()->route('user.devices.index')->with('success', 'Device deleted successfully.');
    }

    public function authenticate(Request $request): JsonResponse
    {
        $request->validate([
            'mac_address' => 'required|string',
        ]);

        $device = Device::where('mac_address', $request->mac_address)->first();

        if (!$device) {
            return response()->json(['error' => 'Device not found'], 404);
        }

        $token = Str::random(60);
        $device->update(['api_token' => hash('sha256', $token)]);

        Activity::create([
            'log_name' => 'device',
            'description' => 'Device authenticated',
            'subject_type' => Device::class,
            'subject_id' => $device->id,
            'causer_type' => null,
            'causer_id' => null,
        ]);

        return response()->json(['token' => $token], 200);
    }
}