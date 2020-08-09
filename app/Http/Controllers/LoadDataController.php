<?php

namespace App\Http\Controllers;

use App\accessory;
use App\BookingType;
use App\Brand;
use App\Engine;
use App\loadData;
use App\Role;
use App\Setting;
use App\Staff;
use App\Supply;
use App\User;
use App\Vehicle_Part;
use App\Vehicle_type;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use LengthException;

class LoadDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function load(){

    /*        $data=[
            'timeStart'=>date("H:m:s"),
            'timeEnd'=>date("H:m:s"),
            'maxBooking'=>2,
            'maxService'=>3,
            'user_id'=>2,
            'created_at'=>now()->toDateTimeString(),
            'updated_at'=>now()->toDateTimeString(),
        ];
        Setting::insert($data);
       
        $data = [];
        for($i = 0;$i < 50; $i++){
            $name = Str::random(30);
            $data[]=[
                'name'=> $name,
                'price'=> rand(11,350),
                'stock'=> rand(100,500),
                'offer'=> 'NO',
                'photo'=> '',
                'created_at'=>now()->toDateTimeString(),
                'updated_at'=>now()->toDateTimeString(),
                'user_id' =>2
            ];
        }

        foreach($data as $dat){
            Supply::insert($dat);
        }
        
        $data = [];
        $array = ['Motorbikes','Car','Van','Small Buses','Others'];
        for($i = 0;$i < count($array) ; $i++){
            $name = $array[$i];
            $data[]=[
                'name'=> $name,             
                'created_at'=>now()->toDateTimeString(),
                'updated_at'=>now()->toDateTimeString(),
                'user_id' =>2
            ];
        }

        foreach($data as $dat){
            Vehicle_type::insert($dat);
        }
        
        $data = [];
        $array = ['Honda','Toyota','Audi','Kia','Hyundai','Suzuki','Jeep','Ford','Mercedes Benz','Nissan','Mitsubishi','Mazda','Acura','Other'];
        for($i = 0;$i < count($array) ; $i++){
            $name = $array[$i];
            $data[]=[
                'name'=> $name,             
                'created_at'=>now()->toDateTimeString(),
                'updated_at'=>now()->toDateTimeString(),
                'user_id' =>2
            ];
        }

        foreach($data as $dat){
            Brand::insert($dat);
        }
        
        $data = [];
        $brands = collect(Brand::all()->modelKeys());
        $vehicletype = collect(Vehicle_type::all()->modelKeys());
        for($i = 0;$i < 50; $i++){
            $name = Str::random(30);
            $data[]=[
                'name'=> $name,
                'brand_id'=> $brands->random(),
                'stock'=> rand(100,500),
                'price'=> rand(11,300),
                'vehicletype_id'=> $vehicletype->random(),
                'photo'=> '',
                'created_at'=>now()->toDateTimeString(),
                'updated_at'=>now()->toDateTimeString(),
                'user_id' =>2
            ];
        }

        foreach($data as $dat){
            Vehicle_Part::insert($dat);
        }

        $data = [];        
        $array = ['Annual Service','Major Service','Repair / Fault and'];
        $prices = [189,200,345];
        $values = [1,2,1];
        $description = ['Repair or replace damaged or worn body components. Include cosmetic repairs for minor dents or scratches.',
        'Maintenance braking or transmission systems.  including the associated electronic systems.  Four-wheel-drive systems.',
        'Full maintenance, radiation and braking systems. Includes stetic repair mirror, cratches, etc'];
        for($i = 0;$i < count($array) ; $i++){
            $name = $array[$i];
            $desc = $description[$i];
            $price = $prices[$i];
            $value = $values[$i];
            $data[]=[
                'name'=> $name,
                'description'=> $desc, 
                'price'=> $price, 
                'value'=> $value,
                'periordStart'=> date("Y-m-d"),
                'periordEnd'=> date("Y-m-d"),             
                'created_at'=>now()->toDateTimeString(),
                'updated_at'=>now()->toDateTimeString(),
                'user_id' =>2
            ];
        }

        foreach($data as $dat){
            BookingType::insert($dat);
        }
        
        $data = [];
        for($i = 0;$i < 50; $i++){
            $name = Str::random(30);
            $data[]=[
                'name'=> $name,
                'price'=> rand(11,350),
                'stock'=> rand(100,500),        
                'photo'=> '',
                'created_at'=>now()->toDateTimeString(),
                'updated_at'=>now()->toDateTimeString(),
                'user_id' =>2
            ];
        }

        foreach($data as $dat){
            accessory::insert($dat);
        }
       /* 
        $min = strtotime("jan 1st -47 years");
        $max = strtotime("dec 31st -18 years");

        for($i = 0;$i < 30; $i++){
            $name = Str::random(30);
            $lastname = Str::random(30);
            $time = rand($min,$max);
            $birth_date = date("Y-m-d",$time);
            $data[]=[
                'name'=> $name,
                'lastname'=> $lastname,
                'gnb'=> rand(2343323,5067876),
                'pps'=> rand(2345,7654),        
                'position'=> 2,
                'showed'=> 'NO',
                'address'=>'',
                'birthday'=>$birth_date,
                'gender'=>'Female',
                'civilStatus'=>'Single',
                'created_at'=>now()->toDateTimeString(),
                'updated_at'=>now()->toDateTimeString(),
                'user_id' =>1
            ];
        }

        foreach($data as $dat){
            Staff::insert($dat);
        }
        */
      //  User::find(3)->assignRole(1);
      //  User::find(2)->assignRole(1);
      $array = ['Diesel','Petrol','Hybrid','Electric','Other'];
      for($i = 0;$i < count($array) ; $i++){
          $name = $array[$i];     
          $data[]=[
              'name'=> $name,
              'created_at'=>now()->toDateTimeString(),
              'updated_at'=>now()->toDateTimeString(),
              'user_id' =>2
          ];
      }

      foreach($data as $dat){
          Engine::insert($dat);
      }
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\loadData  $loadData
     * @return \Illuminate\Http\Response
     */
    public function show(loadData $loadData)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\loadData  $loadData
     * @return \Illuminate\Http\Response
     */
    public function edit(loadData $loadData)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\loadData  $loadData
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, loadData $loadData)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\loadData  $loadData
     * @return \Illuminate\Http\Response
     */
    public function destroy(loadData $loadData)
    {
        //
    }
}
