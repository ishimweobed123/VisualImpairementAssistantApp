<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\PermissionRequest;

class UserPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Handle user permission request from home page.
     */
    public function requestPermission(Request $request)
    {
        $request->validate([
            'permission' => 'required|string',
            'reason' => 'nullable|string|max:500',
        ]);

        PermissionRequest::create([
            'user_id' => Auth::id(),
            'permission' => $request->permission,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('permission_request_sent', 'Your permission request has been sent to the admin.');
    }
}
