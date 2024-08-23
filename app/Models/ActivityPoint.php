<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ActivityPoint extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'activity_id', 'timestamp', 'position_lat', 'position_long',
        'heart_rate', 'cadence', 'speed', 'altitude_device', 'power', 'cumulative_distance',
    ];

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class);
    }
}
