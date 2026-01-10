@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h4>Administración de Hoteles / Lugares</h4>
        </div>

      </div>

      <div class="row">
        <div class="col s12">
          <ul class="collection with-header">
            <li class="collection-header">
              <h6>Listado de Hoteles / Lugares</h6>
            </li>
            @foreach ($hotels as $key => $hotel)
              <li class="collection-item">
                <a href="{{ route('hotels_show', ['hotel' => $hotel->id]) }}">
                  {{ $hotel->name }}
                </a>
                <span class="right">{{ $hotel->zone->number }} - {{ $hotel->zone->name }}</span>

              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <a href="{{ route('hotels_create') }}" class="btn blue">Crea un Hotel/Lugar</a>
        </div>
      </div>
    </div>
  </div>

@endsection
