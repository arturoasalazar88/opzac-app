@extends('layouts.app')

@section('content')

    <div class="section" id="users-show">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Detalles</h3>
                </div>
            </div>

            @if (session('status'))
                <div class="row">
                    <div class="col s12 m12">
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col s12">
                    <div class="collection with-header">
                        <div class="collection-header">
                            <h5>Información del Tour</h5>
                        </div>
                        <div class="collection-item">
                            <b>Nombre</b> {{ $tour->name }}
                        </div>
                        <div class="collection-item">
                            {{-- <b>Horario</b> {{ $tour->horario }} --}}
                            <b>Horarios</b>
                            @forelse ($tour->departures as $key => $departure)
                                {{ $departure->horario }}
                                @if ($departure->tour->company->name == "Maxibus")
                                    - Autobus [{{ $departure->type == 0 ? 'Grande '.$departure->getTypes(0) : 'Pequeño '.$departure->getTypes(1) }}]
                                    <a href="{{ route('departures_edit',['departure' => $departure->id]) }}">Editar</a>
                                @endif
                                @if ( $departure->isActive() )
                                    (<a href="{{ route('departures_cancel', ['departure' => $departure->id ]) }}">Desactivar horario</a>)<br>
                                @else
                                    (<a href="{{ route('departures_activate', ['departure' => $departure->id ]) }}">Reactivar horario</a>)<br>
                                @endif
                                <div>
                                    <a class="waves-effect waves-light btn modal-trigger" href="#modal-{{$departure->id}}">Borrar Horario</a>
                                </div>
                            @empty
                                No hay horarios asociados a este tour ¡Agrega uno!
                            @endforelse
                            <br>
                            @if ( $tour->departures->count() > 0 )
                                {{-- <a href="#!" class="btn teal">Reactivar todos</a> --}}
                            @endif
                        </div>
                        <div class="collection-item">
                            <b>Dueño</b> {{ $tour->company->name }}
                        </div>
                        <div class="collection-item">
                            <b>Límite</b> {{ $tour->limit }}
                        </div>
                        <div class="collection-item">
                            @if ($tour->active)
                                <b>Activo</b>
                            @else
                                <b>Inactivo</b>
                            @endif
                        </div>
                        <div class="collection-item">
                            <b>Costos</b>
                            Niños : {{ $tour->cost_kids }} <br>
                            Adultos : {{ $tour->cost_adults }} <br>
                            INSEN : {{ $tour->cost_elders }}
                        </div>
                        <div class="collection-item">
                            <b>Descripción</b> {{ $tour->description }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12 m3">
                    <a href="{{ route('tours_edit', ['tour'=>$tour->id]) }}" class="btn btn-blue">Editar</a>
                </div>
                <div class="col s12 m3">
                    <a class="waves-effect waves-light btn modal-trigger" href="#modal-tour-{{$tour->id}}">Borrar Tour</a>
                </div>
                <div class="col s12 m3">
                    <a href="{{ route('departures_create', ['tour'=>$tour->id]) }}" class="btn">Añadir Horario</a>
                </div>
            </div>

        </div>
    </div>
    @foreach( $tour->departures as $departure )
        <!-- Modal Structure -->
        <div id="modal-{{$departure->id}}" class="modal" style="margin-top:100px;">
            <div class="modal-content">
            <h4>Borrar horario?</h4>
            <form action="{{ route('departures_destroy', ['departure' => $departure]) }}" method="post">
                <input class="btn btn-warning" type="submit" value="Borrar" />
                @method('delete')
                @csrf
            </form>
            </div>
            {{-- <div class="modal-footer">
            <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
            </div> --}}
        </div>
    @endforeach

    <div id="modal-tour-{{$tour->id}}" class="modal" style="margin-top:100px;">
        <div class="modal-content">
        <h4>Borrar Tour?</h4>
        <form action="{{ route('tours_destroy', ['tour' => $tour]) }}" method="post">
            <input class="btn btn-default" type="submit" value="Borrar" />
            @method('delete')
            @csrf
        </form>
        </div>
        {{-- <div class="modal-footer">
        <a href="#!" class="modal-close waves-effect waves-green btn-flat">Agree</a>
        </div> --}}
    </div>


@endsection
