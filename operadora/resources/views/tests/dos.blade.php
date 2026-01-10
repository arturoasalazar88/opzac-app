@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <h5 class="blue darken-4 teal-title">
                Reservas de <br>
                <b>{{ $tour->name }}</b><br>
                {{ $tour->horario }}
            </h5>
            <h4 class="teal teal-title">Fecha : {{ $date }}</h4>
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            <h4>Reservaciones</h4>
            <table class="striped highlight table-content">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Operador</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Hotel</th>
                        <th>N</th>
                        <th>A</th>
                        <th>I</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($reservations as $key => $reservation)
                    <tr>
                        <td>{{ $reservation->folio }}</td>
                        <td>{{ $reservation->user->username }}</td>
                        <td>{{ $reservation->client }}</td>
                        <td>{{ $reservation->date }}</td>
                        <td>{{ $reservation->hotel->name }}</td>
                        <td>{{ $reservation->number_kids }}</td>
                        <td>{{ $reservation->number_adults }}</td>
                        <td>{{ $reservation->number_elders }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="alert alert-danger">
                            No hay reservas para este tour
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>

        </div>
    </div>

@endsection
