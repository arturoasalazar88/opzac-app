@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h4>Administración de Zonas</h4>
        </div>

      </div>

      <div class="row">
        <div class="col s12">
          <ul class="collection with-header">
            <li class="collection-header">
              <h6>Listado de Zonas</h6>
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
          <a href="{{ route('zones_create') }}" class="btn blue">Crea una Zona</a>
        </div>
      </div>
    </div>
  </div>

@endsection
