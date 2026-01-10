@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Modifica comisiones al usuario</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {!! session('status') !!}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ route('users_update_commission', ['commission' => $commission->id]) }}" method="post">
                {{-- <form class="col s12 m12" action="#!" method="post"> --}}
                    @method('PUT')
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <legend>Información de la comisión</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" name="" value="{{ $commission->tour->name }}" disabled>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="kids" class="" placeholder="Comisión de niños" value="{{ $commission->kids }}">
                            <label for="kids">Comisión de niños</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="adults" class="" placeholder="Comisión de niños" value="{{ $commission->adults }}">
                            <label for="adults">Comisión de adultos</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="elders" class="" placeholder="Comisión de niños" value="{{ $commission->elders }}">
                            <label for="elders">Comisión de INSEN</label>
                        </div>
                        <div class="input-field col s12">
                            <input type="submit" value="Editar" class="btn orange darken-3">
                        </div>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col s12">
                    <h5>Comisiones ya asignadas</h5>
                </div>
                <div class="col s12">
                    <table class="striped">
                        <thead class="collection-header">
                            <tr>
                                <th>Tour</th>
                                <th>Niños</th>
                                <th>Adultos</th>
                                <th>INSEN</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user->commissions as $key => $commission)
                                <tr>
                                    <td>{{ $commission->tour->name }}</td>
                                    <td>{{ $commission->kids }}</td>
                                    <td>{{ $commission->adults }}</td>
                                    <td>{{ $commission->elders }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="10" class="alert alert-danger">
                                        No hay comisiones asignadas a este usuario.<br>
                                        ¡Intenta añadir algunas!
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

@endsection
