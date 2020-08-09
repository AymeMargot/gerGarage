<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingType;
use App\Brand;
use App\Engine;
use App\Vehicle;
use App\Roster;
use App\Setting;
use App\Vehicle_type;
use Illuminate\Http\Request;
use App\Staff;
use Illuminate\Support\Facades\Date;
use Mockery\Undefined;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index()
    {
        $data['bookings'] = Booking::select(
            'bookings.*',            
            'users.name As customer',
            'vehicles.name As vehicle',
            'booking_types.name As bookingtype',
            'booking_types.id As bookingtype_id',
            'bookings.status',
            'bookings.description',     
            'vehicles.license',   
            'rosters.id as roster_id',
            'rosters.date as roster_date',
            'vehicle_types.name as typevehicle'    
        )
            ->join('vehicles', 'bookings.vehicle_id', '=', 'vehicles.id')
            ->join('users','bookings.user_id','=','users.id')
            ->join('rosters','bookings.roster_id','=','rosters.id')
            ->join('vehicle_types', 'vehicles.vehicleType', '=', 'vehicle_types.id')
            ->join('booking_types', 'bookings.bookingtype_id', '=', 'booking_types.id')
            ->orderBy('bookings.created_at', 'Asc')->paginate(5);  
        $maxservice = $this->getMaxService();
        $data['booking_types'] = BookingType::select('id','name')->get();
        $data['rosters'] = Roster::select('rosters.*','staff.name','staff.lastname')
                                    ->join('staff', 'rosters.staff_id', '=', 'staff.id')
                                    ->where('rosters.workload','<',$maxservice)->get();
        return view('bookings.index', $data);
    }

    public function getMaxService(){
         return(Setting::all()->last()->maxService);
    }
    /**
     * Show the form    for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create()
    {
        $data['bookings'] = Booking::select(
            'bookings.*',           
            'vehicles.license',      
            'vehicle_types.name as typevehicle',
            'booking_types.name As bookingtype'        )
            ->join('vehicles', 'bookings.vehicle_id', '=', 'vehicles.id')
            ->join('vehicle_types', 'vehicles.vehicleType', '=', 'vehicle_types.id')
            ->join('booking_types', 'bookings.bookingtype_id', '=', 'booking_types.id')
            ->where('bookings.user_id','=', auth()->id())->orderBy('bookings.created_at', 'desc')->limit(1)->get();
      
        $data['vehicles'] = Vehicle::select('id','name','license')->where('user_id', auth()->id())->get();
        $data['booking_types'] = BookingType::select('id', 'name','description','price')->get();
        $data['vehicle_types'] = Vehicle_type::select('id', 'name')->get();
        $data['makes'] = Brand::select('id', 'name')->get();
        $data['engines'] = Engine::select('id', 'name')->get();
        return view('bookings.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getRoster($date,$maxservice){
       // $date="2020-08-04";        
        $id = Roster::all()
                    ->where('date', '=', $date)
                    ->where('workload', '<', $maxservice)               
                    ->pluck('id'); 
       // echo "ROSTER".$id[0];     
        if($id->isEmpty())
            return -1;
        else
            return $id[0];
     }
    public function getBooksUserDay($user,$day){
        $qty = Booking::where('user_id', '=', $user)
            ->where('date', '=', $day)
            ->where('status', '=', 'BOOKED')
            ->orwhere('status', '=', 'INSERVICE')
            ->get()->count();
        if($qty)
            return $qty;
        else
            return 0;
    }
    public function getVehicleUserDay($vehicle,$day,$user){
        $qty = Booking::where('user_id', '=', $user)
            ->where('date', '=', $day)
            ->where('vehicle_id', '=', $vehicle)
            ->get()->count();
        if($qty)
            return $qty;
        else
            return 0;
    }
    public function store(Request $request)
    {        
        $sql = Setting::all()->last();
        $maxService = $sql->maxService;
        $maxBooking = $sql->maxBooking;

        $vehicle = $request->get('Vehicle');
        $date = $request->get('Date');
        $typebooking = $request->get('BookingType');
        $countRowUser = $this->getBooksUserDay(auth()->id(),$date);
        $countRowVehicle = $this->getVehicleUserDay($vehicle,$date,auth()->id());
        
        $roster = $this->getRoster($date,$maxService);
        //validating        
        $this->validate($request, [
            'BookingType' => 'required',
            'Description' => 'required',
            'Vehicle' => 'required',
            'Date' => 'required|date|after:yesterday'     
        ]);

        if ($countRowVehicle > 0) // avoiding have 2 records for the same vehicle
            return redirect('bookings/create')->with('error','You already made a booking for this vehicle, choose another one');
    
        if (($countRowUser + 1) > $maxBooking)// Controlling max numbers of booking per user
            return redirect('bookings/create')->with('error','Sorry you already got the limit pending book number: ' . $maxBooking);
        
        if ($roster == -1) // Verifing if there is staff available
            return redirect('bookings/create')->with('error','Sorry, there is no staff available at the moment, please try with another date');
        
        $bookings = [
            'user_id' => auth()->id(),
            'status' => 'BOOKED',
            'bookingtype_id' => $request->get('BookingType'),
            'description' => $request->get('Description'),
            'roster_id'=> $roster,
            'vehicle_id' => $request->get('Vehicle'), 
            'diagnosis' => '',            
            'date' => $request->get('Date')          
        ];
        //return response()->json($bookings);
        if(Booking::insert($bookings)){
            if($this->updateRoster($roster,$typebooking,'add'))
                return redirect('bookings/create')->with('success', 'Data saved');
            else
                return redirect('bookings/create')->with('error', 'Roster not update, something is going wrong, try again');    
        }
        return redirect('bookings/create')->with('error', 'Something is going wrong, try again');     
        
    }

    public function search(Request $bookings){
        $this->validate($bookings, [
            'From' => 'required|date|before_or_equal:To',
            'To' => 'required|date',             
        ]);
        $from = $bookings->get('From');
        $to = $bookings->get('To');

        $data['bookings'] = Booking::select(
            'bookings.*',            
            'users.name As customer',
            'vehicles.name As vehicle',
            'booking_types.name As bookingtype',
            'booking_types.id As bookingtype_id',
            'bookings.status',
            'bookings.description',     
            'vehicles.license',   
            'rosters.id as roster_id',
            'rosters.date as roster_date',
            'vehicle_types.name as typevehicle'          )
            ->join('vehicles', 'bookings.vehicle_id', '=', 'vehicles.id')
            ->join('users','bookings.user_id','=','users.id')
            ->join('rosters','bookings.roster_id','=','rosters.id')
            ->join('vehicle_types', 'vehicles.vehicleType', '=', 'vehicle_types.id')
            ->join('booking_types', 'bookings.bookingtype_id', '=', 'booking_types.id')
            ->whereBetween('bookings.date', [$from, $to])->paginate(5);      
            
        $maxservice = $this->getMaxService();
        $data['booking_types'] = BookingType::select('id','name')->get();
        $data['rosters'] = Roster::select('rosters.*','staff.name','staff.lastname')
                           ->join('staff', 'rosters.staff_id', '=', 'staff.id')
                           ->where('rosters.workload','<',$maxservice)->get();
     return view('bookings.index',$data);   
    }
 
    public function updateRoster($roster,$type,$action){   
        
        $value = BookingType::where('id','=',$type)->first()->value;
        $valuenew = Roster::where('id','=',$roster)->first()->workload;
 
        if($action == "add")      
            $valueUpdate = $value + $valuenew;
        else
            $valueUpdate = $valuenew - $value;
        echo 'valueUpdate'.$valueUpdate;
        $update=Roster::where('id','=',$roster)           
                       ->update(['workload' => $valueUpdate]);
        if($update)
            return true;
        else
           return false;          
    }

    public function getVehicle($id)
    {
        $userData['data'] = Vehicle::orderby("name", "asc")
            ->select('id', 'name', 'license', 'color')
            ->where('department', $id)
            ->get();
        echo json_encode($userData);
        exit;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $id)
    {
        $sql = Booking::where('id','=',$request->booking_id)->first();
        $bookingtype_id = $sql->bookingtype_id;
        $roster_id = $sql->roster_id;
 
        if(($request->get('bookingtype_id')!= $sql->bookingtype_id) || ($request->get('roster_id')!= $sql->roster_id)){          
            $this->updateRoster($sql->roster_id,$sql->bookingtype_id,'subtract');
            $this->updateRoster($request->get('roster_id'),$request->get('bookingtype_id'),'add');
        } 

        if($request->get('bookingtype_id') != $sql->bookingtype_id)
            $bookingtype_id = $request->get('bookingtype_id');      
        
        if($request->get('roster_id') != $sql->roster_id)
            $roster_id = $request->get('roster_id');
        
        $diagnosis = "";
        if($request->get('Diagnosis')!="")
            $diagnosis = $request->get('Diagnosis');

        if($sql){
            $bookings = [            
                'bookingtype_id' => $bookingtype_id,
                'description'=> $request->get('Description'),
                'diagnosis' => $diagnosis,
                'status' => $request->get('status_id'),
                'roster_id' => $roster_id           
            ];
         //   return response()->json($bookings);
            if(Booking::where('id','=',$sql->id)->update($bookings)){
               // if($request->get('status_id')=='COLLECTED' || $request->get('status_id')=='FIXED' || $request->get('status_id')=='UNREPAIRABLE')
                 //   $this->updateRoster($roster_id,$bookingtype_id,'subtract');
                return redirect('bookings')->with('success','Book updated successfuly');
            }
            else 
                return redirect('bookings')->with('error','Something is going wrong, please try again');
        }
        else
        return redirect('bookings')->with('error','Something is going wrong, Booking not found');                  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroyByuser($id)
    {             
        $sql = Booking::where('id','=',$id)->first();     
       // return response()->json($sql);
          if($sql){
            if($sql->status !='BOOKED')
                return redirect('bookings/create')->with('error','This book is being processing, please contact to the office for cancelling');            
        
            $delete= Booking::findOrfail($sql->id)->delete();
            if($delete){
                $this->updateRoster($sql->roster_id,$sql->bookingtype_id,'subtract');
                return redirect('bookings/create')->with('success','Part deleted successfuly');                
            }
            else    
                return redirect('bookings/create')->with('error','Something is wrong, try later');
        }
        else
        return redirect('bookings/create')->with('error','Booking not found, try again'); 
    }

    public function destroy(request $bookings, $id)
    {             
        $sql = Booking::where('id','=',$bookings->get('booking_id'))->first();     
       // return response()->json($sql);
          if($sql){
            if($sql->status !='BOOKED')
                return redirect('bookings')->with('error','This book is being processing, the status should be BOOKED to be deleted');            
        
            $delete= Booking::findOrfail($sql->id)->delete();
            if($delete){
                $this->updateRoster($sql->roster_id,$sql->bookingtype_id,'subtract');
                return redirect('bookings')->with('success','Part deleted successfuly');                
            }
            else    
                return redirect('bookings')->with('error','Something is wrong, try later');
        }
        else
        return redirect('bookings')->with('error','Booking not found, try again'); 
    }

   

   
}
