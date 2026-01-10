<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\Tour;
use App\Hotel;
use App\Company;
use App\Departure;
use App\Seat;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Payment;
use App\Mail\ReservationCreated;
use Illuminate\Support\Facades\Mail;
use DB;
use Twilio\Rest\Client;
use Twilio\Jwt\ClientToken;
use Illuminate\Support\Facades\Input;

class ReservationsController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index()
    {
        $reservations = Reservation::orderBy('created_at', 'desc')->paginate(50);
        //$tours = Tour::all();

        return view('reservations.index',[
            'reservations' => $reservations,
            //'tours' => $tours
        ]);
    }

    /**
    * Display a listing of seats
    *
    * @return \Illuminate\Http\Response
    */
    public function selectSeat(Request $request)
    {
        //return request();
        request()->validate([
          'client' => ['required', 'min:4'],
          'hotel_id' => ['required'],
          'date' => ['required'],
          'departure_id' => ['required'],
          'number_kids' => ['required', 'numeric'],
          'number_adults' => ['required', 'numeric'],
          'number_elders' => ['required', 'numeric'],
          'actual_pay' => ['required', 'numeric'],
          'payment_method' => ['required'],
        ]);

        $departure = Departure::findOrFail(request('departure_id'));
        $tour = Tour::findOrFail($departure->tour_id);
        //return $tour;
        $hotel = Hotel::findOrFail(request('hotel_id'));
        // $seats =  $departure->seats()->select('seat')->where('date', Carbon::now()->toDateString())->get();
        $seats =  $departure->seats()->select('seat')->where('date', request('date'))->get();

        // $cost_kids = request('number_kids') * $tour->cost_kids;
        // $cost_adults = request('number_adults') * $tour->cost_adults;
        // $cost_elders = request('number_elders') * $tour->cost_elders;
        $cost_kids = request('number_kids') * ($request->has('price_kids') ? request('price_kids') : $tour->cost_kids);
        $cost_adults = request('number_adults') * ($request->has('price_adults') ? request('price_adults') : $tour->cost_adults);
        $cost_elders = request('number_elders') * ($request->has('price_elders') ? request('price_elders') : $tour->cost_elders);

        request()->price_kids = $request->has('price_kids') ? request('price_kids') : $tour->cost_kids;
        request()->price_adults = $request->has('price_adults') ? request('price_adults') : $tour->cost_adults;
        request()->price_elders = $request->has('price_elders') ? request('price_elders') : $tour->cost_elders;
        request()->room = $request->has('room') ? request('room') : 0;

        $total = $cost_kids + $cost_adults + $cost_elders;

        if ( request('payment_method') == "cortesia" || request('payment_method') == "citypass" ) {
            $total = 0;
        }
        $tickets = request('number_kids') + request('number_adults') + request('number_elders');

        $reservations = $departure->reservations()->where('date', request('date'));

        // number of total tickets in the reservations
        $current_tickets  =  $reservations->sum('number_adults')
                            + $reservations->sum('number_kids')
                            + $reservations->sum('number_elders');

        // number of remaining tickets on the other bus if aplicable
        $bus_size = $departure->type == 0 ? $departure->getTypes(0) : $departure->getTypes(1);
        $overflow_tickets = $current_tickets - $bus_size;
        $bus_size_2 = $departure->type == 0 ? $departure->getTypes(1) : $departure->getTypes(0);
        $other_bus_available = $bus_size_2 - $overflow_tickets;

        $sendSms = false;

        if ( request()->has('sendSMS') && request('telephone') != null ) {
            $sendSms = true;
        }

        return view('layouts.select-seat',[
            'departure' => $departure,
            'seats' => $seats,
            'reservation' => request(),
            'hotel' => $hotel,
            'total' => $total,
            'tickets' => $tickets,
            'current_tickets' => $current_tickets,
            'total_seats' => $departure->getTypeNumber(),
            'other_bus_available' => $other_bus_available,
            'sendSMS' => $sendSms
        ]);
    }


    /**
    * Display a listing of the reservations
    * from all Companies
    *
    * @return \Illuminate\Http\Response
    */
    public function indexCompanies()
    {
        $companies = Company::all();

        //lets add the select your tour first
        //return view('reservations.index-company',[
        return view('companies.select-companies-tour-date',[
            'companies' => $companies,
        ]);
    }

    /**
    * Display a listing of the reservations
    * from a single company
    *
    * @return \Illuminate\Http\Response
    */
    public function indexCompany( Company $company )
    {
        $tours = Tour::all()->where('company_id', $company->id);

        //lets add the select your tour first
        //return view('reservations.index-company',[
        return view('reservations.select-tour-date',[
            'tours' => $tours,
            'company' => $company
        ]);
    }


    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {

        $hotels = Hotel::all();
        $tours = Tour::all();

        return view('reservations.create', [
            'hotels' => $hotels,
            'tours' => $tours
        ]);
    }

    /**
    * Send the create form from a specific company
    * This will only load those company tours
    *
    * @return \Illuminate\Http\Response
    */
    public function createCompany(Company $company) {

        $hotels = Hotel::all();
        $tours = Tour::all()->where('company_id', $company->id);

        if ($tours->isEmpty()) {
            return view('home');
        }

        return view('reservations.create', [
            'hotels' => $hotels,
            'tours' => $tours
        ]);

        // Check this later please
        // return view('reservations.select-tour', [
        //   'hotels' => $hotels,
        //   'tours' => $tours
        // ]);
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {
        //return request();
        request()->validate([
            'client' => ['required', 'min:4'],
            'hotel_id' => ['required'],
            'date' => ['required'],
            'departure_id' => ['required'],
            'number_kids' => ['required', 'numeric'],
            'number_adults' => ['required', 'numeric'],
            'number_elders' => ['required', 'numeric'],
            'actual_pay' => ['required', 'numeric'],
            'payment_method' => ['required'],
        ]);

        /// this one should be re-calculated
        /// we must get the server tour prices, so...
        $departure = Departure::findOrFail(request('departure_id'));
        $tour = Tour::findOrFail($departure->tour_id);

        $reservation = new Reservation;
        // Assign the user id
        if ( $request->has('pass_user') ) {
            $reservation->user_id = request('new_user');
        }
        else {
            $reservation->user_id = Auth::user()->id; //Something like $this
        }
        $reservation->hotel_id = request('hotel_id');
        // $reservation->tour_id = request('tour_id');
        $reservation->departure_id = $departure->id;
        $reservation->tour_id = $tour->id;

        // We must save the request and send a message if
        // the save was successuful or not
        // and give the folio on screen
        // and the remaining of the pay
        $reservation->client = request('client');
        $reservation->client_email = request('client_email');
        $reservation->telephone = $request->has('telephone') ?
            '+'.request('code').request('telephone') : null;
        $reservation->room = request('room') ?? 0;
        $reservation->date = request('date');
        $reservation->number_kids = request('number_kids');
        $reservation->number_adults = request('number_adults');
        $reservation->number_elders = request('number_elders');
        $reservation->payment_method = request('payment_method');

        // $cost_kids = request('number_kids') * $tour->cost_kids;
        // $cost_adults = request('number_adults') * $tour->cost_adults;
        // $cost_elders = request('number_elders') * $tour->cost_elders;
        $cost_kids = request('number_kids') * ($request->has('price_kids') ? request('price_kids') : $tour->cost_kids);
        $cost_adults = request('number_adults') * ($request->has('price_adults') ? request('price_adults') : $tour->cost_adults);
        $cost_elders = request('number_elders') * ($request->has('price_elders') ? request('price_elders') : $tour->cost_elders);

        $reservation->total_kids = $cost_kids;
        $reservation->total_adults = $cost_adults;
        $reservation->total_elders = $cost_elders;

        $reservation->price_kids = $request->has('price_kids') ? request('price_kids') : $tour->cost_kids;
        $reservation->price_adults = $request->has('price_adults') ? request('price_adults') : $tour->cost_adults;
        $reservation->price_elders = $request->has('price_elders') ? request('price_elders') : $tour->cost_elders;

        $total = $cost_kids + $cost_adults + $cost_elders;

        $payment_made = 0;
        if (request("payment_method") == "citypass") {
            $reservation->citypass = request('citypass');
            $total = 0;
            $payment_made = $total;

            $check = Reservation::where('citypass', request('citypass'))->get();

            if ($check->count() > 0) {

                $reservations = $departure->reservations()->where('date', request('date'))->get();
                $message = "El CITYPASS que quieres ingresar ya fue ingresado";

                return redirect()->route('show_single_tour_date_get', [
                    'tour' => $tour,
                    'departure' => $departure,
                    'date' => request('date'),
                    'reservations' => $reservations,
                    'return' => 'true',
                    'message' => $message,
                    'class' => 'danger'
                ]);
            }
        }
        else if (request("payment_method") == "cortesia") {
            $total = 0;
            $payment_made = $total;
        }
        else{
            //aquí llega cuando la reservacion debe
            //guardar algun dinero como dato
            $payment_made = request('actual_pay');


            if ( $reservation->user->role->type == "Módulo" || $reservation->user->isAdmin() ) {

                if ($payment_made == $total) {
                    $reservation->confirmed = true;
                }

            }
        }

        $remaining = $total - $payment_made;
        // lets calculate each ticket type comission
        if ( $request->has('pass_user') ) {
            $user = User::findOrFail(request('new_user'));

            if ( Auth::user()->commissions()->where('tour_id', $tour->id )->count() == 1) {
                $comission_kids = request('number_kids') * ( $user->commisions->kids);
                $comission_adults = request('number_adults') * ( $user->commisions->adults);
                $comission_elders = request('number_elders') * ( $user->commisions->elders);
            }
            else {
                $comission_kids = 0;
                $comission_adults = 0;
                $comission_elders = 0;
            }
        }
        else {
            if ( Auth::user()->commissions()->where('tour_id', $tour->id )->count() == 1) {
                $c = Auth::user()->commissions()->where('tour_id', $tour->id )->first();
                $comission_kids = request('number_kids') * ( $c->kids);
                $comission_adults = request('number_adults') * ( $c->adults);
                $comission_elders = request('number_elders') * ( $c->elders);
            }
            else {
                $comission_kids = 0;
                $comission_adults = 0;
                $comission_elders = 0;
            }
        }
        $total_comission = $comission_kids + $comission_adults + $comission_elders;

        $reservation->comission_kids = $comission_kids;
        $reservation->comission_adults = $comission_adults;
        $reservation->comission_elders = $comission_elders;

        $reservation->total = $total;
        $reservation->actual_pay = $payment_made;
        $reservation->first_payment = $payment_made;
        $reservation->remaining = $remaining;
        $reservation->total_commission = $total_comission;

        if (! is_null(request('credit_numbers')) ) {
            $reservation->credit_numbers = request('credit_numbers');
        }

        $reservation->comments = request('comments');

        $company = $departure->tour->company->name;

        // ge the latest reservation first
        $last = Reservation::latest('id')->first();
        $id = 1;
        if ($last) {
            $id = $last->id + 1;
        }

        $folio = strtoupper(substr($company,0,3)).''.str_pad($id,7,'0',STR_PAD_LEFT);
        $reservation->folio = $folio;

        if ($reservation->actual_pay == $reservation->total_commission) {
            $reservation->status = 1;
        }
        else if ($reservation->actual_pay > $reservation->total_commission && $reservation->actual_pay < $reservation->total ) {
            $reservation->status = 2;
        }
        else if ($reservation->actual_pay >= $reservation->total) {
            $reservation->status = 3;
        }


        if ($reservation->departure->tour->name == "Total Pass") {
            $reservation->confirmed = true;
        }

        $sums_reservations = $departure->reservations()->where('date', request('date'))->where('status', '<>', 4);
        //return $sums_reservations->get();

        $sum_reservations  =  $sums_reservations->sum('number_adults')
                            + $sums_reservations->sum('number_kids')
                            + $sums_reservations->sum('number_elders');

        $tickets = $reservation->number_kids + $reservation->number_adults + $reservation->number_elders;

        // if ( ($departure->reservations()->where('date', request('date'))->count() + 1 ) > $tour->limit ) {
        //return $sum_reservations . " -- " . $tour->limit ." -- ".$tickets;
        if ( ($sum_reservations + $tickets ) > $tour->limit ) {
            $message = "El Tour está lleno para la cantidad de tickets que desea <b>[".$tickets."]</b> no se pudo guardar la reserva";
            $class = "danger";
        }
        else{
            $reservation->save();
            $p = new Payment;
            $p->user_id = Auth::user()->id;
            $p->reservation_id = $reservation->id;
            $p->payment = $payment_made;
            if ( $reservation->confirmed == true ) {
                $p->is_confirm = true;
                $p->user_confirm = $reservation->user->username;
            }
            $p->save();

            $sms = "";
            try
            {
                if ( $request->has('sendSMS') ) {
                    $sms = $this->sendSMS($reservation);
                }else{
                    $sms = " Mensaje SMS omitido";
                }
            }
            catch (\Exception $e)
            {
                $sms = "Error enviando SMS: " . $e->getMessage();
            }
            // $sms = "Mensaje supuestamente enviado";
            $class = "success";
            $message = "Reservación guardada con éxito <b>".$tickets."</b> tickets"." ".$sms;

            if ($reservation->client_email != null) {
                /*Mail::to($reservation->client_email)->queue(
                    new ReservationCreated($reservation)
                );*/
            }
        }

        //========================================================================
        //If you are a recepcionist you must only see your own reservations made
        //========================================================================
        $reservations = $departure->reservations()->where('date', request('date'))->get();
        //return view('tests.dos', [
        //return view('tours.show-single-tour-date', [
        return redirect()->route('show_single_tour_date_get', [
            'tour' => $tour,
            'departure' => $departure,
            'date' => request('date'),
            'reservations' => $reservations,
            'return' => 'true',
            'message' => $message,
            'class' => $class
        ]);

    }

    public function sendSMS(Reservation $reservation)
    {
        $accountSid = config('app.twilio')['TWILIO_ACCOUNT_SID'];
        $authToken  = config('app.twilio')['TWILIO_AUTH_TOKEN'];

        $client = new Client($accountSid, $authToken);
        $body = "";
        if ( $reservation->tour->company->name == "Operadora" ) {
            $body .= 'COMO LLEGAR -> https://bit.ly/2K0k6af ';
        }
        else {
            $body .= 'COMO LLEGAR -> https://bit.ly/2CShisY ';
        }
        $body .= 'RESERVACION '.$reservation->client.' ,';
        $body .= 'FOLIO '.$reservation->folio.', ';
        $body .= 'TOUR '.$reservation->departure->tour->name.' ';
        $body .= 'HORARIO '.$reservation->departure->horario.'. ';
        $body .= 'PAGADO $'.$reservation->first_payment.'. ';
        if ( $reservation->tour->company->name == "Operadora" ) {
            $body .= 'TEL: 4929240050 RESTO A PAGAR: ';
        }
        else {
            $body .= 'RESTO A PAGAR: ';
        }
        $body .= '($'.$reservation->remaining.')';

        try
        {
            // Use the client to do fun stuff like send text messages!
            $client->messages->create(
            // the number you'd like to send the message to
                $reservation->telephone,
            array(
                 // A Twilio phone number you purchased at twilio.com/console
                 //'from' => '+12019034369',
                 'from' => '+12013790327',
                 // the body of the text message you'd like to send
                 'body' => $body
                )
            );
        }
        catch (Exception $e)
        {
            return "Error enviando SMS: " . $e->getMessage();
        }
        return '¡mensaje enviado!';
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function storeWithSeats(Request $request)
    {
        //return request();

        // $departure = Departure::findOrFail(request('departure_id'));
        // return request('seat-'.$departure->type);
        //
        // foreach (request('seat') as $key => $seat) {
        //     if ($seat == "selection") {
        //         $seleccionados .= " ".$key;
        //         $seat = new Seat;
        //         $seat->departure_id = $departure->id;
        //         $seat->date = request('date');
        //         $seat->seat = $key;
        //         $seat->type = $departure->type;
        //         $seat->reservation_id = $reservation->id;
        //         //$seat->save();
        //     }
        // }
        // return $seleccionados;

        request()->validate([
            'client' => ['required', 'min:8'],
            'hotel_id' => ['required'],
            'date' => ['required'],
            'departure_id' => ['required'],
            'number_kids' => ['required', 'numeric'],
            'number_adults' => ['required', 'numeric'],
            'number_elders' => ['required', 'numeric'],
            'actual_pay' => ['required', 'numeric'],
            'payment_method' => ['required'],
        ]);

        /// this one should be re-calculated
        /// we must get the server tour prices, so...
        $departure = Departure::findOrFail(request('departure_id'));
        $tour = Tour::findOrFail($departure->tour_id);
        $message = "";
        $class = "";

        $reservation = new Reservation;
        // Assign the user id
        $reservation->user_id = Auth::user()->id; //Something like $this
        $reservation->hotel_id = request('hotel_id');
        // $reservation->tour_id = request('tour_id');
        $reservation->departure_id = $departure->id;
        $reservation->tour_id = $departure->tour->id;

        $reservation->client = request('client');
        $reservation->client_email = request('client_email');
        $reservation->telephone = '+'.request('code').request('telephone');
        $reservation->room = request('room') ?? 0;
        $reservation->date = request('date');
        $reservation->number_kids = request('number_kids');
        $reservation->number_adults = request('number_adults');
        $reservation->number_elders = request('number_elders');
        $reservation->payment_method = request('payment_method');

        // $cost_kids = request('number_kids') * $tour->cost_kids;
        // $cost_adults = request('number_adults') * $tour->cost_adults;
        // $cost_elders = request('number_elders') * $tour->cost_elders;
        $cost_kids = request('number_kids') * request('price_kids');
        $cost_adults = request('number_adults') * request('price_adults');
        $cost_elders = request('number_elders') * request('price_elders');

        $total = $cost_kids + $cost_adults + $cost_elders;

        $payment_made = 0;
        if (request("payment_method") == "citypass") {
            $payment_made = $total;
            $reservation->citypass = request('citypass');
            $payment_made = 0;
            $total = 0;

            $check = Reservation::where('citypass', request('citypass'))->get();

            if ($check->count() > 0) {

                $reservations = $departure->reservations()->where('date', request('date'))->get();
                $message = "El CITYPASS que quieres ingresar ya fue ingresado";

                return redirect()->route('show_single_tour_date_get', [
                    'tour' => $tour,
                    'departure' => $departure,
                    'date' => request('date'),
                    'reservations' => $reservations,
                    'return' => 'true',
                    'message' => $message,
                    'class' => 'danger'
                ]);
            }

        }
        //Here goes the cortesia
        else if (request("payment_method") == "cortesia") {
            $payment_made = 0;
            $total = 0;
        }
        else{
            $payment_made = request('actual_pay');

            if ( $reservation->user->role->type == "Módulo" || $reservation->user->isAdmin() ) {

                if ($payment_made == $total) {
                    $reservation->confirmed = true;
                }

            }
            if ( $payment_made > $total ) {
                //there was change
                $payment_made =  $total;
            }
        }

        $remaining = $total - $payment_made;
        // lets calculate each ticket type comission
        if ( $request->has('pass_user') ) {
            $user = User::findOrFail(request('new_user'));

            if ( Auth::user()->commissions()->where('tour_id', $tour->id )->count() == 1) {
                $comission_kids = request('number_kids') * ( $user->commisions->kids);
                $comission_adults = request('number_adults') * ( $user->commisions->adults);
                $comission_elders = request('number_elders') * ( $user->commisions->elders);
            }
            else {
                $comission_kids = 0;
                $comission_adults = 0;
                $comission_elders = 0;
            }
        }
        else {
            if ( Auth::user()->commissions()->where('tour_id', $tour->id )->count() == 1) {
                $c = Auth::user()->commissions()->where('tour_id', $tour->id )->first();
                $comission_kids = request('number_kids') * ( $c->kids);
                $comission_adults = request('number_adults') * ( $c->adults);
                $comission_elders = request('number_elders') * ( $c->elders);
            }
            else {
                $comission_kids = 0;
                $comission_adults = 0;
                $comission_elders = 0;
            }
        }

        $total_comission = $comission_kids + $comission_adults + $comission_elders;

        $reservation->comission_kids = $comission_kids;
        $reservation->comission_adults = $comission_adults;
        $reservation->comission_elders = $comission_elders;

        $reservation->total = $total;
        $reservation->actual_pay = $payment_made;
        $reservation->first_payment = $payment_made;
        $reservation->remaining = $remaining;
        $reservation->total_commission = $total_comission;

        if (! is_null(request('credit_numbers')) ) {
            $reservation->credit_numbers = request('credit_numbers');
        }

        $reservation->comments = request('comments');

        $company = $departure->tour->company->name;

        // ge the latest reservation first
        $last = Reservation::latest('id')->first();

        $id = 1;
        if ($last) {
            $id = $last->id + 1;
        }

        $folio = strtoupper(substr($company,0,3)).''.str_pad($id,7,'0',STR_PAD_LEFT);
        $reservation->folio = $folio;

        if ($reservation->actual_pay == $reservation->total_commission) {
            $reservation->status = 1;
        }
        else if ($reservation->actual_pay > $reservation->total_commission && $reservation->actual_pay < $reservation->total ) {
            $reservation->status = 2;
        }
        else if ($reservation->actual_pay >= $reservation->total) {
            $reservation->status = 3;
        }

        $total_of_totals = $departure->getTypes(0) + $departure->getTypes(1);

        if ( ($departure->reservations()->where('date', request('date'))->count() + 1 ) > $total_of_totals ) {
            // code...
            $message = "El Tour está lleno, no se puede guardar la reserva";
            $class = "danger";
        }
        else{

            DB::beginTransaction();

                try {
                    $reservation->save();
                    $p = new Payment;
                    $p->user_id = Auth::user()->id;
                    $p->reservation_id = $reservation->id;
                    $p->payment = $payment_made;
                    if ( $reservation->confirmed == true ) {
                        $p->is_confirm = true;
                        $p->user_confirm = $reservation->user->username;
                    }
                    $p->save();

                    foreach (request('seat-'.$departure->type) as $key => $seat) {
                        if ($seat == "selection") {
                            //$seleccionados .= " ".$key;
                            $seat = new Seat;
                            $seat->departure_id = $departure->id;
                            $seat->date = request('date');
                            $seat->seat = $key;
                            $seat->type = $departure->type;
                            $seat->reservation_id = $reservation->id;
                            $seat->save();
                        }
                    }

                    $class = "success";
                    $sms = "";
                    try
                    {
                        if ( $request->has('sendSMS') && $reservation->telephone != null ) {
                            // code...
                            $sms = $this->sendSMS($reservation);
                        } else {
                            $sms = " Mensaje SMS omitido";
                        }
                    }
                    catch (\Exception $e)
                    {
                        $sms = "Error enviando SMS: " . $e->getMessage();
                    }
                    // $sms = "Mensaje Supuestamente Enviado";
                    $message = "Reservación Guardada con éxito ".$sms;

                    DB::commit();
                    if ($reservation->client_email != null) {
                        /*Mail::to($reservation->client_email)->queue(
                            new ReservationCreated($reservation)
                        );*/
                    }

                } catch (\Exception $e) {
                    $class = "danger";
                    $message = "Lo sentimos hubo un problema al guardar tu reserva, los asientos seleccionados deben haber sido ocupados antes de que terminaras tu proceso";
                    DB::rollBack();
                }
        }

        // $reservations = $tour->reservations->where('date', request('date'));
        $reservations = $departure->reservations()->where('date', request('date'))->get();
        //return view('tests.dos', [
        //return view('tours.show-single-tour-date', [
        return redirect()->route('show_single_tour_date_get', [
            'tour' => $tour,
            'departure' => $departure,
            'date' => request('date'),
            'reservations' => $reservations,
            'return' => 'true',
            'message' => $message,
            'class' => $class,
            'current_reservation' => $reservation,
        ]);

    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show(Reservation $reservation)
    {
        return view('reservations.show', [
            'reservation' => $reservation
        ]);
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Reservation $reservation)
    {
        //
        //return $reservation->tour;
        $hotels = Hotel::all();

        return view('reservations.edit', [
            'reservation' => $reservation,
            'hotels' => $hotels,
            'tours' => Tour::where('company_id', $reservation->tour->company_id)->get(),
        ]);
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, Reservation $reservation)
    {
        //
        request()->validate([
            'client' => ['required', 'min:8'],
            'telephone' => ['required'],
            'hotel_id' => ['required'],
            'room' => ['required', 'numeric'],
            'date' => ['required'],
            'departure_id' => ['required'],
            'actual_pay' => ['required', 'numeric'],
            'payment_method' => ['required'],
        ]);

        $reservation->hotel_id = request('hotel_id');
        $reservation->departure_id = request('departure_id');
        $reservation->client = request('client');
        $reservation->client_email = request('client_email');
        $reservation->telephone = request('telephone');
        $reservation->room = request('room');
        $reservation->date = request('date');
        $reservation->payment_method = request('payment_method');

        //==============================================
        // Initial number of people in the reservations
        // and number of people in the request
        //==============================================
        $total_tickets = $reservation->number_kids + $reservation->number_adults + $reservation->number_elders;
        $request_tickets = request('number_kids') + request('number_adults') + request('number_elders');
        //==============================================
        // Number of reservations already in the tour
        //==============================================
        $departure = Departure::findOrFail(request('departure_id'));
        $sums_reservations = $departure->reservations()->where('date', request('date'));
        $sum_reservations  =  $sums_reservations->sum('number_adults')
                            + $sums_reservations->sum('number_kids')
                            + $sums_reservations->sum('number_elders');
        //==============================================
        // Get the maxibus ID
        //==============================================
        $maxiBus = Company::where('name', 'Maxibus')->first();

        if ( $request_tickets != $total_tickets ) {
            // Sí son más o menos tickets de los ya guardados la primera vez
            // Y aparte es maxibus
            // Para ver lo de los asientos luego, no dejar el cambio
            if( $maxiBus && $reservation->tour->company_id == $maxiBus->id) {
                //return redirect()->back()->with('status', '¡Maxibus cuidado!');
                return redirect()->back()->with('status', '¡Por cuestiones de integridad no puedes guardar más tickets de los ya asignados!');
            }
        }

        $tour = Tour::findOrFail($departure->tour_id);
        if ( $reservation->tour_id != request('tour_id') ) {
            if ( ($sum_reservations + $request_tickets ) > $tour->limit ) {
                return redirect()->back()->with('status', '¡El tour ya no tiene espacio!');
            }
        }

        $reservation->number_kids = request('number_kids');
        $reservation->number_adults = request('number_adults');
        $reservation->number_elders = request('number_elders');
        //$tickets = $reservation->number_kids + $reservation->number_adults + $reservation->number_elders;

        /// this one should be re-calculated
        /// we must get the server tour prices, so...
        $cost_kids = $reservation->number_kids * $tour->cost_kids;
        $cost_adults = $reservation->number_adults * $tour->cost_adults;
        $cost_elders = $reservation->number_elders * $tour->cost_elders;

        $reservation->total = $cost_kids + $cost_adults + $cost_elders;

        $reservation->actual_pay = request('actual_pay');
        $reservation->remaining = $reservation->total - request('actual_pay');

        if (! is_null(request('credit_numbers')) ) {
            $reservation->credit_numbers = request('credit_numbers');
        }

        if ($reservation->actual_pay == $reservation->total_commission) {
            $reservation->status = 1;
        }
        else if ($reservation->actual_pay > $reservation->total_commission && $reservation->actual_pay < $reservation->total ) {
            $reservation->status = 2;
        }
        else if ($reservation->actual_pay >= $reservation->total) {
            $reservation->status = 3;
        }

        $reservation->comments = request('comments');

        $company = $departure->tour->company->name;

        $reservation->save();

        //return request();
        return redirect()->route('reservations_show', [
            'reservation' => $reservation
        ])->with('status', 'Reserva actualizada con éxito');
    }

    /**
    * Show the form to confirm a given reservation
    *
    * @param Reservation $reservation
    *
    */
    public function showConfirm(Reservation $reservation)
    {
        return view('reservations.confirm', [
            'reservation' => $reservation
        ]);
    }

    /**
    * Confirm a given reservation
    *
    * @param Reservation $reservation
    * @return \Illuminate\Http\Response
    */
    public function confirm(Request $request, Reservation $reservation)
    {
        $reservation->confirmed = true;
        $reservation->actual_pay = ($reservation->actual_pay + request('payment'));
        $reservation->remaining = $reservation->total - $reservation->actual_pay;

        if ($reservation->actual_pay == $reservation->total_commission) {
            $reservation->status = 1;
        }
        else if ($reservation->actual_pay > $reservation->total_commission && $reservation->actual_pay < $reservation->total ) {
            $reservation->status = 2;
        }
        else if ($reservation->actual_pay >= $reservation->total) {
            $reservation->status = 3;
        }

        $reservation->save();

        //Just to know that is confirmed and by who
        $p = Payment::where('reservation_id', $reservation->id)->first();
        //$p->user_id = Auth::user()->id;
        $p->reservation_id = $reservation->id;
        $p->payment_confirm = request('payment');
        $p->is_confirm = true;
        $p->user_confirm = Auth::user()->username;
        $p->update();

        //To save the next payment for correlation purposes
        $p2 = new Payment;
        $p2->payment = request('payment');
        $p2->user_id = Auth::user()->id;
        $p2->reservation_id = $reservation->id;
        $p2->save();


        return view('reservations.confirm', [
            'reservation' => $reservation,
            'message' => 'Reservación actualizada'
        ]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {
        //
    }

    public function cancel(Reservation $reservation)
    {
        $cancel = false;
        if (Auth::user()->isAdmin()) {
            $reservation->total = 0;
            $reservation->payment_method = "cancelada";
            $reservation->status = 4;
            //get the seats
            $reservation->seats()->delete();
            //now save
            $reservation->save();

            if( Input::get('departure') ) {
                $url = '/show/single/departure?departure='.Input::get('departure').'&date='.Input::get('date');
                return redirect($url)->withStatus('Reservación cancelada con éxito');
            } else {
                return back()->withStatus('Reservación cancelada con éxito');
            }
        }
        if( Auth::user()->id == $reservation->user->id ) {
            $reservation->total = 0;
            $reservation->payment_method = "cancelada";
            $reservation->status = 4;
            //get the seats
            $reservation->seats()->delete();
            //now save
            $reservation->save();
            return back()->withStatus('Reservación cancelada con éxito');
        }
        if( Auth::user()->isOperador() ) {
            $reservation->total = 0;
            $reservation->payment_method = "cancelada";
            $reservation->status = 4;
            //get the seats
            $reservation->seats()->delete();
            //now save
            $reservation->save();
            return back()->withStatus('Reservación cancelada con éxito');
        }
        else {
            return redirect('/')->withStatus('Sólo los administradores pueden hacer esa acción');
        }
    }
}
