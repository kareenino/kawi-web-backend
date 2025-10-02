<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\BikeSeeder;
use Database\Seeders\ReviewSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\StationSeeder;
use Database\Seeders\OperatorSeeder;
use Database\Seeders\SwapHistoriesSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        //order matters
        $this->call([
            // UserSeeder::class,
            // OperatorSeeder::class,
            // UserSeeder::class,
            // SwapHistoriesSeeder::class,
            // StationSeeder::class,
            // ReviewSeeder::class,
            // BikeSeeder::class,
            PaymentSeeder::class,
            // EcoPointsSeeder::class,
            // FavoritesSeeder::class,
        ]);
    }
}