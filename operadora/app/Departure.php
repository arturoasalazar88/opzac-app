<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Departure extends Model
{
    //
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function seats()
    {
        return $this->hasMany(Seat::class);
    }
    public function isActive()
    {
        // if ($this->date_closed == null) {
        //     return true;
        // }
        // if ( $this->closed && $this->date_closed == Carbon::today()->toDateString() ) {
        //     return false;
        // }

        return $this->closed ? false : true;
    }
    public function active( $date )
    {
        // if ( $this->closed && $this->date_closed == Carbon::parse($date)->toDateString() ) {
        //     return false;
        // }

        return $this->closed ? true : false;
    }
    public function getTypeNumber()
    {
        if ($this->type == 0) {
            return 61;
        }
        else {
            return 52;
        }
    }
    public function getTypes($type)
    {
        if ($type == 0) {
            return 61;
        }
        else {
            return 52;
        }
    }
}
