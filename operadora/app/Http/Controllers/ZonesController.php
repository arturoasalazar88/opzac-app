<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Zone;
use App\Company;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $zones = Zone::all();

      return view('zones.index',[
        'zones' => $zones
      ]);
    }

    /**
     * Show the form to select a company
     *
     * @return \Illuminate\Http\Response
     */
     public function selectCompany() {

         $companies = Company::all();

         return view( 'layouts.select-company', [
            'companies' => $companies,
            'action' => 'administrar las zonas',
            'url' => 'zones_index_company'
         ]);
     }

     public function indexCompany(Company $company)
     {
         $zones = Zone::all();

         return view('zones.index-company', [
             'company' => $company,
             'zones' => $zones,
         ]);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      return view('zones.create');
    }

    public function selectCreate(Company $company)
    {
        return view('zones.create', [
            'company' => $company
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
        'number' => ['required', 'unique:zones'],
        'name' => ['required', 'min:3'],
        'closure' => ['required']
      ]);

      $zone = new Zone();

      $zone->number = request('number');
      $zone->name = request('name');
      $zone->closure = request('closure');

      $zone->save();

      $zones = Zone::all();

      //$this->indexCompany(Company::findOrFail(request('company_id')));

      return view("zones.index",[
          'zones' => $zones,
      ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
      return view('zones.show',[
        'zone' => $zone,
      ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
      return view('zones.edit',[
        'zone' => $zone
      ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
      request()->validate([
        'name' => ['required', 'min:3'],
        'closure' => ['required']
      ]);

      //$zone->number = request('number');
      $zone->name = request('name');
      $zone->closure = request('closure');

      $zone->update();

      //$zones = Zone::all();

      return view("zones.show",[
          'zone' => $zone
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
