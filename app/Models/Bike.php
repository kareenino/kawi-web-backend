<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bike extends Model
{
    protected $fillable = [
        'user_id',
        'plate_number',
        'name',
        'insurance_expiry',
        'last_serviced_at',
    ];

    protected $casts = [
        'insurance_expiry' => 'date',
        'last_serviced_at' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // app/Models/Bike.php
    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }
}