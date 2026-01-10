@extends('layouts.app')

@section('content')

    <div class="section" id="users-show">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Detalles</h3>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <div class="collection with-header">
                        <div class="collection-header">
                            <h5>Información de la Zona</h5>
                        </div>
                        <div class="collection-item">
                            <b>Número</b> {{ $zone->number }}
                        </div>
                        <div class="collection-item">
                            <b>Nombre</b> {{ $zone->name }}
                        </div>
                        <div class="collection-item">
                            <b>Cierre</b> {{ $zone->closure }} <i>*Minutos antes de cada salida</i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <a href="{{ route('zones_edit', ['zone'=>$zone->id]) }}" class="btn btn-blue">Editar</a>
                </div>
            </div>

        </div>
    </div>

@endsection
