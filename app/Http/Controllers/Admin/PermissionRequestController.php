<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class PermissionRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index()
    {
        $requests = PermissionRequest::with('user', 'reviewer')->latest()->get();
        return view('admin.permission_requests.index', compact('requests'));
    }

    public function approve(PermissionRequest $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }
        $request->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        // Assign permission to user
        $user = $request->user;
        if ($user && !$user->hasPermissionTo($request->permission)) {
            $user->givePermissionTo($request->permission);
        }
        return back()->with('success', 'Permission approved and assigned.');
    }

    public function reject(PermissionRequest $request)
    {
        if ($request->status !== 'pending') {
            return back()->with('error', 'Request already processed.');
        }
        $request->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        return back()->with('success', 'Permission request rejected.');
    }
}
