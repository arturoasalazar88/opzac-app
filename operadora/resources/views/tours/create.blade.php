@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Creación de Tours</h3>
                </div>
            </div>
            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ route('tours_store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <legend>Información del nuevo Tour</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" class="" placeholder="Nombre del Tour" value="{{ old('name') }}">
                            <label for="name">Nombre Tour</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <p class="show-on-small hide-on-med-and-up">Dueño</p>
                            <select name="company_id" id="company_id">
                                @foreach ($companies as $key => $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <label class="hide-on-small-and-down">Dueño</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="limit" class="" placeholder="Límite del Tour" value="{{ old('limit') }}">
                            <label for="limit">Límite</label>
                        </div>
                        {{-- <div class="input-field col s12 m4 offset-m1">
                            <input type="text" name="horario" class="timepicker" placeholder="Horario del Tour" value="{{ old('horario') }}">
                            <label for="horario">Horario</label>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="cost_kids" value="{{ old('cost_kids') ? old('cost_kids') : '0' }}">
                            <label for="cost_kids">Precio Niños</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="cost_adults" value="{{ old('cost_adults') ? old('cost_adults') : '0' }}">
                            <label for="cost_adults">Precio Adultos</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="cost_elders" value="{{ old('cost_elders') ? old('cost_elders') : '0' }}">
                            <label for="cost_elders">Precio INSEN</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <textarea id="description" name="description" class="materialize-textarea">Esta es la descripción de mi tour...</textarea>
                            <label for="description">Descripción</label>
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
