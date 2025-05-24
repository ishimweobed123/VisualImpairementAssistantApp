<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DangerZone;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class DangerZoneController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
        $this->middleware('permission:zone-list|zone-create|zone-edit|zone-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:zone-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:zone-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:zone-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $zones = DangerZone::latest()->get();
        return view('admin.danger-zones.index', compact('zones'));
    }

    public function create()
    {
        return view('admin.danger-zones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $zone = DangerZone::create([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
        ]);

        Activity::create([
            'log_name' => 'danger_zone',
            'description' => 'Danger zone created by admin',
            'subject_type' => DangerZone::class,
            'subject_id' => $zone->id,
            'causer_type' => \App\Models\User::class,
            'causer_id' => Auth::user()?->id, // Fixed
            'properties' => ['name' => $zone->name, 'coordinates' => [$zone->latitude, $zone->longitude]],
        ]);

       // event(new \App\Events\DangerZoneUpdated($zone));

        return redirect()->route('admin.danger-zones.index')->with('success', 'Danger zone created successfully.');
    }

    public function show(DangerZone $dangerZone)
    {
        return view('admin.danger-zones.show', compact('dangerZone'));
    }

    public function edit(DangerZone $dangerZone)
    {
        return view('admin.danger-zones.edit', compact('dangerZone'));
    }

    public function update(Request $request, DangerZone $dangerZone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'radius' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        $dangerZone->update([
            'name' => $request->name,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'radius' => $request->radius,
            'description' => $request->description,
            'is_active' => $request->is_active ?? true,
        ]);

        Activity::create([
            'log_name' => 'danger_zone',
            'description' => 'Danger zone updated by admin',
            'subject_type' => DangerZone::class,
            'subject_id' => $dangerZone->id,
            'causer_type' => \App\Models\User::class,
            'causer_id' => Auth::user()?->id, // Fixed
            'properties' => ['name' => $dangerZone->name, 'coordinates' => [$dangerZone->latitude, $dangerZone->longitude]],
        ]);

        //event(new \App\Events\DangerZoneUpdated($dangerZone));

        return redirect()->route('admin.danger-zones.index')->with('success', 'Danger zone updated successfully.');
    }

    public function destroy(DangerZone $dangerZone)
    {
        $zoneName = $dangerZone->name;
        $dangerZone->delete();

        Activity::create([
            'log_name' => 'danger_zone',
            'description' => 'Danger zone deleted by admin',
            'subject_type' => DangerZone::class,
            'subject_id' => $dangerZone->id,
            'causer_type' => \App\Models\User::class,
            'causer_id' => Auth::user()?->id, // Fixed
            'properties' => ['name' => $zoneName],
        ]);

    // event(new \App\Events\DangerZoneUpdated($dangerZone));

        return redirect()->route('admin.danger-zones.index')->with('success', 'Danger zone deleted successfully.');
    }
}