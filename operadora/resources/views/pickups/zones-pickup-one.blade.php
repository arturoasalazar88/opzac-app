@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <h6 class="blue darken-4 teal-title">
                Recolección del día
            </h6>
            <h6 class="teal teal-title">Fecha : {{ $date }}</h6>
        </div>
        <div class="container">
            <div class="row">
                <h4>{{ $title }}</h4>
            </div>
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            <h4>Reservaciones <small>[ conteo {{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders') }} ]</small></h4>
            <table class="striped highlight table-content">
                <thead>
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Tour</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Hotel</th>
                        <th scope="col">N</th>
                        <th scope="col">A</th>
                        <th scope="col">I</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($reservations as $key => $reservation)
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
                        <td data-label="Fecha">{{ $reservation->date }}</td>
                        <td data-label="Hotel">{{ $reservation->hotel_name }}</td>
                        <td data-label="Niños">{{ $reservation->number_kids }}</td>
                        <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                        <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="alert alert-danger">
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
                        <td>{{ $reservations->sum('number_kids') }}</td>
                        <td>{{ $reservations->sum('number_adults') }}</td>
                        <td>{{ $reservations->sum('number_elders') }}</td>
                        {{-- <td>
                            [{{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders')}}]
                        </td> --}}
                    </tr>
                @endif
                </tbody>
            </table>

            <div class="row">
                @if ($reservations->count() != 0)
                <p>
                    <i>*Abrirá en una pestaña nueva</i>
                </p>
                    @if ($type == "zones")
                        <a href="{{ route('printable_zones') }}?zone_id={{$zone_id}}&departure_id={{$departure_id}}&company_id={{$company_id}}&date={{$date}}" target="_blank" class="btn teal">Crear Imprimible</a>
                    @elseif ($type == "departures")
                        <a href="{{ route('printable_departures') }}?zone_id={{$zone_id}}&horario={{$horario}}&company_id={{$company_id}}&date={{$date}}" target="_blank" class="btn teal">Crear Imprimible</a>
                    @elseif ($type == "hotel_1")
                        <a href="{{ route('printable_hotels_departures') }}?horario={{$horario}}&hotel_id={{$hotel}}&company_id={{$company_id}}&date={{$date}}" target="_blank" class="btn teal">Crear Imprimible</a>
                    @elseif ($type == "hotel_2")
                        <a href="{{ route('printable_hotels_tours') }}?tour_id={{$tour_id}}&hotel_id={{$hotel_id}}&company_id={{$company_id}}&date={{$date}}" target="_blank" class="btn teal">Crear Imprimible</a>
                    @elseif ($type == "tours")
                        <a href="{{ route('pickup_result_tours_pdf') }}?tour_id={{$tour_id}}&horario={{$horario}}&company_id={{$company_id}}&date={{$date}}" target="_blank" class="btn teal">Crear Imprimible</a>
                        {{-- <a href="#!" target="_blank" class="btn teal">Crear Imprimible</a> --}}
                    @endif
                @endif
            </div>
        </div>
    </div>

@endsection
