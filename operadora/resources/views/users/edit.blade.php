@extends('layouts.app')

@section('content')
    <div class="section">
        <div class="container">

            <div class="row">
                <div class="col s12">
                    <h4>Editar usuario</h4>
                </div>
            </div>

            <div class="row">
                <form class="col s12" action="{{ route('users_update',['user'=>$user->id]) }}" method="post">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" value="{{ $user->name }}">
                            <label for="name">Nombre Completo</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="username" value="{{ $user->username }}">
                            <label for="username">Username</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <p class="show-on-small hide-on-med-and-up">Hotel / Lugar</p>
                            <select name="hotel_id" id="hotel_id">
                                @foreach ($hotels as $key => $hotel)
                                    <option value="{{ $hotel->id }}" {{ $hotel->id == $user->hotel->id ? "selected" : ""}} >{{ $hotel->name }} </option>
                                @endforeach
                            </select>
                            <label class="hide-on-small-and-down">Hotel / Lugar</label>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="comission_kids" value="{{ $user->comission_kids }}">
                            <label for="comission_kids">Comisión Niños</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="comission_adults" value="{{ $user->comission_adults }}">
                            <label for="comission_adults">Comisión Adultos</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="comission_elders" value="{{ $user->comission_elders }}">
                            <label for="comission_elders">Comisión INSEN</label>
                        </div>
                    </div> --}}
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <p class="show-on-small hide-on-med-and-up">Rol</p>
                            <select name="role_id" id="role_id">
                                @foreach ($roles as $key => $role)
                                    <option value="{{ $role->id }}" {{ $role->id == $user->role->id ? 'selected' : ' '}}>{{ $role->type }}</option>
                                @endforeach
                            </select>
                            <label class="hide-on-small-and-down">Rol</label>
                        </div>
                    </div>
                    <div class="input-field col s12 m6">
                        <p>
                            <label>
                                <input type="checkbox" class="filled-in" name="is_admin" id="is_admin" {{ $user->isAdmin() ? 'checked' : '' }}/>
                                <span>Administrador</span>
                            </label>
                        </p>
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
