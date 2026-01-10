<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Zone;
use App\Tour;
use App\Company;
use App\Departure;
use App\Hotel;
use App\Reservation;
use DB;
use PDF;

class ToursPDFController extends Controller
{
    //
    public function testPDF()
    {
        // $pdf = PDF::loadHTML('<h1>TEST</h1>');
        $var = "Esto es una variable externa";
        $pdf = PDF::loadView('pdf.test' , [
            'var' => $var
        ]);

        return $pdf->stream();
    }

    /**
     * Create the printable edition
     * for the corresponding pickup type
     *
     * @return PDF
     */
    public function printZones()
    {
        $departure_id = Input::get('departure_id');
        $zone_id = Input::get('zone_id');
        $company_id = Input::get('company_id');
        $title = "Todos los tours todas las zonas";

        $reservations = DB::table('reservations')
                    ->join('hotels','reservations.hotel_id','=','hotels.id')
                    ->join('zones','hotels.zone_id','=','zones.id')
                    ->join('departures', 'reservations.departure_id', '=', 'departures.id')
                    ->join('tours', 'departures.tour_id', '=', 'tours.id')
                    ->where('reservations.date', Input::get('date'))
                    ->where('reservations.status', '!=', '4')//the canceled must not show in the reports.
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
                                            'reservations.remaining',
                                            'reservations.folio',
                                            'reservations.citypass',
                                            'reservations.payment_method',
                                            'reservations.total',
                                            'reservations.room',
                                            'reservations.number_kids',
                                            'reservations.number_adults',
                                            'reservations.number_elders',
                                            'zones.name as zone_name',
                                            'hotels.name as hotel_name',
                                            'tours.name as tour_name',
                                            'departures.horario',
                                            'reservations.date')
                                ->orderBy('departures.horario')
                                ->orderBy('hotels.name')
                                ->get();

        $pdf = PDF::loadView('pdf.table-three' , [
            'title' => $title,
            'date' => Input::get('date'),
            'reservations' => $reservations,
        ]);

        return $pdf->stream();
    }

    public function printDepartures()
    {
        $zone_id = Input::get('zone_id');
        $horario = Input::get('horario');
        $company_id = Input::get('company_id');
        $title = "Todas las zonas todos los horarios";

        $reservations = DB::table('reservations')
                    ->join('hotels','reservations.hotel_id','=','hotels.id')
                    ->join('zones','hotels.zone_id','=','zones.id')
                    ->join('departures','reservations.departure_id','=','departures.id')
                    ->join('tours', 'departures.tour_id', '=', 'tours.id')
                    ->where('reservations.date', Input::get('date'))
                    ->where('reservations.status', '!=', '4')//the canceled must not show in the reports.
                    ->where('tours.company_id', $company_id)
                    ->where('tours.name', '<>', 'Total Pass');;

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
                                    'reservations.remaining',
                                    'reservations.folio',
                                    'reservations.citypass',
                                    'reservations.payment_method',
                                    'reservations.total',
                                    'reservations.room',
                                    'reservations.number_kids',
                                    'reservations.number_adults',
                                    'reservations.number_elders',
                                    'reservations.first_payment',
                                    'reservations.telephone',
                                    'zones.name as zone_name',
                                    'hotels.name as hotel_name',
                                    'tours.name as tour_name',
                                    'departures.horario',
                                    'tours.company_id',
                                    'reservations.date')
                        ->orderBy('departures.horario')
                        ->orderBy('zones.id')
                        ->orderBy('hotels.name')
                        ->get();

        $pdf = PDF::loadView('pdf.table-departures' , [
            'title' => $title,
            'date' => Input::get('date'),
            'reservations' => $reservations,
        ]);

        return $pdf->stream();
    }

    public function printTours()
    {
        $departure = Departure::findOrFail(Input::get('departure_id'));
        $reservations = $departure->reservations->where('date', Input::get('date'))->where('status','!=',4)->sortBy('client');
        $title = $departure->tour->name;
        $date = Carbon::parse(Input::get('date'))->toDateString();

        $pdf = PDF::loadView('pdf.table-single-tour' , [
            'title' => $title,
            // 'date' => Carbon::now()->toDateString(),
            'date' => $date,
            'reservations' => $reservations,
        ]);

        return $pdf->stream();
    }

    //Hotel Horarios
    public function printHotelsDepartures()
    {
        $horario = Input::get('horario');
        $hotel = Input::get('hotel_id');
        $company_id = Input::get('company_id');
        $title = "Reporte de recolección todos los hoteles todos los horarios";

        $reservations = DB::table('reservations')
                ->join('hotels','reservations.hotel_id','=','hotels.id')
                ->join('zones','hotels.zone_id','=','zones.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('reservations.date', Input::get('date'))
                ->where('reservations.status', '!=', '4')//the canceled must not show in the reports.
                ->where('tours.company_id', $company_id)
                ->where('tours.name', '<>', 'Total Pass');;

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

            $title = "Reporte de recolección todos los hoteles con horario : <b>".$horario."</b>";
        }
        else if($hotel != 0 && $horario == 0 ) {
            // reservaciones
            // un hotel
            // todos los horarios
            $reservations = $reservations->where('hotels.id', $hotel);

            $hotel_ = Hotel::findOrFail($hotel);
            $title = "Reporte de recolección Hotel : ".$hotel_->name." todos los horarios ";
        }
        else if($hotel != 0 && $horario != 0) {
            // reservaciones
            // un hotel
            // un horario
            $reservations = $reservations->where('hotels.id', $hotel)->where('departures.horario', $horario);

            $hotel_ = Hotel::findOrFail($hotel);
            $title = "Reporte de recolección Hotel : ".$hotel_->name." con horario : <b>".$horario."</b>";
        }

        $reservations = $reservations->select('reservations.client',
                            'reservations.remaining',
                            'reservations.folio',
                            'reservations.citypass',
                            'reservations.payment_method',
                            'reservations.total',
                            'reservations.room',
                            'reservations.number_kids',
                            'reservations.number_adults',
                            'reservations.number_elders',
                            'reservations.first_payment',
                            'zones.name as zone_name',
                            'hotels.id as hotel_id',
                            'hotels.name as hotel_name',
                            'tours.name as tour_name',
                            'departures.horario',
                            'tours.company_id',
                            'reservations.date')
                ->orderBy('zones.id')
                ->orderBy('hotels.name')
                ->orderBy('departures.horario','ASC')
                ->get();

        $pdf = PDF::loadView('pdf.table-two' , [
            'title' => $title,
            'date' => Input::get('date'),
            'reservations' => $reservations,
        ]);

        return $pdf->stream();
    }

    //Hotel Tours
    public function printHotelsTours()
    {
        $tour_id = Input::get('tour_id');
        $hotel_id = Input::get('hotel_id');
        $company_id = Input::get('company_id');
        $title = "Reporte de recolección todos los hoteles con todos los tours";

        $reservations = DB::table('reservations')
                ->join('hotels','reservations.hotel_id','=','hotels.id')
                ->join('zones','hotels.zone_id','=','zones.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('reservations.date', Input::get('date'))
                ->where('reservations.status', '!=', '4')//the canceled must not show in the reports.
                ->where('tours.company_id', $company_id)
                ->where('tours.name', '<>', 'Total Pass');;


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
            $title = "Reporte de recolección todos los hoteles con tour : ".$tour->name;
        }
        else if($hotel_id != 0 && $tour_id == 0 ) {
            // reservaciones
            // un hotel
            // todos los tours
            $reservations = $reservations->where('hotels.id', $hotel_id);

            $hotel = Hotel::findOrFail($hotel_id);
            $title = "Reporte de recolección Hotel : ".$hotel->name." con todos los tours";
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
            $title = "Reporte de recolección Hotel : ".$hotel->name." con tour : ".$tour->name;
        }

        $reservations = $reservations->select('reservations.client',
                    'reservations.remaining',
                    'reservations.folio',
                    'reservations.citypass',
                    'reservations.payment_method',
                    'reservations.total',
                    'reservations.room',
                    'reservations.number_kids',
                    'reservations.number_adults',
                    'reservations.number_elders',
                    'reservations.first_payment',
                    'zones.name as zone_name',
                    'hotels.name as hotel_name',
                    'tours.name as tour_name',
                    'departures.horario',
                    'tours.company_id',
                    'reservations.date')
        ->orderBy('zones.id')
        ->orderBy('hotels.name')
        ->orderBy('departures.horario','ASC')
        ->get();

        $pdf = PDF::loadView('pdf.table-three' , [
            'title' => $title,
            'date' => Input::get('date'),
            'reservations' => $reservations,
        ]);

        return $pdf->stream();
    }

    public function printTours2()
    {
        //http://localhost/operadora/public_html//pickup/tour/selected/1
        $tour_id = Input::get('tour_id');
        $horario = Input::get('horario');
        $company_id = Input::get('company_id');
        $date = Input::get('date');
        $title = "";

        $reservations = DB::table('reservations')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->join('hotels', 'reservations.hotel_id', '=', 'hotels.id')
                ->join('zones', 'hotels.zone_id', '=', 'zones.id')
                ->join('users', 'reservations.user_id', '=', 'users.id')
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
                    'reservations.total',
                    'reservations.remaining',
                    'reservations.room',
                    'reservations.number_adults',
                    'reservations.number_elders',
                    'reservations.payment_method',
                    'reservations.telephone',
                    'users.username',
                    'zones.name as zone_name',
                    'hotels.name as hotel_name',
                    'tours.name as tour_name',
                    'departures.horario',
                    'tours.company_id',
                    'reservations.date')
        ->orderBy('tours.id')
        ->orderBy('departures.horario','ASC')
        ->orderBy('reservations.client','ASC')
        ->get();

        $pdf = PDF::loadView('pdf.table-tours' , [
            'title' => $title,
            'date' => Input::get('date'),
            'reservations' => $reservations,
        ]);

        return $pdf->stream();
    }

    public function printReservation(Reservation $reservation)
    {

        // $pdf = PDF::loadView('pdf.reservations' , [
        //     'reservation' => $reservation
        // ])->setPaper([0, 0, 136.06, 300.00]);
        $pdf = PDF::loadView('pdf.reservations' , [
            'reservation' => $reservation
        ])->setPaper([0, 0, 136.06, 340.00]);

        return $pdf->stream();

    }

    public function showSalesDay()
    {
        $company = Company::findOrFail(Input::get('company_id'));

        return view('sales.day', [
            'company' => $company,
            'tours' => Tour::all(),
        ]);
    }

    public function printSalesDay()
    {
        $zone_id = 0;
        $horario = 0;
        $company_id = Input::get('company_id');
        $date = Carbon::parse(Input::get('date'))->toDateString();
        $date2 = Input::get('date', Carbon::now()->toDateString());
        $date2 = Carbon::parse($date2)->addDay();

        $tour = Input::get('tour_id', '-1');
        //return $date;
        $company = Company::where('id', $company_id)->get()->first();
        $title = "Reporte de ventas del día ".$company->name;

        //$reservations = DB::table('reservations')
        $reservations = DB::table('payments')
                    ->join('reservations','payments.reservation_id','=','reservations.id')
                    ->join('hotels','reservations.hotel_id','=','hotels.id')
                    ->join('zones','hotels.zone_id','=','zones.id')
                    ->join('departures','reservations.departure_id','=','departures.id')
                    ->join('tours', 'departures.tour_id', '=', 'tours.id')
                    ->join('users', 'reservations.user_id', '=', 'users.id')
                    //->where('reservations.date', $date)
                    ->where('tours.company_id', $company_id)
                    ->whereBetween('payments.created_at', [$date, $date2]);

        if ( $tour != '-1' ) {
            $reservations = $reservations->where('tours.id', $tour);
        }

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
                                    'reservations.remaining',
                                    'reservations.folio',
                                    'reservations.citypass',
                                    'reservations.payment_method',
                                    'reservations.total',
                                    'reservations.room',
                                    'reservations.number_kids',
                                    'reservations.number_adults',
                                    'reservations.number_elders',
                                    'reservations.payment_method',
                                    'reservations.citypass',
                                    'payments.payment',
                                    'payments.user_id as usuario',
                                    'payments.user_confirm',
                                    'payments.is_confirm',
                                    'payments.payment_confirm',
                                    'zones.name as zone_name',
                                    'hotels.name as hotel_name',
                                    'tours.name as tour_name',
                                    'departures.horario',
                                    'users.username',
                                    'tours.company_id',
                                    'reservations.date')
                        ->orderBy('reservations.id')
                        ->orderBy('zones.id')
                        ->get();

        //$totals = DB::table('reservations')
        $totals = DB::table('payments')
                ->join('reservations','payments.reservation_id','=','reservations.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->where('tours.company_id', $company_id);
                //->where('reservations.date', $date)

        if ( $tour != '-1' ) {
            $totals = $totals->where('tours.id', $tour);
        }

        $totals = $totals->where('reservations.status','!=','4')
                ->where('reservations.payment_method','!=','cortesia')
                ->where('reservations.payment_method','!=','citypass')
                ->whereBetween('payments.created_at', [$date, $date2])
                ->selectRaw('reservations.payment_method, SUM(payment) as total')
                ->groupBy('payment_method')
                ->orderBy('total')
                ->get();

        if ($reservations->count() > 0) {
            $pdf = PDF::loadView('pdf.total2' , [
                'title' => $title,
                'date' => $date,
                'reservations' => $reservations,
                'totals' => $totals
            ]);
            // code...
            return $pdf->stream();
        }
        else{
            return back()->withStatus('No hay ventas para la opción elegida');
        }

    }
}
