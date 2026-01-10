@extends('layouts.app')

@section('content')

  <div class="section" id="users-show">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h3>Detalles</h3>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <div class="collection with-header">
            <div class="collection-header">
              <h5>Información del Lugar/Hotel</h5>
            </div>
            <div class="collection-item">
              <b>Nombre</b> {{ $hotel->name }}
            </div>
            <div class="collection-item">
              <b>Clave</b> {{ $hotel->key }}
            </div>
            <div class="collection-item">
              <b>Zona {{ $hotel->zone->number }}</b> {{ $hotel->zone->name }}
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <a href="{{ route('hotels_edit',['hotel'=>$hotel->id]) }}" class="btn btn-blue">Editar</a>
        </div>
      </div>

    </div>
  </div>

@endsection
