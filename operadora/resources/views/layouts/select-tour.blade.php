@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Reporte de Recolección del día por Tours</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Hoteles por horario - Estás en {{ $company->name }}</h5>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="container">

            <div class="row">
                <form id="form-horario" class="col s12" action="{{ route('pickup_result_tours') }}" method="post">
                {{-- <form id="form-zones" class="col s12" action="#!" method="post"> --}}
                    @csrf
                    <input type="text" name="date" value="" class="datepicker full-dates">
                    <select class="" name="tour_id" style="display: block;">
                        <option value="0">Todos los Tours</option>
                        @foreach ($tours as $key => $tour)
                            @if ($tour->name != "Total Pass")
                                <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                            @endif
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

        $('.select-tour').on('click', function() {
            //console.log("clickeado "+ $(this).attr('id') );
            $('#tour_id').val($(this).attr('id'));

            $('#form-tours').submit();
        });

    });

</script>

@endsection
