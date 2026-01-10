<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use Auth;
use DB;
use Carbon\Carbon;

class SearchController extends Controller
{
    //
    public function search()
    {
        return view('layouts.search');
    }

    public function makeSearch()
    {
        $q = request( 'q' );

        if ( Auth::user()->globalSearch() ){
            $result = Reservation::where('client','LIKE','%'.$q.'%')
                                    ->orWhere('client_email','LIKE','%'.$q.'%')
                                    ->orWhere('folio','LIKE','%'.$q.'%')->get();
        }
        else {
            //$result = Reservation::where('client','LIKE','%'.$q.'%')->orWhere('client_email','LIKE','%'.$q.'%')->get();
            //$result = Auth::user()->reservations->where('client','LIKE','%'.$q.'%')->orWhere('client_email','LIKE','%'.$q.'%')->get();
            $result = Auth::user()->reservations()->where(function ($query) {
                $query->where('client', 'LIKE', '%'.request( 'q' ).'%')
                        ->orWhere('client_email','LIKE','%'.request( 'q' ).'%')
                        ->orWhere('folio','LIKE','%'.request( 'q' ).'%');
            })->get();
        }

        if ( count($result) > 0 ) {
            return view('layouts.search')->withResult($result)->withQuery ( $q );
        }
            return view ('layouts.search')->withMessage('No se encontraron coincidencias para la búsqueda!');
    }

    public function searchApprove()
    {

        if( Auth::user()->isModule() && ! Auth::user()->isAdmin() ) {
            $result = Reservation::where('date', Carbon::today()->toDateString() )
                                    ->join('tours', 'tours.id', '=' ,'reservations.tour_id')
                                    ->join('departures', 'departures.id', '=' ,'reservations.departure_id')
                                    ->join('hotels', 'hotels.id', '=' ,'reservations.hotel_id')
                                    ->where('status', '!=', '4')
                                    ->where('tours.company_id', Auth::user()->company_id)
                                    ->select('reservations.id',
                                                'reservations.user_id',
                                                'reservations.folio',
                                                'reservations.status',
                                                'reservations.client',
                                                'reservations.confirmed',
                                                'tours.name as tour_name',
                                                'departures.horario',
                                                'reservations.date',
                                                'reservations.number_kids',
                                                'reservations.number_adults',
                                                'reservations.number_elders',
                                                'reservations.first_payment',
                                                'hotels.name as hotel_name')
                                    ->orderBy('client')->limit(25)->get();
        }
        else{
            $result = Reservation::where('date', Carbon::today()->toDateString() )
                    ->join('tours', 'tours.id', '=' ,'reservations.tour_id')
                    ->join('departures', 'departures.id', '=' ,'reservations.departure_id')
                    ->join('hotels', 'hotels.id', '=' ,'reservations.hotel_id')
                    ->where('status', '!=', '4')
                    ->select('reservations.id',
                                'reservations.user_id',
                                'reservations.folio',
                                'reservations.status',
                                'reservations.client',
                                'reservations.confirmed',
                                'tours.name as tour_name',
                                'departures.horario',
                                'reservations.date',
                                'reservations.number_kids',
                                'reservations.number_adults',
                                'reservations.number_elders',
                                'reservations.first_payment',
                                'hotels.name as hotel_name')
                    ->orderBy('client')
                    ->limit(25)
                    ->get();
        }

        //return $result;
        return view('layouts.search-approve', [
            'result' => $result,
            'query' => '',
        ]);
    }

    public function makeSearchApprove()
    {
        $q = request( 'q' );

        if ( Auth::user()->globalSearch() ){

            $result = Reservation::where('client','LIKE','%'.$q.'%')
                                ->orWhere('client_email','LIKE','%'.$q.'%')
                                ->orWhere('folio','LIKE','%'.$q.'%')
                                ->join('tours', 'tours.id','=','reservations.tour_id')
                                ->join('departures', 'departures.id', '=' ,'reservations.departure_id')
                                ->join('hotels', 'hotels.id', '=' ,'reservations.hotel_id')
                                ->select('reservations.id',
                                    'reservations.user_id',
                                    'reservations.folio',
                                    'reservations.status',
                                    'reservations.client',
                                    'reservations.confirmed',
                                    'tours.name as tour_name',
                                    'departures.horario',
                                    'reservations.date',
                                    'reservations.number_kids',
                                    'reservations.number_adults',
                                    'reservations.number_elders',
                                    'reservations.first_payment',
                                    'hotels.name as hotel_name')
                                ->get();
        }
        else {
            if( Auth::user()->isModule() && ! Auth::user()->isAdmin() ) {

                $result = Auth::user()
                    ->reservations()
                    ->join('tours', 'tours.id','=','reservations.tour_id')
                    ->join('departures', 'departures.id', '=' ,'reservations.departure_id')
                    ->join('hotels', 'hotels.id', '=' ,'reservations.hotel_id')
                    ->where('tours.company_id', Auth::user()->company_id)->where(function ($query) {
                        $query->where('client', 'LIKE', '%'.request( 'q' ).'%')
                        ->orWhere('client_email','LIKE','%'.request( 'q' ).'%')
                        ->orWhere('folio','LIKE','%'.request( 'q' ).'%');
                    })->select('reservations.id',
                        'reservations.user_id',
                        'reservations.folio',
                        'reservations.status',
                        'reservations.client',
                        'reservations.confirmed',
                        'tours.name as tour_name',
                        'departures.horario',
                        'reservations.date',
                        'reservations.number_kids',
                        'reservations.number_adults',
                        'reservations.number_elders',
                        'reservations.first_payment',
                        'hotels.name as hotel_name')
                        ->get();
            }
            else{
                $result = Auth::user()
                        ->reservations()
                        ->join('tours', 'tours.id', '=' ,'reservations.tour_id')
                        ->join('departures', 'departures.id', '=' ,'reservations.departure_id')
                        ->join('hotels', 'hotels.id', '=' ,'reservations.hotel_id')->where(function ($query) {
                            $query->where('client', 'LIKE', '%'.request( 'q' ).'%')
                            ->orWhere('client_email','LIKE','%'.request( 'q' ).'%')
                            ->orWhere('folio','LIKE','%'.request( 'q' ).'%');
                        })->select('reservations.id',
                            'reservations.folio',
                            'reservations.status',
                            'reservations.client',
                            'reservations.confirmed',
                            'tours.name as tour_name',
                            'departures.horario',
                            'reservations.date',
                            'reservations.number_kids',
                            'reservations.number_adults',
                            'reservations.number_elders',
                            'reservations.first_payment',
                            'hotels.name as hotel_name')
                            ->get();
            }
        }

        if ( count($result) > 0 ) {
            return view('layouts.search-approve')->withResult($result)->withQuery ( $q );
        }
            return view ('layouts.search-approve')->withMessage('No se encontraron coincidencias para la búsqueda!');
    }
}
