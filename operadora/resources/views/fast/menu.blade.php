@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>FAST TRACK</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Reservación Fast Track - <small>{{ $fast->name }}</small></h5>
                        </li>
                    </ul>
                </div>
                {{-- <div class="col s12 m6 l4">
                    <a href="{{ route('fast_create') }}?tour={{$fast->id}}=&date={{ Carbon\Carbon::today()->toDateString()}}">
                        <div class="card-panel teal">
                            <span class="white-text center">
                                Continuar reserva (FAST TRACK)
                            </span>
                        </div>
                    </a>
                </div> --}}
                @foreach ($fast->departures as $key => $departure)
                    @if ($departure->isActive())
                        <div class="col s12 m6 l4">
                            <a href="{{ route('fast_create') }}?tour={{$fast->id}}=&date={{ Carbon\Carbon::today()->toDateString()}}&departure_id={{$departure->id}}">
                                <div class="card-panel {{ $departure->type == 0 ? 'teal' : 'pink' }}">
                                    <span class="white-text center">
                                        FAST TRACK {{ $departure->horario }} <b>{{ $departure->type == 0 ? 'Verde' : 'Rosa'}}</b>
                                    </span>
                                </div>
                            </a>
                        </div>
                    @endif
                @endforeach
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Activar o desactivar horario</h5>
                        </li>
                    </ul>
                </div>
                @if (session('status'))
                    <div class="col s12 m12">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                @endif
                <div class="col s12 m12 l12">
                        <b>Horarios</b><br>
                        @forelse ($fast->departures as $key => $departure)
                            {{ $departure->horario }}
                            @if ($departure->tour->company->name == "Maxibus")
                                - Autobus [ {{ $departure->type == 0 ? 'Verde' : 'Rosa'}} - {{ $departure->type == 0 ? ''.$departure->getTypes(0) : ''.$departure->getTypes(1) }} ]
                                {{-- <a href="{{ route('departures_edit',['departure' => $departure->id]) }}">Editar</a> --}}
                            @endif
                            @if ( $departure->isActive() )
                                (<a href="{{ route('departures_cancel', ['departure' => $departure->id ]) }}">Desactivar horario</a>)<br>
                            @else
                                (<a href="{{ route('departures_activate', ['departure' => $departure->id ]) }}">Reactivar horario</a>)<br>
                            @endif
                        @empty
                            No hay horarios asociados a este tour ¡Agrega uno!
                        @endforelse
                        <br>
                        @if ( $fast->departures->count() > 0 )
                            {{-- <a href="#!" class="btn teal">Reactivar todos</a> --}}
                        @endif
                </div>

            </div>
            {{-- <div class="row">
                <div class="col s12 m3">
                    <a href="{{ route('departures_create', ['tour'=>$fast->id]) }}" class="btn">Añadir Horario</a>
                </div>
            </div> --}}
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
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <select name="type">
                                <option value="0">Grande ( Verde - 61 Asientos)</option>
                                <option value="1">Pequeño ( Rosa - 50 Asientos)</option>
                            </select>
                            <label>Selecciona el tipo de autobus</label>
                        </div>
                    </div>
                    <input type="hidden" name="tour_id" value="{{ $fast->id }}">
                    <input type="hidden" name="fast" value="true">
                    <div class="row">
                        <div class="col s12">
                            <p><i>*Recuerda seleccionar el autobus correctamente, esto afectará la creación de reservas</i></p>
                        </div>
                        <div class="input-field col s12">
                            <input type="submit" value="Crear Horario" class="btn blue darken-3">
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Confirmación Rápida Fast Track</h5>
                        </li>
                    </ul>
                </div>
                <div class="row">
                    <form class="col s12" method="post" action="{{ route('fast_menu_search') }}" id="search_form">
                        @csrf
                        <div class="row search-box">
                            <div class="input-field col s12 m10">
                                <input placeholder="Introduce tu búsqueda" name="q" id="search" type="text">
                                <label for="q"><b>Busca por Folio, Nombre o Correo electrónico</b></label>
                            </div>
                            <input type="hidden" name="fast_id" value="{{ $fast->id }}">
                            <div class="input-field col s12 m2">
                                {{-- <input type="submit" value="Buscar" name="buscar" class="btn teal" placeholder="buscar">
                                <label for="buscar">Búsqueda</label> --}}
                                <button name="button" class="btn teal" id="make_search">Buscar</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col s12 m12 l12">
                    <p> Los resultados para tu consulta   son :</p>
                    <div class="row reservations-types alert alert-info">
                        <div class="col s12 m3"><i class="fa fa-lock-open"></i>No pagada comisión</div>
                        <div class="col s12 m3"><i class="fa fa-lock-open" style="color: red;"></i>Pagada únicamente comisión</div>
                        <div class="col s12 m3"><i class="fa fa-lock-open" style="color: #ffeb3b;"></i>Pagada más de la comisión</div>
                        <div class="col s12 m3"><i class="fa fa-lock" style="color: green;"></i>Pagada totalmente</div>
                    </div>
                    <table class="table striped table-content">
                        <thead>
                            <tr>
                                <th scope="col">Folio</th>
                                <th scope="col">Cliente</th>
                                <th scope="col">Tour (Compañía)</th>
                                <th scope="col">Horario</th>
                                <th scope="col">Fecha</th>
                                <th scope="col">Hotel</th>
                                <th scope="col">N</th>
                                <th scope="col">A</th>
                                <th scope="col">I</th>
                                <th scope="col">Edita</th>
                                <th scope="col">Confirma</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($result as $reservation)
                                <tr>
                                    <td scope="row" data-label="Folio">
                                        @if ($reservation->status == 0)
                                            <i class="fa fa-lock-open"></i>
                                        @elseif ($reservation->status == 1)
                                            <i class="fa fa-lock-open" style="color: red;"></i>
                                        @elseif ($reservation->status == 2)
                                            <i class="fa fa-lock-open" style="color: #ffeb3b;"></i>
                                        @else
                                            <i class="fa fa-lock" style="color: green;"></i>
                                        @endif
                                        {{ $reservation->folio }}
                                    </td>
                                    <td data-label="Cliente">{{ $reservation->client }}</td>
                                    <td data-label="Tour">
                                        {{ $reservation->departure->tour->name }}
                                        <b>({{ $reservation->departure->tour->company->name}})</b>
                                    </td>
                                    <td data-label="Hora"><b>{{ $reservation->departure->horario }}</b></td>
                                    <td data-label="Fecha">{{ $reservation->date }}</td>
                                    <td data-label="Hotel">{{ $reservation->hotel->name }}</td>
                                    <td data-label="Niños">{{ $reservation->number_kids }}</td>
                                    <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                                    <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                                    <td data-label="Acciones">
                                        <a href="{{ route('reservations_show' , ['reservation' => $reservation->id]) }}">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td data-label="Confirma">
                                        @if ($reservation->confirmed == true)
                                            <a href="{{ route('printable_reservation', [ 'reservation' => $reservation->id]) }}" class="btn red" target="_blank"> Imprimir </a>
                                        @else
                                            <a class="btn purple" href="{{ route('reservation_show_confirm' , ['reservation' => $reservation->id]) }}">Confirmar</a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="alert alert-danger" colspan="15">
                                        No hay reservas actualmente para confirmar hoy
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12 m6 l4">
                </div>
            </div>

        </div>
    </div>

@endsection
