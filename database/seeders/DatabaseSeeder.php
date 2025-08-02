<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        //order matters
        $this->call([
            UserSeeder::class,
            OperatorSeeder::class,
            UserSeeder::class,
            StationSeeder::class,
            SwapHistorySeeder::class
        ]);
    }
}
