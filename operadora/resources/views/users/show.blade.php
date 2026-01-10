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
                            <h5>Usuario : {{ $user->name }}</h5>
                        </div>
                        <div class="collection-item">
                            <b>Correo</b> {{ $user->email }}
                        </div>
                        <div class="collection-item">
                            <b>Username</b> {{ $user->username }}
                        </div>
                        <div class="collection-item">
                            <b>Rol</b> {{ $user->role->type }}
                        </div>
                        <div class="collection-item">
                            <b>Hotel</b> {{ $user->hotel->name }}
                        </div>
                        {{-- <div class="collection-item">
                            <b>Comisión Niños</b> {{ $user->comission_kids }}
                        </div>
                        <div class="collection-item">
                            <b>Comisión Adultos</b> {{ $user->comission_adults }}
                        </div>
                        <div class="collection-item">
                            <b>Comisión INSEN</b> {{ $user->comission_elders }}
                        </div> --}}
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <a href="{{ route('users_edit',['user'=>$user->id]) }}" class="btn btn-blue">Edita Usuario</a>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    {{-- <a class="modal-trigger canceltrigger" href="#modal1" id="{{ $user->id }}">HOLA</a> --}}
                    <a class="btn red modal-trigger" href="#modal1">Borrar Usuario</a>
                    <form id="delete-user" action="{{ route('users_destroy',['user'=>$user->id]) }}" method="post" style="display:none;">
                        @csrf
                        @method("DELETE")
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <h5>Tabla de comisiones</h5>
                </div>
                <div class="col s12">
                    <table class="striped">
                        <thead class="collection-header">
                            <tr>
                                <th>Tour</th>
                                <th>Niños</th>
                                <th>Adultos</th>
                                <th>INSEN</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($user->commissions as $key => $commission)
                                <tr>
                                    <td>{{ $commission->tour->name }}</td>
                                    <td>{{ $commission->kids }}</td>
                                    <td>{{ $commission->adults }}</td>
                                    <td>{{ $commission->elders }}</td>
                                    <td>
                                        <a href="{{ route('users_edit_commission', ['user'=> $user->id, 'commission'=>$commission->id]) }}"><i class="fas fa-edit"></i></a>
                                    </td>
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

            <div class="row">
                {{-- <div class="col s12 m2">
                    <a href="{{ route('users_edit',['user'=>$user->id]) }}" class="btn btn-blue">Edita Comisiones</a>
                </div> --}}
                <div class="col s12 m2">
                    <a href="{{ route('users_add_commission',['user'=>$user->id]) }}" class="btn orange">Añade Comisión</a>
                </div>
            </div>

        </div>
        <!-- Modal Structure -->
        <div id="modal1" class="modal">
            <div class="modal-content">
                <h4>Confirma</h4>
                <p>¿Realmente deseas borrar este usuario?</p>
                <p>Esta acción no se puede deshacer</p>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat teal white-text">Cancelar</a>
                <a href="#!" id="agree" class="waves-effect waves-green btn-flat red white-text">Aceptar</a>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $( document ).ready( function () {

            $('.modal').modal();

            $('#agree').on('click', function(event) {
                event.preventDefault();
                $('#delete-user').submit();
            });
        });
    </script>

@endsection
