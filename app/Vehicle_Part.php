<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehicle_Part extends Model
{
    public function invoices(){
        return $this->belongsToMany(Invoice_Vehiclepart::class)->withTimestamps();
    }
}
