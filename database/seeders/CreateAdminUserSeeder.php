<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class CreateAdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password123'),
            'email_verified_at' => now(),
        ]);

        $role = Role::create(['name' => 'admin']);
        $permissions = Permission::pluck('id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole('admin');

        $userRole = Role::create(['name' => 'user']);
        $userRole->syncPermissions(['obstacle-view', 'settings-edit', 'device-list', 'device-create']);
    }
}