<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
    //
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
