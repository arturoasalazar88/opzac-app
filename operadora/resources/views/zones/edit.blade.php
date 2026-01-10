@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h4>Editar Zona</h4>
                </div>
            </div>

            <div class="row">
                <form class="col s12" action="{{ route('zones_update',['zone'=>$zone->id]) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" disabled="disabled" value="{{ $zone->number }}">
                            <label for="number">Número</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <input type="text" name="name" value="{{ $zone->name }}">
                            <label for="name">Nombre</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <input type="number" name="closure" value="{{ $zone->closure }}">
                            <label for="closure">Cierre</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" value="Editar" class="btn red">
                        </div>
                    </div>
                </form>

                @include('layouts.errors')
            </div>

        </div>
    </div>
@endsection
