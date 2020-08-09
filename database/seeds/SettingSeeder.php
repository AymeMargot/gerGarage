<?php

use App\Setting;
use App\User;
use Illuminate\Database\Seeder;#
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $users = collect(User::all()->modelKeys());
       $data  = [];
       $data[] = [
           'maxBooking' => 2,
           'maxService' => 3,           
           'user_id' => $users->random()
       ];

       foreach($data as $set){
            Setting::insert($set);
       }
       
    }
}
