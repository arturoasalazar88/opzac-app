@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Reporte de Recolección del día por Zonas</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Zonas - Estás  en {{ $company->name }}</h5>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="container">

            <div class="row">
                <form id="form-zones" class="col s12" action="{{ route('zones_result') }}" method="post">
                    {{-- <select class="" name="horario">
                        <option value="all">Todos los horarios</option>
                        @foreach ($horarios as $key => $horario)
                            <option value="{{ $horario->horario }}">{{ $horario->horario }}</option>
                        @endforeach
                    </select> --}}
                    @csrf

                    <input type="text" name="date" value="" id="date" class="datepicker full-dates">

                    <select class="" name="departure_id">
                        <option value="0">Todos los tours</option>
                        {{-- @foreach ($tours as $key => $tour)
                            <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                        @endforeach --}}
                        @foreach ($tours as $key => $tour)
                            {{-- this its the departure id --}}
                            @foreach ($tour->departures as $key => $value)
                                <option value="{{ $value->id }}">
                                    {{ $value->tour->name }}
                                    -
                                    {{ $value->horario }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    <input type="hidden" name="zone_id" value="0" id="zone_id">
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                </form>
            </div>

            <div class="row">
                <div class="col s12 m6 l4">
                    <a href="#!" id="0" class="select-zone">
                        <div class="card-panel indigo">
                            <span class="white-text center">
                                Todas las Zonas
                            </span>
                        </div>
                    </a>
                </div>
                @foreach ($zones as $key => $zone)
                    <div class="col s12 m6 l4">
                        <a href="#!" id="{{ $zone->id }}" class="select-zone">
                            <div class="card-panel indigo">
                                <span class="white-text center">
                                    {{ $zone->name }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>

<script type="text/javascript">
    //console.log("Hey There");

    $( document ).ready(function(){

        $('.select-zone').on('click', function() {
            //console.log("clickeado "+ $(this).attr('id') );
            $('#zone_id').val($(this).attr('id'));

            $('#form-zones').submit();
        });

    });

</script>

@endsection
