<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Recolección</title>

    <style media="screen">
        th, td {
            font-size: 11px;
            padding: 10px 0px;
        }
        tr.header td {
            border-bottom: 1px solid #ddd;
        }
        tr.footer td {
            border-top: 1px solid #ddd;
        }
        body, html {
            /* background-color: red; */
            /* margin: 0;
            padding: 0; */
        }
        .section, .container {
            margin-left: 0;
            margin-right: 0;
            padding-left: 0;
            padding-right: 0;
        }
        .section, table, thead, tbody {
            width: 100%;
            width: 100vw;
        }
        .section {
            /* background-color: yellow; */
        }
        .container {
            margin: 10px;
            /* background-color: green; */
            /* color: white; */
            width: 98%;
        }
        h5 {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="section">
        <div class="container">
            <h5 width="100%" class="center">Operadora Zacatecas S.A de C.V</h5>
            <h6 width="100%" class="center">Fecha : {{ $date }}</h6>
        </div>
        <div class="container">
            <div class="row">
                <h6 class="center">{{ $title }}</h6>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            {{-- <h4>Reservaciones <small>[ conteo {{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders') }} ]</small></h4> --}}
            <table class="">
                <thead>
                    {{-- <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Tour</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Total</th>
                        <th scope="col">Hotel</th>
                        <th scope="col">Zona</th>
                        <th scope="col">N</th>
                        <th scope="col">A</th>
                        <th scope="col">I</th>
                    </tr> --}}
                </thead>
                <tbody>
                    @php
                        $last_tour = $reservations->first()->tour_name;
                        $last_departure = $reservations->first()->horario;
                        $adults = 0;
                        $kids = 0;
                        $elders = 0;
                    @endphp
                    @forelse ($reservations as $key => $reservation)

                        @if ($last_tour != $reservation->tour_name || $key == 0)
                            {{ $last_tour = $reservation->tour_name }}

                            @if ($key != 0)
                                <tr class="footer">
                                    <td colspan="6"></td>
                                    <td>Totales <b>[{{ $adults + $kids + $elders }}]</b></td>
                                    <td>{{ $adults }}</td>
                                    <td>{{ $kids }}</td>
                                    <td>{{ $elders }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="10" style="background: #eee;"><big>{{ $last_tour }}</big></td>
                            </tr>
                            <tr class="header">
                                <td><b>Folio</b></td>
                                <td><b>Cliente</b></td>
                                <td><b>Tour</b></td>
                                <td><b>Horario</b></td>
                                <td><b>Total</b></td>
                                <td><b>Resto</b></td>
                                <td><b>Hotel</b></td>
                                <td><b>A</b></td>
                                <td><b>N</b></td>
                                <td><b>I</b></td>
                            </tr>
                            {{ $kids = 0 }}
                            {{ $adults = 0 }}
                            {{ $elders = 0 }}
                        @endif
                        <tr>
                            <td scope="row" data-label="Folio">{{ $reservation->folio }}</td>
                            <td data-label="Cliente">{{ $reservation->client }}</td>
                            <td data-label="Tour">{{ $reservation->tour_name }}</td>
                            <td data-label="Hora"><b>{{ $reservation->horario }}</b></td>
                            <td data-label="total">{{ $reservation->total }}</td>
                            <td data-label="resto">{{ $reservation->remaining }}</td>
                            <td data-label="Hotel">{{ $reservation->hotel_name }}</td>
                            <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                            <td data-label="Niños">{{ $reservation->number_kids }}</td>
                            <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                        </tr>

                        {{ $kids = $kids + $reservation->number_kids }}
                        {{ $adults = $adults + $reservation->number_adults }}
                        {{ $elders = $elders + $reservation->number_elders }}
                    @empty
                        <tr>
                            <td colspan="8" class="alert alert-danger">
                                No hay reservas para este tour
                            </td>
                        </tr>
                    @endforelse
                    @if ($reservations->count() > 0)
                        <tr class="footer">
                            <td colspan="6"></td>
                            <td>Totales <b>[{{ $adults + $kids + $elders }}]</b></td>
                            <td>{{ $adults }}</td>
                            <td>{{ $kids }}</td>
                            <td>{{ $elders }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
