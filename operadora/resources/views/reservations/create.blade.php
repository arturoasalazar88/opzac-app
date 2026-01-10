@extends('layouts.app')

@section('content')

    <style media="screen">
        .select2 .selection .select2-selection--single, .select2-container--default .select2-search--dropdown .select2-search__field {
            border-width: 0 0 1px 0 !important;
            border-radius: 0 !important;
            height: 2.05rem;
        }

        .select2-container--default .select2-selection--multiple, .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-width: 0 0 1px 0 !important;
            border-radius: 0 !important;
        }

        .select2-results__option {
            color: #26a69a;
            padding: 8px 16px;
            font-size: 16px;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #eee !important;
            color: #26a69a !important;
        }

        .select2-container--default .select2-results__option[aria-selected=true] {
            background-color: #e1e1e1 !important;
        }

        .select2-dropdown {
            border: none !important;
            box-shadow: 0 2px 5px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12);
        }

        .select2-container--default .select2-results__option[role=group] .select2-results__group {
            background-color: #333333;
            color: #fff;
        }

        .select2-container .select2-search--inline .select2-search__field {
            margin-top: 0 !important;
        }

        .select2-container .select2-search--inline .select2-search__field:focus {
            border-bottom: none !important;
            box-shadow: none !important;
        }

        .select2-container .select2-selection--multiple {
            min-height: 2.05rem !important;
        }

        .select2-container--default.select2-container--disabled .select2-selection--single {
            background-color: #ddd !important;
            color: rgba(0,0,0,0.26);
            border-bottom: 1px dotted rgba(0,0,0,0.26);
        }
        .grid-departures div {
            border-radius: 5px;
            cursor: pointer;
        }
        div.selected {
            background-color: #9c27b0 !important
        }
    </style>

    <div class="section" id="users-create">
        <div class="container">

            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ $tour->company->name == "Maxibus" ? route('reservations_select_seat') : route('reservations_store') }}" method="POST" id="reservations-form">

                    @csrf
                    <div class="row">
                        <div class="">
                            <legend class="white-text blue darken-4 teal-title">
                                <smalll>Ingresa una nueva reservación</smalll>
                            </legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <h4>Reservación para</h4>
                            <h5 class="teal teal-title">
                                <b>
                                    {{ $tour->name }}
                                </b> <br>
                                <small>{{ $date->toDateString() }} <b>({{ $date->toFormattedDateString() }})</b></small>
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <h6>
                                Selecciona el Horario (24 horas)
                            </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <select name="departure_id" id="tour_id">
                                @foreach ($tour->departures as $key => $departure)
                                    <option value="{{ $departure->id }}">{{ $departure->horario }}</option>
                                @endforeach
                            </select>
                            <div class="grid-container grid-departures">
                                @forelse ($tour->departures as $key => $departure)
                                    <div class="white-text teal-title {{ $tour->company->name == "Maxibus" ? $departure->type == 0 ? 'green' : 'pink' : 'teal'}}" id="departure_{{ $departure->id }}">
                                        @if ( $departure->isActive() || !$departure->isActive() )

                                            @if ( $date->isToday() && $tour->company->name == "Operadora" && Auth::user()->departureValidation())
                                                {{-- Aquí poner el if para saber sí es el total pass y no filtrar fechas  --}}
                                                @if (Carbon\Carbon::now()->diffInMinutes( $departure->horario, false ) < Auth::user()->hotel->zone->closure )
                                                    {{-- No debería salir --}}
                                                @else
                                                    <span value="{{ $departure->id }}">{{ $departure->horario }}</span>
                                                @endif
                                            @else
                                                {{-- Not today --}}
                                                @if ( $tour->name == "Total Pass")
                                                    {{-- total pass should always allow creating so... --}}
                                                    <span value="{{ $departure->id }}">{{ $departure->horario }}</span>
                                                @elseif (Carbon\Carbon::now()->diffInMinutes( $departure->horario, false ) < 0 )
                                                    {{-- Nothing should happen --}}
                                                    <span value="{{ $departure->id }}">{{ $departure->horario }} {{ $tour->company->name == "Maxibus" ? $departure->type == 0 ? 'Verde' : 'Rosa' : ''}}</span>
                                                @else
                                                    <span value="{{ $departure->id }}">{{ $departure->horario }} {{ $tour->company->name == "Maxibus" ? $departure->type == 0 ? 'Verde' : 'Rosa' : ''}}</span>
                                                @endif

                                            @endif
                                        @endif
                                    </div>
                                @empty
                                    <div value="">No hay Horarios para este tour</div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="">
                            <h6>
                                Agrega el número de personas
                            </h6>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <div>
                                <label for="number_kids">Niños</label>
                            </div>
                            <div class="input-number" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-decrement">-</button>
                                <input type="number" min="0" id="number_kids" name="number_kids" placeholder="Número" value="{{ old('number_kids') ? old('number_kids') : '0' }}" style="margin: 0 5px;">
                                <button type="button" class="btn btn-increment">+</button>
                            </div>
                        </div>
                        <div class="input-field col s12 m1">
                            <div>
                                <label for="cost_kids">Precio c/u</label>
                            </div>
                            <div class="input-number">
                                <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_kids" name="price_kids" placeholder="Precio" value="{{ old('cost_kids') ? old('cost_kids') : $tour->cost_kids }}">
                            </div>
                        </div>
                        <div class="input-field col s12 m3">
                            <div>
                                <label for="number_adults">Adultos</label>
                            </div>
                            <div class="input-number" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-decrement">-</button>
                                <input type="number" min="0" id="number_adults" name="number_adults" placeholder="Número" value="{{ old('number_adults') ? old('number_adults') : '0' }}" style="margin: 0 5px;">
                                <button type="button" class="btn btn-increment">+</button>
                            </div>
                        </div>
                        <div class="input-field col s12 m1">
                            <div>
                                <label for="cost_adults">Precio c/u</label>
                            </div>
                            <div class="input-number">
                                <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_adults" name="price_adults" placeholder="Precio" value="{{ old('cost_adults') ? old('cost_adults') : $tour->cost_adults }}">
                            </div>
                        </div>
                        <div class="input-field col s12 m3">
                            <div>
                                <label for="number_elders">Insen</label>
                            </div>
                            <div class="input-number" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-decrement">-</button>
                                <input type="number" min="0" id="number_elders" name="number_elders" placeholder="Número" value="{{ old('number_elders') ? old('number_elders') : '0' }}" style="margin: 0 5px;">
                                <button type="button" class="btn btn-increment">+</button>
                            </div>
                        </div>
                        <div class="input-field col s12 m1">
                            <div>
                                <label for="cost_elders">Precio c/u</label>
                            </div>
                            <div class="input-number">
                                <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_elders" name="price_elders" placeholder="Precio" value="{{ old('cost_elders') ? old('cost_elders') : $tour->cost_elders }}">
                            </div>
                        </div>

                        <script>
                            document.querySelectorAll('.btn-increment').forEach(button => {
                                button.addEventListener('click', function() {
                                    const input = this.previousElementSibling;
                                    input.stepUp();
                                    input.dispatchEvent(new Event('change'));
                                });
                            });

                            document.querySelectorAll('.btn-decrement').forEach(button => {
                                button.addEventListener('click', function() {
                                    const input = this.nextElementSibling;
                                    input.stepDown();
                                    input.dispatchEvent(new Event('change'));
                                });
                            });
                        </script>
                        {{-- <div class="input-field col s12 m1">
                            <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_kids" name="price_kids" placeholder="Precio" value="{{ old('cost_kids') ? old('cost_kids') : $tour->cost_kids }}">
                            <label for="cost_kids">Precio</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="number" min="0" id="number_adults" name="number_adults" placeholder="Número" value="{{ old('number_adults') ? old('number_adults') : '0' }}">
                            <label for="number_adults">Adultos</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_adults" name="price_adults" placeholder="Precio" value="{{ old('cost_adults') ? old('cost_adults') : $tour->cost_adults }}">
                            <label for="cost_adults">Precio</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="number" min="0" id="number_elders" name="number_elders" placeholder="Número" value="{{ old('number_elders') ? old('number_elders') : '0' }}">
                            <label for="number_elders">Insen</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_elders" name="price_elders" placeholder="Precio" value="{{ old('cost_elders') ? old('cost_elders') : $tour->cost_elders }}">
                            <label for="cost_elders">Precio</label>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="input-field col s12 12">
                            <p class="show-on-small hide-on-med-and-up">Metodo de Pago</p>
                            <select name="payment_method" id="payment_method">
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                                <option value="citypass">Total Pass</option>
                                @if (Auth::user()->canCortesy())
                                    <option value="cortesia">Cortesía</option>
                                @endif
                            </select>
                            <label class="hide-on-small-and-down">Método de Pago</label>
                        </div>
                    </div>
                    <div class="row" id="row-credit-numbers" style="display: none;">
                        <div class="input-field col s12 m6">
                            <input type="text" name="credit_numbers" class="" placeholder="Últimos Dígitos de la Tarjeta" value="{{ old('credit_numbers') }}">
                            <label for="credit_numbers">Últimos 4 dígitos de la tarjeta</label>
                        </div>
                    </div>
                    <div class="row" id="row-citypass" style="display: none;">
                        <div class="input-field col s12 m6">
                            <input type="text" name="citypass" id="citypass" class="" placeholder="City Pass" value="{{ old('citypass') }}">
                            <label for="citypass">Introduce Total Pass</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="number" id="actual_pay" name="actual_pay" placeholder="Pago Realizado" value="{{ old('actual_pay') }}">
                            <label for="actual_pay">Pago Actual</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="text" id="total" name="total" disabled="disabled" placeholder="Total" value="{{ old('total') }}">
                            <label for="total">Total</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="text" id="total_commission" name="total_commission" disabled="disabled" placeholder="Comisión" value="{{ old('total_commission') }}">
                            <label for="total">Comisión</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="grid-container">
                            <button type="button" class="btn btn-large" id="setTotal">Pago Total (100%)</button>
                            <button type="button" class="btn btn-large" id="set25Percent">Pago 25%</button>
                            <button type="button" class="btn btn-large" id="set50Percent">Pago 50%</button>
                            <button type="button" class="btn btn-large" id="set75Percent">Pago 75%</button>
                        </div>
                        <script>
                            document.getElementById('setTotal').addEventListener('click', function() {
                                document.getElementById('actual_pay').value = document.getElementById('total').value;
                            });

                            document.getElementById('set25Percent').addEventListener('click', function() {
                                document.getElementById('actual_pay').value = (document.getElementById('total').value * 0.25).toFixed(2);
                            });

                            document.getElementById('set50Percent').addEventListener('click', function() {
                                document.getElementById('actual_pay').value = (document.getElementById('total').value * 0.50).toFixed(2);
                            });

                            document.getElementById('set75Percent').addEventListener('click', function() {
                                document.getElementById('actual_pay').value = (document.getElementById('total').value * 0.75).toFixed(2);
                            });
                        </script>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <h5>
                                Datos del Cliente
                            </h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <button type="button" class="btn btn-teal" id="fillForm">Llenado Rápido</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="last_name_client" class="" placeholder="Apellido del Cliente" value="{{ old('last_name_client') }}">
                            <label for="client">Apellido(s) del Cliente</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name_client" class="" placeholder="Nombre del Cliente" value="{{ old('name_client') }}">
                            <label for="client">Nombre(s) del Cliente</label>
                        </div>
                    </div>
                    <div class="row">
                        <h6>
                            <small>* Desde aquí los datos son opcionales</small>
                        </h6>
                    </div>
                    <input type="hidden" name="client" class="" placeholder="Nombre del Cliente" value="{{ old('client') }}">
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="email" name="client_email" class="" placeholder="Email del Cliente" value="{{ old('client_email') }}">
                            <label for="client_email">Email Cliente</label>
                        </div>
                    </div>
                    <div class="row valign-wrapper">
                        <div class="input-field col s12 m3">
                            <p class="show-on-small hide-on-med-and-up">Código de área</p>
                            <select name="code" id="code">
                                @foreach ($countries as $key => $country)
                                    <option
                                        value="{{ $country->phonecode }}"
                                        data-icon="{{ asset('/img/flags-m/'.strtolower($country->iso).'.png') }}"
                                        {{ $country->iso == 'MX' ? 'selected' : '' }}>{{ $country->name }}</option>
                                @endforeach
                            </select>
                            <label for="code" class="hide-on-small-and-down">Código de área</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <div class="" id="show-code">
                                <i class="fas fa-plus" style="padding: 15px 5px; background-color: #ebebeb;"></i>
                                <span style="padding: 15px 8px; font-weight: 600;">52</span>
                            </div>
                        </div>
                        <div class="input-field col s12 m8">
                            <input type="text" name="telephone" class="" placeholder="Teléfono del Cliente" value="{{ old('telephone') }}">
                            <label for="telephone">Teléfono del Cliente</label>
                        </div>
                    </div>
                    @if (Auth::user()->canCortesy())
                        <div class="row">
                            <div class="input-field col s12">
                                <p>
                                    <label>
                                        <input type="checkbox" name="sendSMS" id="sendSMS" checked/>
                                        <span>¿Enviar SMS?</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="sendSMS" value="true">
                    @endif
                    {{-- <div class="row">
                        <div class="input-field col s12 m10">
                            <p class="show-on-small hide-on-med-and-up">Hotel/Lugar</p>
                            @if (Auth::user()->role->type == "Recepción")
                                <select name="hotel_id" id="hotel_id">
                                    <option value="{{ Auth::user()->hotel->id }}">{{ Auth::user()->hotel->name }}</option>
                                </select>
                            @else
                                <select name="hotel_id" id="hotel_id">
                                    @foreach ($hotels as $key => $hotel)
                                        <option value="{{ $hotel->id }}" {{ Auth::user()->hotel->id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                                    @endforeach
                                </select>
                            @endif
                            <label class="hide-on-small-and-down">Hotel / Lugar</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input type="number" name="room" class="" placeholder="Habitación" value="1" min="0">
                            <label for="room">Habitación</label>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="col s12 m12">
                            <label for="room">Habitación</label>
                            <input type="number" name="room" class="" placeholder="Habitación" value="1" min="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12 m12">
                            <p>Hotel/Lugar</p>
                            <select class="js-example-basic-single" name="hotel_id" style="width: 100%;">
                                @foreach ($hotels as $key => $hotel)
                                    <option value="{{ $hotel->id }}" {{ Auth::user()->hotel->id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="date" value="{{ $date->toDateString() }}">
                    @if ($tour->company->name != "Maxibus" && Auth::user()->isAdmin() )
                        <div class="row">
                            <div class="input-field col s12 m6">
                                <p>
                                    <label>
                                        <input type="checkbox" name="pass_user" id="pass_user"/>
                                        <span>¿Pasar la reserva a otro usuario?</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                        <div class="row" id="new_user_div" style="display: none;">
                            <div class="input-field col s12 m12">
                                <p class="show-on-small hide-on-med-and-up">Selección de usuario</p>
                                <select name="new_user" id="new_user">
                                    @forelse ($users as $key => $user)
                                        @if ($user->id != Auth::user()->id)
                                            <option value="{{ $user->id }}">{{ $user->username }}</option>
                                        @endif
                                    @empty
                                        <option value="">No hay Horarios usuarios para asignar</option>
                                    @endforelse
                                </select>
                                <label class="hide-on-small-and-down">Selecciona usuario <b><i><small>No hagas caso a las comisiones, estas las calculará la aplicación</small></i></b></label>
                            </div>
                        </div>
                    @endif
                    {{-- <div class="row">
                        <div class="input-field col s12 12">
                            <select name="tour_id" id="tour_id">
                                <option value="{{ $tour->id }}">{{ $tour->name }} -- {{ $tour->horario}}</option>
                            </select>
                            <label>Tour</label>
                        </div>
                    </div> --}}
                    {{-- <div>
                        <div>
                            @foreach ($tour->departures as $key => $departure)
                                <p>
                                    {{ $departure }}
                                </p>
                            @endforeach

                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <textarea id="comments" name="comments" class="materialize-textarea" rows="6"></textarea>
                            <label for="textarea1">Comentarios / Notas extras</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="button" value="Crear Reserva" class="btn blue darken-3"  id="sendForm">
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="input-field col s12">
                            <input type="button" name="ajax" value="Ajax Call" id="ajaxSubmit">
                        </div>
                    </div> --}}
                </form>

                <!-- Modal Structure -->
                <div id="modalCheck" class="modal modalCheck bottom-sheet">
                    <div class="modal-content">
                        <h4>Revisa los datos antes de enviar</h4>
                        <p>Reservación para:
                            <big><b>{{ $tour->name }}</b></big> <b id="r_tour_departure"></b>
                        </p>
                        <p id="r_client_date">
                        </p>

                        <ul class="collection">
                            <li class="collection-item">
                                <b>Cliente</b>
                                <p id="r_client_name"></p>
                                <p id="r_client_email"></p>
                                <p id="r_client_phone"></p>
                            </li>
                            <li class="collection-item">
                                <b>Hotel / Lugar</b>
                                <p id="r_client_hotel"></p>
                                <p id="r_client_room"></p>
                            </li>
                            <li class="collection-item">
                                <b>Reservas</b>
                                <p id="r_client_numbers"></p>
                            </li>
                            <li class="collection-item">
                                <b>Pago</b>
                                <p id="r_client_payment"></p>
                            </li>
                            <li class="collection-item">
                                <b>Comentarios / Notas</b>
                                <p id="r_client_comments"></p>
                            </li>
                        </ul>

                    </div>
                    <div class="modal-footer">
                        <button class="modal-close waves-effect waves-red btn red">Cancelar</button>
                        <button id="sendForm" class="modal-close waves-effect waves-green btn">Enviar</button>
                    </div>
                </div>
                <!-- end modal -->
            </div>
        </div>
    </div>

<div class="form-overlay">
    <p>Cargando...</p>
</div>
<link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>
<script>
jQuery(document).ready(function(){

    function selectDeparture(id) {
        console.log('id '+ id);
        $('#tour_id').val(id);
    }

    function forceKeyPressure( e ) {
        var charInput = e.keyCode;
        if((charInput >= 97) && (charInput <= 122)) { // lowercase
            if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
                var newChar = charInput - 32;
                var start = e.target.selectionStart;
                var end = e.target.selectionEnd;
                e.target.value = e.target.value.substring(0, start) + String.fromCharCode(newChar) + e.target.value.substring(end);
                e.target.setSelectionRange(start+1, start+1);
                e.preventDefault();
            }
        }
    }

    $(".grid-departures div").on('click', function(){
        $(".grid-departures div").removeClass('selected');
        $(this).addClass('selected');
        console.log($(this).children('span').attr('value'));
        selectDeparture( $(this).children('span').attr('value'));
    });

    $("input[type='text']").on('keypress', forceKeyPressure);

    $("#fillForm").on('click', function(){

        $( "input[name='client']" ).val('{{ Auth::user()->username }}');
        $( "input[name='last_name_client']" ).val('LLENADO');
        $( "input[name='name_client']" ).val('RAPIDO {{ strtoupper(Auth::user()->username) }}');
        $( "input[name='client_email']" ).val('reservaciones@operadorazacatecas.mx');
         $( "input[name='telephone']" ).val('4921246452');

        $( "input[name='room']" ).val('101');
        $( "#comments" ).val('Reserva llenada automaticamente desde la app');
    })

    jQuery('#code').on('change', function(){
        $("#show-code span").html( $(this).val() );
    });

    $( "#payment_method" ).on('change', function(){
        console.log(this.value);

        if (this.value == "tarjeta") {
            $("#row-credit-numbers").show("slow");
            $("#row-citypass").hide("slow");
        }
        else if (this.value == "citypass") {
            $("#row-citypass").show("slow");
            $("#row-credit-numbers").hide("slow");
            $('#total').val('0');
            $("#actual_pay").val('0');
        }
        else if (this.value == "cortesia") {
            $("#row-citypass").hide("slow");
            $("#row-credit-numbers").hide("slow");
            $('#total').val('0');
            $("#actual_pay").val('0');
        }else {
            $("#row-citypass").hide("slow");
            $("#row-credit-numbers").hide("slow");
        }
    });

    $( "#pass_user" ).on('change', function(){
        //console.log(this.value);
        if($(this).is(":checked")) {
            //var returnVal = confirm("Are you sure?");
            $("#new_user_div").show("slow");
        }
        else {
            $("#new_user_div").hide("slow");
        }

    });

    jQuery('#number_kids').on('change', function(){

    });

    $("#reviewReservation").on('click',function(){

        if (validate()) {
            $(".modal").modal('open');
        }


        $("#r_client_date").html("Fecha "+ $("input[name='date']").val() );
        $("#r_tour_departure").html( $("#tour_id option:selected").html() );
        $("#r_client_name").html( $( "input[name='client']" ).val() );
        $("#r_client_email").html( $( "input[name='client_email']" ).val() );
        $("#r_client_phone").html( "+" + $("#code").val() + $( "input[name='telephone']" ).val() );

        $("#r_client_hotel").html(  $("#hotel_id option:selected").html() );
        $("#r_client_room").html( 'Habitación '+ $( "input[name='room']" ).val() );

        $("#r_client_numbers").html("Niños = <b>" + $( "input[name='number_kids']" ).val() + "<br /></b> Adultos = <b>" + $( "input[name='number_adults']" ).val() + "<br /></b> INSEN = <b>" + $( "input[name='number_elders']" ).val() + "</b>" );

        var payment_string = "<b>Total = </b> "+ $("input[name='total']").val() +
                                "<br><b>Pagado = </b> "+ $("input[name='actual_pay']").val() +
                                "<br><b>Comisión = </b>"+ $("input[name='total_commission']").val()+
                                "<br><b>Método de Pago = </b> "+ $( "#payment_method" ).val();

        if ( $( "#payment_method" ).val() == "tarjeta" ){
            payment_string += "<br /><b>Últimos Dígitos de la tarjeta = </b>"+$("input[name='credit_numbers']").val();
        }

        $("#r_client_payment").html(payment_string);

        $("#r_client_comments").html( $( "#comments" ).val() );
    });

    function validate() {

        if( !$( "input[name='name_client']" ).val()) {
            M.toast({html: 'Recuerda rellenar el nombre!'});
            return false;
        }
        if( !$( "input[name='last_name_client']" ).val()) {
            M.toast({html: 'Recuerda poner un apellido!'});
            return false;
        }
        // now this is not required
        // if( !$( "input[name='client_email']" ).val()) {
        //     M.toast({html: 'Primero tienes que proporcionar un correo!'});
        //     return false;
        // }
        /*if( !$( "input[name='telephone']" ).val()) {
            M.toast({html: 'Primero tienes que proporcionar un teléfono!'});
            return false;
        }
        if ( $( "input[name='telephone']" ).val().length != 10 ) {
            M.toast({html: 'El teléfono debe ser a 10 dígitos!'});
            return false;
        }*/
        /*if( !$( "input[name='room']" ).val()) {
            M.toast({html: 'Primero tienes que proporcionar una habitación!'});
            return false;
        }*/
        if ( !$("#number_kids").val() || $("#number_kids").val() < 0  ) {
            $("#number_kids").val('0');
        }
        if ( !$("#number_adults").val() || $("#number_adults").val() < 0 ) {
            $("#number_adults").val('0');
        }
        if ( !$("#number_elders").val() || $("#number_elders").val() < 0 ) {
            $("#number_elders").val('0');
        }
        if ( $("#total").val() <= 0 ) {
            //M.toast({html: 'Selecciona alguna cantidad de tickets primero!'});
            //return false;
        }
        if($( "#payment_method" ).val() == "citypass"){
            var total;

            var nk = $("#number_kids").val() ? $("#number_kids").val() : 0;
            var na = $("#number_adults").val() ? $("#number_adults").val() : 0;
            var ne = $("#number_elders").val() ? $("#number_elders").val() : 0;

            total = parseInt(nk) + parseInt(na) + parseInt(ne);
            console.log("total de tickets"+ total);
            if (total != 1) {
                M.toast({html: 'Debes colocar únicamente un ticket por citypass!'});
                return false;
            }
            else{

                if ( !$("#citypass").val() ) {
                    M.toast({html: 'Debes colocar un citypass!'});
                    return false;
                }

                M.toast({html: 'Excelente!'});
                //$("#actual_pay").val($("#total").val());
                $('#total').val('0');
                $("#actual_pay").val('0');
                return true;
            }
        }
        else if($( "#payment_method" ).val() == "cortesia") {
            if ( $("#actual_pay").val() > 0) {
                M.toast({html: 'Existe algun problema con el costo del tour!'});
                return false;
            }
        } else { // any other payment method

            if (! $("#actual_pay").val() ) {
                M.toast({html: 'Debes proporcionar una cantidad en el pago!'});
                return false;
            }
            //here comes if the payment method it's other than citypass
            if ( $("#actual_pay").val() < 0) {
                M.toast({html: 'El pago no debe ser menor a cero!'});
                return false;
            }
            if ( parseInt($("#actual_pay").val()) > parseInt($("#total").val() ) ) {
                M.toast({html: 'El pago no debe ser mayor al total!'});
                return false;
            }
            //total pass only accepts the commision
            /*if ( $("#actual_pay").val() != $('#total_commission').val() && $('#tour_id').val() == 5) {
                M.toast({html: 'El pago no debe ser cero mayor a la comisión para este tour!'});
                return false;
            }*/
        }

        //$( "input[name='client']" ).val($( "input[name='name_client']" ).val()+" "+$( "input[name='last_name_client']" ).val());
        $( "input[name='client']" ).val($( "input[name='last_name_client']" ).val()+" "+$( "input[name='name_client']" ).val());
        return true;
    }

    $("#sendForm").on('click', function( ){
        $( "input[name='client']" ).val($( "input[name='last_name_client']" ).val()+" "+$( "input[name='name_client']" ).val());
        $(".form-overlay").addClass('active');
        $("#reservations-form").submit();
    });

    jQuery('#number_kids, #number_adults, #number_elders, #cost_kids, #cost_adults, #cost_elders').keydown(function(key){
        //return (key.charCode < 48 || key.charCode > 57) ;
        /*if (event.which >= 48 && event.which <= 57) || event.which == 8 || event.which == 46){
            return;
        }*/
        // alert("some key pressed");
        // lets calculate the total of everything
        var total = 0;
        var total_comission = 0;
        // Lets get the comissions
        @if ( Auth::user()->commissions()->where('tour_id', $tour->id)->count() == 1)
            @php
                $c = Auth::user()->commissions()->where('tour_id', $tour->id)->first();
            @endphp
            var comission_kids = {{ $c->kids }};
            var comission_adults = {{ $c->adults }};
            var comission_elders = {{ $c->elders }};
        @else
            var comission_kids = 0;
            var comission_adults = 0;
            var comission_elders = 0;
        @endif

        // here willl save the totals
        var total_kids = 0;
        var total_adults = 0;
        var total_elders = 0;

        var number_kids = isNotNumber($("#number_kids").val());
        var number_adults = isNotNumber($("#number_adults").val());
        var number_elders = isNotNumber($("#number_elders").val());

        console.log("Numbers "+number_kids+" - "+number_adults+" - "+number_elders);

        // calculate the total of each ticket
        total_kids = number_kids * $('#cost_kids').val();
        total_adults = number_adults * $('#cost_adults').val();
        total_elders = number_elders * $('#cost_elders').val();

        total = total_kids + total_adults + total_elders;
        total_comission_kids   = number_kids * (comission_kids);
        total_comission_adults = number_adults * (comission_adults);
        total_comission_elders = number_elders * (comission_elders);

        total_comission = total_comission_kids + total_comission_adults + total_comission_elders;

        console.log("Total "+total);
        console.log("Comision sumada de todos "+total_comission);

        $("#total_commission").val(total_comission);
        $("#total").val(total);

        if ($("#payment_method").val() == 'cortesia') {
            $("#total").val('0');
            $("#actual_pay").val('0');
        }
    });

    jQuery('#number_kids, #number_adults, #number_elders, #cost_kids, #cost_adults, #cost_elders').on('keyup mouseup change', function(key){

        var total = 0;
        var total_comission = 0;
        // Lets get the comissions
        @if ( Auth::user()->commissions()->where('tour_id', $tour->id)->count() == 1)
            @php
                $c = Auth::user()->commissions()->where('tour_id', $tour->id)->first();
            @endphp
            var comission_kids = {{ $c->kids }};
            var comission_adults = {{ $c->adults }};
            var comission_elders = {{ $c->elders }};
        @else
            var comission_kids = 0;
            var comission_adults = 0;
            var comission_elders = 0;
        @endif

        console.log("Comision de kids "+comission_kids+" Pesos");
        console.log("Comision de adults "+comission_adults+" Pesos");
        console.log("Comision de elders "+comission_elders+" Pesos");
        // here willl save the totals
        var total_kids = 0;
        var total_adults = 0;
        var total_elders = 0;

        var number_kids = isNotNumber($("#number_kids").val());
        var number_adults = isNotNumber($("#number_adults").val());
        var number_elders = isNotNumber($("#number_elders").val());

        console.log("Number of tickets "+number_kids+" - "+number_adults+" - "+number_elders);

        // calculate the total of each ticket
        total_kids = number_kids * $('#cost_kids').val();
        total_adults = number_adults * $('#cost_adults').val();
        total_elders = number_elders * $('#cost_elders').val();

        total = total_kids + total_adults + total_elders;
        total_comission_kids   = number_kids * (comission_kids);
        total_comission_adults = number_adults * (comission_adults);
        total_comission_elders = number_elders * (comission_elders);

        console.log("Comision kids "+total_comission_kids);
        console.log("Comision adults "+total_comission_adults);
        console.log("Comision elders "+total_comission_elders);

        total_comission = total_comission_kids + total_comission_adults + total_comission_elders;

        console.log("Total "+total);
        console.log("Comision sumada de todos "+total_comission);

        $("#total_commission").val(total_comission);
        $("#total").val(total);

        if ($("#payment_method").val() == 'cortesia') {
            $("#total").val('0');
            $("#actual_pay").val('0');
        }
    });

    jQuery('#ajaxSubmit').click(function(e){
        console.log("Something Something");
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        jQuery.ajax({
            url: "{{ route('tour_get_prices') }}",
            method: 'post',
            data: {
                tour_id: jQuery('#tour_id').val()
            },
            success: function(result){
                //jQuery('.alert').html(result.success);
                alert("something "+result.price_elders);
                console.log(result.success);
                console.log(result.price_kids);

            }});
        });
});

function isNotNumber(possible)
{
    if (isNaN(possible)) {
        console.log("not a number");
        return 0;
    }
    else {
        return possible;
    }
}
</script>

@endsection
