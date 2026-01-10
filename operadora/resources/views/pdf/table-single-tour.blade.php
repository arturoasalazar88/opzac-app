<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Recolección</title>

    <style media="screen">
        th {
            text-transform: uppercase;
            border-bottom: 1px solid #000;
        }
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
        h6.title {
            background-color: #eee;
            padding: 8px 8px;
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
                <h6 class="title">{!! $title !!} <b>{{ $reservations->first()->departure->horario }}</b></h6>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            {{-- <h4>Reservaciones <small>[ conteo {{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders') }} ]</small></h4> --}}
            <table>
                <thead>
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Cliente</th>
                        {{-- <th scope="col">Horario</th> --}}
                        <th scope="col">Anticipo</th>
                        <th scope="col">Total</th>
                        <th scope="col">Hotel</th>
                        <th scope="col">Hab.</th>
                        <th scope="col">Adultos</th>
                        <th scope="col">Niños&nbsp;</th>
                        <th scope="col">INSEN&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $key => $reservation)
                        <tr>
                            <td>{{ $reservation->folio }}</td>
                            <td>{{ $reservation->client }}</td>
                            {{-- <td><b>{{ $reservation->departure->horario }}</b></td> --}}
                            <td>{{ $reservation->first_payment }}</td>
                            <td>{{ $reservation->total }}</td>
                            <td>{{ $reservation->hotel->name }}</td>
                            <td>{{ $reservation->room }}</td>
                            <td>{{ $reservation->number_adults }}</td>
                            <td>{{ $reservation->number_kids }}</td>
                            <td>{{ $reservation->number_elders }}</td>
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
                            <td style="text-align:left;border-top: 1px solid #000;"><b>Totales</b></td>
                            <td data-label="Total Adultos" style="border-top: 1px solid #000;"><b>{{ $reservations->sum('number_adults') }}</b></td>
                            <td data-label="Total Niños" style="border-top: 1px solid #000;"><b>{{ $reservations->sum('number_kids') }}</b></td>
                            <td data-label="Total INSEN" style="border-top: 1px solid #000;"><b>{{ $reservations->sum('number_elders') }}</b></td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
