<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function invoices()    {
        return $this->belongsToMany(Invoice_Booking::class)->withTimestamps();
    }

    public function sumInvoices($book){
        $sum = Invoice_Booking::where('booking_id','=',$book)->sum('grand_total');
        return $sum;        
    }
}
