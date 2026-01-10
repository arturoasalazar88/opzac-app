<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function payed(){
        return $this->hasMany(Payment::class);
    }

    public function reservations(){
      return $this->hasMany(Reservation::class);
    }

    public function role() {
        return $this->belongsTo(Role::class);
    }

    public function company() {
        return $this->belongsTo(Company::class);
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    public function isAdmin()
    {
        if ($this->is_admin == true) {
            return true;
        }
        return false;
    }

    public function canCancel()
    {
        if ($this->is_admin == true) {
            return true;
        }
        if ($this->role_id == 1 || $this->role_id == 2) {
            return true;
        }
        return false;
    }

    public function canOverSale()
    {
        if ($this->isAdmin()) {
            return true;
        }
        if ($this->role_id == 1 || $this->role_id == 2) {
            return true;
        }
        return false;
    }

    public function canReport()
    {
        if ($this->isAdmin()) {
            return true;
        }
        if ($this->role_id == 1) {
            return true;
        }
        // Module same access level
        // Added March 18 - 2020
        // if ($this->role_id == 3) {
        //     return true;
        // }
        return false;
    }

    public function canCreate()
    {

        if ( $this->role_id == 3) {
            return true;
        }
        // Same acccess level to module
        // and operador 3 == 1
        if ( $this->role_id == 1) {
            return true;
        }
        return false;
    }

    public function canConfirm()
    {
        if ($this->isAdmin()) {
            return true;
        }
        //Role id 2 == Recepcionista
        if ($this->role_id == 1 || $this->role_id == 3 ) {
            return true;
        }
        return false;
    }

    public function canEdit()
    {
        if ($this->isAdmin()) {
            return true;
        }
        if ($this->role_id == 1) {
            return true;
        }
        return false;
    }

    public function globalSearch()
    {
        if ($this->isAdmin()) {
            return true;
        }
        if ($this->role_id == 1) {
            return true;
        }
        return false;
    }

    public function canCortesy()
    {
        if ($this->isAdmin()) {
            return true;
        }
        if ($this->role_id == 3) {
            return true;
        }
        // Same acccess level to module
        // and operador 3 == 1
        if ($this->role_id == 1) {
            return true;
        }
        return false;
    }

    public function isReceptionist()
    {

        if ( $this->role->type != "Recepción") {
            return false;
        }
        return true;
    }
    public function isModule()
    {
        if ( $this->role->type != "Módulo") {
            return false;
        }
        return true;
    }
    public function isOperador()
    {
        if ( $this->role->type != "Operador") {
            return false;
        }
        return true;
    }

    public function departureValidation()
    {
        if ($this->isAdmin()) {
            return false;
        }
        if ( $this->role->type == "Módulo") {
            return false;
        }
        if ( $this->role->type == "Operador") {
            return false;
        }
        return true;
    }

    public function getReduceUsername() {
        $name = $this->username;
        if( strlen($name) >= 5 ) {
            $name = substr($this->username, 0, 5);
        }
        return $name;
    }
}
