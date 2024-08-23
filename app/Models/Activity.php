<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'timezone', 'title', 'sport', 'started_at', 'stationary', 'subsport',
        'file', 'total_elapsed_time', 'total_timer_time', 'avg_speed', 'max_speed',
        'total_distance', 'avg_cadence', 'max_cadence', 'avg_power', 'max_power',
        'avg_heart_rate', 'max_heart_rate', 'total_calories', 'total_ascent_device',
        'polyline',
    ];

    protected $casts = [
        'started_at' => 'datetime',
    ];

    public function activityPoints(): HasMany
    {
        return $this->hasMany(ActivityPoint::class);
    }
}
