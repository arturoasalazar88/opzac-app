@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h4>Editar Tour</h4>
                </div>
            </div>

            <div class="row">

                @include('layouts.errors')
                <form class="col s12" action="{{ route('tours_update',['tour'=>$tour->id]) }}" method="post">
                    @method('PUT')
                    @csrf

                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" value="{{ $tour->name }}">
                            <label for="name">Nombre</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <p class="show-on-small hide-on-med-and-up">Dueño</p>
                            <select name="company_id" id="company_id">
                                @foreach ($companies as $key => $company)
                                    <option value="{{ $company->id }}" {{ $company->id == $tour->company_id ? 'selected' : '' }}>{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <label class="hide-on-small-and-down">Dueño</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="limit" class="" placeholder="Límite del Tour" value="{{ $tour->limit }}">
                            <label for="limit">Límite</label>
                        </div>
                        {{-- <div class="input-field col s12 m4 offset-m1">
                            <input type="text" name="horario" class="timepicker" placeholder="Horario del Tour" value="{{ $tour->horario }}">
                            <label for="horario">Horario</label>
                        </div> --}}
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <p class="show-on-small hide-on-med-and-up">Status</p>
                            <select name="active" id="role">
                                <option value="0">Inactivo</option>
                                <option value="1" {{ $tour->active ? 'selected' : '' }}>Activo</option>
                            </select>
                            <label for="active" class="hide-on-small-and-down">Status</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="cost_kids" value="{{ $tour->cost_kids }}">
                            <label for="cost_kids">Precio Niños</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="cost_adults" value="{{ $tour->cost_adults }}">
                            <label for="cost_adults">Precio Adultos</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="cost_elders" value="{{ $tour->cost_elders }}">
                            <label for="cost_elders">Precio INSEN</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m12">
                            <textarea id="description" name="description" class="materialize-textarea">{{ $tour->description }}</textarea>
                            <label for="description">Descripción</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" value="Editar" class="btn red">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
