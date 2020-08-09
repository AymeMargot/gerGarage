<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Roster extends Model
{
    public function getID(){
        return $this->id;
    }
}
