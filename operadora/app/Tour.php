<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    //

  protected $guarded = [];

  public function reservations()
  {
      return $this->hasMany(Reservation::class);
  }
  public function company()
  {
      return $this->belongsTo(Company::class);
  }
  public function departures()
  {
      return $this->hasMany(Departure::class);
  }

}
