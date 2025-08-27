<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = [
        'user_id',
        'plate_number',
        'model',
        'year',
        'insurance_expiry',
        'last_serviced_at',
        'odometer_km',
        'photo_url',
    ];

    protected $casts = [
        'insurance_expiry' => 'date',
        'last_serviced_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}