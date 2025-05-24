<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('role:admin');
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:permission-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $permissions = Permission::all();
        return view('admin.permissions.index', compact('permissions'));
    }

    public function create()
    {
        return view('admin.permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:permissions']);
        $permission = Permission::create(['name' => $request->name]);

        Activity::create([
            'log_name' => 'permission',
            'description' => 'Permission created by admin',
            'subject_type' => Permission::class,
            'subject_id' => $permission->id,
            'causer_id' => Auth::user()?->id, // Fixed
           // 'causer_id' => auth()->user()?->id, // Fixed
            'properties' => ['name' => $permission->name],
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission created.');
    }

    public function show(Permission $permission)
    {
        return view('admin.permissions.show', compact('permission'));
    }

    public function edit(Permission $permission)
    {
        return view('admin.permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate(['name' => 'required|string|max:255|unique:permissions,name,' . $permission->id]);
        $permission->update(['name' => $request->name]);

        Activity::create([
            'log_name' => 'permission',
            'description' => 'Permission updated by admin',
            'subject_type' => Permission::class,
            'subject_id' => $permission->id,
            'causer_type' => \App\Models\User::class,
            'causer_id' => Auth::user()?->id, // Fixed
            'properties' => ['name' => $permission->name],
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission updated.');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        Activity::create([
            'log_name' => 'permission',
            'description' => 'Permission deleted by admin',
            'subject_type' => Permission::class,
            'subject_id' => $permission->id,
            'causer_type' => \App\Models\User::class,
            'causer_id' => Auth::user()?->id, // Fixed
            'properties' => ['name' => $permission->name],
        ]);

        return redirect()->route('admin.permissions.index')->with('success', 'Permission deleted.');
    }
}