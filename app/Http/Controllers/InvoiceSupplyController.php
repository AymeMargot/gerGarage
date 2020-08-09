<?php

namespace App\Http\Controllers;

use App\Invoice_Supply;
use Illuminate\Http\Request;
use App\Invoice;
use App\Supply;
use App\Invoice_Booking;
use App\Invoice_Vehiclepart;
use App\Vehicle_Part;
use App\Booking;

class InvoiceSupplyController extends Controller
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
    public function create($id)
    {
        $data['invoices'] = invoice:: all()
        ->where('id','=',$id)->first();    
        $data['supplies']=Supply::all();
        return view('invoice_supplies.create',$data);        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $supply = Supply::where('id','=',$request->get('supply_id'))->first();
        echo 'id supply'.$request->get('supply_id');
        $name = $supply->name;           
        $price = $supply->price; 
       // return Response()->json($supply);         
        
        $id = $request->get('invoice_id'); 
        if($supply->stock == 0 || $supply->stock < $request->get('Qty'))
            return redirect('invoices/'.$id.'/edit')->with('error','Verify the stock, not enough items');                 
 
        $totalPrice = $price * $request->get('Qty');
        $discount= $this->getDiscount($request->get('Discount'),$totalPrice);
             
        $subtotal = $totalPrice - $discount;
        $invoice_supplies = [
            'user_id' => auth()->id(),
            'supply_id' => $request->get('supply_id'),
            'invoice_id' => $request->get('invoice_id'),
            'item' =>$name,
            'price' => $price,
            'qty'=> $request->get('Qty'),
            'subtotal' =>$totalPrice,
            'grand_total' =>$subtotal,
            'discount' =>$request->get('Discount')                          
        ];
       // return Response()->json($invoice_supplies);
        
        if(Invoice_Supply::insert($invoice_supplies)){   
            $stock=$this->DecreaseStock($supply->id,$request->get('Qty'));
            $sql = Supply::where('id', $supply->id)
                ->update(['stock' => $stock]);
            $this->updateGrandTotalInvoice($request->get('invoice_id'));
            if($sql)
                return redirect('invoices/'.$id.'/edit')->with('success','item added successfuly');             
            else
                return redirect('invoices/'.$id.'/edit')->with('error','Stock not decreased, please verify');             
        }           
        else
        return redirect('invoices/'.$id.'/edit')->with('error','Something is going wrong, try later');    
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

    public function DecreaseStock($supply,$qty){
        $supply = Supply::findOrFail($supply)->first();  
        $stock = $supply->stock - $qty;
        return $stock;
    }

    public function IncreaseStock($supply,$qty){
        $supply = Supply::findOrFail($supply)->first();  
        $stock = $supply->stock + $qty;
        return $stock;
    }

    public function getDiscount($discount,$price){
        $total = ($discount * $price)/100;
        return $total;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice_Supply  $invoice_Supply
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice_Supply $invoice_Supply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice_Supply  $invoice_Supply
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice_Supply $invoice_Supply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice_Supply  $invoice_Supply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice_Supply $invoice_Supply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice_Supply  $invoice_Supply
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {          
       $sql = Invoice_Supply::where('id','=',$id)->first(); 
         //  return Response()->json($sql); 
       $invoice = $sql->invoice_id;
       $supply = $sql->supply_id;
       $qty = $sql->qty;

       if(Invoice_Supply::destroy($id)){
            
            $stock=$this->IncreaseStock($supply,$qty);
            $sql = Supply::where('id', $supply)
                ->update(['stock' => $stock]);
            $this->updateGrandTotalInvoice($invoice);
            if($sql)
                return redirect('invoices/'.$invoice.'/edit')->with('success','Item deleted successfully');                 
            else
                return redirect('invoices/'.$invoice.'/edit')->with('error','The stock was not updated properly, please verify');                         
            
        }       
        return redirect('invoices/'.$invoice.'/edit')->with('error','item was not deleted, please try again');                     }
}
