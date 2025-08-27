<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable =[
        'station_id',
        'user_id',
        'rating',
        'comment'
    ];

    public function station()
    {
        return $this->belongsTo(Station::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}