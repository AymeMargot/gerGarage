<?php

namespace App\Http\Controllers;

use App\Booking;
use App\BookingType;
use App\Invoice;
use App\Invoice_Booking;
use App\Invoice_Supply;
use App\Supply;
use App\Invoice_Vehiclepart;
use App\Vehicle_Part;
use Illuminate\Http\Request;

class InvoiceController extends Controller
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
        $data['invoices'] = Invoice::select(
            'invoices.*',       
            'users.name As customer'
        )
            ->join('users', 'invoices.user_id', '=', 'users.id')->paginate(5); 
       return view('invoices.index',$data);       
    }

    public function search(Request $invoices)
    {
        $find = $invoices->get('Find');
        if($find == 'all')
            $find='';

        $data['invoices'] = Invoice::select(
            'invoices.*',       
            'users.name As customer'
        )
            ->join('users', 'invoices.user_id', '=', 'users.id') 
            ->where('users.name','like','%'.$find.'%')
            ->paginate(5);
        return view('invoices.index',$data);       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $ids = $this->getBookintoInvoice();
      //  return Response()->json($ids);

        $data['bookings'] = Booking::select('bookings.id','users.name')
                        ->join ('users','users.id','=','bookings.user_id')
                        ->whereNotIn('bookings.id',$ids)->get(); 
        return view('invoices.create',$data);                
        //  return Response()->json($data); 
              
    }

    public function getBookintoInvoice(){
        return(Invoice_Booking::all()->pluck('booking_id'));        
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
            'Date' => 'date|after:yesterday',
            'DateDue' => 'date|after:yesterday',
            'Booking' =>'required',
            'Description'=> 'required',
            'Address'=> 'required'                  
        ]);  
      
        $count = Invoice::where('booking','=',$request->get('Booking'))->count();
        if($count>0)  
            return redirect('invoices')->with('error','This invoice is already made please check booking number'); 
        
        $sqlbook = Booking::where('id','=',$request->get('Booking'))->first(); 
       // return Response()->json($sqlbook);  
        $id_typebook = $sqlbook->bookingtype_id;                      
        $sqltypebook = BookingType::where('id','=',$id_typebook)->first(); 
          
        $name = $sqltypebook->name;           
        $price = $sqltypebook->price;  

        $invoices = [
            'user_id' => auth()->id(),
            'booking' => $request->get('Booking'),
            'title' => $request->get('Description'),    
            'discount' => 0,
            'customer_address' => $request->get('Address'),         
            'date' => $request->get('Date'), 
            'subtotal' => $price,
            'grand_total' => $price,          
            'datedue' => $request->get('DateDue')          
        ];
               
        if(Invoice::insert($invoices)){                     
            $id = Invoice::all()->last()->id;           
             $invoice_bookings = [
                'user_id' => auth()->id(),
                'booking_id' => $request->get('Booking'),
                'invoice_id' => $id,
                'item' => $name,
                'price' => $price,
                'qty'=> '1',
                'subtotal' =>$price,
                'grand_total' =>$price,
                'discount' =>'0'                          
            ];
                     
            $sql = Invoice_Booking::insert($invoice_bookings);
            if(!$sql){                               
                return redirect('invoices/'.$id.'/edit')->with('error','Invoice Booking was not update, please verify'); 
            }
            //Invoice::where('id','=',$id)->update(['grand_total' => $price]);
            return redirect('invoices/'.$id.'/edit')->with('success','invoice added successfuly');             
        }    
        else        
            return redirect('invoices/create')->with('error','Something is going wrong, try later');     
    }

    public function getDiscount($discount,$price){
        $total = ($discount * $price)/100;
        return $total;
    }
    
    public function BookingsTotal($id){        
        $sum = Invoice_Booking::where('invoice_id','=',$id)->sum('subtotal');
        if($sum)
            return($sum);
        return 0;
    }

    public function SuppliesTotal($id){
        $sum = Invoice_Supply::where('invoice_id','=',$id)->sum('subtotal');
        if($sum)
            return($sum);
        return 0;
    }

    public function VehiclepartsTotal($id){
        $sum = Invoice_Vehiclepart::where('invoice_id','=',$id)->sum('subtotal');
        if($sum)
            return($sum);
        return 0;
        
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */

    public function getDataEdit($id){
        $data['invoices']=Invoice:: select(
            'invoices.id',
            'invoices.date',
            'invoices.datedue', 
            'invoices.subtotal',
            'invoices.booking As bookID',
            'users.name',
            'invoices.discount',
            'invoices.grand_total',
            'invoices.customer_address',              
            'invoices.title'              )
            ->join('users', 'invoices.user_id', '=', 'users.id')
            ->where('invoices.id','=',$id)->first();       
        $data['supplies']=Supply::all();
        $data['bookings']=Booking::all();
        $data['vehicleparts']=Vehicle_Part::all();
        $data['invoice_vehicleparts']= Invoice_Vehiclepart::where('invoice_id','=',$id)->get();
        $data['invoice_supplies']= Invoice_Supply::where('invoice_id','=',$id)->get();
        $data['invoice_bookings']= Invoice_Booking::where('invoice_id','=',$id)->get(); 
        $total = $this->VehiclepartsTotal($id) +  $this->SuppliesTotal($id) +  $this->BookingsTotal($id); 
        $discount  = Invoice::findOrFail($id)->first()->discount; 
        $discount = $this->getDiscount($discount,$total); 
        $total = $total -$discount;
       // echo 'totall'.$total;
        $data['total']=[['amount'=>$total]];   
        
        return $data;
    }
    public function edit($id)
    {
        $data=$this->getDataEdit($id);
        //return Response()->json($data); 
        return view('invoices.edit',$data);
        //return Response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    
    public function update(Request $request,  $id)
    {   
        // update invoice payment verifying discount   
        $sql = Invoice::where('id','=',$request->get('invoice'))->first(); 
        if(!$sql)
            return redirect('invoices/'.$id.'/edit')->with('error','invoice not found, please try check it');                             
        
        $id = $sql->id;
        $total = $sql->grand_total; 
        if($request->get('Discount') != 0){             
            $discount = $this->getDiscount($request->get('Discount'),$total);
            $total = $total - $discount;            
        }        
        //return Response()->json($sql);
       
        $invoices = [
            'user_id' => auth()->id(),
            'title' => $request->get('Description'),
            'date' => $request->get('Date'),
            'discount' => $request->get('Discount'),
            'datedue' => $request->get('DateDue'),
            'customer_address' => $request->get('Address'),
            'subtotal' => $total                   
        ];
        if(invoice::where('id','=',$id)->update($invoices))
            return redirect('invoices/'.$id.'/edit')->with('success','The invoice was successfully updated'); 
        else
            return redirect('invoices/'.$id.'/edit')->with('error','Something is going wrong, please try later');                  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $invoices)
    {  
        echo 'invoices '.$invoices->get('invoice_id');    
        //echo '<pre>'; print_r($id); die;
        $delete= Invoice::findOrfail($invoices->get('invoice_id'))->delete();
        if($delete){
            Invoice_Booking::where('invoice_id', $invoices->get('invoice_id'))->delete();
            Invoice_Supply::where('invoice_id', $invoices->get('invoice_id'))->delete();
            Invoice_Vehiclepart::where('invoice_id', $invoices->get('invoice_id'))->delete();
            return redirect('invoices')->with('success','Invoice deleted successfuly');
        }
        else    
            return redirect('invoices')->with('error','Something is wrong, try later');
        
    }
}
