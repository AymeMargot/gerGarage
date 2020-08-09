<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
class Vehicle extends Model
{   
    protected $fillable = [
        'license', 'vehicletype', 'color','brand','engine','user_id = auth()->user()->id'];
}
