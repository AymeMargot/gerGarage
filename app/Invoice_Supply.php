<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice_Supply extends Model
{
    protected $fillable = ['price','item','qty','discount','subtotal'];
}
