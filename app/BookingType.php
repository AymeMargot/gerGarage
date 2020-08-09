<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingType extends Model
{
    public function invoices(){
        return $this->belongsTo(Invoice_Supply::class)->withTimestamps();
    }
}
