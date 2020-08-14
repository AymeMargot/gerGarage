<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class accessory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name', 'price', 'stock','user_id','create_at','update_at','photo'
    ];
}
