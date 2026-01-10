<?php

namespace App\Helpers;

use App\Logger;
use App\Departure;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Session;

class Loggers {

    static function addlog()
    {
        //this function is basically will add the the log to your database.
        $route = explode("@",  Route::getCurrentRoute()->getActionName());
        $controller = $route[0];     // get controller
        $action =  $route[1];        // get action
        $method = \Request::getMethod();

        if ( strcasecmp( $method, "GET" ) != 0 ) { // is not GET

            if ( strcasecmp( $method, "selectSeat" ) != 0 ) { // is not Select Seat

                $params = \Request::all();   // get url parameter
                $username = Auth::user()->name; // can be ur Auth::user()
                // Create the log
                $log = new Logger();
                $log->controller = $controller;
                $log->function = $action;
                $log->action = self::changeAction($action);
                $log->parameter = json_encode($params);
                if( $controller == "App\Http\Controllers\ReservationsController" ) {
                    //$log->parameter = $params->departure_id;
                    /*if( strcasecmp( $action, "confirm" ) != 0 ) {
                        $departure = Departure::find($params['departure_id']);
                        $tour = $departure->tour->name." - ".$departure->horario;
                        $log->tour = $tour;
                        $log->day = $params['date'];
                    }*/
                }

                $log->user = $username;
                $log->user_id = Auth::user()->id;
                $log->rol = Auth::user()->role->type;
                $log->company = Auth::user()->company->name;
                //$log->method = \Request::getMethod();
                $log->method = $method;

                // Remove the searching
                if (array_key_exists('q', $params) === false) {
                    $log->save();
                    return $log->id;
                }

                return -3;
            }
            return -2;
        }

        return -1;
    }

    static function changeAction( $action ) {

        if( strcasecmp($action, "convertStore") == 0) {
            return "Guardar Woocommerce u Operadora";
        }
        if( strcasecmp($action, "store") == 0) {
            return "Guardar";
        }
        if( strcasecmp($action, "update") == 0) {
            return "Actualizar";
        }

        return $action;
    }
}
