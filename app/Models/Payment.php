<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'swap_history_id',
        'method',
        'amount',
        'reference',
        'status',
        'mpesa_phone',
        'merchant_request_id',
        'checkout_request_id',
        'mpesa_receipt',
        'result_code',
        'result_desc',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function swapHistory()
    {
        return $this->belongsTo(SwapHistory::class);
    }
}