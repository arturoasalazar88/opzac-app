@extends('layouts.app')

@section('content')

    <div class="section">
        <div>

            <div class="row">
                <div class="col s12">
                    <h4>Logs del Sistema</h4>
                </div>
            </div>

            @if(isset($message))
                <div class="row">
                    <div class="col s12">
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    </div>
                </div>
            @endif
            <div class="row py-2">
                <div class="col-md-12">
                    <div class="container">
                        <form class="form-inline" method="post" action="{{ route('index_logs') }}">
                            @csrf
                            <div class="form-group mb-2">
                                <label for="staticEmail2" class="sr-only">Busqueda</label>
                                <input type="text" class="form-control" name="q" placeholder="Busca aquí" style="min-width:45vw;">
                            </div>
                            <button type="submit" class="btn btn-warning mb-2">Buscar</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <table class="striped highlight table-content" style="max-width: 100%; overflow: scroll;">
                        <thead>
                            <tr>
                                <th>Registro</th>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Compañía</th>
                                <th>Controlador</th>
                                <th>Función</th>
                                <th>Acción</th>
                                <th>Método</th>
                                <th>Tour</th>
                                <th>Día</th>
                                <th>Parámetros</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($logs as $key => $log)
                                <tr>
                                    <td>{{ $log->created_at }}</td>
                                    <td>{{ $log->user }}</td>
                                    <td>{{ $log->rol }}</td>
                                    <td>{{ $log->company }}</td>
                                    <td>{{ $log->controller }}</td>
                                    <td>{{ $log->function }}</td>
                                    <td>{{ $log->action }}</td>
                                    <td>{{ $log->method }}</td>
                                    <td>{{ $log->tour }}</td>
                                    <td>{{ $log->day }}</td>
                                    <td style="word-break: break-word;">{{ $log->parameter }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

    <script type="text/javascript">
        $( document ).ready( function() {

        });
    </script>

@endsection
