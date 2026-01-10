@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h4>Confirmación Manual de Reserva</h4>
                </div>
            </div>

            @if(isset($message))
                <div class="row">
                    <div class="col s12">
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col s12">
                    @if (!$reservation->confirmed)
                        <p>¿Seguro que deseas confirmar esta reserva?</p>
                        <form class="formConfirm" action="{{ route('reservation_make_confirm',['reservation' => $reservation->id]) }}" method="post">
                            <div class="row">
                                <div class="input-field col s12 m6">
                                    <input type="number" id="payment" name="payment" value="{{ $reservation->remaining}}">
                                    <label for="payment">Pago al momento <b>{{ $reservation->actual_pay }}</b> (Total <b>{{ $reservation->total }}</b> Restante <b>{{ $reservation->remaining }}</b>)</label>
                                </div>
                            </div>
                            @csrf
                            @method('PUT')
                            <input type="button" id="confirmar" class="btn teal darken-1" value="Confirmar">
                        </form>
                        <br />
                        {{-- <a href="#!" class="btn teal darken-1">Confirmar</a> --}}
                    @endif
                    <a href="{{ route('printable_reservation', [ 'reservation' => $reservation->id]) }}" target="_blank" class="btn red"> Imprimir </a>
                    <a href="{{ route('search_approve_make') }}" class="btn orange darken-1">Busca nuevamente</a>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h6><b>FOLIO : </b>{{ $reservation->folio }}</h6>
                            <h6><b>Status :</b> {{ $reservation->confirmed == true ? 'Confirmada' : 'Sin Confirmar' }}</h6>
                        </li>
                        <li class="collection-item"><b>Información del Cliente</b><br>
                            Nombre: {{ $reservation->client }} <br>
                            Email: {{ $reservation->client_email }} <br>
                            Teléfono: {{ $reservation->telephone}} <br>
                            Hotel: {{ $reservation->hotel->name }}  {{ $reservation->room }}
                        </li>

                        <li class="collection-item"><b>Información del Pago</b><br>
                            Método de Pago: {{ $reservation->payment_method}} <br>
                            @if ($reservation->citypass)
                                Número del City Pass: {{ $reservation->citypass }} <br>
                            @endif
                            Total: {{ $reservation->total }} <br>
                            Pagado: {{ $reservation->actual_pay }} <br>
                        </li>

                        <li class="collection-item"><b>Información del Tour</b><br>
                            Nombre: {{ $reservation->departure->tour->name }} <br>
                            Horario: {{ $reservation->departure->horario }} <br>
                            Fecha: {{ $reservation->date }}<br>
                            <b>Niños</b> [{{ $reservation->number_kids }}] <b>Adultos</b> [{{ $reservation->number_adults }}] <b>INSEN</b> [{{ $reservation->number_elders }}] <br>
                            @if ($reservation->departure->tour->company->name == "Maxibus")
                            Asientos:<br>
                            @foreach ($reservation->seats as $key => $seat)
                                @if ($loop->last)
                                    {{ $seat->seat }}
                                @else
                                    {{ $seat->seat }},
                                @endif
                            @endforeach
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $( document ).ready( function() {

            var remaining = {{$reservation->remaining}};

            $('#confirmar').on('click', function( event ){
                event.preventDefault();

                if ( $('#payment').val() != remaining ) {
                    M.toast({html: 'El pago no debe ser ni mayor ni menor al restante!'});
                    return false;
                } else {
                    $(".formConfirm").submit();
                }
            });

        });
    </script>

@endsection
