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
        td big{
            margin-left: 5px;
        }
        body, html {
            /* background-color: red; */
            /* margin: 0;
            padding: 0; */
            text-transform: uppercase;
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
                <h6 class="center">{!! $title !!}</h6>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            {{-- <h4>Reservaciones <small>[ conteo {{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders') }} ]</small></h4> --}}
            <table class="">
                <thead>
                    {{-- This it's the header :) --}}
                </thead>
                <tbody>
                    @php
                        $last_hotel = $reservations->first()->hotel_name;
                        $last_zone = $reservations->first()->zone_name;
                        $last_departure = $reservations->first()->horario;
                        $adults = 0;
                        $kids = 0;
                        $elders = 0;
                    @endphp

                    @forelse ($reservations as $key => $reservation)

                        @if ($key == 0)
                            <tr>
                                <td colspan="11"> <big>{{ strtoupper($last_zone) }}</big> </td>
                            </tr>
                            {{ $last_zone = $reservation->zone_name }}
                        @endif

                        @if ($last_hotel != $reservation->hotel_name || $key == 0)
                            {{ $last_hotel = $reservation->hotel_name }}

                            @if ($key != 0)
                                <tr class="footer">
                                    <td colspan="5"></td>
                                    <td colspan="2">Totales <b>[{{ $adults + $kids + $elders }}]</b></td>
                                    <td>{{ $adults }}</td>
                                    <td>{{ $kids }}</td>
                                    <td>{{ $elders }}</td>
                                </tr>

                                @if ($last_zone != $reservation->zone_name && $key != 0)
                                    <tr>
                                        <td colspan="11">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="11"> <big>{{ strtoupper($reservation->zone_name) }}</big> </td>
                                    </tr>
                                    {{ $last_zone = $reservation->zone_name }}
                                @endif

                            @endif
                            <tr>
                                <td colspan="1" style="background: #414154; text-align: center; padding: 3px 5px;"><big style="color:white;">Hotel</big></td>
                                <td colspan="10" style="background: #ebebeb; padding: 3px 5px;"><big>{{ $last_hotel }}</big></td>
                            </tr>
                            <tr class="header">
                                <td><b>Folio</b></td>
                                <td><b>Cliente</b></td>
                                <td><b>Tour</b></td>
                                <td><b>Horario</b></td>
                                <td><b>Total</b></td>
                                <td><b>Resto</b></td>
                                <td><b>Hab.</b></td>
                                <td><b>Adulto</b></td>
                                <td><b>Niños</b></td>
                                <td><b>Insen</b></td>
                            </tr>
                            {{ $kids = 0 }}
                            {{ $adults = 0 }}
                            {{ $elders = 0 }}

                        @endif

                        <tr>
                            {{-- <td scope="row" data-label="Folio">{{ $reservation->folio }}</td> --}}
                            @if ( $reservation->payment_method != "citypass" )
                                <td scope="row" data-label="Folio">{{ $reservation->folio }}</td>
                            @else
                                <td scope="row" data-label="Folio">{{ $reservation->citypass }}</td>
                            @endif
                            <td data-label="Cliente">{{ $reservation->client }}</td>
                            <td data-label="Tour">{{ $reservation->tour_name }}</td>
                            <td data-label="Hora"><b>{{ $reservation->horario }}</b></td>
                            <td data-label="total">{{ $reservation->total }}</td>
                            <td data-label="Zona">{{ $reservation->remaining }}</td>
                            <td data-label="Habitación">{{ $reservation->room }}</td>
                            <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                            <td data-label="Niños">{{ $reservation->number_kids }}</td>
                            <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                        </tr>

                        {{ $kids = $kids + $reservation->number_kids }}
                        {{ $adults = $adults + $reservation->number_adults }}
                        {{ $elders = $elders + $reservation->number_elders }}
                    @empty
                        <tr>
                            <td colspan="10" class="alert alert-danger">
                                No hay reservas para este tour
                            </td>
                        </tr>
                    @endforelse
                    @if ($reservations->count() > 0)
                        <tr class="footer">
                            <td colspan="5"></td>
                            <td colspan="2">Totales <b>[{{ $adults + $kids + $elders }}]</b></td>
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
