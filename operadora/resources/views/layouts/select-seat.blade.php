@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Selecciona asientos</h4>
                </div>
            </div>

            <!-- -->

            <div class="row reservations-types alert">
                <div class="col s12 m3"><i class="fa fa-couch taken"></i>Asiento Tomado</div>
                <div class="col s12 m3"><i class="fa fa-couch available"></i>Asiento Disponible</div>
                <div class="col s12 m3"><i class="fa fa-couch selection"></i>Tu selección</div>
            </div>
            {{-- <form class="" method="post" action="{{ route('test_request_seats') }}"> --}}
            <form class="" method="post" action="{{ route('reservations_store_seat') }}" id="reservation-with-seats-form">
                @csrf
                <div class="row">
                    <div class="col s12">
                        <input type="hidden" name="client" value="{{ $reservation->client }}">
                        <input type="hidden" name="client_email" value="{{ $reservation->client_email }}">
                        <input type="hidden" name="telephone" value="{{ $reservation->telephone}}">
                        <input type="hidden" name="code" value="{{ $reservation->code}}">
                        <input type="hidden" name="hotel_id" value="{{ $hotel->id }}">
                        <input type="hidden" name="room" value="{{ $reservation->room }}">
                        <input type="hidden" name="date" value="{{ $reservation->date }}">
                        <input type="hidden" name="departure_id" value="{{ $departure->id }}">
                        <input type="hidden" name="number_kids" value="{{ $reservation->number_kids}}">
                        <input type="hidden" name="number_adults" value="{{ $reservation->number_adults}}">
                        <input type="hidden" name="number_elders" value="{{ $reservation->number_elders}}">
                        <input type="hidden" name="price_kids" value="{{ $reservation->price_kids}}">
                        <input type="hidden" name="price_adults" value="{{ $reservation->price_adults}}">
                        <input type="hidden" name="price_elders" value="{{ $reservation->price_elders}}">
                        <input type="hidden" name="payment_method" value="{{ $reservation->payment_method}}">
                        <input type="hidden" name="total" value="{{ $total }}">
                        <input type="hidden" name="actual_pay" value="{{ $reservation->actual_pay }}">
                        <input type="hidden" name="citypass" value="{{ $reservation->citypass }}">
                        <input type="hidden" name="comments" value="{{ $reservation->comments}}">
                        @if ( $sendSMS )
                            <input type="hidden" name="sendSMS" value="on">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col s12 m4">
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[1]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[2]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[3]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[4]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[5]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[6]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[7]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[8]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[9]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[10]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[11]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[12]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[13]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[14]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[15]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[16]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[17]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[18]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[19]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[20]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[21]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[22]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[23]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[24]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[25]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[26]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[27]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[28]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[29]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[30]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[31]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[32]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[33]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[34]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[35]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[36]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[37]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[38]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[39]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[40]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[41]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[42]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[43]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[44]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[45]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[46]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[47]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[48]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[49]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[50]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[51]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[52]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[53]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[54]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[55]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[56]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[57]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[58]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[59]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[60]" value="available">
                        </div>
                        <div>
                            <input type="hidden" name="seat-{{$departure->type}}[61]" value="available">
                            <input type="hidden" name="seat-{{$departure->type}}[62]" value="available">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col s12">
                        <h6>Asientos tomados al momento <b>{{ $current_tickets }}</b></h6>
                        <h6>Asientos deseados <b id="ticket-label">{{ $tickets }}</b></h6>
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
                @if ($current_tickets + $tickets > $total_seats)
                    <div class="col s12 alert alert-danger">
                        @if (Auth::user()->canOverSale())
                            <p>
                                No hay la totalidad de asientos disponibles para terminar tu reserva
                            </p>
                            {{-- <p>
                                ¿Estás seguro de agregar la reservación?<br>
                                Asientos disponibles en el otro autobus <b>hasta</b>
                                {{ $departure->type == 0 ? $departure->getTypes(1) : $departure->getTypes(0) }}
                                <br>
                                Aún disponibles {{ $other_bus_available }}
                            </p>
                            <input type="button" name="" value="Enviar ¿Seguro?" class="btn red" id="shure"> --}}
                        @else
                            <p>
                                No hay la totalidad de asientos disponibles para terminar tu reserva
                            </p>
                        @endif
                    </div>
                @else
                    {{-- <p>
                        Asientos Totales {{ $total_seats}}
                    </p>
                    <p>
                        Departure Type {{ $departure->type }}
                    </p> --}}
                    <input type="button" name="" value="Enviar" class="btn teal" id="send-save-seats">
                    <input type="button" name="" value="Recargar" class="btn orange" id="send-reload" onclick="location.reload(true);">
                @endif
            </form>

            <!-- -->

            <div class="row">
                <div class="col s12 m6">
                    <ul class="collection with-header">
                        {{-- <li class="collection-header"><h6>Reserva al momento</h6></li> --}}
                        <li class="collection-item"><b>Información del Cliente</b><br>
                            {{ $reservation->client }} <br>
                            {{ $reservation->client_email }} <br>
                            +{{ $reservation->code }}{{ $reservation->telephone}} <br>
                            Hotel: {{ $hotel->name }}  {{ $reservation->room }}
                        </li>

                        <li class="collection-item"><b>Pago</b><br>
                            {{ $reservation->payment_method}} <br>
                            @if ( $reservation->payment_method == "citypass" )
                                <b>{{ $reservation->citypass }}</b><br>
                            @endif
                            Total: {{ $total }} <br>
                            Pagado: {{ $reservation->actual_pay }} <br>
                        </li>
                    </ul>
                </div>
                <div class="col s12 m6">
                    <ul class="collection with-header">
                        <li class="collection-item"><b>Información del Tour</b><br>
                            {{ $departure->tour->name }} <br>
                            {{ $departure->horario }} <b>(24hrs) - {{ $departure->type == 0 ? 'Verde' : 'Rosa'}}</b><br>
                            {{ $reservation->date }}
                        </li>
                        <li class="collection-item"><b>Personas</b><br>
                            Niños: [{{ $reservation->number_kids}}] <br>
                            Adultos: [{{ $reservation->number_adults}}] <br>
                            INSEN: [{{ $reservation->number_elders}}] <br>
                        </li>
                        <li class="collection-item"><b>Notas / Comentarios</b><br>
                            {{ $reservation->comments}}
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>


    <div class="form-overlay">
        <p>Cargando...</p>
    </div>

    <script type="text/javascript">
    // global variables
    var seats_type = {{ $departure->type }};
    var seats_number = {{ $departure->getTypeNumber() }};
    var total_tickets = {{ $tickets }};
    var counter = 0;
    var otherBusSeats = {{ $departure->type == 0 ? $departure->getTypes(1) : $departure->getTypes(0) }};
    var remainingSeats = {{ $total_seats - $current_tickets }};
    var departure_id = {{ $departure->id }};

    $( document ).ready(function(){

        // Lets move to another bus
        $("#shure").on('click', function(){
            console.log("Asientos en el otro bus "+otherBusSeats);
            console.log("Remaining Seats "+remainingSeats);
            if (remainingSeats > 0) {
                //console.log("Primero debes seleccionar todos los asientos aún disponibles");
                M.toast({html: '¡Primero debes seleccionar todos los asientos aún disponibles!'});
            }
            else{
                //M.toast({html: '¡Podemos continuar!'});
                $(".form-overlay").addClass('active');
                $("#reservation-with-seats-form").submit();
            }
        });

        @foreach ($seats as $key => $seat)
            console.log("Occupied "+ {{ $seat->seat }});
            $("input[name='seat-{{$departure->type}}[{{$seat->seat}}]']").val("taken");
            $("#{{$seat->seat}}").removeClass("selection");
            $("#{{$seat->seat}}").removeClass("available");
            $("#{{$seat->seat}}").addClass("taken");
            $("#{{$seat->seat}}").unbind("click");
        @endforeach

        // Seats Function
        $(".seats i.available").on('click', function(){

            if (counter < total_tickets
                &&
                ! $(this).hasClass('selection') ) {

                    // console.log("ID = "+$(this).attr('id'));
                    $(this).toggleClass("selection");
                    $("input[name='seat-{{$departure->type}}["+$(this).attr('id')+"]']").val("selection");
                    counter = counter + 1;
                    remainingSeats = remainingSeats - 1;
                }
                else if ( $(this).hasClass("selection") ) {
                    $(this).toggleClass("selection");
                    $("input[name='seat-{{$departure->type}}["+$(this).attr('id')+"]']").val("available");
                    counter = counter - 1;
                    remainingSeats = remainingSeats + 1;
                }
                $("#ticket-label").html((total_tickets - counter));
                console.log("counter "+counter);
                console.log("Remaining Seats on click "+remainingSeats);
            });
        });

        $("#send-save-seats").on('click', function(e){
            e.preventDefault();
            if (counter == total_tickets) {
                $(".form-overlay").addClass('active');
                $("#reservation-with-seats-form").submit();
            }
            else{
                M.toast({html: '¡No has seleccionado todos los asientos!'});
            }

        });

        </script>

    @endsection
