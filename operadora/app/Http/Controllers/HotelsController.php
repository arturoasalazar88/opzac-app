<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hotel;
use App\Zone;

class HotelsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $hotels = Hotel::all();

      return view('hotels.index',[
        'hotels' => $hotels
      ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $zones = Zone::all();
      return view('hotels.create',[
        'zones' => $zones,
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
        'name' => ['required', 'min:3'],
        'key' => ['required', 'min:2'],
        'zone_id' => ['required', 'exists:zones,id']
      ]);
      //return request()->all();
      $hotel = new Hotel;

      $hotel->name = request('name');
      $hotel->key = request('key');
      $hotel->zone_id = request('zone_id');

      $hotel->save();

      $hotels = Hotel::all();

      return view('hotels.index', [
          'hotels' => $hotels
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Hotel $hotel)
    {
      return view('hotels.show',[
        'hotel' => $hotel,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Hotel $hotel)
    {

      $zones = Zone::all();

      return view('hotels.edit',[
        'hotel' => $hotel,
        'zones' => $zones
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hotel $hotel)
    {
      request()->validate([
        'name' => ['required', 'min:5'],
        'key' => ['required', 'min:2'],
        'zone_id' => ['required']
      ]);

      $hotel->name = request('name');
      $hotel->key = request('key');
      $hotel->zone_id = request('zone_id');

      $hotel->update();

      //return redirect('/projects');

      $hotels = Hotel::all();

      return view('hotels.index', [
          'hotels' => $hotels
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
}
