<?php

namespace App\Http\Controllers;

use App\Invoice_Vehiclepart;
use App\Vehicle_Part;
use Illuminate\Http\Request;
use App\Invoice;
use App\Invoice_Booking;
use App\Invoice_Supply;

class InvoiceVehiclepartController extends Controller
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
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {            
        
        $sql = Vehicle_Part::where('id','=',$request->get('vehiclepart_id'))->first();
    
        $name = $sql->name;           
        $price = $sql->price; 
        $vehiclepart = $sql->id; 
       // return Response()->json($supply);         
        
        $invoice = $request->get('invoice_id'); 
        if($sql->stock == 0 || $sql->stock < $request->get('Qty'))
            return redirect('invoices/'.$invoice.'/edit')->with('error','Verify the stock, not enough items');                 
 
        $totalPrice = $price * $request->get('Qty');
        $discount= $this->getDiscount($request->get('Discount'),$totalPrice);
              
        $subtotal = $totalPrice - $discount;
        $invoice_vehiclepart = [
            'user_id' => auth()->id(),
            'vehiclepart_id' => $request->get('vehiclepart_id'),
            'invoice_id' => $request->get('invoice_id'),
            'item' =>$name,
            'price' => $price,
            'qty'=> $request->get('Qty'),
            'subtotal' =>$totalPrice,
            'grand_total' =>$subtotal,
            'discount' =>$request->get('Discount')                          
        ];
       // return Response()->json($invoice_supplies);
        
        if(Invoice_Vehiclepart::insert($invoice_vehiclepart)){   
            $stock=$this->DecreaseStock($vehiclepart,$request->get('Qty'));
            $this->updateGrandTotalInvoice($request->get('invoice_id'));
          //  return(Response()->json($stock));
            $sql = Vehicle_Part::where('id', $vehiclepart)
                ->update(['stock' => $stock]);
            if($sql)
                return redirect('invoices/'.$invoice.'/edit')->with('success','item added successfuly');             
            else
                return redirect('invoices/'.$invoice.'/edit')->with('error','Stock not decreased, please verify');             
        }           
        else
        return redirect('invoices/'.$invoice.'/edit')->with('error','Something is going wrong, try later');             
    
    }

    public function DecreaseStock($id,$qty){
        $sql = Vehicle_Part::findOrFail($id)->first();  
        $stock = $sql->stock - $qty;
        return $stock;
    }

    public function getDiscount($discount,$price){
        $total = ($discount * $price)/100;
        return $total;
    }

    public function updateGrandTotalInvoice($invoice){
        $sumBookings = Invoice_Booking::where('invoice_id','=',$invoice)->sum('grand_total');
        $sumSupplies = Invoice_Supply::where('invoice_id','=',$invoice)->sum('grand_total');
        $sumVehicleparts = Invoice_Vehiclepart::where('invoice_id','=',$invoice)->sum('grand_total');
        $total = $sumBookings + $sumSupplies + $sumVehicleparts;

        $sql = Invoice::where('id','=',$invoice)->first();
        $discount = $this->getDiscount($sql->discount,$total);
        $subtotal = $total - $discount;

        $sql = Invoice::where('id','=',$invoice)->update(['grand_total' => $total,'subtotal'=>$subtotal]);
        if($sql)
            return true;
        return false;
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice_Vehiclepart  $invoice_Vehiclepart
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_Vehiclepart $invoice_Vehiclepart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice_Vehiclepart  $invoice_Vehiclepart
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_Vehiclepart $invoice_Vehiclepart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice_Vehiclepart  $invoice_Vehiclepart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_Vehiclepart $invoice_Vehiclepart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice_Vehiclepart  $invoice_Vehiclepart
     * @return \Illuminate\Http\Response
     */
    public function IncreaseStock($item,$qty){
        $sql = Vehicle_Part::findOrFail($item)->first();  
        $stock = $sql->stock + $qty;
        return $stock;
    }

    public function destroy($id)
    {
        echo "entroo".$id;
        $sql = Invoice_Vehiclepart::where('id','=',$id)->first(); 
        
         //  return Response()->json($sql); 
        $invoice = $sql->invoice_id;
        echo "invoice".$invoice;
        
        $vehiclepart = $sql->vehiclepart_id;
        $qty = $sql->qty;

       if(Invoice_Vehiclepart::destroy($id)){
            
            $stock=$this->IncreaseStock($vehiclepart,$qty);
            $sql = Vehicle_Part::where('id', $vehiclepart)
                ->update(['stock' => $stock]);
            $this->updateGrandTotalInvoice($invoice);
            if($sql)
                return redirect('invoices/'.$invoice.'/edit')->with('success','Item deleted successfully');                 
            else
                return redirect('invoices/'.$invoice.'/edit')->with('error','The stock was not updated properly, please verify');                         
            
        }       
        return redirect('invoices/'.$invoice.'/edit')->with('error','item was not deleted, please try again');                    
    
    }
        
}

