<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('f_a_q_s')->insert([
            [
                'question' => 'How do I locate the nearest battery swapping station?',
                'answer'   => 'Open the app and go to the map screen. It will automatically show the closest battery swapping stations based on your GPS location.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'What do I need to start using a swapping station?',
                'answer'   => 'You need a registered account, a compatible e-motorbike, and an active subscription or payment method linked to your profile.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'How much does a battery swap cost?',
                'answer'   => 'Pricing may vary by station, but typically a single swap costs between KES 100 and KES 150 depending on location and battery size.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Can I reserve a battery in advance?',
                'answer'   => 'Yes, the app allows you to reserve a battery for up to 30 minutes to ensure availability when you arrive.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'What should I do if the station is out of batteries?',
                'answer'   => 'The app will notify you if a station is low or out of stock. You can find the next closest station using the in-app map.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
