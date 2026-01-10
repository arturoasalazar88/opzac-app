@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h5 class="blue darken-4 teal-title">
                        Elige el tipo de revisión
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="section" id="reservations-tour-container">
        <div class="container">
            <div class="row">
                <!-- Type -->
                <div class="col s12 m6 l6">
                    <a href="{{ route('tour_select_company_before_zone') }}">
                        <div class="card-panel indigo">
                            <span class="white-text center">
                                Zonas
                            </span>
                        </div>
                    </a>
                </div>
                <!-- End Type -->
                <!-- Type -->
                <div class="col s12 m6 l6">
                    <a href="#!">
                        <div class="card-panel indigo">
                            <span class="white-text center">
                                Horario
                            </span>
                        </div>
                    </a>
                </div>
                <!-- End Type -->
                <!-- Type -->
                <div class="col s12 m6 l6">
                    <a href="#!">
                        <div class="card-panel indigo">
                            <span class="white-text center">
                                Tours
                            </span>
                        </div>
                    </a>
                </div>
                <!-- End Type -->
                <!-- Type -->
                <div class="col s12 m6 l6">
                    <a href="#!">
                        <div class="card-panel indigo">
                            <span class="white-text center">
                                Hotel
                            </span>
                        </div>
                    </a>
                </div>
                <!-- End Type -->
            </div>
        </div>
    </div>

@endsection
