<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Device;
use App\Models\User;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'admin@example.com')->first();
        Device::create([
            'name' => 'Ultrasonic Sensor',
            'type' => 'ultrasonic',
            'status' => 'active',
            'user_id' => $user->id,
            'mac_address' => '00:1B:44:11:3A:B7',
        ]);
    }
}