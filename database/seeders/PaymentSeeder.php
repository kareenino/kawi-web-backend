<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\SwapHistory;
use Faker\Factory as Faker;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        // Get existing user and swap history IDs
        $userIds = User::pluck('id')->toArray();
        $swapIds = SwapHistory::pluck('id')->toArray();

        foreach (range(1, 20) as $i) {
            $method = $faker->randomElement(['mpesa', 'cash']);
            $isMpesa = $method === 'mpesa';

            DB::table('payments')->insert([
                'user_id'             => $faker->randomElement($userIds),
                'swap_history_id'     => $faker->randomElement($swapIds),
                'method'              => $method,
                'amount'              => $faker->randomFloat(2, 400, 1000),
                'mpesa_phone'         => $isMpesa ? $faker->numerify('07########') : null,
                'merchant_request_id' => $isMpesa ? $faker->uuid : null,
                'checkout_request_id' => $isMpesa ? $faker->uuid : null,
                'mpesa_receipt'       => $isMpesa ? strtoupper($faker->bothify('##??##??')) : null,
                'result_code'         => $isMpesa ? $faker->randomElement(['0', '1']) : null,
                'result_desc'         => $isMpesa ? $faker->randomElement(['Success', 'Failed']) : null,
                'reference'           => strtoupper($faker->bothify('KAWI####')),
                'status'              => $faker->randomElement(['pending', 'succeeded', 'failed']),
                'created_at'          => now(),
                'updated_at'          => now(),
            ]);
        }
    }
}