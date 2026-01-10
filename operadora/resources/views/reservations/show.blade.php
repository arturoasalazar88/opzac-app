@extends('layouts.app')

@section('content')

    <div class="section" id="users-show">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Detalles de Reserva</h3>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {!! session('status') !!}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <div class="collection with-header">
                        <div class="collection-header">
                            <h5>Folio : {{ $reservation->folio }}</h5>
                        </div>
                        {{-- <div class="collection-item">
                            <b>Status</b> Not Yet Implemented
                        </div> --}}
                        <div class="collection-item">
                            <b>Tour</b> {{ $reservation->departure->tour->name }}
                        </div>
                        <div class="collection-item">
                            <b>Horario</b> {{ $reservation->departure->horario }}
                        </div>
                        <div class="collection-item">
                            <b>Correo</b> {{ $reservation->client_email }}
                        </div>
                        <div class="collection-item">
                            <b>Nombre</b> {{ $reservation->client }}
                        </div>
                        <div class="collection-item">
                            <b>Teléfono</b> {{ $reservation->telephone }}
                        </div>
                        <div class="collection-item">
                            <b>Fecha</b> {{ Carbon\Carbon::parse($reservation->date)->toFormattedDateString() }}
                        </div>
                        <div class="collection-item">
                            <b>Hotel & Habitación</b> {{ $reservation->hotel->name }}
                            <span>{{ $reservation->room }}</span>
                        </div>
                        <div class="collection-item">
                            <b>Niños <small>[${{ $reservation->departure->tour->cost_kids }}]</small></b>
                            Tickets <span>{{ $reservation->number_kids }}</span>
                            Total <span>{{ $reservation->departure->tour->cost_kids * $reservation->number_kids }}</span>
                            Comisión <span>${{ $reservation->comission_kids }}</span>
                            <b>Adultos <small>[${{ $reservation->departure->tour->cost_adults }}]</small></b>
                            Tickets <span>{{ $reservation->number_adults }}</span>
                            Total <span>{{ $reservation->departure->tour->cost_adults * $reservation->number_adults }}</span>
                            Comisión <span>${{ $reservation->comission_adults }}</span>
                            <b>INSEN <small>[${{ $reservation->departure->tour->cost_elders }}]</small></b>
                            Tickets <span>{{ $reservation->number_elders }}</span>
                            Total <span>{{ $reservation->departure->tour->cost_elders * $reservation->number_elders }}</span>
                            Comisión <span>${{ $reservation->comission_elders }}</span>
                        </div>
                        @if ($reservation->departure->tour->company->name == "Maxibus")
                            <div class="collection-item">
                                <b>Asientos</b>
                                @foreach ($reservation->seats as $key => $seat)
                                    Num.<span>{{ $seat->seat }}</span>
                                @endforeach
                            </div>
                        @endif
                        <div class="collection-item">
                            <b>Total</b> ${{ $reservation->total }}
                        </div>
                        <div class="collection-item">
                            <b>Pagado</b> ${{ $reservation->actual_pay }}
                        </div>
                        <div class="collection-item">
                            <b>Restante</b> ${{ $reservation->remaining }}
                        </div>
                        <div class="collection-item">
                            <b>Usuario Registrante</b> {{ $reservation->user ? $reservation->user->name : 'N/A' }}
                            {{-- <b>Comisión</b> --}}
                            {{-- <span>{{ $reservation->total_commission }}</span> <span>{{ $reservation->user->comision }}%</span> --}}
                        </div>
                        <div class="collection-item">
                            <b>Método de Pago</b> {{ $reservation->payment_method }}
                        </div>
                        @if ($reservation->citypass)
                            <div class="collection-item">
                                <b>Número del Total Pass</b> {{ $reservation->citypass }}
                            </div>
                        @endif
                        @if (strcmp($reservation->payment_method,"tarjeta") == 0)
                            <div class="collection-item">
                                <b>Últimos dígitos de la tarjeta</b> {{ $reservation->credit_numbers }}
                            </div>
                        @endif
                        <div class="collection-item">
                            <b>Notas/Comentarios</b> {{ $reservation->comments }}
                        </div>
                    </div>
                </div>
            </div>

            @if ($reservation->departure->tour->company->name == "Maxibus")
                <!-- Seats -->
                <div class="row">
                    <div class="col s12">
                        <h6>Asientos tomados para la reservación</h6>
                    </div>
                    @if ($reservation->departure->type == 0)
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
                                <i id="29" class="fas fa-3x fa-couch available"><div>29</div></i>
                                <i id="30" class="fas fa-3x fa-couch available"><div>30</div></i>
                                <span></span>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                                <i class="fas fa-3x fa-couch" style="color: transparent;"></i>
                            </div>
                            <div>
                                <i id="25" class="fas fa-3x fa-couch available"><div>25</div></i>
                                <i id="26" class="fas fa-3x fa-couch available"><div>26</div></i>
                                <span></span>
                                <i id="27" class="fas fa-3x fa-couch available"><div>27</div></i>
                                <i id="28" class="fas fa-3x fa-couch available"><div>28</div></i>
                            </div>
                            <div>
                                <i id="21" class="fas fa-3x fa-couch available"><div>21</div></i>
                                <i id="22" class="fas fa-3x fa-couch available"><div>22</div></i>
                                <span></span>
                                <i id="23" class="fas fa-3x fa-couch available"><div>23</div></i>
                                <i id="24" class="fas fa-3x fa-couch available"><div>24</div></i>
                            </div>
                            <div>
                                <i id="17" class="fas fa-3x fa-couch available"><div>17</div></i>
                                <i id="18" class="fas fa-3x fa-couch available"><div>18</div></i>
                                <span></span>
                                <i id="19" class="fas fa-3x fa-couch available"><div>19</div></i>
                                <i id="20" class="fas fa-3x fa-couch available"><div>20</div></i>
                            </div>
                            <div>
                                <i id="13" class="fas fa-3x fa-couch available"><div>13</div></i>
                                <i id="14" class="fas fa-3x fa-couch available"><div>14</div></i>
                                <span></span>
                                <i id="15" class="fas fa-3x fa-couch available"><div>15</div></i>
                                <i id="16" class="fas fa-3x fa-couch available"><div>16</div></i>
                            </div>
                            <div>
                                <i id="9" class="fas fa-3x fa-couch available"><div>9</div></i>
                                <i id="10" class="fas fa-3x fa-couch available"><div>10</div></i>
                                <span></span>
                                <i id="11" class="fas fa-3x fa-couch available"><div>11</div></i>
                                <i id="12" class="fas fa-3x fa-couch available"><div>12</div></i>
                            </div>
                            <div>
                                <i id="5" class="fas fa-3x fa-couch available"><div>5</div></i>
                                <i id="6" class="fas fa-3x fa-couch available"><div>6</div></i>
                                <span></span>
                                <i id="7" class="fas fa-3x fa-couch available"><div>7</div></i>
                                <i id="8" class="fas fa-3x fa-couch available"><div>8</div></i>
                            </div>
                            <div>
                                <i id="3" class="fas fa-3x fa-couch available"><div>3</div></i>
                                <i id="4" class="fas fa-3x fa-couch available"><div>4</div></i>
                                <span>&nbsp;</span>
                                <i id="1" class="fas fa-3x fa-couch available"><div>1</div></i>
                                <i id="2" class="fas fa-3x fa-couch available"><div>2</div></i>
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

            <div class="row">

                <div class="col s12">
                    <a href="{{ route('reservations_edit', ['reservation'=>$reservation->id]) }}" class="btn btn-blue">Editar</a>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        @if ($reservation->departure->tour->company->name == "Maxibus")
            @foreach ($reservation->seats as $key => $seat)
                console.log("Occupied "+ {{ $seat->seat }});
                $("#{{$seat->seat}}").removeClass("selection");
                $("#{{$seat->seat}}").removeClass("available");
                $("#{{$seat->seat}}").addClass("taken");
                $("#{{$seat->seat}}").unbind("click");
            @endforeach
        @endif
    </script>

@endsection
