<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FavoritesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('favorites')->insert([
            [
                'user_id'    => 1,
                'station_id' => 10,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id'    => 1,
                'station_id' => 12,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id'    => 2,
                'station_id' => 13,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}