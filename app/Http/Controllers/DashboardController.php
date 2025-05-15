<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Location;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Get total users (only for admin)
        $totalUsers = $user->hasRole('admin') ? User::count() : null;
        
        // Get device statistics
        $devices = $user->hasRole('admin') 
            ? Device::all() 
            : $user->devices()->get();
            
        $totalDevices = $devices->count();
        $activeDevices = $devices->where('is_active', true)->count();
        
        // Get today's locations
        $locationsToday = $totalDevices > 0 
            ? Location::whereIn('device_id', $devices->pluck('id'))
                ->whereDate('timestamp', Carbon::today())
                ->count()
            : 0;
            
        // Get recent activities
        $recentActivities = $this->getRecentActivities($user);
        
        // Get device status
        $deviceStatus = $this->getDeviceStatus($devices);
        
        // Get recent locations
        $recentLocations = $totalDevices > 0
            ? Location::whereIn('device_id', $devices->pluck('id'))
                ->with('device')
                ->latest()
                ->take(5)
                ->get()
            : collect();

        return view('dashboard', compact(
            'totalUsers',
            'totalDevices',
            'activeDevices',
            'locationsToday',
            'recentActivities',
            'deviceStatus',
            'recentLocations'
        ));
    }
    
    private function getRecentActivities($user)
    {
        $activities = [];
        
        // Add recent device activities
        $recentDevices = $user->devices()
            ->latest()
            ->take(3)
            ->get();
            
        foreach ($recentDevices as $device) {
            $activities[] = [
                'title' => 'New Device Added',
                'description' => "Device {$device->name} was added to your account",
                'time' => $device->created_at->diffForHumans(),
                'color' => 'bg-green-100',
                'icon' => '<svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" /></svg>'
            ];
        }
        
        // Add recent location updates
        if ($user->devices()->exists()) {
            $recentLocations = Location::whereIn('device_id', $user->devices->pluck('id'))
                ->latest()
                ->take(3)
                ->get();
                
            foreach ($recentLocations as $location) {
                $activities[] = [
                    'title' => 'Location Updated',
                    'description' => "Device {$location->device->name} reported new location",
                    'time' => $location->timestamp->diffForHumans(),
                    'color' => 'bg-blue-100',
                    'icon' => '<svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>'
                ];
            }
        }
        
        // Sort activities by time
        usort($activities, function($a, $b) {
            return strtotime($b['time']) - strtotime($a['time']);
        });
        
        return array_slice($activities, 0, 5);
    }
    
    private function getDeviceStatus($devices)
    {
        $total = $devices->count();
        if ($total === 0) {
            return [
                [
                    'name' => 'Active Devices',
                    'count' => 0,
                    'percentage' => 0,
                    'color' => 'bg-green-500'
                ],
                [
                    'name' => 'Inactive Devices',
                    'count' => 0,
                    'percentage' => 0,
                    'color' => 'bg-red-500'
                ]
            ];
        }
        
        $active = $devices->where('is_active', true)->count();
        $inactive = $total - $active;
        
        return [
            [
                'name' => 'Active Devices',
                'count' => $active,
                'percentage' => ($active / $total) * 100,
                'color' => 'bg-green-500'
            ],
            [
                'name' => 'Inactive Devices',
                'count' => $inactive,
                'percentage' => ($inactive / $total) * 100,
                'color' => 'bg-red-500'
            ]
        ];
    }
} 