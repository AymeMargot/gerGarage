<?php

namespace App\Http\Controllers;

use App\accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class AccessoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['accessories'] = accessory::paginate(5);         
        return view('accessories.index',$data);       
    }

    public function search(Request $accessories){        
        $find = $accessories->get('Find');
        if($find == 'all')
            $find='';

        $data['accessories'] = accessory::where('name','like','%'.$find.'%')->paginate(5);
        return view('accessories.index', $data);
    }

    public function list()
    {
        $data['accessories'] = accessory::paginate(10);         
        return view('listAccessories',$data);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {      
        return view('accessories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {      
        $photo="";
        if($request->hasFile('Photo')){
            Storage::delete('public/'.$request->get('Photo'));
            $accessories['photo']=$request->file('Photo')->store('accessoriesUploads','public');
            $photo = $request->file('Photo'); 
        }

        $accessories = [
            'user_id' => auth()->id(),
            'name' => $request->get('Name'),
            'price' => $request->get('Price'),    
            'stock' => $request->get('Stock'),
            'photo' => $photo                  
        ];        

        if(accessory::insert($accessories))
            return redirect('accessories')->with('success','Accessory added successfuly');
        else    
            return redirect('accessories')->with('error','Something is wrong, try later');             
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\accessory  $accessory
     * @return \Illuminate\Http\Response
     */
    public function show(accessory $accessory)
    {
        //
    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\accessory  $accessory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {     
        $accessories = accessory::findOrFail($id);
        return view('accessories.edit',compact('accessories'));
        
    }

    public function single($id)
    {     
        $accessories = accessory::findOrFail($id);
        return view('singleAccessory',compact('accessories'));
        
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\accessory  $accessory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {             
        $found = accessory::findOrfail($request->get('accessory_id'));
        $photo=""; 

        if($found){           
            if($request->hasFile('Photo')){
                Storage::delete('public/'.$found->photo);
                $accessories['photo']=$request->file('Photo')->store('accessoriesUploads','public');
                $photo = $request->file('Photo'); 
            }

            $accessories = [
                'user_id' => auth()->id(),
                'name' => $request->get('Name'),
                'price' => $request->get('Price'),    
                'stock' => $request->get('Stock'),
                'photo' => $photo                   
            ];

            if(accessory::where('id','=',$found->id)->update($accessories))
                return redirect('accessories')->with('success','Accessory updated successfuly');
            else    
                return redirect('accessories')->with('error','Something is wrong, try later');
        }
        return redirect('accessories')->with('error','Accessory not found, try again');        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\accessory  $accessory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $accessories)
    {
        $delete= accessory::findOrfail($accessories->get('accessory_id'))->delete();
        if($delete)
            return redirect('accessories')->with('success','Accessory deleted successfuly');
        else    
            return redirect('accessories')->with('error','Something is wrong, try later');
 
    }
}
