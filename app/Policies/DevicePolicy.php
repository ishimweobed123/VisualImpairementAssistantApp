<?php
namespace App\Policies;
use App\Models\User;
use App\Models\Device;
use Illuminate\Auth\Access\Response;

class DevicePolicy
{
    public function view(User $user, Device $device): bool
    {
        return $user->id === $device->user_id || $user->hasRole('admin');
    }

    public function update(User $user, Device $device): bool
    {
        return $user->id === $device->user_id || $user->hasRole('admin');
    }

    public function delete(User $user, Device $device): bool
    {
        return $user->id === $device->user_id || $user->hasRole('admin');
    }
}