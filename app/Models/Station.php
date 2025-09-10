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
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function operator()
    {
        return $this->belongsTo(Operator::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function favoredBy()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
}
