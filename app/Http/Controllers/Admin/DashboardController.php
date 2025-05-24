<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DangerZone;
use App\Models\Device;
use App\Models\User;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
    }

    public function index()
    {
        // Basic counts
        $userCount = User::count();
        $deviceCount = Device::count();
        $zoneCount = DangerZone::count();

        // User stats
        $activeUsers = User::whereNotNull('email_verified_at')->count();
        $inactiveUsers = User::whereNull('email_verified_at')->count();

        // Recent activities
        $recentActivities = Activity::query()
            ->with(['causer' => function ($query) {
                $query->where('causer_type', \App\Models\User::class);
            }])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Chart data: Devices and zones created over the past 7 days
        $days = collect(range(0, 6))->map(function ($offset) {
            return Carbon::today()->subDays($offset)->format('Y-m-d');
        })->reverse();

        $deviceData = [];
        $zoneData = [];

        foreach ($days as $day) {
            $deviceData[$day] = Device::whereDate('created_at', $day)->count();
            $zoneData[$day] = DangerZone::whereDate('created_at', $day)->count();
        }

        return view('admin.dashboard', compact(
            'userCount',
            'deviceCount',
            'zoneCount',
            'activeUsers',
            'inactiveUsers',
            'recentActivities',
            'days',
            'deviceData',
            'zoneData'
        ));
    }
}