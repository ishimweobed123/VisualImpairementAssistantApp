<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User Management
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            
            // Role Management
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            
            // Device Management
            'device-list',
            'device-create',
            'device-edit',
            'device-delete',
            
            // Location Management
            'location-list',
            'location-create',
            'location-edit',
            'location-delete',
            
            // Alert Management
            'alert-list',
            'alert-create',
            'alert-edit',
            'alert-delete',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Add a permission for assigning roles
        if (!Permission::where('name', 'role-assign')->exists()) {
            Permission::create(['name' => 'role-assign']);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(array_merge($permissions, ['role-assign']));

        $caregiverRole = Role::create(['name' => 'caregiver']);
        $caregiverRole->givePermissionTo([
            'user-list',
            'device-list',
            'location-list',
            'alert-list',
            'alert-create',
        ]);

        $visualImpairedRole = Role::create(['name' => 'visual-impaired']);
        $visualImpairedRole->givePermissionTo([
            'device-list',
            'location-list',
            'alert-list',
        ]);
    }
}