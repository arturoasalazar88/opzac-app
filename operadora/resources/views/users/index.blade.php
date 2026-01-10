@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">
      <div class="row">
        <div class="col s12">
          <h4>Administración de usuarios</h4>
        </div>

      </div>

      @if ( session('status') )
        <div class="row">
            <div class="col s12">
                <div class="alert alert-danger">
                    {{ session('status') }}
                </div>
            </div>
        </div>
      @endif

      <div class="row">
        <div class="col s12">
          <ul class="collection with-header">
            <li class="collection-header">
              <h6>Listado de Usuarios</h6>
            </li>
            @foreach ($users as $key => $user)
              <li class="collection-item">
                <a href="{{ route('users_show', ['user' => $user->id]) }}">
                  {{ $user->name }}
                </a>
                <br />
                ({{ $user->role->type }} - {{ $user->hotel->name }})
                <b style="display: block;"><a href="{{ route('user_single_reservations', ['user' => $user->id]) }}">Ver Reservas</a></b>
              </li>
            @endforeach
          </ul>

          {{ $users->links() }}
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <a href="{{ route('users_create') }}" class="btn blue">Crea un usuario </a>
        </div>
      </div>
    </div>
  </div>

@endsection
