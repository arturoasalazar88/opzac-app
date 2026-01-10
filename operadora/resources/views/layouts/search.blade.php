@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h4>Búsqueda</h4>
                </div>
            </div>

            <div class="row">
                <form class="col s12" method="post" action="{{ route('search_make') }}" id="search_form">
                    @csrf
                    <div class="row search-box">
                        <div class="input-field col s12 m10">
                            <input placeholder="Introduce tu búsqueda" name="q" id="search" type="text">
                            <label for="q">Búsqueda</label>
                        </div>
                        <div class="input-field col s12 m2">
                            {{-- <input type="submit" value="Buscar" name="buscar" class="btn teal" placeholder="buscar">
                            <label for="buscar">Búsqueda</label> --}}
                            <button id="make_search" name="button" class="btn teal">Buscar</button>
                        </div>
                    </div>
                </form>
            </div>

            @if(isset($result))
                <div class="row">
                    <div class="col s12">
                        <p> Los resultados para tu consulta  <b> {{ $query }} </b> son :</p>
                        <div class="row reservations-types alert alert-info">
                            <div class="col s12 m3"><i class="fa fa-lock-open"></i>No pagada comisión</div>
                            <div class="col s12 m3"><i class="fa fa-lock-open" style="color: red;"></i>Pagada únicamente comisión</div>
                            <div class="col s12 m3"><i class="fa fa-lock-open" style="color: #ffeb3b;"></i>Pagada más de la comisión</div>
                            <div class="col s12 m3"><i class="fa fa-lock" style="color: green;"></i>Pagada totalmente</div>
                        </div>
                        <table class="table striped table-content">
                            <thead>
                                <tr>
                                    <th scope="col">Folio</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Tour (Compañía)</th>
                                    <th scope="col">Horario</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Hotel</th>
                                    <th scope="col">N</th>
                                    <th scope="col">A</th>
                                    <th scope="col">I</th>
                                    <th scope="col">Más</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($result as $reservation)
                                    <tr>
                                        <td scope="row" data-label="Folio">
                                            @if ($reservation->status == 0)
                                                <i class="fa fa-lock-open"></i>
                                            @elseif ($reservation->status == 1)
                                                <i class="fa fa-lock-open" style="color: red;"></i>
                                            @elseif ($reservation->status == 2)
                                                <i class="fa fa-lock-open" style="color: #ffeb3b;"></i>
                                            @else
                                                <i class="fa fa-lock" style="color: green;"></i>
                                            @endif
                                            {{ $reservation->folio }}</td>
                                        <td data-label="Cliente">{{ $reservation->client }}</td>
                                        <td data-label="Tour">
                                            {{ $reservation->departure->tour->name ? $reservation->departure->tour->name : 'N/A'  }}
                                            <b>({{ $reservation->departure->tour->company->name ? $reservation->departure->tour->company->name : 'N/A'}})</b>
                                        </td>
                                        <td data-label="Hora"><b>{{ $reservation->departure->horario }}</b></td>
                                        <td data-label="Fecha">{{ $reservation->date }}</td>
                                        <td data-label="Hotel">{{ $reservation->hotel->name }}</td>
                                        <td data-label="Niños">{{ $reservation->number_kids }}</td>
                                        <td data-label="Adultos">{{ $reservation->number_adults }}</td>
                                        <td data-label="INSEN">{{ $reservation->number_elders }}</td>
                                        <td data-label="Acciones">
                                            <a href="{{ route('reservations_show' , ['reservation' => $reservation->id]) }}">
                                                <i class="far fa-edit"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            @if(isset($message))
                <div class="row">
                    <div class="col s12">
                        <div class="alert alert-danger">
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script type="text/javascript">
    $("#make_search").on('click', function(e){
        e.preventDefault();

        var search = $("#search");

        if (search.val().trim() == "") {
            M.toast({html: 'La búsqueda no puede ir vacía'});
        }
        else if(search.val().trim().length <= 3) {
            M.toast({html: 'Ingresa una búsqueda más larga'});
        }
        else{
            $("#search_form").submit();
        }

    });
    </script>

@endsection
