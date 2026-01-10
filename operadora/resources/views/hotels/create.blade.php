@extends('layouts.app')

@section('content')

  <div class="section" id="users-create">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h3>Creación de Hoteles/Lugares</h3>
        </div>
      </div>
      <div class="row">

        @include('layouts.errors')

        <form class="col s12 m12" action="{{ route('hotels_store') }}" method="post">
          @csrf
          <div class="row">
            <div class="col s12">
              <legend>Información del nuevo Lugar o Hotel</legend>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="text" name="name" class="" placeholder="Nombre del Hotel" value="{{ old('name') }}">
              <label for="name">Nombre</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m6">
              <input type="text" name="key" class="" placeholder="Clave del Hotel" value="{{ old('key') }}">
              <label for="key">Clave</label>
            </div>
            <div class="input-field col s12 m6">
              <p class="show-on-small hide-on-med-and-up">Zona</p>
              <select name="zone_id" id="zone_id">
                @foreach ($zones as $key => $zone)
                  <option value="{{ $zone->id }}">#{{$zone->number}} {{ $zone->name }}</option>
                @endforeach
              </select>
              <label class="hide-on-small-and-down">Zona</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="submit" value="Crear" class="btn blue darken-3">
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>

  </div>

@endsection
