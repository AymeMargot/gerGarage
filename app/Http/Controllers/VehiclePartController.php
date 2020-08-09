<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Vehicle_Part;
use App\Vehicle_type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehiclePartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data= $this->getVehicle_partsAll();   
        return view('vehicle_parts.index',$data);
    }

    public function search(Request $vehicle_parts){       
        
        $find = $vehicle_parts->get('Find');
        if($find == 'all')
            $find='';
      //  echo 'find'.$find;
      $data['vehicle_parts']= Vehicle_Part::select(
        'vehicle__parts.*',        
        'brands.name As make',
        'brands.id As make_id',
        'vehicle_types.name As vehicletype',
        'vehicle_types.id As vehicletype_id'       
        )
        ->join('brands', 'vehicle__parts.brand_id', '=', 'brands.id')
        ->join('vehicle_types', 'vehicle__parts.vehicletype_id', '=', 'vehicle_types.id')
        ->where('vehicle__parts.name','like','%'.$find.'%')
        ->orderBy('vehicle__parts.id', 'asc')
        ->paginate(5);
    $data['vehicle_types']=Vehicle_type::all();
    $data['makes']=Brand::all();
    return view('vehicle_parts.index', $data);
    }
    

    public function getVehicle_parts($id){

        $data['vehicle_parts']= Vehicle_Part::select(
            'vehicle__parts.id',
            'vehicle__parts.name',
            'brands.name As make',
            'brands.id As make_id',
            'vehicle_types.name As vehicle_type',
            'vehicle_types.id As vehicletype_id',
            'vehicle__parts.stock',
            'vehicle__parts.price',
            'vehicle__parts.photo'
            )
            ->join('brands', 'vehicle__parts.brand_id', '=', 'brands.id')
            ->join('vehicle_types', 'vehicle__parts.vehicletype_id', '=', 'vehicle_types.id')
            ->where('vehicle__parts.id','=',$id)->get();
            return $data;
    }
    public function getVehicle_partsAll(){

        $data['vehicle_parts']= Vehicle_Part::select(
            'vehicle__parts.*',            
            'brands.name As make',
            'brands.id As make_id',
            'vehicle_types.name As vehicletype',
            'vehicle_types.id As vehicletype_id'            
            )
            ->join('brands', 'vehicle__parts.brand_id', '=', 'brands.id')
            ->join('vehicle_types', 'vehicle__parts.vehicletype_id', '=', 'vehicle_types.id')
            ->orderBy('vehicle__parts.id', 'asc')
            ->paginate(5);
        $data['vehicle_types']=Vehicle_type::all();
        $data['makes']=Brand::all();
        
        return $data;

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['vehicle_types']=Vehicle_type::all();
        $data['makes']=Brand::all();
        return view('vehicle_parts.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {        
        $photo = "";
        if($request->hasFile('Photo')){
            $vehicle_parts['photo']=$request->file('Photo')->store('vehiclePartsUploads','public');
            $photo = $request->file('Photo');  
        }

        $vehicle_parts = [
            'name' => $request->get('Name'),
            'brand_id'=> $request->get('brand_id'),
            'vehicletype_id' => $request->get('vehicletype_id'),
            'stock' => $request->get('Stock'),
            'price' => $request->get('Price'),            
            'user_id' => auth()->id(),
            'photo' => $photo                   
        ];

        if(Vehicle_Part::insert($vehicle_parts))
            return redirect('vehicles_parts')->with('success','The Vehicle part was added successfully');
        else
            return redirect('vehicles_parts')->with('error','Something is going wrong, try later');            
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vehicle_Part  $vehicle_Part
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle_Part $vehicle_Part)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vehicle_Part  $vehicle_Part
     * @return \Illuminate\Http\Response
     */
    public function edit(Vehicle_Part $vehicle_Part)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vehicle_Part  $vehicle_Part
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    { 
        $found = Vehicle_Part::findOrfail($request->vehiclepart_id);
        $photo="";         
        if($found){           
            if($request->hasFile('Photo')){
                Storage::delete('public/'.$found->photo);
                $vehicle_parts['photo']=$request->file('Photo')->store('vehiclePartsUploads','public');
                $photo = $request->file('Photo'); 
            }

            $vehicle_parts = [            
                'name' => $request->get('Name'),
                'brand_id'=> $request->get('brand_id'),
                'vehicletype_id' => $request->get('vehicletype_id'),
                'stock' => $request->get('Stock'),
                'price' => $request->get('Price'),            
                'user_id' => auth()->id(),
                'photo' =>$photo
            ];

            if(Vehicle_Part::where('id','=',$found->id)->update($vehicle_parts))
                return redirect('vehicles_parts')->with('success','Part updated successfuly');
            else    
                return redirect('vehicles_parts')->with('error','Something is wrong, try later');
        }
        return redirect('vehicles_parts')->with('error','Item not found, try again');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vehicle_Part  $vehicle_Part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $vehicle_parts)
    {        
        //echo '<pre>'; print_r($id); die;
        $delete= Vehicle_Part::findOrfail($vehicle_parts->get('vehiclepart_id'))->delete();
        if($delete)
            return redirect('vehicles_parts')->with('success','Part deleted successfuly');
        else    
            return redirect('vehicles_parts')->with('error','Something is wrong, try later');
        
    }
}
