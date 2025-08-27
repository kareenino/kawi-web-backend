<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EcoPointsSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('ecopoints')->insert([
            [
                'user_id' => 1,
                'points_change' => 10,
                'balance_after' => 10,
                'reason' => 'swap completed',
                'created_at' => $now->copy()->subDays(3),
                'updated_at' => $now->copy()->subDays(3),
            ],
            [
                'user_id' => 1,
                'points_change' => 5,
                'balance_after' => 15,
                'reason' => 'bonus promo',
                'created_at' => $now->copy()->subDay(),
                'updated_at' => $now->copy()->subDay(),
            ],
            [
                'user_id' => 2,
                'points_change' => 8,
                'balance_after' => 8,
                'reason' => 'swap completed',
                'created_at' => $now->copy()->subHours(12),
                'updated_at' => $now->copy()->subHours(12),
            ],
        ]);
    }
}