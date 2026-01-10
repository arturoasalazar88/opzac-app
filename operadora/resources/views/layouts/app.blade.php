<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <!-- First Realese -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width">
    <meta name="mobile-web-app-capable" content="yes">
    <link rel="icon" sizes="192x192" href="/icon.png">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Compiled and minified CSS -->
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->
    <link href="{{ asset('css/materialize.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css?v=2.2') }}" rel="stylesheet">


    <!-- Compiled and minified JavaScript -->
    <script src="{{ asset('js/jQuery.js') }}"></script>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>-->
    <script src="{{ asset('js/materialize.min.js') }}"></script>
    <script src="{{ asset('js/init.js?v=2.1') }}"></script>
</head>
<body>
    <div id="app">
        <div class="navbar-fixed">

            <nav class="blue darken-4" role="navigation">
                <div class="nav-wrapper container">
                    <a id="logo-container" class="brand-logo" href="{{ url('/home') }}">
                        {{-- {{ config('app.name', 'Laravel') }} --}}
                        Inicio
                    </a>
                    <ul class="right hide-on-med-and-down">
                        <!-- This links will show to anyone -->
                        <!--<li><a href="#">To All Links</a></li>-->
                        <!-- Authentication Links -->
                        @guest
                            <li>
                                <a href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            {{-- @if (Route::has('register'))
                                <li>
                                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif --}}
                        @else
                            @if ( Auth::user()->canConfirm() )
                                <li>
                                    <a href="{{ route('search_approve_make') }}">
                                        Confirmar
                                    </a>
                                </li>
                            @endif
                            @if ( Auth::user()->isAdmin() )
                                <li>
                                    <a class="dropdown-trigger" href="#!" data-target="dropdown-hotels">
                                        Hoteles <i class="material-icons right">arrow_drop_down</i>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-trigger" href="#!" data-target="dropdown-users">
                                        Usuarios <i class="material-icons right">arrow_drop_down</i>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-trigger" href="#!" data-target="dropdown-zones">
                                        Zonas <i class="material-icons right">arrow_drop_down</i>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-trigger" href="#!" data-target="dropdown-tours">
                                        Tours <i class="material-icons right">arrow_drop_down</i>
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-trigger" href="#!" data-target="dropdown-reservations">
                                    Reservas <i class="material-icons right">arrow_drop_down</i>
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-trigger" href="#!" data-target="dropdown1" style="background-color: rgba(0,0,0,0.2);">
                                    {{ Auth::user()->username }} ({{ Auth::user()->role->type }}) {{ Auth::user()->isAdmin() ? '(Admin)' : ''}} ({{ Auth::user()->company->name}}) <!--<i class="material-icons right">arrow_drop_down</i>-->
                                </a>
                            </li>

                        @endguest
                    </ul>


                    <a href="#" data-target="nav-mobile" class="sidenav-trigger"><i class="fa fa-bars"></i></a>
                    <!-- End Nav Mobile -->
                </div>
            </nav>

        </div>

        <!-- Nav Mobile -->
        <ul id="nav-mobile" class="sidenav">

            @guest
                <li>
                    {{-- <a href="{{ route('login') }}">{{ __('Login') }}</a> --}}
                    <a href="#">
                        Bienvenido a Operadora <br>
                        Logeate Primero
                    </a>
                </li>
            @else
                <li><div class="divider"></div></li>
                <li>
                    <a href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                <li><div class="divider"></div></li>
                <li>
                    <a href="{{ route('company_select_create') }}">Crear Reserva</a>
                </li>
                <li>
                    <a href="{{ route('search_normal') }}">B�squeda</a>
                </li>
                <li>
                    <a href="{{ route('search_approve_make') }}">Busca y confirma</a>
                </li>
                <li>
                    <a href="{{ route('user_reservations') }}">Mis Reservaciones</a>
                </li>
                <li>
                    <a href="{{ route('pickup_types') }}">Reportes de Recolección</a>
                </li>
                {{-- Auth User but not admin  --}}
                {{-- Mobile Menu Bar Tours --}}
                <li class="no-padding">
                    <ul class="collapsible collapsible-accordion">
                        <li>
                            <a class="collapsible-header">Reservaciones<i class="material-icons">arrow_drop_down</i></a>
                            <div class="collapsible-body">
                                <ul>
                                    <li>
                                        <a href="{{route('company_select_view')}}">Ver</a>
                                    </li>
                                    <li>
                                        <a href="{{route('company_select_create')}}">Crear Nueva</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>

                <li><div class="divider"></div></li>
                @if ( Auth::user()->isAdmin() )
                    <li><a class="subheader">Administrar</a></li>
                    <li><div class="divider"></div></li>
                    {{-- Mobile Menu Bar Users --}}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Usuarios<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <a href="{{route('users_index')}}">Ver Todos</a>
                                        </li>
                                        <li>
                                            <a href="{{route('users_create')}}">Crear Nuevo</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    {{-- Mobile Menu Bar Hotels --}}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Hoteles<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <a href="{{route('hotels_index')}}">Ver Todos</a>
                                        </li>
                                        <li>
                                            <a href="{{route('hotels_create')}}">Crear Nuevo</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    {{-- Mobile Menu Bar Zones --}}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Zonas<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <a href="{{route('zones_index')}}">Adminsitrar Zonas</a>
                                        </li>
                                        <li>
                                            <a href="{{route('zones_create')}}">Crear Nueva</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                    {{-- Mobile Menu Bar Tours --}}
                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header">Tours<i class="material-icons">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <li>
                                            <a href="{{route('tours_index')}}">Ver</a>
                                        </li>
                                        <li>
                                            <a href="{{route('tours_create')}}">Crear Nuevo</a>
                                        </li>
                                        {{-- <li>
                                            <a href="#!">Revisar Tour</a>
                                        </li> --}}
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>
                @endif

            @endguest
        </ul>

        <ul id="dropdown-hotels" class="dropdown-content">
            <li>
                <a href="{{route('hotels_index')}}">Ver Todos</a>
            </li>
            <li>
                <a href="{{route('hotels_create')}}">Crear Nuevo</a>
            </li>
        </ul>
        <ul id="dropdown-reservations" class="dropdown-content">
            <li>
                <a href="{{route('company_select_view')}}">Ver</a>
            </li>
            <li>
                <a href="{{route('company_select_create')}}">Crear Nueva</a>
            </li>
            @if (Auth::check())
                @if ( Auth::user()->isAdmin() || Auth::user()->role->type != "Recepción")
                    <li>
                        <a href="{{ route('company_select_view') }}">Revisar Tour</a>
                    </li>
                @endif
            @endif
            <li>
                <a href="{{ route('search_normal') }}">Busca y Edita</a>
            </li>
        </ul>
        <ul id="dropdown-users" class="dropdown-content">
            <li>
                <a href="{{route('users_index')}}">Ver Todos</a>
            </li>
            <li>
                <a href="{{route('users_create')}}">Crear Nuevo</a>
            </li>
        </ul>
        <ul id="dropdown-zones" class="dropdown-content">
            <li>
                <a href="{{route('zones_index')}}">Administrar Zonas</a>
            </li>
            <li>
                <a href="{{route('zones_create')}}">Crear Nueva</a>
            </li>
        </ul>
        <ul id="dropdown-tours" class="dropdown-content">
            <li>
                <a href="{{route('tours_index')}}">Ver Todos</a>
            </li>
            <li>
                <a href="{{route('tours_create')}}">Crear Nuevo</a>
            </li>
        </ul>
        <ul id="dropdown1" class="dropdown-content">
            <li>
                <a href="{{ route('user_reservations') }}">Mis Reservaciones</a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </li>
        </ul>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @auth
        <footer>
            {{-- {{ Carbon\Carbon::setLocale('es') }} --}}
                <div class="" style="display: inline-block; float: left;">
                    Usuario <b>{{ Auth::user()->username }}</b>
                </div>
            Hoy es:
            {{ Carbon\Carbon::now()->toFormattedDateString() }} !
        </footer>
    @endauth
    <script>
        jQuery( document ).ready(
            function(){
                $('.modal').modal();
                console.log("fdsfs")
            }
        );
    </script>
</body>
</html>
