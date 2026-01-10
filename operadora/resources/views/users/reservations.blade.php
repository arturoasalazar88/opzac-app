@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <h4>{{ $title }}</h4>
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            <h4>Registro de Pagos <small>del día {{ Carbon\Carbon::parse($date)->toDateString() }}</small></h4>

            <form method="get" class="row">
                <div class="col s12 m5">
                    <input type="text" id="date1" name="date" class="datepicker full-dates2" value="{{ Carbon\Carbon::parse($date)->toDateString() }}">
                </div>
                <div class="col s12 m5">
                    <select class="" name="tour_id" id="tour_id">
                        <option value="-1" {{ $active_tour == '-1' ? 'selected' : ''}}>Todos los tours</option>
                        @foreach ($tours as $key => $tour)
                            <option value="{{ $tour->id }}" {{ $active_tour == $tour->id ? 'selected' : ''}}>{{ $tour->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col s12 m2">
                    <div class="input-field">
                        <input type="submit" id="resend" class="btn teal" value="Enviar">
                    </div>
                </div>
            </form>

            <div class="row reservations-types alert alert-info">
                <div class="col s12 m2"><i class="fa fa-times" style="color: red;"></i>Cancelada</div>
                <div class="col s12 m2"><i class="fa fa-lock-open"></i>No pagada comisión</div>
                <div class="col s12 m2"><i class="fa fa-lock-open" style="color: red;"></i>Pagada únicamente comisión</div>
                <div class="col s12 m2"><i class="fa fa-lock-open" style="color: #ffeb3b;"></i>Pagada más de la comisión</div>
                <div class="col s12 m2"><i class="fa fa-lock" style="color: green;"></i>Pagada totalmente</div>
            </div>
            <div class="alert">
                <p>
                    <i><b>*Este no es un reporte de reservaciones sino un reporte de pagos </b></i>
                </p>
            </div>
            <table class="striped highlight table-content">
                <thead>
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Tour (Compañía)</th>
                        <th scope="col">Horario</th>
                        <th scope="col">Creada</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">M.Pago</th>
                        <th scope="col">Total</th>
                        <th scope="col">N</th>
                        <th scope="col">A</th>
                        <th scope="col">I</th>
                        <th scope="col">Más</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($reservations as $key => $reservation)
                    <tr>
                        <td scope="row" data-label="Folio">
                            @if ($reservation->status == 0)
                                <i class="fa fa-lock-open"></i>
                            @elseif ($reservation->status == 1)
                                <i class="fa fa-lock-open" style="color: red;"></i>
                            @elseif ($reservation->status == 2)
                                <i class="fa fa-lock-open" style="color: #ffeb3b;"></i>
                            @elseif ($reservation->status == 3)
                                <i class="fa fa-lock" style="color: green;"></i>
                            @else
                                <i class="fa fa-times" style="color: red;"></i>
                            @endif

                            @if ( $reservation->payment_method != "citypass" )
                                {{ $reservation->folio }}
                            @else
                                {{ $reservation->citypass }}
                            @endif
                        </td>
                        <td data-label="Cliente">{{ $reservation->client }}</td>
                        <td data-label="Tour">
                            {{-- {{ $reservation->departure->tour->name }} --}}
                            {{ $reservation->tour_name }}
                            {{-- <b>({{ $reservation->departure->tour->company->name}})</b> --}}
                        </td>
                        {{-- <td data-label="Hora"><b>{{ $reservation->departure->horario }}</b></td> --}}
                        <td data-label="Hora"><b>{{ $reservation->horario }}</b></td>
                        <td>{{ Carbon\Carbon::parse($reservation->created_at)->toDateString() }}</td>
                        <td data-label="Fecha">{{ $reservation->date }}</td>
                        <td data-label="M. Pago">{{ $reservation->payment_method != 'citypass' ? $reservation->payment_method : 'Total Pass'  }}</td>
                        {{-- <td data-label="Total">{{ $reservation->first_payment }}</td> --}}
                        <td data-label="Total">{{ $reservation->payment }}</td>
                        <td data-label="Niños">{{ $reservation->number_kids }}</td>
                        <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                        <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                        <td data-label="Acciones">
                            @if ($reservation->status != 4 )
                                <a href="{{ route('reservations_show' , ['reservation' => $reservation->id]) }}">
                                    <i class="far fa-edit"></i>
                                </a>
                            @endif
                            @if ( Auth::user()->canCancel() && $reservation->status != 4 )
                                <a class="modal-trigger canceltrigger" href="#modal1" id="{{ $reservation->id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="13" class="alert alert-danger">
                            No hay reservas de este usuario para el día seleccionado
                        </td>
                    </tr>
                @endforelse
                @foreach ($totals as $key => $total)
                    <tr>
                        <td colspan="6"></td>
                        <td>Total {{ $total->payment_method }}</td>
                        <td>{{ $total->total }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{-- {{ $reservations->links() }} --}}

            <div class="row" style="margin-top:15px;">
                <div class="col">
                    @if( isset($notYou))
                        <a href="{{ route('user_single_reservations', ['user' => $user]) }}?pdf=true&date={{$date}}" target="_blank" class="btn teal">Imprimible</a>
                        <a href="{{ route('user_reservations_by_tours') }}?pdf=true&date={{$date}}&user={{ $user }}" target="_blank" class="btn teal">Imprimible por recorrido</a>
                    @else
                        <a href="{{ route('user_reservations') }}?pdf=true&date={{$date}}" target="_blank" class="btn teal">Imprimible</a>
                        <a href="{{ route('user_reservations_by_tours') }}?pdf=true&date={{$date}}" target="_blank" class="btn teal">Imprimible por recorrido</a>
                    @endisset
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Structure -->
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h4>Confirma</h4>
            <p>¿Realmente deseas cancelar la reserva?</p>
            <p>Esta acción no se puede deshacer</p>
        </div>
        <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat teal white-text">Cancelar</a>
            <a href="#!" id="agreeCancel" class="waves-effect waves-green btn-flat red white-text">Aceptar</a>
        </div>
    </div>

    <script type="text/javascript">
        jQuery(document).ready( function(){
            $('.modal').modal();

            var id;

            $('.canceltrigger').on('click', function() {
                id = $(this).attr('id');
                console.log( $(this).attr('id') );
            });

            $('#agreeCancel').on('click', function(event) {

                event.preventDefault();
                console.log("clicked");

                var url = "{{ URL::to("/") }}";

                url = url + '/reservation/cancel/' + id;

                console.log(url);
                window.location.href = url;

            });

            $('.full-dates2').datepicker({
                format: 'yyyy-mm-dd',
                setDefaultDate: true,
                defaultDate: '{{ Carbon\Carbon::parse($date)->toDateString() }}',
                i18n: {
                          months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                          monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                          weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                          weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                          weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
                      }
            });
        });
    </script>

@endsection
