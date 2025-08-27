<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SwapHistoriesSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

         DB::table('swap_histories')->insert([

            [
                'user_id' => 1,
                'station_id' => 10,
                'bike_id' => 1,
                'operator_id' => 8,
                'battery_count' => 1,
                'price' => 150.00,
                'status' => 'completed',
                'notes' => 'First test swap at CBD',
                'swapped_at' => $now->subDay(),
            ],
            [
                'user_id' => 1,
                'station_id' => 11,
                'bike_id' => null,
                'operator_id' => 9,
                'battery_count' => 2,
                'price' => 300.00,
                'status' => 'completed',
                'notes' => 'Double battery swap',
                'swapped_at' => $now->subDay(),
                
            ],
            [
                'user_id' => 2,
                'station_id' => 12,
                'bike_id' => 1,
                'operator_id' => 10,
                'battery_count' => 1,
                'price' => 200.00,
                'status' => 'failed',
                'notes' => 'Swap attempt failed due to low stock',
                'swapped_at' => $now->subHours(12),
                
            ],
            [
                'user_id' => 3,
                'station_id' => 13,
                'bike_id' => null, // user hadn’t added bike yet
                'operator_id' => 11,
                'battery_count' => 1,
                'price' => 180.00,
                'status' => 'completed',
                'notes' => null,
                'swapped_at' => $now->subHours(5),
                
            ],
        ]);
    }
}