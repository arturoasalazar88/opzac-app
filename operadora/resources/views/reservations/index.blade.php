@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Vista de Reservas</h3>
                </div>

            </div>
            <div class="row">
                <div class="col s12 m3">
                    <a href="{{ route('reservations_create') }}" class="btn blue">Crea una Reserva</a>
                </div>
                <div class="col s12 m3">
                    <a href="#!" class="btn green">Revisar Tous</a>
                </div>
                <div class="col s12 m3">
                    <a href="#!" class="btn red">Something ...</a>
                </div>
                <div class="col s12 m3">
                    <a href="#!" class="btn purple">Something else</a>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <h3>Ultimas reservas hechas</h3>
                    <table class="striped highlight table-content">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Cliente</th>
                                <th>Tour y Horario</th>
                                <th>Fecha</th>
                                <th>Niños</th>
                                <th>Adultos</th>
                                <th>INSEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reservations as $key => $reservation)
                                <tr>
                                    <td>{{ $reservation->id }}</td>
                                    <td>{{ $reservation->user->username }}</td>
                                    <td>{{ $reservation->client }}</td>
                                    <td>{{ $reservation->tour->name }} <span>{{ $reservation->tour->horario }}</span></td>
                                    <td>{{ $reservation->date }}</td>
                                    <td>{{ $reservation->number_kids }}</td>
                                    <td>{{ $reservation->number_adults }}</td>
                                    <td>{{ $reservation->number_elders }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="section" id="reservations-tour-container">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Listado de últimas reservas por Tour</h3>
                </div>
                @foreach ($tours as $key => $tour)
                    <div class="col s12 section-view">
                        <ul class="collection with-header">
                            <li class="collection-header">
                                <h5>{{ $tour->name }} - {{ $tour->horario }} Llenado hasta ahora ({{ $tour->reservations()->get()->count() }})</h5>
                            </li>
                            @foreach ($tour->reservations as $key => $reservation)
                                <li class="collection-item">
                                    <a href="{{ route('reservations_show',['reservation' => $reservation->id ]) }}">
                                        <b>{{ $reservation->id }}</b>
                                        {{ $reservation->client }}
                                        {{ $reservation->date }}
                                        {{ $reservation->number_kids }}
                                        {{ $reservation->number_adults }}
                                        {{ $reservation->number_elders }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

@endsection
