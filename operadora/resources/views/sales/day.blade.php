@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h4>Reporte del día {{ $company->name }}</h4>
                </div>
            </div>

            @if(Session::has('status'))
                <div class="row">
                    <div class="col s12">
                        <div class="alert alert-success">
                            <p>{{Session('status')}}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <form class="col s12" method="get" action="{{ route('sales_today') }}" id="search_form">
                    @csrf
                    <div class="row search-box">
                        <div class="input-field col s12 m5">
                            <input name="date" id="search" type="text" class="datepicker full-dates2">
                            <input type="hidden" name="company_id" value="{{ $company->id }}">
                            {{-- <input type="text" name="date" value="" class="datepicker exclude-dates" id="date"> --}}
                            <label for="date">Selecciona la fecha</label>
                        </div>
                        <div class="input-field col s12 m5">
                            <select class="" name="tour_id" id="tour_id">
                                <option value="-1">Todos los tours</option>
                                @foreach ($tours as $key => $tour)
                                    <option value="{{ $tour->id }}">{{ $tour->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="input-field col s12 m2">
                            {{-- <input type="submit" value="Buscar" name="buscar" class="btn teal" placeholder="buscar"> --}}
                            <a id="buscar" target="_blank" class="btn teal" href="{{ route('sales_today') }}?date={{ Carbon\Carbon::now()->toDateString() }}&company_id={{ $company->id }}">Buscar</a>
                            {{-- <label for="buscar">Búsqueda</label> --}}
                            {{-- <button id="make_search" name="button" class="btn teal">Buscar</button> --}}
                        </div>
                    </div>
                </form>
                {{-- <a href="#!" target="_blank" id="clickMe"></a> --}}
            </div>
        </div>
    </div>

    <script type="text/javascript">

    $('.full-dates2').datepicker({
        format: 'yyyy-mm-dd',
        defaultDate: new Date(),
        setDefaultDate: true,
        onSelect: getDate,
        i18n: {
                  months: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
                  monthsShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Set", "Oct", "Nov", "Dic"],
                  weekdays: ["Domingo","Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"],
                  weekdaysShort: ["Dom","Lun", "Mar", "Mie", "Jue", "Vie", "Sab"],
                  weekdaysAbbrev: ["D","L", "M", "M", "J", "V", "S"]
              }
    });

    function getDate( date ){
        newDate = Date( date );
        console.log("date is "+date);
        //var s = newDate.toDateString();
        var dateobj = new Date( date );
        var url = "{{ route('sales_today') }}";

        // Contents of date portion of above date object is
        // converted into a string using toDateString() function.
        var B = dateobj.toDateString();
        console.log("date is "+B);
        url = url + "?date="+B+"&company_id={{ $company->id }}&tour_id="+$('#tour_id').val();
        $("#buscar").attr( 'href', url);
    }

    $( document ).ready( function() {

        var url = "{{ route('sales_today') }}";
        url = url + "?date="+ $("#search").val() +"&company_id={{ $company->id }}&tour_id="+$('#tour_id').val();

        $("#buscar").attr( 'href', url);

        $("#tour_id").change( function() {
            url = "{{ route('sales_today') }}";
            url = url + "?date="+ $("#search").val() +"&company_id={{ $company->id }}&tour_id="+$(this).val();
            $("#buscar").attr( 'href', url);

        });
    });
    </script>

@endsection
