<?php

namespace App\Http\Controllers;

use App\accessory;
use App\Service;
use App\Staff;
use App\BookingType;
use App\Brand;
use App\Supply;
use App\Vehicle_Part;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
    }

    public function listPublic()
    {        
        $data['staff'] = staff::select('staff.id','staff.name','staff.photo','staff.lastname','staff.showed','roles.name as position')
                                ->join('roles', 'staff.position', '=', 'roles.id')
                                ->where('showed','=','YES')->skip(0)->take(4)->get();         
        $data['bookingtype'] = BookingType::all(); 
        $data['vehicle_parts'] = Vehicle_Part::skip(0)->take(5)->get();
        $data['supplies'] = Supply::skip(0)->take(5)->get();
        $data['accessories'] = accessory::skip(0)->take(5)->get();        
        $data['brands'] = Brand::all();            
        return view('home',$data);       
    }

    public function listServices()
    {
        $data['bookingtype'] = BookingType::all(); 
        return view('services',$data);
    }
    public function listAccessories()
    {
        $data['accessories'] = accessory::paginate(4); 
        return view('listAccessories',$data);
    }
    public function listSupplies()
    {
        $data['supplies'] = Supply::paginate(4); 
        return view('listSupplies',$data);
    }

    public function listVehicleparts()
    {
        $data['vehicle_parts'] = Vehicle_Part::paginate(4); 
        return view('listVehicleparts',$data);
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
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Service $service)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Service $service)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Service $service)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
