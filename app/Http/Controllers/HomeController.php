<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\BookingType;
use App\Brand;
use App\Staff;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $data['services'] = service::paginate(4);     
        $data['staff'] = staff::paginate(3); 
        $data['bookingtype'] = BookingType::paginate(4); 
        $data['brands'] = Brand::paginate(8);  
        return view('home');
    }
}
