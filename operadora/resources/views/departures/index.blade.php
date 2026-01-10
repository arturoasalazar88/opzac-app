@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h3>Administración de Horarios</h3>
        </div>

      </div>

      <div class="row">
        <div class="col s12">
          <ul class="collection with-header">
            <li class="collection-header">
              <h5>Listado de Horarios</h5>
            </li>
            @foreach ($departures as $key => $departure)
              <li class="collection-item">
                <a href="{{ $departure->id }}">
                  {{ $departure->id }} - {{ $departure->horario }}
                </a>
              </li>
            @endforeach
          </ul>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          {{-- <a href="{{ route('zones_create', ['company' => $company->id ]) }}" class="btn blue">Crea una Zona</a> --}}
        </div>
      </div>
    </div>
  </div>

@endsection
