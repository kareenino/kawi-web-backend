<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BikeSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('bikes')->insert([
            'user_id'          => 1,
            'plate_number'     => 'KDM 1234',
            'model'            => 'Spiro Automax 2015',
            'year'             => 2015,
            'insurance_expiry' => now()->addYear(),
            'last_serviced_at' => now()->subMonths(2),
            'odometer_km'      => 15200,
            'photo_url'        => null,
            'created_at'       => now(),
            'updated_at'       => now(),
        ]);
    }
}