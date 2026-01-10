<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Mail\ReservationCreated;
use Illuminate\Support\Facades\Mail;

class Reservation extends Model
{
    //
  protected $guarded = [];

  protected static function boot(){
     parent::boot();

     // static::created(function($reservation){
     //     Mail::to($reservation->client_email)->send(
     //         new ReservationCreated($reservation)
     //     );
     // });
  }

  public function payments()
  {
      return $this->hasMany(Payment::class);
  }
  public function tour()
  {
    return $this->belongsTo(Tour::class);
  }
  public function user()
  {
    return $this->belongsTo(User::class);
  }
  public function hotel()
  {
    return $this->belongsTo(Hotel::class);
  }
  public function departure()
  {
      return $this->belongsTo(Departure::class);
  }
  public function seats()
  {
      return $this->hasMany(Seat::class);
  }
}
