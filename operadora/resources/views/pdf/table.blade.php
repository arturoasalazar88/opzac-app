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
    </style>
</head>
<body>
    <div class="section">
        <div class="container">
            <h6>Fecha : {{ $date }}</h6>
        </div>
        <div class="container">
            <div class="row">
                <h6>{{ $title }}</h6>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            {{-- <h4>Reservaciones <small>[ conteo {{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders') }} ]</small></h4> --}}
            <table class="striped">
                <thead>
                    <tr>
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
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $key => $reservation)
                        <tr>
                            <td scope="row" data-label="Folio">{{ $reservation->folio }}</td>
                            <td data-label="Cliente">{{ $reservation->client }}</td>
                            <td data-label="Tour">{{ $reservation->tour_name }}</td>
                            <td data-label="Hora"><b>{{ $reservation->horario }}</b></td>
                            <td data-label="total">{{ $reservation->total }}</td>
                            <td data-label="Hotel">{{ $reservation->hotel_name }}</td>
                            <td data-label="Zona">{{ $reservation->zone_name }}</td>
                            <td data-label="Niños">{{ $reservation->number_kids }}</td>
                            <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                            <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="alert alert-danger">
                                No hay reservas para este tour
                            </td>
                        </tr>
                    @endforelse
                    @if ($reservations->count() > 0)
                        <tr style="border-bottom: 1px solid #f2f2f2;">
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td style="text-align:center;">Totales</td>
                            <td data-label="Total Niños">{{ $reservations->sum('number_kids') }}</td>
                            <td data-label="Total Adultos">{{ $reservations->sum('number_adults') }}</td>
                            <td data-label="Total INSEN">{{ $reservations->sum('number_elders') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
