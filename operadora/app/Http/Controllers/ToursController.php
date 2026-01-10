<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tour;
use App\Company;
use Carbon\Carbon;
use Auth;
use Illuminate\Support\Facades\Input;

class ToursController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $companies = Company::all();

      return view('tours.select', [
        'companies' => $companies
      ]);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showToursCompany( Company $company )
    {

      //$tours = Tour::all()->where('company_id', $id);

      if ( Auth::user()->isAdmin() ) {
        $tours = Tour::all()->where('company_id', $company->id);
      }
      else if ( Auth::user()->isModule() || Auth::user()->isOperador() ) {
        $tours = Tour::all()->where('company_id', $company->id)->Where('name', 'Tour centro historico');
      }


      return view('tours.index', [
        'tours' => $tours,
        'company' => $company
      ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function showDepartures( Tour $tour )
    {

      $departures = $tour->departures;

      return view('tours.select-departure', [
        'tour' => $tour,
        'departures' => $departures
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $today = Carbon::now();
      $companies = Company::all();

      //return 'something '.$today->isSunday();

      return view('tours.create', [
          'companies' => $companies
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
      request()->validate([
        'name' => ['required', 'min:10'],
        'limit' => ['required', 'numeric', 'min:1'],
        'company_id' => ['required'],
        'description' => ['required', 'min:10'],
        'cost_kids' => ['required', 'numeric','min:0'],
        'cost_adults' => ['required', 'numeric','min:0'],
        'cost_elders' => ['required', 'numeric','min:0'],
      ]);

      //$today = Carbon::now();
      //return $today->toDateString();

      $tour = new Tour;

      $tour->name = request('name');
      //$tour->horario = request('horario');
      $tour->limit = request('limit');
      $tour->owner = 'none';
      $tour->company_id = request('company_id');
      $tour->cost_kids = request('cost_kids');
      $tour->cost_adults = request('cost_adults');
      $tour->cost_elders = request('cost_elders');
      $tour->description = request('description');
      $tour->current = Carbon::now()->toDateString();
      //$tour->active = true, it's the default value

      //return request()->all();
      $tour->save();

      $company = Company::findOrFail( request('company_id') );

      //$this->showToursCompany( $company );

      $tours = Tour::all()->where('company_id', request('company_id'));

      return view('tours.index', [
        'tours' => $tours,
        'company' => $company
      ]);

      // return view('tours_company', [
      //     'tours' => $tours,
      //     'company' => request('company_id')
      // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Tour $tour)
    {
        $tour->departures = $tour->departures()->orderBy('horario')->get();
      //return $tour;
      return view('tours.show',[
        'tour' => $tour
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTour(Tour $tour)
    {
      $response = $tour;
      $response->departures;
      return $response;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTourDepartures()
    {
        $tour_id = Input::get('tour_id', 1);
        $tour = Tour::findOrFail( $tour_id );
        return $tour->departures;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Tour $tour)
    {

      $companies = Company::all();
      return view('tours.edit',[
        'tour' => $tour,
        'companies' => $companies
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tour $tour)
    {
      //dd("hey");
      //return request()->all();
      request()->validate([
        'name' => ['required', 'min:10'],
        'limit' => ['required', 'numeric', 'min:1'],
        'company_id' => ['required'],
        'description' => ['required', 'min:10'],
        'active' => ['required', 'boolean'],
        'cost_kids' => ['required', 'numeric', 'min:0'],
        'cost_adults' => ['required', 'numeric', 'min:0'],
        'cost_elders' => ['required', 'numeric', 'min:0'],
      ]);

      $tour->name = request('name');
      //$tour->horario = request('horario');
      $tour->limit = request('limit');
      $tour->owner = 'none';
      $tour->company_id = request('company_id');
      $tour->description = request('description');
      $tour->active = request('active');
      $tour->cost_kids = request('cost_kids');
      $tour->cost_adults = request('cost_adults');
      $tour->cost_elders = request('cost_elders');

      $tour->update();

      $tours = Tour::all();

      return view('tours.show', [
          'tour' => $tour,
      ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tour $tour)
    {
        if( Auth::user()->isAdmin() || Auth::user()->isOperador() || Auth::user()->isModule() ) {

            $tour->departures()->delete();
            $tour->delete();

            return redirect()->route('home')
                    ->withStatus('El tour ha sido borrado');
        }
        else {
            return redirect()->back()
                    ->withStatus('No tienes los permisos suficientes para esta acción');
        }
    }

    public function getPrices(Request $request)
    {
        $tour = Tour::findOrFail(request('tour_id'));
        $price_kids = $tour->cost_kids;
        $price_adults = $tour->cost_adults;
        $price_elders = $tour->cost_elders;

        //return $tour;
        return response()->json([
            'status'=> '0',
            'price_kids' => $price_kids,
            'price_adults' => $price_adults,
            'price_elders' => $price_elders,
        ]);
    }
}
