<?php

namespace App\Http\Controllers;

use App\Departure;
use App\Tour;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Reservation;
use Auth;

class DepartureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $departures = Departure::all();

        return view('departures.index', [
            'departures' => $departures
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Tour $tour)
    {
        return view('departures.create', [
            'tour' => $tour
        ]);
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
          'horario' => ['required'],
          'tour_id' => ['required']
        ]);

        $departure_2 = Departure::where('tour_id', request('tour_id') )
                                    ->where('horario', request('horario') )
                                    ->get();

        if( $departure_2->count() > 0 ) {
            return back()->withStatus('¡No se puede duplicar horarios para un tour!');
        }

        $departure = new Departure;

        $departure->tour_id = request('tour_id');
        $departure->horario = request('horario');
        if (! is_null(request('type'))) {
            $departure->type = request('type');
        }

        $departure->save();

        $tour = Tour::findOrFail(request('tour_id'));

        if (request()->has('fast')) {

            $result = Reservation::where('date', Carbon::today()->toDateString() )
            ->where('tour_id', $tour->id)
            ->orderBy('client')
            ->limit(25)
            ->get();

            return view('fast.menu', [
                'fast' => $tour,
                'result' => $result
            ]);
        }

        return view('tours.show', [
            'tour' => $tour,
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Departure  $departure
     * @return \Illuminate\Http\Response
     */
    public function show(Departure $departure)
    {
        return $departure;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Departure  $departure
     * @return \Illuminate\Http\Response
     */
    public function edit(Departure $departure)
    {
        return view('departures.edit', [
            'departure' => $departure
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Departure  $departure
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Departure $departure)
    {
        $departure->type = request('type');
        $departure->save();

        $tour = Tour::findOrFail($departure->tour->id);

        return redirect()->route('tours_show', ['tour' => $tour]);
    }

    public function cancel(Departure $departure)
    {
        $reservations = $departure->reservations()
                        ->where('date', Carbon::today()->toDateString())
                        ->where('confirmed','!=','1')
                        ->where('status', '!=', '4');

        if ( $reservations->count() > 0 ) {
            return redirect()->back()
                    ->withStatus('No se puede desactivar un horario con reservaciones "no confirmadas", modifica o confirma las reservaciones de este horario para poderlo desactivar');
        }
        else {

            $departure->closed = true;
            $departure->date_closed = Carbon::today()->toDateString();
            $departure->save();

            return redirect()->back()
                    ->withStatus('El horario ha sido desactivado');
        }

    }
    public function activate(Departure $departure)
    {

        $departure->closed = false;
        // $departure->date_closed = Carbon::yesterday()->toDateString();
        $departure->date_closed = null;
        $departure->save();

        return redirect()->back()
                ->withStatus('El horario ha sido reactivado');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Departure  $departure
     * @return \Illuminate\Http\Response
     */
    public function destroy(Departure $departure)
    {
        if( Auth::user()->isAdmin() || Auth::user()->isOperador() || Auth::user()->isModule() ) {
            $departure->delete();
            return redirect()->back()
                    ->withStatus('El horario ha sido borrado');
        }
        else {
            return redirect()->back()
                    ->withStatus('No tienes los permisos suficientes para esta acción');
        }
    }
}
