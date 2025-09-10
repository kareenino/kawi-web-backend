<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operator extends Model
{
    protected $fillable = [
        'user_id',
        'company_name',
        'phone_number',
        'region',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function stations()
    {
        return $this->hasMany(Station::class);
    }
    public function bikes()
    {
        return $this->hasMany(Bike::class);
    }
}