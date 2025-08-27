<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\Station;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'station_id' => 10,
                'user_id' => 1,
                'rating' => 5,
                'comment' => 'Great service and fast swap',
            ],
            [
                'station_id' =>11,
                'user_id' => 2,
                'rating' => 4,
                'comment' => 'Convenient location but a bit crowded.',
            ],
            [
                'station_id' => 12,
                'user_id' => 1,
                'rating' => 3,
                'comment' => 'Battery stock was low during peak hour.',
            ],
            [
                'station_id' => 13,
                'user_id' => 3,
                'rating' => 5,
                'comment' => 'Super smooth experience. Highly recommend!',
            ],
            [
                'station_id' => 14,
                'user_id' => null,
                'rating' => 4,
                'comment' => 'Quick and easy but no staff on-site.',
            ],
        ]);
    }
}