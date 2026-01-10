@extends('layouts.app')

@section('content')

    {{-- Este archivo es la vista actual de Operadora,
    Un resumen de una compañía especificada
    y todos sus tours --}}

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h2 class="teal teal-title">{{ $company->name }}</h2>
                    <h3>Vista de Reservas para el día actual</h3>
                </div>

            </div>
            {{-- <div class="row">
                <div class="col s12 m3">
                    <a href="#" class="btn blue">Crea una Reserva</a>
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
            </div> --}}
            @forelse ($tours as $key => $tour)
                <div class="row">
                    <div class="col s12">
                        <h4 class="blue darken-4 teal-title">
                            Reservas de <br>
                            <b>{{ $tour->name }}</b>
                        </h4>
                        <h5>{{ $tour->horario}} [{{ $tour->reservations()->get()->count() }}]</h5>
                        <table class="striped highlight table-content">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Niños</th>
                                    <th>Adultos</th>
                                    <th>INSEN</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tour->reservations as $key => $reservation)
                                    <tr>
                                        <td>{{ $reservation->id }}</td>
                                        <td>{{ $reservation->user->username }}</td>
                                        <td>{{ $reservation->client }}</td>
                                        <td>{{ $reservation->date }}</td>
                                        <td>{{ $reservation->number_kids }}</td>
                                        <td>{{ $reservation->number_adults }}</td>
                                        <td>{{ $reservation->number_elders }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="alert alert-danger">
                                            No hay reservas para este tour
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <div class="row">
                    <div class="col s12 alert alert-danger">
                        <h5>
                            No hay Tours para esta compañía
                        </h5>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Últimas reservas de {{ $company->name }}</h3>
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
    </div>

@endsection
