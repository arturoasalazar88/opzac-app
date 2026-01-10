@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4 class="blue darken-4 teal-title">Tours de {{ $company->name }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            <div class="row">
                <div class="col s12 m6">
                    <h4>Selecciona fecha a revisar</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m4">
                    <form class="" action="#!" method="post">
                        <input type="text" id="date-selector" name="date" class="datepicker full-dates teal white-text" style="padding-left: 25px; font-weight: 600; cursor: pointer;">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m6">
                    <h4>Selecciona tour</h4>
                </div>
            </div>
            <div class="row">
                <div class="grid-container">
                    @foreach ($tours as $key => $tour)
                        {{-- @foreach ($tour->departures as $key => $value)
                            <div class="col s12 m6 l4">
                                <a href="#!" class="form-tour-a">
                                    <form class="teal white-text teal-title" action="{{ route('show_single_tour_date', ["departure" => $value->id]) }}" method="post">
                                        @csrf
                                        <h5>{{ $tour->name }} - <br> {{ $value->horario}} </h5> --}}
                                        {{-- <input type="text" name="date" class="datepicker"> --}}
                                        {{-- <input type="hidden" class="form-date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}"> --}}
                                        {{-- <input type="submit" name="" value="Revisar" class="btn"> --}}
                                    {{-- </form>
                                </a>
                            </div>
                        @endforeach --}}
                        {{-- <div class="col s12 m6 l4"> --}}
                            <a href="{{ route('tours_select_departure', ["tour" => $tour->id]) }}" class="form-tour-a teal white-text teal-title">
                                <h5 class="center">{{ $tour->name }}</h5>
                                {{-- @if ( ! $tour->active )
                                    <h6 class="center"><b>(No Activo)</b></h6>
                                @endif --}}
                                {{-- <form class="teal white-text teal-title" action="" method="post">
                                    @csrf
                                    <h5>{{ $tour->name }}</h5> --}}
                                    {{-- <input type="text" name="date" class="datepicker"> --}}
                                    {{-- <input type="hidden" class="form-date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}"> --}}
                                    {{-- <input type="submit" name="" value="Revisar" class="btn"> --}}
                                {{-- </form> --}}
                            </a>
                        {{-- </div> --}}
                    @endforeach
                </div>
            </div>
        </div>
    </div>

<script type="text/javascript">
    jQuery(document).ready( function(){

        //============================================//
        // Lets retrive the seelcted date
        //============================================//
        $('#date-selector').on('change', function(){
            var date = $('#date-selector').val();
            //console.log('date '+ date);
            $(".form-tour-a .form-date").val(date);
        });
        //============================================//
        // And assign that value to the hidden inputs
        //============================================//
        $('a.form-tour-a').on('click', function(){
            $(this).children('form').submit();
        });

    });
</script>

@endsection
