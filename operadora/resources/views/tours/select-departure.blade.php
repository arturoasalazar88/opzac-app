@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4 class="blue darken-4 teal-title">{{ $tour->name }} <small>({{ $tour->company->name }})</small></h4>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            {{-- <div class="row">
                <div class="col s12 m6">
                    <h4>Selecciona fecha a revisar</h4>
                </div>
            </div> --}}
            <div class="row">
                <div class="col s12">
                    <h5>Selecciona fecha a revisar</h5>
                </div>
                <div class="col s12 m4">
                    <form class="" action="#!" method="post">
                        <input type="text" id="date-selector" name="date" class="datepicker full-dates teal white-text" style="padding-left: 25px; font-weight: 600;">
                    </form>
                </div>
            </div>
            {{-- <div class="row">
                <div class="col s12 m6">
                    <h4>Salidas para {{ $tour->name }}</h4>
                </div>
            </div> --}}
            <div class="row">
                <div class="col s12">
                    <h5>Selecciona horario (24hrs)</h5>
                </div>
                @forelse ($departures as $key => $departure)
                    <div class="col s12 m3 l4">
                        <a href="#!" class="form-tour-a">
                            <form class="purple darken-3 white-text teal-title" action="{{ route('show_single_tour_date', ["departure" => $departure->id]) }}" method="post">
                                @csrf
                                <h5 class="center">
                                    {{ $departure->horario }}<br/>
                                    <b>{{ $departure->type == 0 ? 'Verde' : 'Rosa'}}</b>
                                </h5>
                                {{-- <input type="text" name="date" class="datepicker"> --}}
                                <input
                                    type="hidden"
                                    id="form-date"
                                    class="form-date"
                                    name="date"
                                    value="{{ \Carbon\Carbon::now()->toDateString() }}"
                                    >
                                {{-- <input type="submit" name="" value="Revisar" class="btn"> --}}
                            </form>
                        </a>
                    </div>
                @empty
                    <div class="alert alert-danger">
                        <p>No hay salidas para este tour</p>
                    </div>
                @endforelse
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
