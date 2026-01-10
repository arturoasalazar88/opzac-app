@extends('layouts.app')

@section('content')
  <div class="section">
    <div class="container">

      <div class="row">
        <div class="col s12">
          <h4>Editar Hotel</h4>
        </div>
      </div>

      <div class="row">
        <form class="col s12" action="{{ route('hotels_update',['hotel'=>$hotel->id]) }}" method="post">
          @csrf
          @method('PUT')

          <div class="row">
            <div class="input-field col s12">
              <input type="text" name="name" value="{{ $hotel->name }}">
              <label for="name">Nombre</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="text" name="key" value="{{ $hotel->key }}">
              <label for="key">Clave</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12 m6">
                <p class="show-on-small hide-on-med-and-up">Zona</p>
              <select name="zone_id">
                @foreach ($zones as $key => $zone)
                  <option value="{{ $zone->id }}" {{ $zone->id == $hotel->zone->id ? 'selected' : ''}}>{{ $zone->name }}</option>
                @endforeach
              </select>
              <label for="zone_id" class="hide-on-small-and-down">Zona</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="submit" value="Editar" class="btn red">
            </div>
          </div>
        </form>

        @include('layouts.errors')
      </div>

    </div>
  </div>
@endsection
