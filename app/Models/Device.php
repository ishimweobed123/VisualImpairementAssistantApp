<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Device extends Model
{
    use LogsActivity;

    protected $fillable = [
        'name', 'type', 'status', 'user_id', 'mac_address', 'api_token',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'type', 'status', 'mac_address'])
            ->logOnlyDirty()
            ->setDescriptionForEvent(fn(string $eventName) => "Device {$eventName}");
    }
}