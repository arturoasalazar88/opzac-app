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
            <h6 width="100%" class="center">Hora de impresión (24hrs): {{ Carbon\Carbon::now()->hour }}:{{ Carbon\Carbon::now()->minute }}</h6>
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
                    <tr>
                        <th>Folio</th>
                        <th>Tour</th>
                        <th>Usuario</th>
                        <th>Pago</th>
                        <th>U. Confirm</th>
                        <th>P. Confirm</th>
                        <th>Total</th>
                        <th>M. Pago</th>
                        <th>A</th>
                        <th>N</th>
                        <th>I</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse( $reservations as $reservation)
                        <tr>
                            @if ( $reservation->payment_method != "citypass" )
                                <td scope="row" data-label="Folio">{{ $reservation->folio }}</td>
                            @else
                                <td scope="row" data-label="Folio">{{ $reservation->citypass }}</td>
                            @endif
                            <td data-label="Tour">{{ $reservation->tour_name }}</td>
                            <td data-label="Usuario">{{ $reservation->username }}</td>
                            <td data-label="Pago">{{ $reservation->payment }}</td>
                            @if ($reservation->is_confirm == true)
                                <td data-label="Usuario Confirm">{{ $reservation->user_confirm }}</td>
                                <td data-label="Pago Confirm">{{ $reservation->payment_confirm }}</td>
                            @else
                                <td data-label="Usuario Confirm">N/A</td>
                                <td data-label="Pago Confirm">N/A</td>
                            @endif
                            <td data-label="Total"><b>{{ $reservation->total }}</b></td>
                            <td data-label="M. Pago">{{ $reservation->payment_method }}</td>
                            <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                            <td data-label="Niños">{{ $reservation->number_kids }}</td>
                            <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="alert alert-danger">
                                No hay reservas para este día
                            </td>
                        </tr>
                    @endforelse
                    @foreach ($totals as $key => $total)
                        <tr>
                            <td colspan="3"></td>
                            <td>Total {{ $total->payment_method }}</td>
                            <td>{{ $total->total }}</td>
                        </tr>
                    @endforeach
                    {{-- @if ($reservations->count() > 0)
                        <tr class="footer">
                            <td colspan="3"></td>
                            <td>Total</td>
                            <td>$<b>{{ $total_of_totals }}</b></td>
                            <td>Totales <b>[{{ $adults + $kids + $elders }}]</b></td>
                            <td>{{ $adults }}</td>
                            <td>{{ $kids }}</td>
                            <td>{{ $elders }}</td>
                        </tr>
                    @endif --}}
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
