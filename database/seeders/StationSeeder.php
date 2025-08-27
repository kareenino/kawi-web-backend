<?php

namespace Database\Seeders;

use App\Models\Station;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StationSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('stations')->insert([
            ['name'=>'GreenPower Hub','operator_id'=>1,'address'=>'Nairobi CBD, Kenya','capacity'=>20,'available_batteries'=>12,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'EcoVolt Station','operator_id'=>2,'address'=>'Westlands, Nairobi','capacity'=>15,'available_batteries'=>8,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'ChargeMax Point','operator_id'=>3,'address'=>'Kisumu Town','capacity'=>10,'available_batteries'=>3,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'VoltDrive Station','operator_id'=>4,'address'=>'Mombasa Road','capacity'=>25,'available_batteries'=>20,'status'=>'inactive','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'AmpExchange','operator_id'=>5,'address'=>'Thika Superhighway','capacity'=>30,'available_batteries'=>30,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Spiro Swap – South B','operator_id'=>1,'address'=>'South B, Mukoma Rd, Nairobi','capacity'=>22,'available_batteries'=>14,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ampersand Swap – Hurlingham','operator_id'=>2,'address'=>'Hurlingham, Argwings Kodhek Rd, Nairobi','capacity'=>18,'available_batteries'=>9,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'ARC Ride Hub – Industrial Area','operator_id'=>3,'address'=>'Enterprise Rd, Industrial Area, Nairobi','capacity'=>26,'available_batteries'=>20,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Ecobodaa Hub – Kilimani','operator_id'=>4,'address'=>'Sapphire Business Park, Kilimani, Nairobi','capacity'=>16,'available_batteries'=>7,'status'=>'active','created_at'=>now(),'updated_at'=>now()],
            ['name'=>'Kiri EV Swap – Ridgeways','operator_id'=>6,'address'=>'Ridgeways, Kiambu Rd, Nairobi','capacity'=>12,'available_batteries'=>5,'status'=>'inactive','created_at'=>now(),'updated_at'=>now()],
        ]);
    }
}