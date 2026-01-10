@extends('layouts.app')

@section('content')

    <div class="section" id="users-create">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h3>Creación de Usuarios</h3>
                </div>
            </div>
            <div class="row">

                @include('layouts.errors')

                <form class="col s12 m12" action="{{ route('users_store') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col s12">
                            <legend class="blue darken-4">Información del nuevo usuario</legend>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="text" name="name" class="" placeholder="Nombre" value="{{ old('name') }}">
                            <label for="name">Nombre Completo</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <input type="text" name="username" class="" placeholder="Nombre de Usuario" value="{{ old('username') }}">
                            <label for="name">Nombre de Usuario (nombre en pantalla)</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <p class="show-on-small hide-on-med-and-up">Hotel / Lugar</p>
                            <select name="hotel_id" id="hotel_id">
                                @foreach ($hotels as $key => $hotel)
                                    <option value="{{ $hotel->id }}">{{ $hotel->name }}</option>
                                @endforeach
                            </select>
                            <label class="hide-on-small-and-down">Hotel / Lugar</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <p class="show-on-small hide-on-med-and-up">Compañía</p>
                            <select name="company_id" id="company_id">
                                @foreach ($companies as $key => $company)
                                    <option value="{{ $company->id }}">{{ $company->name }}</option>
                                @endforeach
                            </select>
                            <label class="hide-on-small-and-down">Compañía</label>
                            <p><b><i>* Para el rol de recepcionista este dato no afecta su funcionamiento</i></b></p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="email" name="email" class="" placeholder="Email" value="{{ old('email') }}">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="password" name="password" class="" placeholder="Contraseña">
                            <label for="password_confirm">Contraseña</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="password" name="password_confirmation" class="" placeholder="Confirma Contraseña">
                            <label for="password_confirmation">Confirma Contraseña</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 m6">
                            <p class="show-on-small hide-on-med-and-up">Rol</p>
                            <select name="role_id" id="role_id">
                                @foreach ($roles as $key => $role)
                                    <option value="{{ $role->id }}">{{ $role->type }}</option>
                                @endforeach
                            </select>
                            <label class="hide-on-small-and-down">Rol</label>
                        </div>
                        <div class="input-field col s12 m6">
                            <p>
                                <label>
                                    <input type="checkbox" class="filled-in" name="is_admin" id="is_admin"/>
                                    <span>Administrador</span>
                                </label>
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s12">
                            <p><b><i>* Las comisiones las podrás agregar depués de crear el usuario</i></b></p>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="input-field col s12 m4">
                            <input type="number" name="comission_kids" class="" placeholder="Comision" value="{{ old('comission_kids') }}">
                            <label for="rol">Comisión Niños</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="comission_adults" class="" placeholder="Comisión" value="{{ old('comission_adults') }}">
                            <label for="rol">Comisión Adultos</label>
                        </div>
                        <div class="input-field col s12 m4">
                            <input type="number" name="comission_elders" class="" placeholder="Comisión" value="{{ old('comission_elders') }}">
                            <label for="rol">Comisión INSEN</label>
                        </div>
                    </div> --}}
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
