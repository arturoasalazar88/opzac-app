<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Logger extends Model
{
    //
    protected $fillable = ['controller','method','action','parameter','user'];
}
