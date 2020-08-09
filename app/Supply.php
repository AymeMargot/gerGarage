<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    
    public function invoices(){
        return $this->belongsToMany(Invoice_Supply::class)->withTimestamps();
    }
}
