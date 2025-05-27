<?php

namespace App\Http\Controllers;

use App\Models\DangerZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserZoneController extends Controller
{
    public function index()
    {
        $zones = DangerZone::all();
        return view('zones.index', compact('zones'));
    }

    public function create()
    {
        return view('zones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        DangerZone::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->route('user.zones.index')->with('success', 'Zone created successfully.');
    }

    public function show(DangerZone $zone)
    {
        return view('zones.show', compact('zone'));
    }

    public function edit(DangerZone $zone)
    {
        return view('zones.edit', compact('zone'));
    }

    public function update(Request $request, DangerZone $zone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $zone->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        return redirect()->route('user.zones.index')->with('success', 'Zone updated successfully.');
    }

    public function destroy(DangerZone $zone)
    {
        $zone->delete();
        return redirect()->route('user.zones.index')->with('success', 'Zone deleted successfully.');
    }
}
