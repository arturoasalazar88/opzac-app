<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tour;
use App\Company;
use App\Zone;
use App\Hotel;
use App\Departure;
use App\Reservation;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Auth;

class ToursViewsController extends Controller
{
    // ========================================
    // Enters a company, gets all the tours
    // of that specific company
    // ========================================
    public function test(Company $company)
    {

        $tours = $company->tours;

        return view('tests.uno', [
            'company' => $company,
            'tours' => $tours
        ]);
    }

    public function ZonesPickupOutput()
    {
        // $tour_id = request('tour_id');
        $departure_id = request('departure_id');
        $zone_id = request('zone_id');
        $company_id = request('company_id');
        $date = request('date');
        $title = "Todos los tours todas las zonas";

        $reservations = DB::table('reservations')
                    ->join('hotels','reservations.hotel_id','=','hotels.id')
                    ->join('zones','hotels.zone_id','=','zones.id')
                    ->join('departures', 'reservations.departure_id', '=', 'departures.id')
                    ->join('tours', 'departures.tour_id', '=', 'tours.id')
                    ->where('reservations.status', '!=', 4)
                    ->where('reservations.date', $date)
                    ->where('tours.company_id', $company_id)
                    ->where('tours.name', '<>', 'Total Pass');

        if ( $zone_id == 0 && $departure_id == 0) {
            // Registros de reservaciones
            // Todas las zonas
            // todos los tours departures
        }
        else if( $zone_id == 0 && $departure_id != 0 ){
            // Registro de reservaciones
            // Todas las zonas
            // un único tour
            $departure = Departure::findOrFail($departure_id);
            $tour_id = $departure->tour->id;

            $reservations = $reservations->where('departures.id', $departure_id);

            $tour = Tour::findOrFail($tour_id);

            $title = "Todas las zonas con tour : ".$tour->name;
        }
        else if( $zone_id != 0 && $departure_id == 0 ){
            // Registro de reservas
            // Una zona
            // todos los tours
            $reservations = $reservations->where('zones.id', $zone_id);
            $zone = Zone::findOrFail($zone_id);
            $title = "Zona : ".$zone->name." con todos los tour ";
        }
        else if( $zone_id != 0 && $departure_id != 0) {
            // Registro de reservas
            // Una zona
            // un tour
            $departure = Departure::findOrFail($departure_id);
            $tour_id = $departure->tour->id;

            $reservations = $reservations->where('zones.id', $zone_id)->where('departures.id', $departure_id);

            $zone = Zone::findOrFail($zone_id);
            $tour = Tour::findOrFail($tour_id);
            $title = "Zona : ".$zone->name." con tour : ".$tour->name;
        }

        $reservations = $reservations->select('reservations.client',
                                            'reservations.folio',
                                            'reservations.citypass',
                                            'reservations.payment_method',
                                            'reservations.number_kids',
                                            'reservations.number_adults',
                                            'reservations.number_elders',
                                            'zones.name as zone_name',
                                            'hotels.name as hotel_name',
                                            'tours.name as tour_name',
                                            'departures.horario',
                                            'reservations.date')
                                ->orderBy('departures.horario')
                                ->get();

        // return $reservations;
        return view('pickups.zones-pickup-one', [
            'reservations' => $reservations,
            'date' => $date,
            'title' => $title,
            'departure_id' => $departure_id,
            'zone_id' => $zone_id,
            'company_id' => $company_id,
            'type' => 'zones'
        ]);
    }// end function


    public function hoursPickupOutput()
    {
        $zone_id = request('zone_id');
        $horario = request('horario');
        $company_id = request('company_id');
        $date = request('date');
        $title = "Todas las zonas todos los horarios";

        $reservations = DB::table('reservations')
                    ->join('hotels','reservations.hotel_id','=','hotels.id')
                    ->join('zones','hotels.zone_id','=','zones.id')
                    ->join('departures','reservations.departure_id','=','departures.id')
                    ->join('tours', 'departures.tour_id', '=', 'tours.id')
                    ->where('reservations.status', '!=', 4)
                    ->where('reservations.date', $date)
                    ->where('tours.company_id', $company_id)
                    ->where('tours.name', '<>', 'Total Pass');

        if ($zone_id == 0 && $horario == 0) {
            // Todas las zonas
            // un día
            // todos los horarios
        }
        else if ($zone_id == 0 && $horario != 0) {
            // Todas las zonas
            // un horario
            $reservations = $reservations->where('departures.horario', $horario);

            $title = "Todas las zonas, horario : ".$horario;
        }
        else if ($zone_id !=0 && $horario == 0) {
            // Una zona
            // Todos los horarios
            $reservations = $reservations->where('zones.id', $zone_id);

            $zone = Zone::findOrFail($zone_id);
            $title = "Zona : ".$zone->name." todos los horarios";

        }
        else if ($zone_id != 0 && $horario != 0 ) {
            // Una zona
            // un horario
            $reservations = $reservations->where('zones.id', $zone_id)->where('departures.horario', $horario);

            $zone = Zone::findOrFail($zone_id);
            $title = "Zona : ".$zone->name ." horario : ".$horario;
        }

        $reservations = $reservations->select('reservations.client',
                                    'reservations.folio',
                                    'reservations.citypass',
                                    'reservations.payment_method',
                                    'reservations.number_kids',
                                    'reservations.number_adults',
                                    'reservations.number_elders',
                                    'zones.name as zone_name',
                                    'hotels.name as hotel_name',
                                    'tours.name as tour_name',
                                    'departures.horario',
                                    'tours.company_id',
                                    'reservations.date')
                        ->orderBy('departures.horario')
                        ->get();

        //return $reservations;
        return view('pickups.zones-pickup-one', [
            'reservations' => $reservations,
            'date' => $date,
            'title' => $title,
            'zone_id' => $zone_id,
            'horario' => $horario,
            'company_id' => $company_id,
            'type' => 'departures'
        ]);
    }// end function

    public function hotelsPickupOutputHorario()
    {
        $horario = request('horario');
        $hotel = request('hotel_id');
        $company_id = request('company_id');
        $date = request('date');
        $title = "Todos los hoteles todos los horarios";

        $reservations = DB::table('reservations')
                ->join('hotels','reservations.hotel_id','=','hotels.id')
                ->join('zones','hotels.zone_id','=','zones.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('reservations.status', '!=', 4)
                ->where('reservations.date', $date)
                ->where('tours.company_id', $company_id)
                ->where('tours.name', '<>', 'Total Pass');

        if ($hotel == 0 && $horario == 0) {
            // reservaciones
            // todos los hoteles
            // todos los horarios
        }
        else if($hotel == 0 && $horario != 0) {
            // reservaciones
            // todos los Hoteles
            // un horario
            $reservations = $reservations->where('departures.horario', $horario);

            $title = "Todos los hoteles con horario : ".$horario;
        }
        else if($hotel != 0 && $horario == 0 ) {
            // reservaciones
            // un hotel
            // todos los horarios
            $reservations = $reservations->where('hotels.id', $hotel);

            $hotel_ = Hotel::findOrFail($hotel);
            $title = "Hotel : ".$hotel_->name." todos los horarios ";
        }
        else if($hotel != 0 && $horario != 0) {
            // reservaciones
            // un hotel
            // un horario
            $reservations = $reservations->where('hotels.id', $hotel)->where('departures.horario', $horario);

            $hotel_ = Hotel::findOrFail($hotel);
            $title = "Hotel : ".$hotel_->name." con horario : ".$horario;
        }

        $reservations = $reservations->select('reservations.client',
                            'reservations.folio',
                            'reservations.citypass',
                            'reservations.payment_method',
                            'reservations.number_kids',
                            'reservations.number_adults',
                            'reservations.number_elders',
                            'zones.name as zone_name',
                            'hotels.name as hotel_name',
                            'tours.name as tour_name',
                            'departures.horario',
                            'tours.company_id',
                            'reservations.date')
                ->orderBy('hotels.name')
                ->orderBy('departures.horario','ASC')
                ->get();

        // return request();
        // return $reservations;
        return view('pickups.zones-pickup-one', [
            'reservations' => $reservations,
            'date' => $date,
            'title' => $title,
            'horario' => $horario,
            'hotel' => $hotel,
            'company_id' => $company_id,
            'type' => 'hotel_1'
        ]);
    }// end function

    public function hotelsPickupOutputTours()
    {
        $tour_id = request('tour_id');
        $hotel_id = request('hotel_id');
        $company_id = request('company_id');
        $date = request('date');
        $title = "Todos los hoteles con todos los tours";

        $reservations = DB::table('reservations')
                ->join('hotels','reservations.hotel_id','=','hotels.id')
                ->join('zones','hotels.zone_id','=','zones.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('reservations.status', '!=', 4)
                ->where('reservations.date', $date)
                ->where('tours.company_id', $company_id)
                ->where('tours.name', '<>', 'Total Pass');


        if ($hotel_id == 0 && $tour_id == 0) {
            // reservaciones
            // todos los hoteles
            // todos los horarios
        }
        else if($hotel_id == 0 && $tour_id != 0) {
            // reservaciones
            // todos los Hoteles
            // un tour
            $reservations = $reservations->where('departures.tour_id', $tour_id);

            $tour = Tour::findOrFail($tour_id);
            $title = "Todos los hoteles con tour : ".$tour->name;
        }
        else if($hotel_id != 0 && $tour_id == 0 ) {
            // reservaciones
            // un hotel
            // todos los tours
            $reservations = $reservations->where('hotels.id', $hotel_id);

            $hotel = Hotel::findOrFail($hotel_id);
            $title = "Hotel : ".$hotel->name." con todos los tours";
        }
        else if($hotel_id != 0 && $tour_id != 0) {
            // reservaciones
            // un hotel
            // un tour
            $reservations = $reservations
                            ->where('hotels.id', $hotel_id)
                            ->where('departures.tour_id', $tour_id);

            $hotel = Hotel::findOrFail($hotel_id);
            $tour = Tour::findOrFail($tour_id);
            $title = "Hotel : ".$hotel->name." con tour : ".$tour->name;
        }

        $reservations = $reservations->select('reservations.client',
                    'reservations.folio',
                    'reservations.payment_method',
                    'reservations.citypass',
                    'reservations.number_kids',
                    'reservations.number_adults',
                    'reservations.number_elders',
                    'zones.name as zone_name',
                    'hotels.name as hotel_name',
                    'tours.name as tour_name',
                    'departures.horario',
                    'tours.company_id',
                    'reservations.date')
        ->orderBy('hotels.name')
        ->orderBy('departures.horario','ASC')
        ->get();

        return view('pickups.zones-pickup-one', [
            'reservations' => $reservations,
            'date' => $date,
            'title' => $title,
            'tour_id' => $tour_id,
            'hotel_id' => $hotel_id,
            'company_id' => $company_id,
            'type' => 'hotel_2'
        ]);
    }

    /**
     * Return
     * The view for the types of pickups
     *
     * @return \Illuminate\Http\Response
     */
    public function showPickupTypes()
    {
        return view('pickups.show');
    }

    /**
     * Return
     * The view to select
     * a company before selecting zone
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCompanyBeforeTour(){

        if (! Auth::user()->isAdmin() ) {
            return $this->tourSelect( Auth::user()->company );
        }

        $companies = Company::all();

        return view('layouts.select-company', [
            'action' => 'seleccionar zona',
            'companies' => $companies,
            'url' => 'pickup_select_tour'
        ]);
    }

    /**
     * Return
     * The view to select
     * a company before selecting zone
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCompanyBeforeHotel(){

        if (! Auth::user()->isAdmin() ) {
            return $this->hotelSelect( Auth::user()->company );
        }

        $companies = Company::all();

        return view('layouts.select-company', [
            'action' => 'seleccionar hotel',
            'companies' => $companies,
            'url' => 'tour_hotel_select'
        ]);
    }

    /**
     * Return
     * The view to select
     * a company before selecting zone
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCompanyBeforeZone(){

        if (! Auth::user()->isAdmin() ) {
            return $this->ZonaSelect( Auth::user()->company );
        }

        $companies = Company::all();

        return view('layouts.select-company', [
            'action' => 'seleccionar zona',
            'companies' => $companies,
            'url' => 'tour_zona_select'
        ]);
    }

    /**
     * Return
     * The view to select
     * a company before selecting HOURS
     *
     * @return \Illuminate\Http\Response
     */
    public function selectCompanyBeforeHour(){

        if (! Auth::user()->isAdmin() ) {
            return $this->hourSelect( Auth::user()->company );
        }

        $companies = Company::all();

        return view('layouts.select-company', [
            'action' => 'seleccionar horario',
            'companies' => $companies,
            'url' => 'tour_hour_select'
        ]);
    }

    /**
     * Return
     * The view to select
     * a company before selecting zone
     *
     * @param \App\Company the company to filter the tours
     * @return \Illuminate\Http\Response
     */
    public function ZonaSelect( Company $company)
    {
        $zones = Zone::all();
        $tours = Tour::all()->where('company_id', $company->id);
        $horarios = Tour::select('horario')->where('company_id', $company->id)->groupBy('horario')->get();

        return view('layouts.select-zone', [
            'zones' => $zones,
            'horarios' => $horarios,
            'tours' => $tours,
            'company' => $company
        ]);
    }

    /**
     * Return
     * The view to select
     * a company before selecting zone
     *
     * @param \App\Company the company to filter the tours
     * @return \Illuminate\Http\Response
     */
    public function hourSelect( Company $company)
    {
        $zones = Zone::all();
        //$tours = Tour::all()->where('company_id', $company->id);
        //$horarios = Tour::select('horario')->where('company_id', $company->id)->groupBy('horario')->get();
        $horarios = DB::table('departures')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('tours.company_id', $company->id)
                ->select('departures.horario as horario')
                ->groupBy('horario')
                ->get();


        return view('layouts.select-hour', [
            'zones' => $zones,
            'horarios' => $horarios,
            'company' => $company
        ]);
    }

    public function hotelSelect(Company $company)
    {
        $hotels = Hotel::all();
        $tours = Tour::all()->where('company_id', $company->id);
        //$horarios = Tour::select('horario')->where('company_id', $company->id)->groupBy('horario')->get();
        $horarios = DB::table('departures')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('tours.company_id', $company->id)
                ->select('departures.horario as horario')
                ->groupBy('horario')
                ->get();

        return view('layouts.select-hotel', [
            'tours' => $tours,
            'horarios' => $horarios,
            'company' => $company,
            'hotels' => $hotels
        ]);
    }

    public function tourSelect(Company $company)
    {
        $hotels = Hotel::all();
        $tours = Tour::all()->where('company_id', $company->id);
        //$horarios = Tour::select('horario')->where('company_id', $company->id)->groupBy('horario')->get();
        $horarios = DB::table('departures')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('tours.company_id', $company->id)
                ->select('departures.horario as horario')
                ->groupBy('horario')
                ->get();

        return view('layouts.select-tour', [
            'tours' => $tours,
            'horarios' => $horarios,
            'company' => $company,
            'hotels' => $hotels
        ]);
    }

    public function toursSelectOutput()
    {
        //http://localhost/operadora/public_html//pickup/tour/selected/1
        $tour_id = request('tour_id');
        $horario = request('horario');
        $company_id = request('company_id');
        $date = request('date');
        $title = "";

        $reservations = DB::table('reservations')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->join('hotels', 'reservations.hotel_id', '=', 'hotels.id')
                ->join('zones', 'hotels.zone_id', '=', 'zones.id')
                ->where('reservations.status', '!=', 4)
                ->where('reservations.date', $date)
                ->where('tours.company_id', $company_id)
                ->where('tours.name', '<>', 'Total Pass');


        if ($horario == 0 && $tour_id == 0) {
            // reservaciones
            // todos los hoteles
            // todos los horarios
        }
        else if($horario == 0 && $tour_id != 0) {
            // reservaciones
            // todos los horarios
            // un tour
            $reservations = $reservations->where('departures.tour_id', $tour_id);

            $tour = Tour::findOrFail($tour_id);
            $title = "Todos los horarios con tour : ".$tour->name;
        }
        else if($horario != 0 && $tour_id == 0 ) {
            // reservaciones
            // un horario
            // todos los tours
            $reservations = $reservations->where('departures.horario', $horario);

            $title = "Todos los tours un horario : ".$horario."";
        }
        else if($horario != 0 && $tour_id != 0) {
            // reservaciones
            // un horario
            // un tour
            $reservations = $reservations
                            ->where('departures.horario', $horario)
                            ->where('departures.tour_id', $tour_id);

            $tour = Tour::findOrFail($tour_id);
            $title = "Horario : ".$horario." con tour : ".$tour->name;
        }

        $reservations = $reservations->select('reservations.client',
                    'reservations.folio',
                    'reservations.payment_method',
                    'reservations.citypass',
                    'reservations.number_kids',
                    'reservations.number_adults',
                    'reservations.number_elders',
                    'zones.name as zone_name',
                    'hotels.name as hotel_name',
                    'tours.name as tour_name',
                    'departures.horario',
                    'tours.company_id',
                    'reservations.date')
        ->orderBy('tours.id')
        ->orderBy('departures.horario','ASC')
        ->get();

        return view('pickups.zones-pickup-one', [
            'reservations' => $reservations,
            'date' => $date,
            'title' => $title,
            'tour_id' => $tour_id,
            'horario' => $horario,
            'company_id' => $company_id,
            'type' => 'tours'
        ]);
    }

    // select company -> select tour -> select date -> show
    public function getTourDate()
    {
        return "tour ajax con fecha";
    }

    /**
     * Returns the view for
     * Tour : single tour
     * Date : single tour date
     * Reservations : compound of reservations
     *                  of that particular tour
     * @param App\Tour instance of a single tour
     * @return \Illuminate\Http\Response
     */
    public function singleTourDate(Departure $departure)
    {
        $date = request('date');
        $user = Auth::user();

        $reservationsQuery = $departure->reservations()
            ->where('date', $date)
            ->where('status', '!=', 4);

        if ($user->isReceptionist()) {
            $reservationsQuery->where('user_id', $user->id);
        }
        // return $reservationsQuery->get();
        $reservations = $reservationsQuery->with(['user', 'seats'])->get();

        $message = Input::get('message', '');
        $class = Input::get('class', '');
        $return = Input::has('return');
        $returnLink = Input::get('return', '#!');
        $current_reservation = Input::has('current_reservation') ? Reservation::find(Input::get('current_reservation')) : null;

        return view('tours.show-single-tour-date', [
            'departure' => $departure,
            'date' => $date,
            'reservations' => $reservations,
            'departure_id' => $departure->id,
            'printable' => true,
            'message' => $message,
            'class' => $class,
            'return' => $return,
            'seats' => $departure->seats()->select('seat')->where('date', $date)->get(),
            'current_reservation' => $current_reservation,
        ]);
    }

    public function singleTourDateGET()
    {
        //return Input::get('departure');
        $departure = Departure::findOrFail( Input::get('departure', 1) );
        $reservations = $departure->reservations->where('date', Input::get('date') )->where('status','!=',4);
        $tour = $departure->tour;

        $message = Input::get('message','');
        $class = Input::get('class', '');
        //return view('tests.dos', [
        return view('tours.show-single-tour-date', [
            'departure' => $departure,
            'date' => Input::get('date'),
            'reservations' => $reservations,
            'departure_id' => $departure->id,
            'printable' => true,
            'message' => $message,
            'class' => $class,
            'seats' =>  $departure->seats()->select('seat')->where('date', Input::get('date'))->get(),
        ]);
    }
}
