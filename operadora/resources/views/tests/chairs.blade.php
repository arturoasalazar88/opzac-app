@extends('layouts.app')

@section('content')

    <style media="screen">
        .seats span {
            display: inline-block;
            min-width: 25px;
        }
        .taken {
            color: #000000;
        }
        .available {
            color: #ebebeb;
        }
        .selection {
            color: green;
        }
        .fa-3x{
            font-size: 2.5em;
            cursor: pointer;
        }
    </style>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Selecciona asientos</h4>
                </div>
            </div>
            <div class="row reservations-types alert">
                <div class="col s12 m3"><i class="fa fa-couch taken"></i>Asiento Tomado</div>
                <div class="col s12 m3"><i class="fa fa-couch available"></i>Asiento Disponible</div>
                <div class="col s12 m3"><i class="fa fa-couch selection"></i>Tu selección</div>
            </div>
            <form class="" method="post" action="{{ route('test_request_seats') }}">
                @csrf
                <div class="row">
                    <div class="col s12 m4 seats first-floor center">
                        <h5>Primer Piso</h5>
                        <div>
                            <input type="hidden" name="seat[1]" value="taken">
                            <i id="1" class="fas fa-3x fa-couch taken"></i>
                            <input type="hidden" name="seat[2]" value="available">
                            <i id="2" class="fas fa-3x fa-couch available"></i>
                            <span>&nbsp;</span>
                            <input type="hidden" name="seat[3]" value="available">
                            <i id="3" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[4]" value="available">
                            <i id="4" class="fas fa-3x fa-couch available"></i>
                        </div>
                        <div>
                            <input type="hidden" name="seat[5]" value="available">
                            <i id="5" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[6]" value="available">
                            <i id="6" class="fas fa-3x fa-couch available"></i>
                            <span></span>
                            <input type="hidden" name="seat[7]" value="available">
                            <i id="7" class="fas fa-3x fa-couch taken"></i>
                            <input type="hidden" name="seat[8]" value="available">
                            <i id="8" class="fas fa-3x fa-couch available"></i>
                        </div>
                        <div>
                            <input type="hidden" name="seat[9]" value="available">
                            <i id="9" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[10]" value="available">
                            <i id="10" class="fas fa-3x fa-couch taken"></i>
                            <span></span>
                            <input type="hidden" name="seat[11]" value="available">
                            <i id="11" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[12]" value="available">
                            <i id="12" class="fas fa-3x fa-couch available"></i>
                        </div>
                        <div>
                            <input type="hidden" name="seat[13]" value="available">
                            <i id="13" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[14]" value="available">
                            <i id="14" class="fas fa-3x fa-couch available"></i>
                            <span></span>
                            <i id="15" class="fas fa-3x fa-couch taken"></i>
                            <input type="hidden" name="seat[15]" value="available">
                            <i id="16" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[16]" value="available">
                        </div>
                    </div>
                    <div class="col s12 m4 seats second-floor center">
                        <h5>Segundo Piso</h5>
                        <div>
                            <input type="hidden" name="seat[17]" value="available">
                            <i id="17" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[18]" value="taken">
                            <i id="18" class="fas fa-3x fa-couch taken"></i>
                            <span></span>
                            <input type="hidden" name="seat[19]" value="available">
                            <i id="19" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[20]" value="available">
                            <i id="20" class="fas fa-3x fa-couch available"></i>
                        </div>
                        <div>
                            <input type="hidden" name="seat[21]" value="available">
                            <i id="21" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[22]" value="available">
                            <i id="22" class="fas fa-3x fa-couch available"></i>
                            <span></span>
                            <input type="hidden" name="seat[23]" value="taken">
                            <i id="23" class="fas fa-3x fa-couch taken"></i>
                            <input type="hidden" name="seat[24]" value="available">
                            <i id="24" class="fas fa-3x fa-couch available"></i>
                        </div>
                        <div>
                            <input type="hidden" name="seat[25]" value="available">
                            <i id="25" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[26]" value="available">
                            <i id="26" class="fas fa-3x fa-couch available"></i>
                            <span></span>
                            <input type="hidden" name="seat[27]" value="available">
                            <i id="27" class="fas fa-3x fa-couch taken"></i>
                            <input type="hidden" name="seat[28]" value="available">
                            <i id="28" class="fas fa-3x fa-couch available"></i>
                        </div>
                        <div>
                            <input type="hidden" name="seat[29]" value="available">
                            <i id="29" class="fas fa-3x fa-couch available"></i>
                            <input type="hidden" name="seat[30]" value="available">
                            <i id="30" class="fas fa-3x fa-couch available"></i>
                            <span></span>
                            <input type="hidden" name="seat[31]" value="taken">
                            <i id="31" class="fas fa-3x fa-couch taken"></i>
                            <input type="hidden" name="seat[32]" value="available">
                            <i id="32" class="fas fa-3x fa-couch available"></i>
                        </div>
                    </div>
                </div>
                <input type="submit" name="" value="Enviar">
            </form>
        </div>
    </div>

    <script type="text/javascript">
        var total_tickets = 3;
        var counter = 0;

        $(".seats i.available").on('click', function(){

            if (counter < total_tickets
                &&
                ! $(this).hasClass('selection') ) {

                // console.log("ID = "+$(this).attr('id'));
                $(this).toggleClass("selection");
                $("input[name='seat["+$(this).attr('id')+"]']").val("selection");
                counter = counter + 1;
            }
            else if ( $(this).hasClass("selection") ) {
                $(this).toggleClass("selection");
                $("input[name='seat["+$(this).attr('id')+"]']").val("available");
                counter = counter - 1;
            }
            console.log("counter "+counter);
        });
    </script>

@endsection
