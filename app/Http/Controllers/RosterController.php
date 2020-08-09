<?php

namespace App\Http\Controllers;

use App\Roster;
use App\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['rosters'] = Roster::select(
            'rosters.*',
            'staff.name',
            'staff.lastname',
            'staff.id as mechanic_id'
        )
            ->join('staff', 'rosters.staff_id', '=', 'staff.id')
            ->paginate(5);
        $data['staff'] = Staff::where('position', '=', '2')->get();
        return view('rosters.index', $data);
    }

    public function search(Request $rosters)
    {
        $this->validate($rosters, [
            'From' => 'required|date|before_or_equal:To',
            'To' => 'required|date',
        ]);
        $from = $rosters->get('From');
        $to = $rosters->get('To');
        $data['rosters'] = Roster::select(
            'rosters.*',
            'staff.name',
            'staff.lastname',
            'staff.id as mechanic_id'
        )
            ->join('staff', 'rosters.staff_id', '=', 'staff.id')
            ->whereBetween('rosters.date', [$from, $to])
            ->paginate(5);
        $data['staff'] = Staff::where('position', '=', '2')->get();
        return view('rosters.index', $data);
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
        $from = $request->get('FromDate');
        $to = $request->get('ToDate');
        $dayAfter = $from;

        $sw = true;
        while (($dayAfter < $to || $dayAfter == $to) && $sw) {
            $roster = [
                'user_id' => auth()->id(),
                'workload' => '0',
                'staff_id' => $request->get('staff_id'),
                'fromTime' => $request->get('FromTime'),
                'toTime' => $request->get('ToTime'),
                'date' => $dayAfter
            ];

            $dayAfter = Carbon::createFromFormat('Y-m-d', $dayAfter)->addDays(1)->format('Y-m-d');
            //  echo 'data'.$roster; 
            $sql = Roster::where('staff_id', '=', $request->get('staff_id'))
                ->where('date', '=', $dayAfter)->count();
            if ($sql == 0) {
                if (!Roster::insert($roster))
                    $sw = false;
            }
        }
        if ($sw)
            return redirect('rosters')->with('success', 'Roster saved successfully');
        else
            return redirect('rosters')->with('error', 'Something is going wrog, try again');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roster  $roster
     * @return \Illuminate\Http\Response
     */
    public function show()
    {        
        $data['users'] = Staff::where('id','=',auth()->id())->first();
        $data['rosters'] = Roster::select('rosters.*', 'bookings.id as book', 'bookings.description', 'bookings.status')
            ->leftJoin('bookings', 'rosters.id', '=', 'bookings.roster_id')
            ->where('rosters.staff_id', '=', auth()->id())
            ->get();
        $data['staff'] = Staff::all();
        //return Response()->json($data); 
        return view('rosters.show', $data);
    }

    public function UserSearch(Request $rosters)
    {
        if ($rosters->get('staff_id') != '')
            $user = $rosters->get('staff_id');
        else
            $user = auth()->id();
        $data['users'] = Staff::where('id','=',$user)->first();
        $data['rosters'] = Roster::select('rosters.*', 'bookings.id as book', 'bookings.description', 'bookings.status')
            ->leftJoin('bookings', 'rosters.id', '=', 'bookings.roster_id')
            ->where('rosters.staff_id', '=', $user)
            ->get();

      //  return Response()->json($data); 
        $data['staff'] = Staff::all();
        return view('rosters.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roster  $roster
     * @return \Illuminate\Http\Response
     */
    public function edit(Roster $roster)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roster  $roster
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $rosters = [
            'user_id' => auth()->id(),
            'date' => $request->get('Date'),
            'staff_id' => $request->get('staff_id'),
            'fromTime' => $request->get('FromTime'),
            'toTime' => $request->get('ToTime')
        ];

        $found = Roster::findOrfail($request->roster_id);
        if (Roster::where('id', '=', $found->id)->update($rosters))
            return redirect('rosters')->with('success', 'Roster updated successfuly');
        else
            return redirect('rosters')->with('error', 'Something is going wrong, please try again');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roster  $roster
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $roster)
    {
        $delete = Roster::findOrfail($roster->get('roster_id'))->delete();
        if ($delete)
            return redirect('rosters')->with('success', 'Roster deleted successfuly');
        else
            return redirect('rosters')->with('error', 'Something is wrong, try later');
    }
}
