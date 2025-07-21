<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SwapHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class SwapHistorySeeder extends Seeder
{
    public function run(): void
    {
        // Optionally truncate table first
        // DB::table('swap_histories')->truncate();

        SwapHistory::insert([
            [
                'user_id' => 1,
                'station_id' => 1,
                'battery_count' => 1,
                'swapped_at' => Carbon::now()->subDays(1),
                'notes' => 'Smooth swap',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 1,
                'station_id' => 2,
                'battery_count' => 2,
                'swapped_at' => Carbon::now()->subDays(2),
                'notes' => 'Quick and easy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'station_id' => 1,
                'battery_count' => 1,
                'swapped_at' => Carbon::now()->subHours(3),
                'notes' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}