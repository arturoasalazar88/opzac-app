@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Agrega un Horario al tour</h4>
                    <h4>{{ $tour->name }}</h4>
                </div>
            </div>

            @if (session('status'))
                <div class="row">
                    <div class="col s12 m12">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col s12">
                    <p>Horarios ya agregados</p>
                    <ul>
                        @forelse ($tour->departures as $key => $departure)
                            <li> <b>{{ $departure->horario }}</b>
                            @if ( $tour->company->name == "Maxibus")
                                Autobus {{ $departure->type == 0 ? 'Verde' : 'Rosa'}} - {{ $departure->type == 0 ? 'Grande [61 Asientos]' : 'Pequeño [50 Asientos]' }}
                            @endif
                            </li>
                        @empty
                            <li>No hay horarios aún para este tour</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ route('departures_store') }}" method="post">
                {{-- <form class="col s12 m12" action="#!" method="post"> --}}
                    @csrf
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="text" class="timepicker" name="horario" id="horario" placeholder="Agrega Horario" value="{{ old('horario') }}">
                            <!--<label for="closure">Tiempo de cierre</label>-->
                        </div>
                    </div>
                    @if ($tour->company->name == "Maxibus")
                        <div class="row">
                            <div class="input-field col s12 m4">
                                <select name="type">
                                    <option value="0">Grande (Verde - 61 Asientos)</option>
                                    <option value="1">Pequeño (Rosa - 50 Asientos)</option>
                                </select>
                                <label>Selecciona el tipo de autobus</label>
                            </div>
                        </div>
                    @endif
                    <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                    <div class="row">
                        <div class="col s12">
                            <p><i>*Recuerda seleccionar el autobus correctamente, esto afectara la creación de reservas</i></p>
                        </div>
                        <div class="input-field col s12">
                            <input type="submit" value="Crear Horario" class="btn blue darken-3">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
