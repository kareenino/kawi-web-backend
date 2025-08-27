<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcoPoint extends Model
{
    protected $table = 'ecopoints';

    protected $fillable = [
        'user_id', 
        'swap_history_id', 
        'points_delta', 
        'balance_after', 
        'reason',
    ];

    public function user()
    {
         return $this->belongsTo(User::class); 
    }
    
    public function swapHistory()
    {
        return $this->belongsTo(SwapHistory::class); 
    }

    // Auto-calc balance_after on create if not provided
    protected static function booted(): void
    {
        // static::creating(function (EcoPoint $row) {
        //     if (is_null($row->balance_after)) {
        //         $prev = static::where('user_id', $row->user_id)
        //             ->orderByDesc('id')
        //             ->value('balance_after') ?? 0;

        //         $row->balance_after = $prev + (int) $row->points_delta;
        //     }
        // });
    }
}