<?php

namespace App\Http\Controllers;

use App\Vehicle;
use Illuminate\Http\Request;
use App\Booking;
use App\BookingType;
use App\Brand;
use App\Vehicle_type;
use App\Engine;


class VehicleController extends Controller
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['brands'] = Brand::select('id','name')->get();
        $data['vehicle_types'] = Vehicle_type::select('id','name')->get();
        $data['engines'] = Engine::select('id','name')->get();
        return view('vehicles.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       /* $this->validate($request,[
            'VehicleType' => 'required',  
            'Engine' => 'required', 
            'Brand' => 'required',
            'License' => 'required|unique:vehicles',    
            'Name' => 'required' 
        ]);
        */
        $vehicles =[
            'license' => $request->get('License'),
            'vehicleType' => $request->get('VehicleType'),
            'name' => $request->get('Name'),
            'brand' => $request->get('Brand'),
            'engine' => $request->get('Engine'),
            'user_id' => auth()->id()
        ];
       // $vehicles = $request->except(['_token']);
        if(Vehicle::insert( $vehicles))
            return redirect('bookings/create')->with('success','Vehicle added successfuly');
         else
            return redirect('bookings/create')->with('error','Something is wrong, try later');
            
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        //
    }
}
