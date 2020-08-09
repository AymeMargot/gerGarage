<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillabe = ['customer', 'customer_address', 'title', 'date',
                         'datedue','subtotal','grand_total', 'discount'];

    public function supplies(){
        return $this->hasMany(Invoice_Supply::class)->withTimestamps();
    }

    public function vehicle_parts(){
        return $this->hasMany(Vehicle_Part::class)->withTimestamps();
    }

    public function bookings()    {
        return $this->hasOne(bookings::class)->withTimestamps();
    }

    public function getCustomer($id){
        
    }
    
}
