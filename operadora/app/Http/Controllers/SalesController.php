<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reservation;
use App\User;
use App\Hotel;
use App\Departure;
use App\Tour;
use App\Company;
use DB;
use Illuminate\Support\Facades\Input;

class SalesController extends Controller
{
    //
    public function index()
    {
        $date1 = Input::get('date1');
        $date2 = Input::get('date2');

        $tours = DB::table('reservations')->join('tours', 'reservations.tour_id','tours.id');
                        if (Input::has('company_id')) {
                            $tours = $tours->where('tours.company_id', Input::get('company_id'));
                        }
                        $tours = $tours->whereBetween('date', [$date1, $date2])
                        ->selectRaw('tours.id, tours.name, SUM(total)')
                        ->groupBy('tours.name')
                        ->get()
                        ->pluck('name');
        $totals = DB::table('reservations')->join('tours', 'reservations.tour_id','tours.id');
                        if (Input::has('company_id')) {
                            $totals = $totals->where('tours.company_id', Input::get('company_id'));
                        }
                        $totals = $totals->whereBetween('date', [$date1, $date2])
                        ->selectRaw('tours.id, tours.name, SUM(total)')
                        ->groupBy('tours.name')
                        ->get()
                        ->pluck('SUM(total)');

        // 'tours' => Tour::select('name')->get()->pluck('name'),
        return view('sales.test', [
            'tours' => $tours,
            'totals' => $totals
        ]);
    }

    public function users()
    {
        $date1 = Input::get('date1');
        $date2 = Input::get('date2');

        $users = DB::table('reservations')->join('users', 'reservations.user_id','users.id')
                        ->whereBetween('date', [$date1, $date2])
                        ->selectRaw('users.id, users.username, SUM(total)')
                        ->groupBy('users.id')
                        ->orderBy('SUM(total)','DESC')
                        ->limit(10)
                        ->get()
                        ->pluck('username');
        $totals = DB::table('reservations')->join('users', 'reservations.user_id','users.id')
                        ->whereBetween('date', [$date1, $date2])
                        ->selectRaw('users.id, users.username, SUM(total)')
                        ->groupBy('users.id')
                        ->orderBy('SUM(total)','DESC')
                        ->limit(10)
                        ->get()
                        ->pluck('SUM(total)');

        // 'tours' => Tour::select('name')->get()->pluck('name'),
        return view('sales.users', [
            'users' => $users,
            'totals' => $totals
        ]);
    }

    public function hotels()
    {
        $date1 = Input::get('date1');
        $date2 = Input::get('date2');

        $hotels = DB::table('reservations')->join('hotels', 'reservations.hotel_id','hotels.id')
                        ->whereBetween('date', [$date1, $date2])
                        ->selectRaw('hotels.id, hotels.name, SUM(total)')
                        ->groupBy('hotels.id')
                        ->orderBy('SUM(total)','DESC')
                        ->limit(10)
                        ->get()
                        ->pluck('name');
        $totals = DB::table('reservations')->join('hotels', 'reservations.hotel_id','hotels.id')
                        ->whereBetween('date', [$date1, $date2])
                        ->selectRaw('hotels.id, hotels.name, SUM(total)')
                        ->groupBy('hotels.id')
                        ->orderBy('SUM(total)','DESC')
                        ->limit(10)
                        ->get()
                        ->pluck('SUM(total)');

        // 'tours' => Tour::select('name')->get()->pluck('name'),
        return view('sales.hotels', [
            'hotels' => $hotels,
            'totals' => $totals
        ]);
    }

    public function dates()
    {
        $date1 = Input::get('date1');
        $date2 = Input::get('date2');

        $dates = Reservation::whereBetween('date', [$date1, $date2])
                        ->selectRaw('reservations.date, SUM(total)')
                        ->groupBy('date')
                        ->get()
                        ->pluck('date');
        $totals = Reservation::whereBetween('date', [$date1, $date2])
                        ->selectRaw('reservations.date, SUM(total)')
                        ->groupBy('date')
                        ->get()
                        ->pluck('SUM(total)');

        return view('sales.points', [
            'dates' => $dates,
            'totals' => $totals
        ]);
    }

    public function confirmed()
    {
        $date1 = Input::get('date1');
        $date2 = Input::get('date2');

        $confirmed =  Reservation::whereBetween('date', [ $date1, $date2 ])->where('confirmed', true)->count();
        $notConfirmed =  Reservation::whereBetween('date', [ $date1, $date2 ])->where('confirmed', false)->count();

        return view('sales.confirmed', [
            'confirmed' => $confirmed,
            'notConfirmed' => $notConfirmed
        ]);
    }


}
