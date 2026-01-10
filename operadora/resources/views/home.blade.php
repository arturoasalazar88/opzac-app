@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12 m12">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>¡Hola! {{ Auth::user()->username }} </h3>

                </div>
            </div>
        </div>
    </div>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12 m12">
                    <div class="grid-container" style="grid-template-columns: repeat(2, 1fr);">
                        <a href="{{ route('company_select_create') }}" class="format-url green">
                            <span class="white-text">
                                <h6><b>Crear Reserva</b></h6>
                            </span>
                        </a>
                        <a href="{{ route('companies_reservations') }}" class="format-url green">
                            <span class="white-text">
                                <h6><b>Revisar</b></h6>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
    </div>
    <div class="section">
        <div class="container">
            <p>
                ¿Qué te gustaría hacer?
            </p>

            @if ( Auth::user()->isAdmin() )
                <ul class="collection with-header">
                    <li class="collection-header">
                        Administración Rápida
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('users_index') }}"><i class="fas fa-user"></i> Administrar Usuarios</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('zones_index') }}"><i class="fas fa-map-marked"></i>Administrar Zonas</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('hotels_index') }}"><i class="fas fa-hotel"></i>Administrar Hoteles</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('tours_index') }}"><i class="fas fa-bus"></i>Administrar Tours</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('index_logs') }}"><i class="fas fa-clipboard-list"></i>Logs del Sistema</a>
                    </li>
                </ul>
                <ul class="collection with-header">
                    <li class="collection-header">
                        Reportes
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('sales_index') }}?date1={{ Carbon\Carbon::now()->toDateString() }}&date2={{ Carbon\Carbon::now()->toDateString() }}"><i class="fas fa-chart-bar"></i>Reportes Ventas de Tours</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('sales_users') }}?date1={{ Carbon\Carbon::now()->toDateString() }}&date2={{ Carbon\Carbon::now()->toDateString() }}"><i class="fas fa-chart-pie"></i>Reportes Ventas de Usuario</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('sales_hotels') }}?date1={{ Carbon\Carbon::now()->toDateString() }}&date2={{ Carbon\Carbon::now()->toDateString() }}"><i class="fas fa-chart-pie"></i>Reportes Ventas de Hoteles</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('sales_dates') }}?date1={{ Carbon\Carbon::now()->toDateString() }}&date2={{ Carbon\Carbon::now()->toDateString() }}"><i class="fas fa-chart-line"></i>Reportes Ventas</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('sales_confirmed') }}?date1={{ Carbon\Carbon::now()->toDateString() }}&date2={{ Carbon\Carbon::now()->toDateString() }}"><i class="fas fa-chart-pie"></i>Reporte Confirmadas vs No Confirmadas</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('show_sales_today') }}?company_id=1"><i class="fas fa-chart-pie"></i>Reporte de Ventas del día Operadora</a>
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('show_sales_today') }}?company_id=2"><i class="fas fa-chart-pie"></i>Reporte de Ventas del día Maxibus</a>
                    </li>
                </ul>

                {{-- <ul class="collapsible">
                    <li>
                        <div class="collapsible-header"><i class="fas fa-chart-bar"></i>Reportes Operadora</div>
                        <div class="collapsible-body">
                            <span>
                                <a href="{{ route('sales_index') }}?date1={{ Carbon\Carbon::now()->toDateString() }}&date2={{ Carbon\Carbon::now()->toDateString() }}&company_id=1">Reportes Ventas de Tours</a>
                            </span><br/>
                            <span>
                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="collapsible-header"><i class="fas fa-chart-bar"></i>Reportes Maxibus</div>
                        <div class="collapsible-body">
                            <span>
                                <a href="{{ route('sales_index') }}?date1={{ Carbon\Carbon::now()->toDateString() }}&date2={{ Carbon\Carbon::now()->toDateString() }}&company_id=2">Reportes Ventas de Tours</a>
                            </span><br/>
                            <span>
                            </span>
                        </div>
                    </li>
                </ul> --}}

            @endif

            @if ( Auth::user()->canCreate() && !Auth::user()->isAdmin() )
                <ul class="collection with-header">
                    <li class="collection-header">
                        Administración Rápida
                    </li>
                    <li class="collection-item">
                        <a href="{{ route('tours_index') }}"><i class="fas fa-bus"></i>Administrar Tours</a>
                    </li>
                </ul>
            @endif
        </div>
    </div>
    <div class="section">
        <div class="container">
            <ul class="collection with-header">
                <li class="collection-header">
                    Acciones Rápidas
                </li>
                <li class="collection-item">
                    <a href="{{ route('company_select_create') }}">
                        <i class="fas fa-book"></i>
                        Crear reserva
                    </a>
                </li>
                {{-- <li class="collection-item">
                    <a href="{{ route('company_select_view') }}">
                        <i class="fas fa-eye"></i>
                        Ver reservas por compañía
                    </a>
                </li> --}}
                @if ( Auth::user()->isAdmin() || Auth::user()->role->type != "Recepción")
                    <li class="collection-item">
                        <a href="{{ route('company_select_view') }}">
                            <i class="fas fa-clipboard-check"></i>
                            Revisar Fecha y Tour
                        </a>
                    </li>
                @endif
                @if (Auth::user()->canReport())
                    <li class="collection-item">
                        <a href="{{ route('pickup_types') }}">
                            <i class="fas fa-list-ul"></i>
                            Reportes de recolección
                        </a>
                    </li>
                @endif
                <li class="collection-item">
                    <a href="{{ route('user_reservations') }}">
                        <i class="fas fa-address-book"></i>
                        Mis Reservaciones
                    </a>
                </li>
                <li class="collection-item">
                    <a href="{{ route('search_normal') }}">
                        <i class="fas fa-search"></i>
                        Busca y edita
                    </a>
                </li>
                @if ( Auth::user()->canConfirm() )
                    <li class="collection-item">
                        <a href="{{ route('search_approve_make') }}">
                            <i class="fas fa-search"></i>
                            Busca y confirma
                        </a>
                    </li>
                @endif
            </ul>
        </div>
    </div>

@endsection
