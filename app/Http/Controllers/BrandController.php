<?php

namespace App\Http\Controllers;

use App\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
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
        $data['makes'] = Brand:: paginate(5);
        return view('makes.index',$data);
    }

    public function search(Request $makes){       
        
        $find = $makes->get('Find');
        if($find == 'all')
            $find='';
      //  echo 'find'.$find;
        $data['makes'] = Brand::where('name','like','%'.$find.'%')->paginate(5);
        return view('makes.index', $data);
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
            $make['photo']=$request->file('Photo')->store('makesUploads','public');
            $photo = $request->file('Photo');            
        }

        $make = [
            'user_id' => auth()->id(),
            'name' => $request->get('Name'),
            'photo' => $photo                       
        ];

        if(Brand::insert($make))
            return redirect('makes')->with('success','The make was added successfully');
        else
            return redirect('makes')->with('error','Something is going wrong, try later');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {       
        $found = Brand::findOrfail($request->get('make_id'));
        $photo = "";    
        if($found){           
            if($request->hasFile('Photo')){
                Storage::delete('public/'.$found->photo);
                $make['photo']=$request->file('Photo')->store('makesUploads','public');
                $photo = $request->file('Photo');  
            }

            $make = [
                'user_id' => auth()->id(),
                'name' => $request->get('Name'),  
                'photo' => $photo                    
            ];

            if(Brand::where('id','=',$found->id)->update($make))
                return redirect('makes')->with('success','Make updated successfuly');
            else    
                return redirect('makes')->with('error','Something is wrong, try later');
        }
        return redirect('makes')->with('error','Make not found, try again');   
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $makes)
    {        
        //echo '<pre>'; print_r($id); die;
        $delete= Brand::findOrfail($makes->get('make_id'))->delete();
        if($delete)
            return redirect('makes')->with('success','Make deleted successfuly');
        else    
            return redirect('makes')->with('error','Something is wrong, try later');
        
    }

    public function deleteAll(Request $makes){
        echo 'entroo'.$makes->get('make_id');

    }
}
