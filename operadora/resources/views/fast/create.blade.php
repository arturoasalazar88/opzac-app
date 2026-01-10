@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Reservación para</h4>
                    <h5 class="teal teal-title">
                        <b>
                            {{ $tour->name }} <small>({{ $departure->horario }} - {{ $departure->type == 0 ? 'Verde' : 'Rosa'}})</small>
                        </b>
                        <br>
                        <small>{{ $date->toDateString() }} <b>({{ $date->toFormattedDateString() }})</b></small>
                    </h5>
                </div>
            </div>
            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ $tour->company->name == "Maxibus" ? route('reservations_store_seat') : route('reservations_store') }}" method="POST" id="reservations-form">

                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <legend class="white-text blue darken-4 teal-title">Ingresa una nueva reservación</legend>
                        </div>
                    </div>
                    <input type="hidden" name="client" class="" placeholder="Nombre del Cliente" value="FAST TRACK">
                    <input type="hidden" name="client_email" class="" placeholder="Email del Cliente" value="reservaciones@operadorazacatecas.mx">
                    <input type="hidden" name="code" value="52">
                    <input type="hidden" name="telephone" class="" placeholder="Teléfono del Cliente" value="4921246452">

                    <input type="hidden" value="{{ Auth::user()->hotel->id }}" name="hotel_id">
                    {{-- <input type="hidden" name="room" class="" placeholder="Habitación" value="101" min="0"> --}}


                    <input type="hidden" name="date" value="{{ $date->toDateString() }}">
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <h6>Horario <b>{{ $departure->horario }} ({{ $departure->type == 0 ? 'Verde' : 'Rosa'}})</b></h6>
                            <input type="hidden" name="departure_id" value="{{ $departure->id }}">
                        </div>
                    </div>
                    <input type="hidden" name="room" class="" placeholder="Habitación" value="101">
                    <div class="row">
                        <div class="input-field col s12 m3">
                            <div>
                                <label for="number_kids">Niños</label>
                            </div>
                            <div class="input-number" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-small btn-decrement">-</button>
                                <input type="number" min="0" id="number_kids" name="number_kids" placeholder="Número" value="{{ old('number_kids') ? old('number_kids') : '0' }}" style="margin: 0 5px;">
                                <button type="button" class="btn btn-small btn-increment">+</button>
                            </div>
                        </div>
                        <div class="input-field col s12 m1">
                            <label for="cost_kids">Precio c/u</label>
                            <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_kids" name="price_kids" placeholder="Precio" value="{{ old('cost_kids') ? old('cost_kids') : $tour->cost_kids }}">
                        </div>
                        <div class="input-field col s12 m3">
                            <div>
                                <label for="number_adults">Adultos</label>
                            </div>
                            <div class="input-number" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-small btn-decrement">-</button>
                                <input type="number" min="0" id="number_adults" name="number_adults" placeholder="Número" value="{{ old('number_adults') ? old('number_adults') : '0' }}" style="margin: 0 5px;">
                                <button type="button" class="btn btn-small btn-increment">+</button>
                            </div>
                        </div>
                        <div class="input-field col s12 m1">
                            <label for="cost_adults">Precio c/u</label>
                            <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_adults" name="price_adults" placeholder="Precio" value="{{ old('cost_adults') ? old('cost_adults') : $tour->cost_adults }}">
                        </div>
                        <div class="input-field col s12 m3">
                            <div>
                                <label for="number_elders">Insen</label>
                            </div>
                            <div class="input-number" style="display: flex; align-items: center;">
                                <button type="button" class="btn btn-small btn-decrement">-</button>
                                <input type="number" min="0" id="number_elders" name="number_elders" placeholder="Número" value="{{ old('number_elders') ? old('number_elders') : '0' }}" style="margin: 0 5px;">
                                <button type="button" class="btn btn-small btn-increment">+</button>
                            </div>
                        </div>
                        <div class="input-field col s12 m1">
                            <label for="cost_elders">Precio c/u</label>
                            <input type="number" min="0" {{ Auth::user()->isReceptionist() ? 'disabled' : ''}} id="cost_elders" name="price_elders" placeholder="Precio" value="{{ old('cost_elders') ? old('cost_elders') : $tour->cost_elders }}">
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
                    </div>
                    @if (Auth::user()->canCortesy())
                        <div class="row">
                            <div class="input-field col s12">
                                <p>
                                    <label>
                                        <input type="checkbox" name="sendSMS" id="sendSMS"/>
                                        <span>¿Enviar SMS?</span>
                                    </label>
                                </p>
                            </div>
                        </div>
                    @else
                        <input type="hidden" name="sendSMS" value="true">
                    @endif
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
                            <input type="text" name="citypass" id="citypass" class="" placeholder="Total Pass" value="{{ old('citypass') }}">
                            <label for="citypass">Introduce Total Pass</label>
                        </div>
                    </div>
                    <div class="row">
                        <input type="hidden" name="actual_pay" class="actual_pay" value="">
                        <div class="input-field col s12 m6">
                            <input type="number" id="actual_pay" placeholder="Pagado Realizado" value="{{ old('actual_pay') }}">
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
                        <div class="input-field col s12 m12">
                            <input type="text" id="change" name="change" disabled="disabled" placeholder="Cambio" value="0">
                            <label for="total">Cambio</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <textarea id="comments" name="comments" class="materialize-textarea" rows="6"></textarea>
                            <label for="textarea1">Comentarios / Notas extras</label>
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
                            {{-- <h6>Asientos tomados al momento <b>{{ $current_tickets }}</b></h6>
                            <h6>Asientos deseados <b id="ticket-label">{{ $tickets }}</b></h6> --}}
                        </div>
                        {{-- <h2> Tipo de departure {{ $departure->type }} </h2> --}}
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

                    <div class="row">
                        <div class="input-field col s12">
                            <input type="button" id="sendSeats" value="Crear Reserva" class="btn blue darken-3" >
                            <input type="button" name="" value="Recargar" class="btn orange" id="send-reload" onclick="location.reload(true);">
                        </div>
                    </div>
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

<script>

// global variables
var seats_type = {{ $departure->type }};
var seats_number = {{ $departure->getTypeNumber() }};
var total_tickets = 0;
var counter = 0;
var otherBusSeats = {{ $departure->type == 0 ? $departure->getTypes(1) : $departure->getTypes(0) }};
var remainingSeats = {{ $total_seats - $current_tickets }};
var departure_id = {{ $departure->id }};


jQuery(document).ready(function(){

    @foreach ($seats as $key => $seat)
        console.log("Occupied "+ {{ $seat->seat }});
        $("input[name='seat-{{$departure->type}}[{{$seat->seat}}]']").val("taken");
        $("#{{$seat->seat}}").removeClass("selection");
        $("#{{$seat->seat}}").removeClass("available");
        $("#{{$seat->seat}}").addClass("taken");
        $("#{{$seat->seat}}").unbind("click");
    @endforeach

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

    $("input[type='text']").on('keypress', forceKeyPressure);

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
        $("#r_client_phone").html( "+52" + $( "input[name='telephone']" ).val() );

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

        if( !$( "input[name='client']" ).val()) {
            M.toast({html: 'Primero tienes que proporcionar un nombre!'});
            return false;
        }
        // now this is not always required
        // if( !$( "input[name='client_email']" ).val()) {
        //     M.toast({html: 'Primero tienes que proporcionar un correo!'});
        //     return false;
        // }
        if( !$( "input[name='telephone']" ).val()) {
            M.toast({html: 'Primero tienes que proporcionar un teléfono!'});
            return false;
        }
        if ( $( "input[name='telephone']" ).val().length != 10 ) {
            M.toast({html: 'El teléfono debe ser a 10 dígitos!'});
            return false;
        }
        if( !$( "input[name='room']" ).val()) {
            M.toast({html: 'Primero tienes que proporcionar una habitación!'});
            return false;
        }
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
            if ( $("#actual_pay").val() <= 0) {
                M.toast({html: 'El pago no debe ser cero o menor de cero!'});
                return false;
            }
            if ( parseInt($("#actual_pay").val()) > parseInt($("#total").val() ) ) {
                M.toast({html: 'El pago no debe ser mayor al total!'});
                return false;
            }
            @if (Auth::user()->role->type = "Modulo")
                // if ( parseInt($("#actual_pay").val()) != parseInt($("#total").val() ) ) {
                //     M.toast({html: 'Solo puedes crear reservas con pago completo!'});
                //     return false;
                // }
            @endif
        }
        return true;
    }

    $("#sendForm").on('click', function( ){
        $(".form-overlay").addClass('active');
        $("#reservations-form").submit();
    });

    $("#sendSeats").on('click', function() {
        console.log("Total Tickets =  "+total_tickets);

        if (total_tickets != 0) {
            if (total_tickets == counter) {
                console.log("El contador es igual al total de tickets");
                if ( ! $("#actual_pay").val() || $("#actual_pay").val() == "" ) {
                    M.toast({html: 'No olvides poner una cantidad en el pago!'});
                    return false;
                }
                else {
                    $("input[name='actual_pay']").val( $("#actual_pay").val() );
                    $("#reservations-form").submit();
                }
            }
            else{
                console.log("El contador NO igual al total de tickets");
                M.toast({html: 'Debes seleccionar el número correcto de asientos!'});
                return false;
            }
        }
        else{
            M.toast({html: 'Debes seleccionar algún asiento, no puede quedar en cero!'});
            return false;
        }
        //$("#reservations-form").submit();
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

        total_tickets = 0;
        total_tickets = parseInt(number_kids) + parseInt(number_adults) + parseInt(number_elders);
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
        // $("#actual_pay").val(total);
        // $(".actual_pay").val(total);
        $("#change").val('0');

        if ($("#payment_method").val() == 'cortesia') {
            $("#total").val('0');
            $("#actual_pay").val('0');
        }
    });

    jQuery('#number_kids, #number_adults, #number_elders, #cost_kids, #cost_adults, #cost_elders, .stepsChanger').on('keyup mouseup change', function(key){

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

        total_tickets = 0;
        total_tickets = parseInt(number_kids) + parseInt(number_adults) + parseInt(number_elders);

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
        // $("#actual_pay").val(total);
        // $(".actual_pay").val(total);

        if ($("#payment_method").val() == 'cortesia') {
            $("#total").val('0');
            $("#actual_pay").val('0');
        }
    });

    jQuery('#actual_pay').on('keyup mouseup', function(key){
        if( $("#actual_pay").val() ) {
            change = parseInt( $("#actual_pay").val() ) - parseInt( $("#total").val() );
            if ( ! isNaN(change) ) {
                if (change > 0 ) {
                    $("#change").val(change);
                }
                else {
                    $("#change").val('0');
                }
            }
        }
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
