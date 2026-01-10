@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <h6 class="blue darken-4 teal-title">
                Reservas de <br>
                <b>{{ $departure->tour->name }}</b><br>
                {{ $departure->horario }}
            </h6>
            <h6 class="teal teal-title">Fecha : {{ $date }}</h6>
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            @isset($message)
                <div class="alert alert-{{ $class }}">
                    <p>{!! $message !!}</p>
                </div>
            @endisset
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @isset($return)
                @if ($return == true)
                    <a href="{{ route('company_select_create') }}" class="btn orange">Volver</a>
                @endif
            @endisset
            @if ($departure->tour->company->name == "Maxibus")
                <!-- Seats -->
                <div class="row">
                    <div class="col s12">
                        <h6>Asientos tomados al momento</h6>
                    </div>
                    @if ($departure->type == 0)
                        {{-- The Big Bus --}}
                        <div class="col s12 m4 seats first-floor center">
                            <h5>Parte de arriba</h5>
                            <div>
                                <i id="38" class="fas fa-3x fa-couch available"><div>38</div></i>
                                <i id="37" class="fas fa-3x fa-couch available"><div>37</div></i>
                                <span></span>
                                <i id="none" class="fas fa-3x fa-shoe-prints taken" style="font-size: 2rem;"><div>Entrada</div></i>
                                <i id="none" class="fas fa-3x fa-couch" style="color: transparent;"></i>
                            </div>
                            <div>
                                <i id="36" class="fas fa-3x fa-couch available"><div>36</div></i>
                                <i id="35" class="fas fa-3x fa-couch available"><div>35</div></i>
                                <span></span>
                                <i id="34" class="fas fa-3x fa-couch available"><div>34</div></i>
                                <i id="33" class="fas fa-3x fa-couch available"><div>33</div></i>
                            </div>
                            <div>
                                <i id="32" class="fas fa-3x fa-couch available"><div>32</div></i>
                                <i id="31" class="fas fa-3x fa-couch available"><div>31</div></i>
                                <span></span>
                                <i id="30" class="fas fa-3x fa-couch available"><div>30</div></i>
                                <i id="29" class="fas fa-3x fa-couch available"><div>29</div></i>
                            </div>
                            <div>
                                <i id="28" class="fas fa-3x fa-couch available"><div>28</div></i>
                                <i id="27" class="fas fa-3x fa-couch available"><div>27</div></i>
                                <span></span>
                                <i id="26" class="fas fa-3x fa-couch available"><div>26</div></i>
                                <i id="25" class="fas fa-3x fa-couch available"><div>25</div></i>
                            </div>
                            <div>
                                <i id="24" class="fas fa-3x fa-couch available"><div>24</div></i>
                                <i id="23" class="fas fa-3x fa-couch available"><div>23</div></i>
                                <span></span>
                                <i id="22" class="fas fa-3x fa-couch available"><div>22</div></i>
                                <i id="21" class="fas fa-3x fa-couch available"><div>21</div></i>
                            </div>
                            <div>
                                <i id="20" class="fas fa-3x fa-couch available"><div>20</div></i>
                                <i id="19" class="fas fa-3x fa-couch available"><div>19</div></i>
                                <span></span>
                                <i id="18" class="fas fa-3x fa-couch available"><div>18</div></i>
                                <i id="17" class="fas fa-3x fa-couch available"><div>17</div></i>
                            </div>
                            <div>
                                <i id="16" class="fas fa-3x fa-couch available"><div>16</div></i>
                                <i id="15" class="fas fa-3x fa-couch available"><div>15</div></i>
                                <span></span>
                                <i id="14" class="fas fa-3x fa-couch available"><div>14</div></i>
                                <i id="13" class="fas fa-3x fa-couch available"><div>13</div></i>
                            </div>
                            <div>
                                <i id="12" class="fas fa-3x fa-couch available"><div>12</div></i>
                                <i id="11" class="fas fa-3x fa-couch available"><div>11</div></i>
                                <span></span>
                                <i id="10" class="fas fa-3x fa-couch available"><div>10</div></i>
                                <i id="9" class="fas fa-3x fa-couch available"><div>9</div></i>
                            </div>
                            <div>
                                <i id="8" class="fas fa-3x fa-couch available"><div>8</div></i>
                                <i id="7" class="fas fa-3x fa-couch available"><div>7</div></i>
                                <span></span>
                                <i id="6" class="fas fa-3x fa-couch available"><div>6</div></i>
                                <i id="5" class="fas fa-3x fa-couch available"><div>5</div></i>
                            </div>
                            <div>
                                <i id="4" class="fas fa-3x fa-couch available"><div>4</div></i>
                                <i id="3" class="fas fa-3x fa-couch available"><div>3</div></i>
                                <span>&nbsp;</span>
                                <i id="2" class="fas fa-3x fa-couch available"><div>2</div></i>
                                <i id="1" class="fas fa-3x fa-couch available"><div>1</div></i>
                            </div>
                            <h6>Frente del Autobus</h6>
                        </div>
                        <div class="col s12 m4 seats second-floor center">
                            <h5>Parte de abajo</h5>
                            <div>
                                <i id="61" class="fas fa-3x fa-couch available"><div>61</div></i>
                                <i id="60" class="fas fa-3x fa-couch available"><div>60</div></i>
                                <span></span>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                            </div>
                            <div>
                                <i id="59" class="fas fa-3x fa-couch available"><div>59</div></i>
                                <i id="58" class="fas fa-3x fa-couch available"><div>58</div></i>
                                <span></span>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                            </div>
                            <div>
                                <i id="57" class="fas fa-3x fa-couch available"><div>57</div></i>
                                <i id="56" class="fas fa-3x fa-couch available"><div>56</div></i>
                                <span></span>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                            </div>
                            <div>
                                <i id="55" class="fas fa-3x fa-couch available"><div>55</div></i>
                                <i id="54" class="fas fa-3x fa-couch available"><div>54</div></i>
                                <span></span>
                                <i id="53" class="fas fa-3x fa-couch available"><div>53</div></i>
                                <i id="52" class="fas fa-3x fa-couch available"><div>52</div></i>
                            </div>
                            <div>
                                <i id="51" class="fas fa-3x fa-couch available"><div>51</div></i>
                                <i id="50" class="fas fa-3x fa-couch available"><div>50</div></i>
                                <span></span>
                                <i id="49" class="fas fa-3x fa-couch available"><div>49</div></i>
                                <i id="48" class="fas fa-3x fa-couch available"><div>48</div></i>
                            </div>
                            <div>
                                <i id="47" class="fas fa-3x fa-couch available"><div>47</div></i>
                                <i id="46" class="fas fa-3x fa-couch available"><div>46</div></i>
                                <span></span>
                                <i id="45" class="fas fa-3x fa-couch available"><div>45</div></i>
                                <i id="44" class="fas fa-3x fa-couch available"><div>44</div></i>
                            </div>
                            <div>
                                <i id="43" class="fas fa-3x fa-couch available"><div>43</div></i>
                                <i id="42" class="fas fa-3x fa-couch available"><div>42</div></i>
                                <span></span>
                                <i id="41" class="fas fa-3x fa-couch available"><div>41</div></i>
                                <i id="40" class="fas fa-3x fa-couch available"><div>40</div></i>
                            </div>
                            <div>
                                <i id="39" class="fas fa-3x fa-couch available"><div>39</div></i>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                                <span></span>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color:transparent;"></i>
                            </div>
                            <h6>Frente del Autobus</h6>
                        </div>
                    @else
                        {{-- Small Bus --}}
                        <div class="col s12 m4 seats first-floor center">
                            <h5>Parte de arriba</h5>
                            <div>
                                <i id="30" class="fas fa-3x fa-couch available"><div>30</div></i>
                                <i id="29" class="fas fa-3x fa-couch available"><div>29</div></i>
                                <span></span>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                            </div>
                            <div>
                                <i id="27" class="fas fa-3x fa-couch available"><div>27</div></i>
                                <i id="28" class="fas fa-3x fa-couch available"><div>28</div></i>
                                <span>&nbsp;</span>
                                <i class="fas fa-3x fa-couch" style="opacity: 0;"><div></div></i>
                                <i class="fas fa-3x fa-couch" style="opacity: 0;"><div></div></i>
                            </div>
                            <div>
                                <i id="26" class="fas fa-3x fa-couch available"><div>26</div></i>
                                <i id="25" class="fas fa-3x fa-couch available"><div>25</div></i>
                                <span></span>
                                <i id="24" class="fas fa-3x fa-couch available"><div>24</div></i>
                                <i id="23" class="fas fa-3x fa-couch available"><div>23</div></i>
                            </div>
                            <div>
                                <i id="19" class="fas fa-3x fa-couch available"><div>19</div></i>
                                <i id="20" class="fas fa-3x fa-couch available"><div>20</div></i>
                                <span></span>
                                <i id="21" class="fas fa-3x fa-couch available"><div>21</div></i>
                                <i id="22" class="fas fa-3x fa-couch available"><div>22</div></i>

                            </div>
                            <div>

                                <i id="18" class="fas fa-3x fa-couch available"><div>18</div></i>
                                <i id="17" class="fas fa-3x fa-couch available"><div>17</div></i>
                                <span></span>
                                <i id="16" class="fas fa-3x fa-couch available"><div>16</div></i>
                                <i id="15" class="fas fa-3x fa-couch available"><div>15</div></i>
                            </div>
                            <div>

                                <i id="11" class="fas fa-3x fa-couch available"><div>11</div></i>
                                <i id="12" class="fas fa-3x fa-couch available"><div>12</div></i>
                                <span></span>
                                <i id="13" class="fas fa-3x fa-couch available"><div>13</div></i>
                                <i id="14" class="fas fa-3x fa-couch available"><div>14</div></i>
                            </div>
                            <div>
                                <i id="10" class="fas fa-3x fa-couch available"><div>10</div></i>
                                <i id="9" class="fas fa-3x fa-couch available"><div>9</div></i>
                                <span></span>
                                <i id="8" class="fas fa-3x fa-couch available"><div>8</div></i>
                                <i id="7" class="fas fa-3x fa-couch available"><div>7</div></i>
                            </div>
                            <div>
                                <i id="3" class="fas fa-3x fa-couch available"><div>3</div></i>
                                <i id="4" class="fas fa-3x fa-couch available"><div>4</div></i>
                                <span>&nbsp;</span>
                                <i id="5" class="fas fa-3x fa-couch available"><div>5</div></i>
                                <i id="6" class="fas fa-3x fa-couch available"><div>6</div></i>
                            </div>
                            <div>
                                <i class="fas fa-3x fa-couch" style="opacity: 0;"><div></div></i>
                                <i class="fas fa-3x fa-couch" style="opacity: 0;"><div></div></i>
                                <span>&nbsp;</span>
                                <i id="2" class="fas fa-3x fa-couch available"><div>2</div></i>
                                <i id="1" class="fas fa-3x fa-couch available"><div>1</div></i>
                            </div>
                            <h6>Frente del Autobus</h6>
                        </div>
                        <div class="col s12 m4 seats second-floor center">
                            <h5>Parte de abajo</h5>
                            <div>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <span></span>
                                <i id="55" class="fas fa-3x fa-couch available"><div>55</div></i>
                                <i id="54" class="fas fa-3x fa-couch available"><div>54</div></i>
                            </div>
                            <div>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <span></span>
                                <i id="53" class="fas fa-3x fa-couch available"><div>53</div></i>
                                <i id="52" class="fas fa-3x fa-couch available"><div>52</div></i>
                            </div>
                            <div>
                                <i id="48" class="fas fa-3x fa-couch available"><div>48</div></i>
                                <i id="49" class="fas fa-3x fa-couch available"><div>49</div></i>
                                <span></span>
                                <i id="50" class="fas fa-3x fa-couch available"><div>50</div></i>
                                <i id="51" class="fas fa-3x fa-couch available"><div>51</div></i>
                            </div>
                            <div>
                                <i id="47" class="fas fa-3x fa-couch available"><div>47</div></i>
                                <i id="46" class="fas fa-3x fa-couch available"><div>46</div></i>
                                <span></span>
                                <i id="45" class="fas fa-3x fa-couch available"><div>45</div></i>
                                <i id="44" class="fas fa-3x fa-couch available"><div>44</div></i>
                            </div>
                            <div>
                                <i id="40" class="fas fa-3x fa-couch available"><div>40</div></i>
                                <i id="41" class="fas fa-3x fa-couch available"><div>41</div></i>
                                <span></span>
                                <i id="42" class="fas fa-3x fa-couch available"><div>42</div></i>
                                <i id="43" class="fas fa-3x fa-couch available"><div>43</div></i>
                            </div>
                            <div>
                                <i id="39" class="fas fa-3x fa-couch available"><div>39</div></i>
                                <i id="38" class="fas fa-3x fa-couch available"><div>38</div></i>
                                <span></span>
                                <i id="37" class="fas fa-3x fa-couch available"><div>37</div></i>
                                <i id="36" class="fas fa-3x fa-couch available"><div>36</div></i>
                            </div>
                            <div>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <span></span>
                                <i id="34" class="fas fa-3x fa-couch available"><div>34</div></i>
                                <i id="35" class="fas fa-3x fa-couch available"><div>35</div></i>
                            </div>
                            <h6>Frente del Autobus</h6>
                        </div>
                    @endif
                </div>
                <!-- /Seats -->
            @endif
            @if ( $departure->tour->name == "Tour centro historico" && count($reservations) > 0 )
                <a class="btn teal" href="{{ route('fast_create') }}?tour={{$reservations->first()->tour_id}}=&date={{ Carbon\Carbon::parse($date)->toDateString() }}&departure_id={{$departure->id}}">Regresar Fast Track</a>
            @endif
            <h4>Reservaciones <small>[ conteo {{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders') }} - límite {{ $departure->tour->limit }}]</small></h4>
            <table class="striped highlight table-content">
                <thead>
                    <tr>
                        <th scope="col">Folio</th>
                        <th scope="col">Operador</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">M. Pago</th>
                        <th scope="col">Total</th>
                        <th scope="col">Hotel</th>
                        <th scope="col">N</th>
                        <th scope="col">A</th>
                        <th scope="col">I</th>
                        <th scope="col">Editar</th>
                    </tr>
                </thead>
                <tbody>
                @forelse ($reservations as $key => $reservation)
                    @if (isset($current_reservation) && $current_reservation != null)
                        <tr style="{{ $reservation->id == $current_reservation->id ? 'background-color: lightsteelblue;' : '' }} ">
                    @else
                        <tr style="">
                    @endif
                        @if ( $reservation->payment_method != "citypass")
                            <td scope="row" data-label="Folio">{{ $reservation->folio }}</td>
                        @else
                            <td scope="row" data-label="Folio">{{ $reservation->citypass }}</td>
                        @endif
                        <td data-label="Operador">{{ $reservation->user ? $reservation->user->username : 'N/A' }}</td>
                        <td data-label="Cliente">{{ $reservation->client }}</td>
                        <td data-label="M. Pago">{{ $reservation->payment_method != "citypass" ? $reservation->payment_method : "Total Pass"}}</td>
                        <td data-label="Total">{{ $reservation->total }}</td>
                        <td data-label="Hotel">{{ $reservation->hotel->name }}</td>
                        <td data-label="Niños">{{ $reservation->number_kids }}</td>
                        <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                        <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                        <td data-label="Acciones">
                            @if ($reservation->user_id == Auth::user()->id || Auth::user()->isAdmin())
                                <a href="{{ route('reservations_show' , ['reservation' => $reservation->id]) }}">
                                    <i class="far fa-edit"></i>
                                </a>
                            @endif
                            @if ( Auth::user()->canCancel() && $reservation->status != 4 )
                                <a class="modal-trigger canceltrigger" href="#modal1" id="{{ $reservation->id }}">
                                    <i class="fa fa-times"></i>
                                </a>
                            @endif
                            @if (Auth::user()->isAdmin() || Auth::user()->isModule() || $departure->tour->name == "Tour centro historico")
                                <a href="{{ route('printable_reservation', [ 'reservation' => $reservation->id]) }}" class="btn red" target="_blank"> Imprimir </a>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="11" class="alert alert-danger">
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
                        <td>
                            [{{ $reservations->sum('number_kids') + $reservations->sum('number_adults') + $reservations->sum('number_elders')}}]
                        </td>
                    </tr>
                @endif
                </tbody>
            </table>

            @isset($printable)
                @if ($reservations->count() > 0)
                    <p>
                        <i>*Abrirá en una pestaña nueva</i>
                    </p>
                    <a href="{{ route('printable_tours') }}?departure_id={{$departure_id}}&date={{$date}}" target="_blank" class="btn teal">Crear Imprimible</a>
                @endif
            @endisset
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
        $( document ).ready( function () {

            @isset($current_reservation)
                @if ($current_reservation != null)
                    window.open("{{ route('printable_reservation', [ 'reservation' => $current_reservation->id]) }}", "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=500,left=500,width=400,height=600");
                @endif
            @endisset

            $('.modal').modal();

            $('.canceltrigger').on('click', function() {
                id = $(this).attr('id');
                console.log( $(this).attr('id') );
            });

            $('#agreeCancel').on('click', function(event) {

                event.preventDefault();
                console.log("clicked");

                var url = "{{ URL::to("/") }}";

                url = url + '/reservation/cancel/' + id +'?departure={{ $departure->id }}&date={{ $date }}';

                console.log(url);
                window.location.href = url;

            });

            @if ($departure->tour->company->name == "Maxibus")
                console.log( '{{ $departure->tour->company->name}}' );

                    @foreach( $reservations as $item )
                        @foreach( $item->seats as $seat )
                            $("input[name='seat-{{$departure->type}}[{{$seat->seat}}]']").val("taken");
                            $("#{{$seat->seat}}").removeClass("selection");
                            @if( $item->user )
                                $("#{{$seat->seat}} div").after("<p>{{$item->user->getReduceUsername() ?? ''}}</p>");    
                            @endif
                            
                            $("#{{$seat->seat}}").removeClass("available");
                            $("#{{$seat->seat}}").addClass("taken");
                            $("#{{$seat->seat}}").unbind("click");
                        @endforeach
                    @endforeach
            @endif
        });
    </script>
    <style>
        .fa-3x {
            position: relative;
        }
        i p {
            position: absolute;
            color: black;
            background: white;
            font-size: 13px;
            z-index: 3;
            top: 0%;
            left: 50%;
            transform: translateX(-50%);
            padding: 3px;
            width: 100%;
            border: 1px solid;
        }
    </style>
@endsection
