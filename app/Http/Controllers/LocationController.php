<?php

namespace App\Http\Controllers;

use App\Models\Location;
use App\Models\Device;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class LocationController extends Controller
{
    /**
     * Display the location tracking interface for a device.
     */
    public function index(Device $device)
    {
        // Verify device ownership
        if ($device->user_id !== Auth::id()) {
            abort(403);
        }

        return view('locations.index', compact('device'));
    }

    /**
     * Store a new location for a device.
     */
    public function store(Request $request, Device $device)
    {
        $request->validate([
            'latitude' => 'required|numeric|between:-90,90',
            'longitude' => 'required|numeric|between:-180,180',
            'accuracy' => 'nullable|numeric|min:0',
            'altitude' => 'nullable|numeric',
            'speed' => 'nullable|numeric|min:0',
            'heading' => 'nullable|numeric|between:0,360',
            'timestamp' => 'required|date',
        ]);

        // Verify device ownership
        if ($device->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $location = Location::create([
            'device_id' => $device->id,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'accuracy' => $request->accuracy,
            'altitude' => $request->altitude,
            'speed' => $request->speed,
            'heading' => $request->heading,
            'timestamp' => $request->timestamp,
        ]);

        return response()->json($location, 201);
    }

    /**
     * Get location history for a device.
     */
    public function history(Request $request, Device $device)
    {
        // Verify device ownership
        if ($device->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $query = Location::where('device_id', $device->id);

        if ($request->has('start_date')) {
            $query->where('timestamp', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('timestamp', '<=', $request->end_date);
        }

        $locations = $query->orderBy('timestamp', 'desc')->paginate(50);

        return response()->json($locations);
    }

    /**
     * Get the latest location for a device.
     */
    public function latest(Device $device)
    {
        // Verify device ownership
        if ($device->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $location = Location::where('device_id', $device->id)
            ->latest('timestamp')
            ->first();

        return response()->json($location);
    }

    /**
     * Export location data in CSV or JSON format.
     */
    public function export(Request $request, Device $device)
    {
        // Verify device ownership
        if ($device->user_id !== Auth::id()) {
            abort(403);
        }

        $query = Location::where('device_id', $device->id);

        if ($request->has('start_date')) {
            $query->where('timestamp', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('timestamp', '<=', $request->end_date);
        }

        $locations = $query->orderBy('timestamp', 'asc')->get();

        $format = $request->get('format', 'csv');
        $filename = "device_{$device->id}_locations_" . now()->format('Y-m-d_H-i-s');

        if ($format === 'json') {
            return Response::json($locations)
                ->header('Content-Disposition', "attachment; filename={$filename}.json")
                ->header('Content-Type', 'application/json');
        }

        // CSV format
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}.csv",
        ];

        $callback = function() use($locations) {
            $file = fopen('php://output', 'w');

            // Add CSV headers
            fputcsv($file, [
                'Timestamp',
                'Latitude',
                'Longitude',
                'Accuracy (m)',
                'Altitude (m)',
                'Speed (m/s)',
                'Heading (°)'
            ]);

            // Add data rows
            foreach ($locations as $location) {
                fputcsv($file, [
                    $location->timestamp,
                    $location->latitude,
                    $location->longitude,
                    $location->accuracy,
                    $location->altitude,
                    $location->speed,
                    $location->heading
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
} 