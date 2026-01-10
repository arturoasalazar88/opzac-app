@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Reporte de Recolección del día por horarios</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Horarios - Estás en {{ $company->name }}</h5>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="container">

            <div class="row">
                <form id="form-horario" class="col s12" action="{{ route('hours_result') }}" method="post">
                {{-- <form id="form-zones" class="col s12" action="#!" method="post"> --}}
                    <input type="text" name="date" id="date" value="" class="datepicker full-dates">
                    @csrf
                    <select class="" name="zone_id">
                        <option value="0">Todas las Zonas</option>
                        @foreach ($zones as $key => $zone)
                            <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="horario" value="" id="horario">
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                </form>
            </div>

            <div class="row">
                <div class="col s12 m6 l4">
                    <a href="#!" id="0" class="select-horario">
                        <div class="card-panel indigo">
                            <span class="white-text center">
                                Todos las Horarios
                            </span>
                        </div>
                    </a>
                </div>
                @foreach ($horarios as $key => $horario)
                    <div class="col s12 m6 l4">
                        <a href="#!" id="{{ $horario->horario }}" class="select-horario">
                            <div class="card-panel indigo">
                                <span class="white-text center">
                                    {{ $horario->horario }}
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

        $('.select-horario').on('click', function() {
            //console.log("clickeado "+ $(this).attr('id') );
            $('#horario').val($(this).attr('id'));

            $('#form-horario').submit();
        });

    });

</script>

@endsection
