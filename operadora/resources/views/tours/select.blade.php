@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Selecciona la compañía</h4>
                </div>
            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Compañías</h5>
                        </li>
                    </ul>
                </div>
            </div>

        </div>
    </div>

    <div class="section">
        <div class="container">

            <div class="row">
                @foreach ($companies as $key => $company)
                    <div class="col s12 m6 l4">
                        <a href="{{ route('tours_company', ['company' => $company->id ]) }}">
                            <div class="card-panel teal">
                                <span class="white-text center">
                                    {{ $company->name }}
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="row">
                <div class="col s12">
                    <a href="{{ route('tours_create') }}" class="btn blue">Crea un Tour</a>
                </div>
            </div>

        </div>
    </div>

@endsection
