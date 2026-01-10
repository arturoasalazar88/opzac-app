<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <title>Reservaciones</title>

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
        h6.title {
            background-color: #eee;
            padding: 8px 8px;
        }
    </style>
</head>
<body>
    <div class="section">
        <div class="container">
            <h5 width="100%" class="center">Reservaciones de Usuario: {{ $user }}</h5>
            <h6 width="100%" class="center">Fecha Reporte: {{ $date }} - Hora de impresión (24hrs): {{ Carbon\Carbon::now()->hour }}:{{ Carbon\Carbon::now()->minute }}  </h6>
        </div>
    </div>
    <div class="section">
        <div class="container">
            {{-- <h4>Reservaciones <small>[ conteo {{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders') }} ]</small></h4> --}}
            <table>
                <thead>
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Tour</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">M. Pago</th>
                        <th scope="col">Total</th>
                        <th scope="col">N</th>
                        <th scope="col">A</th>
                        <th scope="col">I</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reservations as $key => $reservation)
                        <tr>
                            @if ( $reservation->payment_method != "citypass" )
                                <td scope="row" data-label="Folio">{{ $reservation->folio }}</td>
                            @else
                                <td scope="row" data-label="Folio">{{ $reservation->citypass }}</td>
                            @endif
                            <td>{{ $reservation->tour_name }}
                            {{-- <b>({{ $reservation->departure->tour->company->name}})</b></td> --}}
                            <td><b>{{ $reservation->horario }}</b></td>
                            <td>{{ $reservation->date }}</td>
                            <td>{{ $reservation->payment_method }}</td>
                            <td>{{ $reservation->payment }}</td>
                            <td>{{ $reservation->number_kids }}</td>
                            <td>{{ $reservation->number_adults }}</td>
                            <td>{{ $reservation->number_elders }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="alert alert-danger">
                                No hay reservas para este usuario
                            </td>
                        </tr>
                    @endforelse
                    @foreach ($totals as $key => $total)
                        <tr>
                            <td colspan="4"></td>
                            <td>Total {{ $total->payment_method }}</td>
                            <td>{{ $total->total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
