@extends('layouts.app')

@section('content')

    {{-- <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Selecciona la compañía antes de {{ $action }}</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Compañías</h5>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div> --}}

    <div class="section">
        <div class="container">
            {{-- <div class="row">
                <div class="col s12">
                    <div class="grid-container">
                        @foreach ($companies as $key => $company)
                            <a href="{{ route($url, ['company' => $company->id ]) }}" class="teal">
                                    <span class="white-text center">
                                        {{ $company->name }}
                                    </span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div> --}}
            {{-- USER is --}}
            {{-- Receptionist or Admin but no Operador --}}
            <div class="row">
                <form method="get" action="#" id="form-select-tour">
                    @csrf
                    <input type="hidden" name="tour_id" id="tour_id" value="-1">
                    <div class="input-field col s12 ">
                        <input type="text" name="date" value="" class="datepicker exclude-dates" id="date">
                        <label for="date">Selecciona Fecha</label>
                    </div>
                </form>
                <div class="col">
                    <p id="date-display">
                    </p>
                </div>
            </div>

            <div class="row">
                @forelse ($companies as $key => $company)
                <div class="col s6">
                    <div class="grid-container" style="grid:none;">
                            <a href="{{ route($url, ['company' => $company->id ]) }}" class="teal">
                                <span class="white-text center">
                                    {{ $company->name }}
                                </span>
                            </a>
                            @forelse ($company->tours as $key => $tour)
                            {{-- <div class="col s12 m6 l4"> --}}
                                    {{-- <a href="{{ route($url, ['tour' => $tour->id ]) }}"> --}}
                                        <a href="#!" class="format-url indigo" id="{{$tour->id}}">
                                            {{-- <a href="#!" class="click-tour" id="{{ $tour->id }}"> --}}
                                                {{-- <div class="card-panel indigo"> --}}
                                                    <span class="white-text center">
                                                        <h6><b>{{ $tour->name }}</b></h6>
                                                        {{-- @if (Auth::user()->role->type == "Recepción" && $tour->company->name == "Operadora" && Auth::user()->hotel->zone->closure)
                                                            <b>Cierre:</b> {{ Auth::user()->hotel->zone->closure }} minutos antes de cada salida
                                                        @endif --}}
                                                    </span>
                                                {{-- </div> --}}
                                        </a>
                                        {{-- </div> --}}
                                @empty
                                    <div class="alert alert-danger" style="grid-column:1/3;">
                                        <p>
                                            No hay tours asociados a esta compañía, o están desactivados globalmente!
                                        </p>
                                    </div>
                            @endforelse
                        </div>
                    </div>
                        @empty
                            <div class="alert alert-danger" style="grid-column:1/3;">
                                <p>
                                    No hay tours asociados a esta compañía, o están desactivados global
                                </p>
                            </div>
                        @endforelse

            </div>
            <div class="row">
                <div class="col s12">
                    <div class="grid-container">
                        @if ( (isset($fast) && !Auth::user()->isReceptionist()) || (isset($fast) && Auth::user()->isAdmin()) )
                            @if ( Auth::user()->isAdmin() || !Auth::user()->isOperador())
                                <a href="{{ route('fast_menu') }}" class="pink darken-1">
                                    <span class="white-text center">
                                        {{ $fast->name }} (FAST TRACK)
                                    </span>
                                </a>
                            @endif
                        @endif
                        @if ( (isset($fast2) && !Auth::user()->isReceptionist()) || (isset($fast2) && Auth::user()->isAdmin()) )
                            @if (Auth::user()->isAdmin() || !Auth::user()->isOperador())
                                <a href="{{ route('fast_menu') }}?id={{ $fast2->id }}" class="pink darken-1">
                                    <span class="white-text center">
                                        {{ $fast2->name }} (FAST TRACK)
                                    </span>
                                </a>
                            @endif
                        @endif
                        @if ( (isset($fast3) && !Auth::user()->isReceptionist()) || (isset($fast3) && Auth::user()->isAdmin()) )
                            @if (Auth::user()->isAdmin() || !Auth::user()->isOperador())
                                <a href="{{ route('fast_menu') }}?id={{ $fast3->id }}" class="pink darken-1">
                                    <span class="white-text center">
                                        {{ $fast3->name }} (FAST TRACK)
                                    </span>
                                </a>
                            @endif
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        //console.log("Hey There");

        $( document ).ready(function(){

            $('#date').on('change', function() {
                let date = new Date($("#date").val());
                $('#date-display').html("Fecha seleccionada: "+
                    date.toLocaleDateString('es-ES', {
                        weekday: 'long',
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric',
                        timeZone: 'UTC'
                    })
                );
            });

            let date = new Date($("#date").val());

            $('#date-display').html("Fecha seleccionada: "+
                date.toLocaleDateString('es-ES', {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric',
                    timeZone: 'UTC'
                })
            );

            $('.click-tour').on('click', function() {
                //console.log("clickeado "+ $(this).attr('id') );
                $('#tour_id').val($(this).attr('id'));

                $('#form-select-tour').submit();
            });

            var url = "{{ route('company_create_reservation_2') }}";
            console.log('{{route($url, ['company' => $company->id ])}}');
            $('.format-url').on('click', function(event){

                url = "{{ route('company_create_reservation_2') }}";

                event.preventDefault();
                url = url + "?" + "tour=" +this.id+ "&date=" +$("#date").val();
                console.log("going to: "+url);
                document.location.href = url;
            });

        });

    </script>

@endsection
