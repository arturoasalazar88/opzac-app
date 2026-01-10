<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    //
  protected $guarded = [];

  public function hotels()
  {
    return $this->hasMany(Hotel::class);
  }

  public function company()
  {
      return $this->belongsTo(Company::class);
  }
}
