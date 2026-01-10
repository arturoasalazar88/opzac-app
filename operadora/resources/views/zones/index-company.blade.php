@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h3>Administración de Zonas</h3>
        </div>

      </div>

      <div class="row">
        <div class="col s12">
          <ul class="collection with-header">
            <li class="collection-header">
              <h5>Listado de Zonas</h5>
            </li>
            @foreach ($zones as $key => $zone)
              <li class="collection-item">
                <a href="{{ route('zones_show',['zone' => $zone->id ]) }}">
                  {{ $zone->number }} - {{ $zone->name }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <a href="{{ route('zones_select_create', ['company' => $company->id]) }}" class="btn blue">Crea una Zona</a>
        </div>
      </div>
    </div>
  </div>

@endsection
