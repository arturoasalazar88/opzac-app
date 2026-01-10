<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <title>Reservation</title>
        <style media="screen">
            * {
                font-size: 10px;
            }
            body, html {
                margin: 0;
                padding: 0;
                border: 1px dotted black;
            }
        </style>
    </head>
    <body>
        <div style="font-size: 8px; padding:5px;">
            Zacatecas, México,<br>
            Con Fecha {{ Carbon\Carbon::now()->toDateString() }}<br>
            Este no es un comprobante fiscal
        </div>
        <div style="width: 100%; text-align: left; padding: 15px;">
            <span style="font-size: 12px;"><b>{{ $reservation->departure->tour->company->name}}, Zacatecas</b></span><br>
            <span style="font-size: 12px;"><b>FOLIO : </b>{{ $reservation->folio }}</b></span>
            <br>
            <b>Nombre:</b> {{ $reservation->client }} <br>
            <b>Email:</b> {{ $reservation->client_email }} <br>
            <b>Teléfono:</b> {{ $reservation->telephone}} <br>
            <b>Hotel:</b> {{ $reservation->hotel->name }}  {{ $reservation->room }}
            {{-- <hr size="3"> --}}
            <br>
            <br>
            <span style="font-size: 10px;"><b>Información del Tour</b></span>
            <br>
            {{ $reservation->departure->tour->name }} <br>
            <b>Horario:</b> {{ $reservation->departure->horario }} <br>
            <b>Fecha:</b> {{ $reservation->date }}<br>
            <b>Niños</b> [{{ $reservation->number_kids }}] <b>Adultos</b> [{{ $reservation->number_adults }}] <b>INSEN</b> [{{ $reservation->number_elders }}] <br>
            @if ($reservation->departure->tour->company->name == "Maxibus")
                <b>Asientos:</b><br>
                @foreach ($reservation->seats as $key => $seat)
                    @if ($loop->last)
                        {{ $seat->seat }}
                    @else
                        {{ $seat->seat }},
                    @endif
                @endforeach
            @endif
            <br>
            <br>
            <span style="font-size: 10px;"><b>Información de Pago</b></span>
            <br>
            <b>Método de Pago:</b> {{ $reservation->payment_method}} <br>
            <b>Total:</b> {{ $reservation->total }} <br>
            <b>Pagado:</b> {{ $reservation->actual_pay }} <br>
            @if ($reservation->total != $reservation->actual_pay)
                <b>Restante:</b> {{ $reservation->remaining }} <br>
            @endif
            {{-- <hr size="3"> --}}

            <br>
            <br>
            <span style="font-size: 10px;"><b>Gracias por su preferencia.</b></span>

        </div>
    </body>
</html>
