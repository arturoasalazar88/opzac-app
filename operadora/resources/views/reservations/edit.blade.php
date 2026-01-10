@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Reservación hecha para</h4>
                    <h5 class="teal teal-title">
                        <b>
                            {{ $reservation->departure->tour->name }}
                        </b> <br>
                            {{$reservation->departure->horario}} (24hrs)
                    </h5>
                </div>
            </div>
            @if (session('status'))
                <div class="row">
                    <div class="col s12">
                            <div class="alert alert-info">
                                {!! session('status') !!}
                            </div>
                    </div>
                </div>
            @endif
            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ route('reservation_update', ['reservation' => $reservation->id]) }}" method="post" id="reservations-form">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col s12">
                            <legend class="white-text blue darken-4 teal-title">Modifica los datos</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="client" class="" placeholder="Nombre del Cliente" value="{{ $reservation->client }}">
                            <label for="client">Nombre Cliente</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="email" name="client_email" class="" placeholder="Email del Cliente" value="{{ $reservation->client_email }}">
                            <label for="client_email">Email Cliente</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="telephone" class="" placeholder="Teléfono del Cliente" value="{{ $reservation->telephone }}">
                            <label for="telephone">Teléfono del Cliente</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m10">
                            <select name="hotel_id" id="hotel_id">
                                @foreach ($hotels as $key => $hotel)
                                    <option value="{{ $hotel->id }}" {{ $reservation->hotel->id == $hotel->id ? 'selected' : '' }}>{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                            <label>Hotel / Lugar</label>
                        </div>
                        <div class="input-field col s12 m2">
                            <input type="number" name="room" class="" placeholder="Habitación" value="{{ $reservation->room }}">
                            <label for="room">Habitación</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" name="date" class="datepicker edit-dates" placeholder="Fecha" value="{{ $reservation->date }}">
                            <label for="date">Fecha</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 12">
                            <select name="tour_id" id="tour_id">
                                @foreach ($tours as $key => $tour)
                                    <option value="{{ $tour->id }}" {{ $tour->id == $reservation->tour_id ? 'selected' : ''}}>{{ $tour->name }}</option>
                                @endforeach
                            </select>
                            <label>Tour</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <select name="departure_id" id="departure_id">
                                @forelse ($reservation->departure->tour->departures as $key => $departure)
                                    <option value="{{ $departure->id }}" {{ $departure->id == $reservation->departure->id ? 'selected' : ''}}>{{ $departure->horario }}</option>
                                @empty
                                    <option value="">No hay Horarios para este tour</option>
                                @endforelse
                            </select>
                            <label>Selecciona el Horario</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <input type="number" id="number_kids" name="number_kids" placeholder="Número" value="{{ $reservation->number_kids }}">
                            <label for="number_kids">Niños</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" disabled id="cost_kids" placeholder="Precio" value="{{ $reservation->departure->tour->cost_kids }}">
                            <label for="cost_kids">Precio</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="number" id="number_adults" name="number_adults" placeholder="Número" value="{{ $reservation->number_adults }}">
                            <label for="number_adults">Adultos</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" disabled id="cost_adults" placeholder="Precio" value="{{  $reservation->departure->tour->cost_adults }}">
                            <label for="cost_adults">Precio</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="number" id="number_elders" name="number_elders" placeholder="Número" value="{{ $reservation->number_elders }}">
                            <label for="number_elders">Insen</label>
                        </div>
                        <div class="input-field col s12 m1">
                            <input type="number" disabled id="cost_elders" placeholder="Precio" value="{{ $reservation->departure->tour->cost_elders }}">
                            <label for="cost_elders">Precio</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="number" name="actual_pay" placeholder="Pagado Actual" value="{{ $reservation->actual_pay }}">
                            <label for="actual_pay">Pago Actual</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="text" id="total" name="total" disabled="disabled" placeholder="Total" value="{{ $reservation->total }}">
                            <label for="total">Total</label>
                        </div>
                        <div class="input-field col s12 m3">
                            <input type="text" id="total_commission" name="total_commission" disabled="disabled" placeholder="Comisión" value="{{ $reservation->total_commission }}">
                            <label for="total">Comisión</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 12">
                            <select name="payment_method" id="payment_method">
                                <option value="efectivo" {{ $reservation->payment_method == 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                                <option value="tarjeta" {{ $reservation->payment_method == 'tarjeta' ? 'selected' : '' }}>Tarjeta</option>
                            </select>
                            <label>Método de Pago</label>
                        </div>
                    </div>
                    <div class="row" id="row-credit-numbers" style="{{ $reservation->payment_method == 'tarjeta' ? '' : 'display: none;' }}">
                        <div class="input-field col s12 m6">
                            <input type="text" name="credit_numbers" class="" placeholder="Últimos Dígitos de la Tarjeta" value="{{ $reservation->credit_numbers }}">
                            <label for="credit_numbers">Últimos 4 dígitos de la tarjeta</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <textarea id="comments" name="comments" class="materialize-textarea">{{$reservation->comments}}</textarea>
                            <label for="textarea1">Comentarios / Notas extras</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="button" value="Editar Reserva" class="btn orange darken-3 modal-trigger" href="#modalCheck" id="reviewReservation">
                        </div>
                    </div>
                </form>

                <!-- Modal Structure -->
                <div id="modalCheck" class="modal modalCheck bottom-sheet">
                    <div class="modal-content">
                        <h4>Revisa los datos antes de guardar</h4>
                        <p>Reservación para:
                            <big><b class="tour_name"></b></big>
                            <b id="r_tour_departure"></b>
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
                        <a href="#!" id="sendForm" class="modal-close waves-effect waves-orange btn orange">Enviar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script>
jQuery(document).ready(function(){

    $("#tour_id").on('change', function() {
        $.ajax({
            //Cambiar a type: POST si necesario
            type: "GET",
            // Formato de datos que se espera en la respuesta
            dataType: "json",
            // URL a la que se enviará la solicitud Ajax
            //url: "http://localhost/op2.0/public_html/tour/show/departures/"+$("#tour_id").val(),
            url: "{{ route('tours_get_departures') }}/?tour_id="+$("#tour_id").val(),
        })
        .done(function( data, textStatus, jqXHR ) {
            if ( console && console.log ) {
                console.log( "La solicitud se ha completado correctamente." );
                console.log(data);
                $("#departure_id").empty();
                $.each( data, function( key, val) {
                    console.log("key "+key+" - value "+val.horario);
                    $("#departure_id").append('<option value="'+val.id+'">'+val.horario+'</option>');
                    $("#departure_id").trigger('contentChanged');
                    $("#departure_id").formSelect();
                });
            }
        })
        .fail(function( jqXHR, textStatus, errorThrown ) {
            if ( console && console.log ) {
                console.log( "La solicitud a fallado: " +  textStatus);
            }
        });
    });


    $('.edit-dates').datepicker({
        format: 'yyyy-mm-dd',
        defaultDate: {{ $reservation->date }},
        setDefaultDate: true,
        i18n: {
                  months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                  monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                  weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                  weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                  weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
              }
    });

    $( "#payment_method" ).on('change', function(){
        //console.log(this.value);
        $("#row-credit-numbers").toggle("slow");
    });

    jQuery('#number_kids').on('change', function(){

    });

    $("#reviewReservation").on('click',function(){
        //$(".tour_name").html( $('#tour_id option:selected').text() );
        $("#r_client_date").html("Fecha "+ $("input[name='date']").val() );
        $("#r_tour_departure").html( $("#tour_id option:selected").html() );
        $("#r_client_name").html( $( "input[name='client']" ).val() );
        $("#r_client_email").html( $( "input[name='client_email']" ).val() );
        $("#r_client_phone").html( $( "input[name='telephone']" ).val() );

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

    $("#sendForm").on('click', function(){
        $("#reservations-form").submit();
    });

    // jQuery('#tour_id').on('change', function() {
    //     //alert( this.value );
    //     console.log("Tours = "+ this.value );
    //     /// here wi should do the ajax call to retrive the prices
    //     /// and change the inputs
    //     /// and change the total
    //     $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //     }); /// end ajax setup
    //     jQuery.ajax({
    //         url: "{{ route('tour_get_prices') }}",
    //         method: 'post',
    //         data: {
    //             tour_id: this.value
    //         },
    //         success: function(result){
    //
    //             $("#cost_kids").val(result.price_kids);
    //             $("#cost_adults").val(result.price_adults);
    //             $("#cost_elders").val(result.price_elders);
    //
    //             /// new total
    //             var total = ( result.price_kids * $('#number_kids').val() ) + ( result.price_adults *  $('#number_adults').val() ) + ( result.price_elders *  $('#number_elders').val() );
    //             $("#total").val(total);
    //             // the 10 it's just a patch
    //             var total_commission = total * ( 10 / 100 );
    //             $("#total_commission").val(total_commission);
    //         }
    //     }); /// end ajax call
    // }); /// end on change select tours

    jQuery('#number_kids, #number_adults, #number_elders').keydown(function(key){
        //return (key.charCode < 48 || key.charCode > 57) ;
        /*if (event.which >= 48 && event.which <= 57) || event.which == 8 || event.which == 46){
            return;
        }*/
        // alert("some key pressed");
        // lets calculate the total of everything
        var total = 0;
        var total_comission = 0;
        // Lets get the comissions
        var comission_kids = {{ Auth::user()->comission_kids }};
        var comission_adults = {{ Auth::user()->comission_adults }};
        var comission_elders = {{ Auth::user()->comission_elders }};

        console.log("Comision de kids "+comission_kids+"%");
        console.log("Comision de adults "+comission_adults+"%");
        console.log("Comision de elders "+comission_elders+"%");
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
        total_comission_kids   = total_kids * (comission_kids / 100 );
        total_comission_adults = total_adults * (comission_adults / 100 );
        total_comission_elders = total_elders * (comission_elders / 100 );

        total_comission = total_comission_kids + total_comission_adults + total_comission_elders;

        console.log("Total "+total);
        console.log("Comision sumada de todos "+total_comission);

        $("#total_commission").val(total_comission);
        $("#total").val(total);
    });

    jQuery('#number_kids, #number_adults, #number_elders').on('keyup mouseup', function(key){

        var total = 0;
        var total_comission = 0;
        // Lets get the comissions
        var comission_kids = {{ Auth::user()->comission_kids }};
        var comission_adults = {{ Auth::user()->comission_adults }};
        var comission_elders = {{ Auth::user()->comission_elders }};

        console.log("Percentage kids "+comission_kids+"%");
        console.log("Percentage adults "+comission_adults+"%");
        console.log("Percentage elders "+comission_elders+"%");
        // here willl save the totals
        var total_kids = 0;
        var total_adults = 0;
        var total_elders = 0;

        var number_kids = isNotNumber($("#number_kids").val());
        var number_adults = isNotNumber($("#number_adults").val());
        var number_elders = isNotNumber($("#number_elders").val());

        console.log("Number of tickets"+number_kids+" - "+number_adults+" - "+number_elders);

        // calculate the total of each ticket
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
        total_comission_kids   = total_kids * (comission_kids / 100 );
        total_comission_adults = total_adults * (comission_adults / 100 );
        total_comission_elders = total_elders * (comission_elders / 100 );

        console.log("Comision kids "+total_comission_kids);
        console.log("Comision adults "+total_comission_adults);
        console.log("Comision elders "+total_comission_elders);

        total_comission = total_comission_kids + total_comission_adults + total_comission_elders;

        console.log("Total "+total);
        console.log("Comision sumada de todos "+total_comission);

        $("#total_commission").val(total_comission);
        $("#total").val(total);

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
