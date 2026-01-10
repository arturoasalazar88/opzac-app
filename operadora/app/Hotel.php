<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    //
  protected $guarded = [];

  public function zone()
  {
    //return $this->hasOne(Zone::class);
    return $this->belongsTo(Zone::class);
  }

  public function users()
  {
      return $this->hasMany(User::class);
  }
}
