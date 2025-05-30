<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $users = User::with('roles')->latest()->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => bcrypt($request->password),
            'email_verified_at' => now(),
        ]);

        if ($request->roles) {
            // Convert role IDs to names before syncing
            $roleNames = Role::whereIn('id', $request->roles)->pluck('name')->toArray();
            $user->syncRoles($roleNames);
        }

        Activity::create([
            'log_name' => 'user',
            'description' => 'User created by admin',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'causer_type' => User::class,
            'causer_id' => optional(Auth::user())->id,
            'properties' => ['name' => $user->name, 'email' => $user->email],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        $user->load('roles', 'devices');
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone_number' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array',
            'roles.*' => 'exists:roles,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        // Convert role IDs to names before syncing
        $roleNames = Role::whereIn('id', $request->roles ?? [])->pluck('name')->toArray();
        $user->syncRoles($roleNames);
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        Activity::create([
            'log_name' => 'user',
            'description' => 'User updated by admin',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'causer_type' => User::class,
            'causer_id' => optional(Auth::user())->id,
            'properties' => ['name' => $user->name, 'email' => $user->email],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->getKey() === Auth::user()?->id) {
            return redirect()->route('admin.users.index')->with('error', 'Cannot delete yourself.');
        }

        $user->delete();

        Activity::create([
            'log_name' => 'user',
            'description' => 'User deleted by admin',
            'subject_type' => User::class,
            'subject_id' => $user->id,
            'causer_type' => User::class,
            'causer_id' => Auth::id(),
            'properties' => ['name' => $user->name, 'email' => $user->email],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
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

        // You can store this in a table or send a notification/email to admin
        // For demo, just log or flash a message
        // Example: store in a table called permission_requests (not implemented here)

        // Optionally, notify admin or log
        // activity()->causedBy(auth()->user())->log('Requested permission: ' . $request->permission);

        return redirect()->back()->with('permission_request_sent', 'Your permission request has been sent to the admin.');
    }
}