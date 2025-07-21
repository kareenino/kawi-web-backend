<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = [
        'name',
        'operator_id',
        'address',
        'capacity',
        'available_batteries',
        'status',
        'opening_hours',
    ];
}
