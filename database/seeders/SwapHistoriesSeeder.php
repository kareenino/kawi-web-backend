<?php

namespace Database\Seeders;

use App\Models\Bike;
use App\Models\Operator;
use App\Models\Station;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SwapHistoriesSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Get real IDs from existing data
        $userIds = User::pluck('id')->toArray();
        $bikeIds = Bike::pluck('id')->toArray();
        $stationIds = Station::pluck('id')->toArray();
        $operatorIds = Operator::pluck('id')->toArray();

        foreach (range(1, 16) as $i) {
            DB::table('swap_histories')->insert([
                'user_id'       => $faker->randomElement($userIds),
                'station_id'    => $faker->randomElement($stationIds),
                'bike_id'       => $faker->randomElement($bikeIds),
                'operator_id'   => $faker->randomElement($operatorIds),
                'battery_count' => $faker->numberBetween(1, 2),
                'price' => $faker->randomFloat(2, 400, 1000),
                'status'        => $faker->randomElement(['completed', 'failed']),
                'notes'         => $faker->optional()->sentence(),
                'swapped_at'    => $faker->dateTimeBetween('-7 days', 'now'),
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }

        // $now = now();

        //  DB::table('swap_histories')->insert([

        //     [
        //         'user_id' => 1,
        //         'station_id' => 10,
        //         'bike_id' => 1,
        //         'operator_id' => 8,
        //         'battery_count' => 1,
        //         'price' => 150.00,
        //         'status' => 'completed',
        //         'notes' => 'First test swap at CBD',
        //         'swapped_at' => $now->subDay(),
        //     ],
        //     [
        //         'user_id' => 1,
        //         'station_id' => 11,
        //         'bike_id' => null,
        //         'operator_id' => 9,
        //         'battery_count' => 2,
        //         'price' => 300.00,
        //         'status' => 'completed',
        //         'notes' => 'Double battery swap',
        //         'swapped_at' => $now->subDay(),
                
        //     ],
        //     [
        //         'user_id' => 2,
        //         'station_id' => 12,
        //         'bike_id' => 1,
        //         'operator_id' => 10,
        //         'battery_count' => 1,
        //         'price' => 200.00,
        //         'status' => 'failed',
        //         'notes' => 'Swap attempt failed due to low stock',
        //         'swapped_at' => $now->subHours(12),
                
        //     ],
        //     [
        //         'user_id' => 3,
        //         'station_id' => 13,
        //         'bike_id' => null, // user hadn’t added bike yet
        //         'operator_id' => 11,
        //         'battery_count' => 1,
        //         'price' => 180.00,
        //         'status' => 'completed',
        //         'notes' => null,
        //         'swapped_at' => $now->subHours(5),
                
        //     ],
        // ]);
    }
}