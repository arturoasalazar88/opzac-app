@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Reporte de Recolección del día por Hoteles</h4>
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
                <form id="form-horario" class="col s12" action="{{ route('hotels_result_horarios') }}" method="post">
                {{-- <form id="form-zones" class="col s12" action="#!" method="post"> --}}
                    @csrf
                    <input type="text" name="date" value="" class="datepicker full-dates">
                    {{-- <select class="" name="hotel_id" style="display:block !important;">
                        <option value="0">Todos los hoteles</option>
                        @foreach ($hotels as $key => $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select> --}}
                    <p>Hotel</p>
                    <select class="hotel-select" name="hotel_id" style="width: 100%;">
                        <option value="0">Todos los hoteles</option>
                        @foreach ($hotels as $key => $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
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

    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Hoteles por tours - Estás en {{ $company->name }}</h5>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <form id="form-tours" class="col s12" action="{{ route('hotels_result_tours') }}" method="post">
                    @csrf
                    <input type="text" name="date" value="" class="datepicker full-dates">
                    {{-- <select class="" name="hotel_id" style="display: block !important;">
                        <option value="0">Todos los hoteles</option>
                        @foreach ($hotels as $key => $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select> --}}
                    <p>Hotel</p>
                    <select class="hotel-select" name="hotel_id" style="width: 100%;">
                        <option value="0">Todos los hoteles</option>
                        @foreach ($hotels as $key => $hotel)
                            <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                        @endforeach
                    </select>
                    <input type="hidden" name="tour_id" value="" id="tour_id">
                    <input type="hidden" name="company_id" value="{{ $company->id }}">
                </form>
            </div>

            <div class="row">
                <div class="col s12 m6 l4">
                    <a href="#!" id="0" class="select-tour">
                        <div class="card-panel indigo">
                            <span class="white-text center">
                                Todos los tours
                            </span>
                        </div>
                    </a>
                </div>
                @foreach ($tours as $key => $tour)
                    <div class="col s12 m6 l4">
                        <a href="#!" id="{{ $tour->id }}" class="select-tour">
                            <div class="card-panel indigo">
                                <span class="white-text center">
                                    {{ $tour->name }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
<link href="{{ asset('select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<script src="{{ asset('select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.hotel-select').select2();
    });
</script>
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
