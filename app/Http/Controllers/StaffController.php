<?php

namespace App\Http\Controllers;

use App\Role;
use App\Staff;
use App\User;
use Role_User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class StaffController extends Controller
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
        $ids = $this->getUserintoStaff();
        
        $data['staff'] = Staff::paginate(5);    
        $data['users'] = User::select('id','name','email')->whereNotIn('id',$ids)->get();  
        $data['roles'] = Role::select('id','name')->get(); 
        $data['staff'] = Staff::select(
                        'staff.*',            
                        'roles.name As role' )
                        ->join('roles', 'staff.position', '=', 'roles.id')
                        ->paginate(5); 
        
        //return Response()->json($data);
        return view('staff.index', $data);
    }

    public function search(Request $staff){
        
        $find = $staff->get('Find');
        if($find == 'all')
            $find='';
        
        $ids = $this->getUserintoStaff();          
        $data['users'] = User::select('id','name','email')->whereNotIn('id',$ids)->get();  
        $data['roles'] = Role::select('id','name')->get();
        $data['staff'] = Staff::select(
                        'staff.*',            
                        'roles.name As role' )
                        ->join('roles', 'staff.position', '=', 'roles.id')
                        ->where('staff.name','like','%'.$find.'%')
                        ->orwhere('staff.lastname','like','%'.$find.'%')
                        ->paginate(5);         
        return view('staff.index', $data);
    }
    public function getUserintoStaff(){
        return(Staff::all()->pluck('id'));        
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
        $this->validate($request, [
            'Birthday' => 'date'     
        ]);

        $staff = [
            'user_id' => auth()->id(),
            'name' => $request->get('Name'),
            'lastname' => $request->get('Lastname'),    
            'position' => $request->get('Position'),         
            'showed' => $request->get('Showed'),
            'birthday' => $request->get('Birthday'),
            'gender' => $request->get('Gender'), 
            'civilStatus' => $request->get('CivilStatus'), 
            'gnb' => $request->get('Gnb'), 
            'pps' => $request->get('Pps'), 
            'id' => $request->get('User'),  
            'address' => $request->get('Address')          
        ];
       // return Response()->json($staff);
        if($request->hasFile('Photo')){
            $staff['photo']=$request->file('Photo')->store('staffUploads','public');
        }

        if(staff::insert($staff)){
            User::find($request->get('User'))->assignRole($request->get('Position'));
          //  $sql = ::where('user_id','=',$request->get('User'));
            return redirect('staff')->with('success','The staff was added successfully');
        }
        else
            return redirect('staff')->with('error','Something is going wrong, try later');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show(Staff $staff)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(Staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {          
        $found = Staff::findOrfail($request->get('staff_id'));
        $position = $found->position; 
        
        if($position != $request->get('Position')){
            $sql=User::find($request->get('staff_id'))->assignRole($request->get('Position'));
            if($sql)
                $position = $request->get('Position');
        }
        
        $staff = [
           'user_id' => auth()->id(),
           'name' => $request->get('Name'),
           'lastname' => $request->get('Lastname'),    
           'position' => $position,         
           'showed' => $request->get('Showed'),
           'gnb' => $request->get('Gnb'),
           'pps' => $request->get('Pps'),
           'birthday' => $request->get('Birthday'),
           'gender' => $request->get('Gender'),
           'address' => $request->get('Address'),
           'civilStatus' => $request->get('CivilStatus')                
        ];

        if($found){           
            if($request->hasFile('Photo')){
                Storage::delete('public/'.$found->photo);
                $staff['photo']=$request->file('Photo')->store('StaffUploads','public');
            }

            if(Staff::where('id','=',$found->id)->update($staff))               
                return redirect('staff')->with('success','Staff updated successfuly');                         
            else    
                return redirect('staff')->with('error','Something is wrong, try later');
        }
        return redirect('staff')->with('error','Staff not found, try again');   
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $staff)
    {        
        $delete= Staff::findOrfail($staff->get('staff_id'))->delete();

        if($delete){
            User::findOrfail($staff->get('staff_id'))->delete();
            return redirect('staff')->with('success','Supply deleted successfuly');
        }
        else    
            return redirect('staff')->with('error','Something is wrong, try later');
      
    }
}
