@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Tours de {{ $company->name }}</h4>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            <div class="row">
                <div class="col s12 m6">
                    <h4>Selecciona Fecha</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s12 m4">
                    <form class="" action="#!" method="post">
                        <input type="text" id="date-selector" name="date" class="datepicker teal accent-4 white-text" style="padding-left: 25px;">
                    </form>
                </div>
            </div>
            <br>
            <div class="row">
                @foreach ($tours as $key => $tour)
                    <div class="col s12 m6 l4">
                        <a href="#!" class="form-tour-a">
                            <form class="teal white-text teal-title" action="{{ route('test_dos', ["tour" => $tour->id]) }}" method="post">
                                @csrf
                                <h5>{{ $tour->name }}</h5>
                                {{-- <input type="text" name="date" class="datepicker"> --}}
                                <input type="hidden" class="form-date" name="date" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                {{-- <input type="submit" name="" value="Revisar" class="btn"> --}}
                            </form>
                        </a>
                    </div>
                @endforeach
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
