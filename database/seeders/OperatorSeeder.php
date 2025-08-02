<?php

namespace Database\Seeders;

use App\Models\Operator;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Operator::create([
            'user_id'=>'2',
            'company_name'=>'Spiro',
            'phone_number'=>'0711111',
            'region'=>'Mombasa Road',
        ]);
        Operator::create([
            'user_id'=>'2',
            'company_name'=>'ARC',
            'phone_number'=>'07222222',
            'region'=>'Thika Road',
        ]);
        Operator::create([
           'user_id'=>'2',
            'company_name'=>'Ampersand',
            'phone_number'=>'07333333',
            'region'=>'Kasarani',
        ]);
        Operator::create([
           'user_id'=>'2',
            'company_name'=>'Spiro 2',
            'phone_number'=>'07444444',
            'region'=>'Madaraka',
        ]);
        Operator::create([
           'user_id'=>'2',
            'company_name'=>'ARC 2',
            'phone_number'=>'07555555',
            'region'=>'Langata',
        ]);
    }
}