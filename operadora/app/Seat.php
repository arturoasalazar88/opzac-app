<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    //
    public function departure()
    {
        return $this->belongsTo(Departure::Class);
    }
}
