<?php

namespace Database\Seeders;

use App\Models\Station;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Station::create([
            'name'=>'Total Energies',
            'operator_id'=>'1',
            'address'=>'Nairobi',
            'capacity'=>'100',
            'available_batteries'=>'52',
            'status'=>'active',
        ]);
        Station::create([
            'name'=>'Rubis',
            'operator_id'=>'2',
            'address'=>'Nairobi',
            'capacity'=>'70',
            'available_batteries'=>'30',
            'status'=>'maintenance',
        ]);
        Station::create([
            'name'=>'Shell',
            'operator_id'=>'3',
            'address'=>'Nairobi',
            'capacity'=>'50',
            'available_batteries'=>'12',
            'status'=>'inactive',
        ]);  
    }
}