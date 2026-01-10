@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Reservación para</h4>
                    <h5 class="teal teal-title">
                        <b>
                            {{ $tour->name }}
                        </b> <br>
                            {{$tour->horario}} (24hrs)
                    </h5>
                </div>
            </div>
            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ route('reservations_store') }}" method="post" id="reservations-form">
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <legend class="white-text blue darken-4 teal-title">Ingresa una nueva reservación</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="client" class="" placeholder="Nombre del Cliente" value="{{ old('client') }}">
                            <label for="client">Nombre Cliente</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="email" name="client_email" class="" placeholder="Email del Cliente" value="{{ old('client_email') }}">
                            <label for="client_email">Email Cliente</label>
                        </div>
                    </div>
                    <div class="row">
                        <!-- INSTANCE A HOTEL::ALL() OR SOMETHING -->
                        <!-- PASS through THE VIEW -->
                        <div class="input-field col s12 m10">
                            <select name="hotel_id" id="hotel_id">
                                @foreach ($hotels as $key => $hotel)
                                    <option value="{{ $hotel->id }}" {{ Auth::user()->hotel->id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                            <label>Hotel / Lugar</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input type="number" name="room" class="" placeholder="Habitación" value="{{ old('room') }}">
                            <label for="room">Habitación</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" name="date" class="datepicker" placeholder="Fecha" value="{{ old('date') }}">
                            <label for="date">Fecha</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 12">
                            <select name="tour_id" id="tour_id">
                                <option value="{{ $tour->id }}">{{ $tour->name }} -- {{ $tour->horario}}</option>
                            </select>
                            <label>Tour</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <input type="number" id="number_kids" name="number_kids" placeholder="Número" value="{{ old('number_kids') ? old('number_kids') : '0' }}">
                            <label for="number_kids">Niños</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" disabled id="cost_kids" placeholder="Precio" value="{{ old('cost_kids') ? old('cost_kids') : $tour->cost_kids }}">
                            <label for="cost_kids">Precio</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="number" id="number_adults" name="number_adults" placeholder="Número" value="{{ old('number_adults') ? old('number_adults') : '0' }}">
                            <label for="number_adults">Adultos</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" disabled id="cost_adults" placeholder="Precio" value="{{ old('cost_adults') ? old('cost_adults') : $tour->cost_adults }}">
                            <label for="cost_adults">Precio</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="number" id="number_elders" name="number_elders" placeholder="Número" value="{{ old('number_elders') ? old('number_elders') : '0' }}">
                            <label for="number_elders">Insen</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" disabled id="cost_elders" placeholder="Precio" value="{{ old('cost_elders') ? old('cost_elders') : $tour->cost_elders }}">
                            <label for="cost_elders">Precio</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="number" name="actual_pay" placeholder="Pagado Actual" value="{{ old('actual_pay') }}">
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
                        <div class="input-field col s12 12">
                            <select name="payment_method" id="payment_method">
                                <option value="efectivo">Efectivo</option>
                                <option value="tarjeta">Tarjeta</option>
                            </select>
                            <label>Método de Pago</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" value="Crear Reserva" class="btn blue darken-3">
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="input-field col s12">
                            <input type="button" name="ajax" value="Ajax Call" id="ajaxSubmit">
                        </div>
                    </div> --}}
                </form>
            </div>
        </div>
    </div>



<script>
jQuery(document).ready(function(){

    jQuery('#number_kids').on('change', function(){

    });

    jQuery('#tour_id').on('change', function() {
        //alert( this.value );
        console.log("Tours = "+ this.value );
        /// here wi should do the ajax call to retrive the prices
        /// and change the inputs
        /// and change the total
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        }); /// end ajax setup
        jQuery.ajax({
            url: "{{ route('tour_get_prices') }}",
            method: 'post',
            data: {
                tour_id: this.value
            },
            success: function(result){

                $("#cost_kids").val(result.price_kids);
                $("#cost_adults").val(result.price_adults);
                $("#cost_elders").val(result.price_elders);

                /// new total
                var total = ( result.price_kids * $('#number_kids').val() ) + ( result.price_adults *  $('#number_adults').val() ) + ( result.price_elders *  $('#number_elders').val() );
                $("#total").val(total);
                // the 10 it's just a patch
                var total_commission = total * ( 10 / 100 );
                $("#total_commission").val(total_commission);
            }
        }); /// end ajax call
    }); /// end on change select tours

    jQuery('#number_kids, #number_adults, #number_elders').keydown(function(key){
        //return (key.charCode < 48 || key.charCode > 57) ;
        /*if (event.which >= 48 && event.which <= 57) || event.which == 8 || event.which == 46){
            return;
        }*/
        //alert("some key pressed");
        /// lets calculate the total of everything
        var total = 0;
        var total_commission = 0;
        // var commission_percentage = {{ Auth::user()->comision }};
        var commission_percentage = 10

        var total_kids = 0;
        var total_adults = 0;
        var total_elders = 0;

        var number_kids = isNotNumber($("#number_kids").val());
        var number_adults = isNotNumber($("#number_adults").val());
        var number_elders = isNotNumber($("#number_elders").val());

        console.log("Numbers "+number_kids+" - "+number_adults+" - "+number_elders);

        total_kids = number_kids * $('#cost_kids').val();
        total_adults = number_adults * $('#cost_adults').val();
        total_elders = number_elders * $('#cost_elders').val();

        // if(isNaN(total_kids)) {
        //     total_kids = 0;
        // }
        // if(isNaN(total_adults)) {
        //     total_adults = 0;
        // }
        // if(isNaN(total_elders)) {
        //     total_elders = 0;
        // }

        total = total_kids + total_adults + total_elders;
        total_commission = total * (commission_percentage / 100 );

        console.log("Comision "+total_commission);
        console.log("finish "+total);

        $("#total_commission").val(total_commission);
        $("#total").val(total);
    });

    jQuery('#number_kids, #number_adults, #number_elders').on('keyup mouseup', function(key){

        var total = 0;
        var total_commission = 0;
        // var commission_percentage = {{ Auth::user()->comision }};
        var commission_percentage = 10;

        var total_kids = 0;
        var total_adults = 0;
        var total_elders = 0;

        var number_kids = isNotNumber($("#number_kids").val());
        var number_adults = isNotNumber($("#number_adults").val());
        var number_elders = isNotNumber($("#number_elders").val());

        console.log("Numbers "+number_kids+" - "+number_adults+" - "+number_elders);

        total_kids = number_kids * $('#cost_kids').val();
        total_adults = number_adults * $('#cost_adults').val();
        total_elders = number_elders * $('#cost_elders').val();

        // if(isNaN(total_kids)) {
        //     total_kids = 0;
        // }
        // if(isNaN(total_adults)) {
        //     total_adults = 0;
        // }
        // if(isNaN(total_elders)) {
        //     total_elders = 0;
        // }

        total = total_kids + total_adults + total_elders;
        total_commission = total * (commission_percentage / 100 );

        console.log("Comision "+total_commission);
        console.log("finish "+total);

        $("#total_commission").val(total_commission);
        $("#total").val(total);
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
