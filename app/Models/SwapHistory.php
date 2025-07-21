<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SwapHistory extends Model
{
    protected $fillable = [
        'user_id',
        'station_id',
        'battery_count',
        'notes',
        'swapped_at'
    ];

    protected $casts = [
        'swapped_at' => 'datetime',
    ];
}