<?php

namespace App\Http\Controllers;

use App\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupplyController extends Controller
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
        $data['supplies'] = Supply::paginate(5);
        return view('supplies.index',$data);
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
        $photo = "";       
        if($request->hasFile('Photo')){
            Storage::delete('public/'.$request->get('Photo'));
            $supplies['photo']=$request->file('Photo')->store('suppliesUploads','public');
            $photo = $request->file('Photo'); 
        }

        $supplies = [
            'user_id' => auth()->id(),
            'name' => $request->get('Name'),
            'price' => $request->get('Price'),    
            'stock' => $request->get('Stock'),         
            'offer' => $request->get('Offer'),
            'photo' => $photo           
        ];

        if(Supply::insert($supplies))
            return redirect('supplies')->with('success','Supply added successfuly');
        else    
            return redirect('supplies')->with('error','Something is wrong, try later');              
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function show(Supply $supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function edit(Supply $supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $found = Supply::findOrfail($request->get('supply_id'));
        $photo="";    
        if($found){

            if($request->hasFile('Photo')){
                Storage::delete('public/'.$found->photo);
                $supplies['photo']=$request->file('Photo')->store('suppliesUploads','public');
                $photo = $request->file('Photo'); 
            }

            $supplies = [
                'user_id' => auth()->id(),
                'name' => $request->get('Name'),
                'price' => $request->get('Price'),    
                'stock' => $request->get('Stock'),         
                'offer' => $request->get('Offer'),
                'photo' => $photo           
            ];

            if(Supply::where('id','=',$found->id)->update($supplies))
                return redirect('supplies')->with('success','Supply updated successfuly');
            else    
                return redirect('supplies')->with('error','Something is wrong, try later');
        }
        return redirect('supplies')->with('error','Supply not found, try again');   
    
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Supply  $supply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $supplies)
    {               
        $delete= Supply::findOrfail($supplies->get('supply_id'))->delete();
        if($delete)
            return redirect('supplies')->with('success','Supply deleted successfuly');
        else    
            return redirect('supplies')->with('error','Something is wrong, try later');      
    }
    public function search(Request $supplies){
        
        $find = $supplies->get('Find');
        if($find == 'all')
            $find='';
      //  echo 'find'.$find;
        $data['supplies'] = Supply::where('name','like','%'.$find.'%')->paginate(5);
        return view('supplies.index', $data);
    }

}
