@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h4>Editar tipo de autobus para la salida</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <h5>Horario <b>{{ $departure->horario }} - {{ $departure->type == 0 ? 'Verde' : 'Rosa'}}</b></h5>
                </div>
            </div>

            <div class="row">
                <form class="col s12" action="{{ route('departures_update',['departure'=>$departure->id]) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="input-field col s12 m4">
                            <select name="type">
                                <option value="0" {{ $departure->type == 0 ? "selected" : ""}}>Grande ( {{ $departure->type == 0 ? 'Verde' : 'Rosa'}} - {{ $departure->getTypes(0) }} Asientos)</option>
                                <option value="1" {{ $departure->type == 1 ? "selected" : ""}}>Pequeño ( {{ $departure->type == 0 ? 'Verde' : 'Rosa'}} - {{ $departure->getTypes(1) }} Asientos)</option>
                            </select>
                            <label>Selecciona el tipo de autobus</label>
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
