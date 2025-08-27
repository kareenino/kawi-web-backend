<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('payments')->insert([
            [
                'user_id' => 1,
                'swap_history_id' => 5,
                'method' => 'mpesa',
                'amount' => 150.00,
                'reference' => 'MPESA12345',
                'status' => 'succeeded',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'user_id' => 2,
                'swap_history_id' => 6,
                'method' => 'cash',
                'amount' => 200.00,
                'reference' => null,
                'status' => 'succeeded',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}