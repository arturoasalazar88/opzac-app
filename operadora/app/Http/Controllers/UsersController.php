<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use App\Hotel;
use App\Tour;
use App\Company;
use App\Commission;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use PDF;
use DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $users = User::all();

      //return $users;

      $users = User::paginate(15);


      return view('users.index',[
        'users' => $users
      ]);
    }

    public function indexUsersRoles()
    {
        // $users = User::all();

        //return $users;

        $users = User::paginate(15);

        return view('users.index',[
          'users' => $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $hotels = Hotel::all();
        $companies = Company::all();

        return view('users.create',[
            'roles' => $roles,
            'hotels' => $hotels,
            'companies' => $companies,
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

        // return $request;
        request()->
        validate([
            'name' => ['required', 'min:6'],
            'username' => ['required', 'min:3', 'unique:users'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'min:6', 'confirmed'],
        ]);

        // create a new user
        $user = new User;
        // fill all the model data
        $user->name = request('name');
        $user->username = request('username');
        $user->hotel_id = request('hotel_id');
        $user->email = request('email');
        // $user->comission_kids = request('comission_kids');
        // $user->comission_adults = request('comission_adults');
        // $user->comission_elders = request('comission_elders');
        $user->role_id = request('role_id');
        $user->company_id = request('company_id');
        $user->password = Hash::make(request('password'));

        $is_admin = false;

        if ( $request->has('is_admin') ) {
            $is_admin = true;
        }
        $user->is_admin = $is_admin;

        // Save in the database
        $user->save();

        // Lets retrive the users
        // and return to the users index
        $users = User::paginate(15);

        return view('users.index', [
            'users' => $users
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      //$project = Project::findOrFail($id);

      return view('users.show', [
        'user' => $user
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

        $roles = Role::all();
        $hotels = Hotel::all();


      return view('users.edit',[
        'user' => $user,
        'roles' => $roles,
        'hotels' => $hotels
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
      //$user = Project::findOrFail($id);

      request()->validate([
        'name' => ['required', 'min:8'],
        'username' => ['required', 'min:3'],
      ]);

      $user->name = request('name');
      $user->username = request('username');
      $user->hotel_id = request('hotel_id');
      $user->role_id = request('role_id');

      $is_admin = false;

      if ( request()->has('is_admin') ) {
          $is_admin = true;
      }
      $user->is_admin = $is_admin;

      $user->update();

      /// If the user change its status to a non Administrador
      /// then move all the way to the home view
      /// for safety
      return view("home");

    }

    public function usersReservations()
    {
        $date = Input::get('date', Carbon::now()->toDateString());
        //return $date;
        $date2 = Input::get('date', Carbon::now()->toDateString());
        $date2 = Carbon::parse($date2)->addDay();
        $tour = Input::get('tour_id', '-1');

        $pdf_ = Input::get('pdf', false);
        //return $pdf_;

        //$reservations = Auth::user()->reservations()->whereBetween('created_at', [$date, $date2])->orderBy('created_at', 'DESC')->get();
        $title = "Pagos en Reservaciones de " . Auth::user()->name;
        //return $reservations;

        $reservations = DB::table('payments')
                ->join('reservations', 'payments.reservation_id', '=', 'reservations.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->join('hotels', 'reservations.hotel_id', '=', 'hotels.id')
                ->join('zones', 'hotels.zone_id', '=', 'zones.id')
                ->where('payments.user_id', Auth::user()->id)
                ->whereBetween('payments.created_at', [$date, $date2]);
                // ->where('payments.user_id', Auth::user()->id);

        if ( $tour != "-1" ) {
            $reservations = $reservations->where('tours.id', $tour);
        }

        $reservations = $reservations->select('reservations.client',
                    'reservations.id',
                    'reservations.folio',
                    'reservations.status',
                    'reservations.payment_method',
                    'reservations.citypass',
                    'reservations.number_kids',
                    'reservations.number_adults',
                    'reservations.number_elders',
                    'reservations.created_at',
                    'payments.payment',
                    'zones.name as zone_name',
                    'hotels.name as hotel_name',
                    'tours.name as tour_name',
                    'departures.horario',
                    'tours.company_id',
                    'reservations.date')
        ->get();

        //return $reservations;

        // $totals = DB::table('reservations')
        //         ->where('user_id', Auth::user()->id)
        //         ->where('status', '!=' ,'4')
        //         ->where('payment_method', '!=' ,'cortesia')
        //         ->where('payment_method', '!=' ,'citypass')
        //         ->whereBetween('created_at', [$date, $date2])
        //         ->limit(5)
        //         ->selectRaw('payment_method, SUM(total) as total')
        //         ->groupBy('payment_method')
        //         ->orderBy('total')
        //         ->get();
        $totals = DB::table('payments')
                ->join('reservations', 'payments.reservation_id', '=', 'reservations.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id');

        if ( $tour != "-1" ) {
            $totals = $totals->where('tours.id', $tour);
        }

        $totals = $totals->where('payments.user_id', Auth::user()->id)
                ->where('reservations.status', '!=' ,'4')
                ->where('reservations.payment_method', '!=' ,'cortesia')
                ->where('reservations.payment_method', '!=' ,'citypass')
                ->whereBetween('payments.created_at', [$date, $date2])
                ->limit(5)
                ->selectRaw('reservations.payment_method, SUM(payments.payment) as total')
                ->groupBy('reservations.payment_method')
                ->orderBy('total')
                ->get();

        if ( $pdf_ ) {
            $pdf = PDF::loadView('pdf.users-reservations' , [
                'user' => Auth::user()->name,
                'date' => $date,
                'reservations' => $reservations,
                'totals' => $totals,
            ]);
            // code...
            return $pdf->stream();
        }

        return view('users.reservations', [
            'reservations' => $reservations,
            'title' => $title,
            'date' => $date,
            'totals' => $totals,
            'tours' => Tour::all(),
            'active_tour' => $tour
        ]);
    }

    public function userReservations(User $user)
    {
        $date = Input::get('date', Carbon::now()->toDateString());
        $date2 = Input::get('date', Carbon::now()->toDateString());
        $date2 = Carbon::parse($date2)->addDay();

        $tour = Input::get('tour_id', '-1');

        $pdf_ = Input::get('pdf', false);

        $reservations = $user->reservations()->whereBetween('created_at', [$date, $date2])->orderBy('date', 'DESC')->paginate(15);
        $title = "Reservaciones realizadas por " . $user->name;

        $reservations = DB::table('payments')
                ->join('reservations', 'payments.reservation_id', '=', 'reservations.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id')
                ->join('hotels', 'reservations.hotel_id', '=', 'hotels.id')
                ->join('zones', 'hotels.zone_id', '=', 'zones.id')
                ->where('payments.user_id', $user->id)
                ->whereBetween('payments.created_at', [$date, $date2]);
                // ->where('payments.user_id', Auth::user()->id);
        if ( $tour != "-1" ) {
            $reservations = $reservations->where('tours.id', $tour);
        }

        $reservations = $reservations->select('reservations.client',
                    'reservations.id',
                    'reservations.folio',
                    'reservations.status',
                    'reservations.payment_method',
                    'reservations.citypass',
                    'reservations.number_kids',
                    'reservations.number_adults',
                    'reservations.number_elders',
                    'reservations.created_at',
                    'payments.payment',
                    'zones.name as zone_name',
                    'hotels.name as hotel_name',
                    'tours.name as tour_name',
                    'departures.horario',
                    'tours.company_id',
                    'reservations.date')
        ->get();

        $totals = DB::table('payments')
                ->join('reservations', 'payments.reservation_id', '=', 'reservations.id')
                ->join('departures','reservations.departure_id','=','departures.id')
                ->join('tours', 'departures.tour_id', '=', 'tours.id');

        if ( $tour != "-1" ) {
            $totals = $totals->where('tours.id', $tour);
        }

        $totals = $totals->where('payments.user_id', $user->id)
                ->where('reservations.status', '!=' ,'4')
                ->where('reservations.payment_method', '!=' ,'cortesia')
                ->where('reservations.payment_method', '!=' ,'citypass')
                ->whereBetween('payments.created_at', [$date, $date2])
                ->limit(5)
                ->selectRaw('reservations.payment_method, SUM(payments.payment) as total')
                ->groupBy('reservations.payment_method')
                ->orderBy('total')
                ->get();

        if ( $pdf_ ) {
            $pdf = PDF::loadView('pdf.users-reservations' , [
                'user' => $user->name,
                'date' => $date,
                'totals' => $totals,
                'reservations' => $reservations,
            ]);
            // code...
            return $pdf->stream();
        }

        return view('users.reservations', [
            'reservations' => $reservations,
            'title' => $title,
            'date' => $date,
            'totals' => $totals,
            'user' => $user->id,
            'notYou' => 'notYou',
            'tours' => Tour::all(),
            'active_tour' => $tour
        ]);
    }

    public function addCommission(User $user)
    {
        return view('commissions.add', [
            'user' => $user,
            'tours' => Tour::all(),
        ]);
    }

    public function storeCommission(User $user)
    {
        request()->validate([
            'kids' => ['required', 'numeric', 'min:0'],
            'adults' => ['required', 'numeric', 'min:0'],
            'elders' => ['required', 'numeric', 'min:0'],
        ]);

        $c = new Commission;

        $c->tour_id = request('tour_id');
        $c->user_id = $user->id;
        $c->kids = request('kids');
        $c->adults = request('adults');
        $c->elders = request('elders');

        $c->save();

        return redirect()->back()->with('status', 'Comisión agregada con éxito');;
    }

    public function editCommission(User $user, Commission $commission)
    {
        return view('commissions.edit', [
            'user' => $user,
            'commission' => $commission,
        ]);
    }

    public function updateCommission(Commission $commission)
    {
        request()->validate([
            'kids' => ['required', 'numeric', 'min:0'],
            'adults' => ['required', 'numeric', 'min:0'],
            'elders' => ['required', 'numeric', 'min:0'],
        ]);

        $commission->kids = request('kids');
        $commission->adults = request('adults');
        $commission->elders = request('elders');

        $commission->save();

        return redirect()->back()->with('status', 'Comisión actualizada con éxito');;
    }

    //PDF NEW FORMAT LOGED user
    public function usersReservationsByTours()
    {
        $date = Input::get('date', Carbon::now()->toDateString());
        //return $date;
        $date2 = Input::get('date', Carbon::now()->toDateString());
        $date2 = Carbon::parse($date2)->addDay();


        if (Input::has('user')) {

            $user = User::find(Input::get('user'));

            // $reservations = $user
            //             ->reservations()
            //             ->join('tours', 'tours.id', 'reservations.tour_id')
            //             ->whereBetween('reservations.created_at', [$date, $date2])
            //             ->orderBy('tours.id')->get();

            $reservations = DB::table('payments')
                    ->join('reservations', 'payments.reservation_id', '=', 'reservations.id')
                    ->join('departures','reservations.departure_id','=','departures.id')
                    ->join('tours', 'departures.tour_id', '=', 'tours.id')
                    ->join('hotels', 'reservations.hotel_id', '=', 'hotels.id')
                    ->join('zones', 'hotels.zone_id', '=', 'zones.id')
                    ->where('payments.user_id', $user->id)
                    ->whereBetween('payments.created_at', [$date, $date2]);
                    // ->where('payments.user_id', $user->id);

            $reservations = $reservations->select('reservations.client',
                        'reservations.id',
                        'reservations.folio',
                        'reservations.status',
                        'reservations.payment_method',
                        'reservations.citypass',
                        'reservations.number_kids',
                        'reservations.number_adults',
                        'reservations.number_elders',
                        'reservations.created_at',
                        'payments.payment',
                        'zones.name as zone_name',
                        'hotels.name as hotel_name',
                        'tours.name as tour_name',
                        'departures.horario',
                        'tours.id as tour_id',
                        'tours.company_id',
                        'reservations.date')
            ->get();

            $title = "Reservaciones realizadas por " . $user->name;
        }
        else{

            // $reservations = Auth::user()
            //             ->reservations()
            //             ->join('tours', 'tours.id', 'reservations.tour_id')
            //             ->whereBetween('reservations.created_at', [$date, $date2])
            //             ->orderBy('tours.id')->get();

            $reservations = DB::table('payments')
                    ->join('reservations', 'payments.reservation_id', '=', 'reservations.id')
                    ->join('departures','reservations.departure_id','=','departures.id')
                    ->join('tours', 'departures.tour_id', '=', 'tours.id')
                    ->join('hotels', 'reservations.hotel_id', '=', 'hotels.id')
                    ->join('zones', 'hotels.zone_id', '=', 'zones.id')
                    ->where('payments.user_id', Auth::user()->id)
                    ->whereBetween('payments.created_at', [$date, $date2]);
                    // ->where('payments.user_id', Auth::user()->id);

            $reservations = $reservations->select('reservations.client',
                        'reservations.id',
                        'reservations.folio',
                        'reservations.status',
                        'reservations.payment_method',
                        'reservations.citypass',
                        'reservations.number_kids',
                        'reservations.number_adults',
                        'reservations.number_elders',
                        'reservations.created_at',
                        'payments.payment',
                        'zones.name as zone_name',
                        'hotels.name as hotel_name',
                        'tours.name as tour_name',
                        'departures.horario',
                        'tours.id as tour_id',
                        'tours.company_id',
                        'reservations.date')
            ->get();

            $title = "Reservaciones realizadas por " . Auth::user()->name;
        }



        $pdf = PDF::loadView('pdf.users-reservations2' , [
            'user' => Auth::user()->name,
            'date' => $date,
            'reservations' => $reservations,
        ]);
        // code...
        return $pdf->stream();
    }
    //
    public function usersReservationsByToursGET()
    {
        $date = Input::get('date', Carbon::now()->toDateString());
        //return $date;
        $date2 = Input::get('date', Carbon::now()->toDateString());
        $date2 = Carbon::parse($date2)->addDay();

        $reservations = Auth::user()->reservations()->join('tours', 'tours.id', 'reservations.tour_id')->whereBetween('reservations.created_at', [$date, $date2])->orderBy('tours.id')->get();
        $title = "Reservaciones realizadas por " . Auth::user()->name;

        $pdf = PDF::loadView('pdf.users-reservations2' , [
            'user' => Auth::user()->name,
            'date' => $date,
            'reservations' => $reservations,
        ]);
        // code...
        return $pdf->stream();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->commissions()->delete();
        $user->delete();
        return redirect()->route('users_index')->with('status', 'Usuario borrado del sistema');
    }
}
