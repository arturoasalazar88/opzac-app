<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\Tour;
use App\Hotel;
use App\Company;
use App\User;
use App\Departure;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use DB;
use Auth;

class CompanyReservationsController extends Controller
{
    //==============================================================//
    //
    //  This controller it's just to the select your company page
    //  And call the tours to show them before any real action
    //
    //=============================================================//

    /**
     * Show the select blocks to select a company
     * index -> see reservatons -> select your company
     * in the reservations index page
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCompanyView()
    {
        $companies = Company::all();
        $fast = Tour::where('name', 'Tour centro historico')->get()->first();
        $fast2 = Tour::where('name', 'Leyendas con el Diablo de Zacatecas')->get()->first();

        //If you are not admin than you may not see other than your company
        if( Auth::user()->isAdmin() ) {
            return view('layouts.select-company', [
                'action' => 'ver reservas',
                'companies' => $companies,
                'fast' => $fast,
                'fast2' => $fast2,
                'url' => 'reservations_company'
            ]);
        }
        if ( Auth::user()->isReceptionist() || Auth::user()->isModule() ) {

            $tours = Tour::all()->where('company_id', Auth::user()->company->id);

            return view('reservations.select-tour-date',[
                'tours' => $tours,
                'company' => Auth::user()->company
            ]);
        }

        return view('layouts.select-company', [
            'action' => 'ver reservas',
            'companies' => $companies,
            'fast' => $fast,
            'fast2' => $fast2,
            'url' => 'reservations_company'
        ]);
    }

    /**
     * Show the select blocks to select a company
     * in the reservations index page
     * index -> create reservations -> select your company
     * send to the create reservation page
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCompanyCreate()
    {
        $companies = Company::all();
        $fast = Tour::where('name', 'Tour centro historico')->get()->first();
        $fast2 = Tour::where('name', 'Leyendas con el Diablo de Zacatecas')->get()->first();
        $fast3 = Tour::where('name', 'Tour Revolucionario')->get()->first();

        // after company_select_tour
        // before 'url' => 'reservations_company_create'
        return view('layouts.select-company', [
            'action' => 'crear reservas',
            'companies' => $companies,
            'fast' => $fast,
            'fast2' => $fast2,
            'fast3' => $fast3,
            'url' => 'company_select_tour'
        ]);
    }

    /**
     * Here just to show the piles tours
     * of a single company
     * select company -> select tour page
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCompanyTour(Company $company)
    {
        $tours = Tour::all()->where('company_id', '=', $company->id)->where('active', '=',1);

        // Check this later pupouse
        return view('reservations.select-tour', [
          'tours' => $tours,
          'company' => $company,
          'url' => 'company_create_reservation_2',
        ]);
    }

    /**
     * Call the create reservation page with
     * only one tour
     * select company -> select tour -> create reservation page
     * of a single company
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateReservationTour(Tour $tour)
    {
        $hotels = Hotel::all();
        $users = User::all();

        //return view('reservations.create_from_tour', [
        return view('reservations.create', [
          'hotels' => $hotels,
          'tour' => $tour,
          'users' => $users,
        ]);
    }

    /**
     * Call the create reservation page with
     * only one tour
     * select company -> select tour -> create reservation page
     * of a single company
     *
     * @return \Illuminate\Http\Response
     */
    public function showCreateReservation()
    {
        //dd(Input::get('date'));
        $hotels = Hotel::orderBy('name')->get();
        $users = User::all();
        $tour = Tour::findOrFail(Input::get('tour'));
        $date = new Carbon(Input::get('date'));


        //return $tour->departures->sortBy('horario');

        $departures = collect();

        foreach ($tour->departures as $key => $departure) {
            $departures->push($departure);
        }

        //return $departures->sort('horario', SORT_REGULAR, true);
        $collect = $departures->sortBy('horario');

        $tour->departures = null;
        $tour->departures = $collect->values()->all();

        // return $tour->departures;
        // return $collect->values()->all();

        return view('reservations.create', [
          'hotels' => $hotels,
          'tour' => $tour,
          'users' => $users,
          'date' => $date,
          'countries' => DB::select('SELECT * FROM country')
        ]);
    }

    public function fastMenu()
    {
        if (Input::has('id')) {
            $fast = Tour::findOrFail( Input::get('id') );
        }
        else {
            $fast = Tour::where('name', 'Tour centro historico')->get()->first();
        }

        $fast->departures = $fast->departures->sortBy('horario');

        $result = Reservation::where('date', Carbon::today()->toDateString() )
        ->where('tour_id', $fast->id)
        ->orderBy('client')
        ->limit(25)
        ->get();

        return view('fast.menu', [
            'fast' => $fast,
            'result' => $result
        ]);
    }

    public function fastMenuSearch()
    {
        //$fast = Tour::where('name', 'Tour centro historico')->get()->first();
        $fast = Tour::find( request('fast_id') );

        $q = request( 'q' );

        $result = Reservation::where('tour_id', $fast->id)
                                ->where('client','LIKE','%'.$q.'%')
                                ->orWhere('client_email','LIKE','%'.$q.'%')
                                ->orWhere('folio','LIKE','%'.$q.'%')->get();

        $fast->departures = $fast->departures->sortBy('horario');

        return view('fast.menu', [
            'fast' => $fast,
            'result' => $result
        ]);
    }

    public function fastCreate()
    {
        // $hotels = Hotel::all();
        // $users = User::all();
        $tour = Tour::findOrFail(Input::get('tour'));
        $date = new Carbon(Input::get('date'));
        $departure = Departure::findOrFail(Input::get('departure_id'));

        //return $departure;
        $reservations = $departure->reservations()->where('date', Input::get('date'));

        // number of total tickets in the reservations
        $current_tickets  =  $reservations->sum('number_adults')
                            + $reservations->sum('number_kids')
                            + $reservations->sum('number_elders');

        $seats =  $departure->seats()->select('seat')->where('date', Input::get('date'))->get();

        return view('fast.create', [
          'tour' => $tour,
          'date' => $date,
          'departure' => $departure,
          'total_seats' => $departure->getTypeNumber(),
          'current_tickets' => $current_tickets,
          'seats' => $seats,
        ]);
    }
}
