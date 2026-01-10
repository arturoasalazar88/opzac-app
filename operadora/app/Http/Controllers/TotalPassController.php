<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\Departure;
use App\Tour;
use DB;
use Illuminate\Support\Facades\Input;

class TotalPassController extends Controller
{
    public function orders()
    {
        $page = Input::get('page', 0 );
        if ( $page > 0 ) {
            $page = $page - 1;
        }
        $page < 0 ? $page = 0 : $page = $page;

        $offset = $page * 15; //15 each page
        $limit = 15;

        $tour = Tour::where('name','Total Pass')->first();
        $toursIds = Tour::where('name','like','%Pass%')->get();
        $toursIds = $toursIds->pluck('id');

        //$reservations = Reservation::where('departure_id',$tour->departures[0]->id)->offset($offset)->limit($limit)->get();
        $reservations = Reservation::whereIn('tour_id',$toursIds)->offset($offset)->limit($limit)->get();

        foreach ($reservations as $key => $r) {
            $r->pass_type = $r->tour_id == 2 ? 'total' : 'basic';
            $r->cost_kids = $tour->cost_kids;
            $r->cost_adults = $tour->cost_adults;
            $r->cost_elders = $tour->cost_elders;
        }

        // return Reservation::where('departure_id',$tour->departures[0]->id)->offset($offset)->limit($limit)->get();
        return $reservations;
    }

    public function order()
    {
        $orderNumber = Input::get('order');

        $tour = Tour::where('name','Total Pass')->first();

        $reservation = Reservation::where('folio', $orderNumber)->first();

        $reservation->pass_type = $reservation->tour_id == 2 ? 'total' : 'basic';
        $reservation->cost_kids = $tour->cost_kids;
        $reservation->cost_adults = $tour->cost_adults;
        $reservation->cost_elders = $tour->cost_elders;

        // return Reservation::where('folio', $orderNumber)->first();
        return $reservation;
    }

    public function search()
    {
        $orderNumber = Input::get('q');

        $reservation = Reservation::where('folio', $orderNumber)->first();

        if ($reservation) {

            $tour = Tour::where('name','Total Pass')->first();

            $reservation->cost_kids = $reservation->price_kids;
            $reservation->cost_adults = $reservation->price_adults;
            $reservation->cost_elders = $reservation->price_elders;

            return $reservation;
        }
        if ( is_null($reservation) ) {
            return -1;
        }

        return $reservation;
    }
}
