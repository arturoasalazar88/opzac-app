<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    //
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }
}
