<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('operators')->insert([
            ['user_id'=>1, 'company_name'=>'Spiro', 'phone_number'=>'+254711660372', 'region'=>'Old Mombasa Road, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>2, 'company_name'=>'Ampersand Energy', 'phone_number'=>'', 'region'=>'Hurlingham / Dagoretti / Mountain View, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>3, 'company_name'=>'ARC Ride', 'phone_number'=>'', 'region'=>'Enterprise Rd (GoDown area), Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>14, 'company_name'=>'Ecobodaa Mobility', 'phone_number'=>'0748198333', 'region'=>'Kilimani / Sapphire Business Park, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>16, 'company_name'=>'Roam (Opibus)', 'phone_number'=>'+254740666555', 'region'=>'National Park East Gate Rd, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>1, 'company_name'=>'Kiri EV', 'phone_number'=>'+254758949026', 'region'=>'Ridgeways Springs, Kiambu Road, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>2, 'company_name'=>'Opibus (e-motos)', 'phone_number'=>'+254757460552', 'region'=>'Airport North Road, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>3, 'company_name'=>'Mobius Motors (e-bike)', 'phone_number'=>'0800662487', 'region'=>'Sameer Business Park, Mombasa Road, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>14, 'company_name'=>'BasiGo', 'phone_number'=>'', 'region'=>'Industrial Area, Nairobi','created_at' => now(),
                    'updated_at' => now(),],
            ['user_id'=>16,'company_name'=>'EMAK (ecosystem)', 'phone_number'=>'', 'region'=>'Nairobi','created_at' => now(),
                    'updated_at' => now(),],
        ]);
    }
}