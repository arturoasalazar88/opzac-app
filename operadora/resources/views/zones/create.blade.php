@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Creación de Zonas</h3>
                </div>
            </div>
            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ route('zones_store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <legend>Información de la nueva Zona</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="number" class="" placeholder="Número de Zona" value="{{ old('number') }}">
                            <label for="number">Número <i>* Uno que no esté ya en uso</i></label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" class="" placeholder="Nombre" value="{{ old('name') }}">
                            <label for="name">Nombre Zona</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="number" name="closure" placeholder="Cierre" value="{{ old('closure') }}">
                            <label for="closure">Cierre</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" value="Crear" class="btn blue darken-3">
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>

@endsection
