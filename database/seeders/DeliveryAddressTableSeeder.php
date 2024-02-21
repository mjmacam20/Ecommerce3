<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords = [
            ['user_id'=>1,'name'=>'Albert','address'=>'123-binloc','city'=>'Dagupan','state'=>'Pangasinan','country'=>'Philippines','zincode'=>'2432','mobile'=>'21234567899','status'=>'1'],
            ['user_id'=>2,'name'=>'Albert','address'=>'23-binloc','city'=>'Mangaldan','state'=>'Pangasinan','country'=>'Philippines','zincode'=>'2432','mobile'=>'21234876599','status'=>'1'],
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
