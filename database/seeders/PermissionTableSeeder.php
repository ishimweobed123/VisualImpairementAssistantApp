<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionTableSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'user-list', 'user-create', 'user-edit', 'user-delete',
            'device-list', 'device-create', 'device-edit', 'device-delete',
            'role-list', 'role-create', 'role-edit', 'role-delete',
            'danger-zone-list', 'danger-zone-create', 'danger-zone-edit', 'danger-zone-delete',
            'obstacle-view', 'settings-edit',
            'report-view', 'report-generate',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}