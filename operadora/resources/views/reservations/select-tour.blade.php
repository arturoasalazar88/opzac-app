@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Tours de {{ $company->name }} selecciona el tour</h4>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Tours</h5>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="container">

            <div class="row">
                <form method="get" action="#" id="form-select-tour">
                    @csrf
                    <input type="hidden" name="tour_id" id="tour_id" value="-1">
                    <div class="input-field col s12 ">
                        <input type="text" name="date" value="" class="datepicker exclude-dates" id="date">
                        <label for="date">Selecciona Fecha</label>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col s12">
                    <div class="grid-container">
                        @forelse ($tours as $key => $tour)
                                {{-- <div class="col s12 m6 l4"> --}}
                                    {{-- <a href="{{ route($url, ['tour' => $tour->id ]) }}"> --}}
                                    <a href="#!" class="format-url indigo" id="{{$tour->id}}">
                                    {{-- <a href="#!" class="click-tour" id="{{ $tour->id }}"> --}}
                                        {{-- <div class="card-panel indigo"> --}}
                                            <span class="white-text center">
                                                <h6><b>{{ $tour->name }}</b></h6>
                                                @if (Auth::user()->role->type == "Recepción" && $tour->company->name == "Operadora" && Auth::user()->hotel->zone->closure)
                                                    <b>Cierre:</b> {{ Auth::user()->hotel->zone->closure }} minutos antes de cada salida
                                                @endif
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
            </div>

        </div>
    </div>

    <script type="text/javascript">
        //console.log("Hey There");

        $( document ).ready(function(){

            $('.click-tour').on('click', function() {
                //console.log("clickeado "+ $(this).attr('id') );
                $('#tour_id').val($(this).attr('id'));

                $('#form-select-tour').submit();
            });

            var url = "{{ route('company_create_reservation_2') }}";

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
