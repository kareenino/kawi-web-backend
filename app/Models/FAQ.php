<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FAQ extends Model
{
    // protected $table = 'f_a_q_s';
    protected $table = 'faqs';

    protected $fillable = [
        'question',
        'answer',
        'is_published'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}