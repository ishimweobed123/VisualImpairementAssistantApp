<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Obstacle extends Model
{
    protected $fillable = [
        'device_id', 'distance', 'type', 'latitude', 'longitude', 'detected_at',
    ];

    protected $casts = [
        'detected_at' => 'datetime',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}