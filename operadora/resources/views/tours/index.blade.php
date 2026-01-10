@extends('layouts.app')

@section('content')

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col s12">
                    <h4>Administración de Tours {{ $company->name }}</h4>
                </div>

            </div>

            <div class="row">
                <div class="col s12">
                    <ul class="collection with-header">
                        <li class="collection-header">
                            <h5>Tours de {{ $company->name }}</h5>
                            <h6><i class="fas fa-check"></i>  Activo <br> <i class="fas fa-times"></i>  Inactivo</h6>
                        </li>
                        @forelse ($tours as $key => $tour)
                            <li class="collection-item">
                                <a href="{{ route('tours_show',['tour' => $tour->id ]) }}">

                                    @if ($tour->active)
                                        <i class="fas fa-check"></i>
                                    @else
                                        <i class="fas fa-times"></i>
                                    @endif

                                    {{ $tour->name }}
                                </a>
                            </li>
                        @empty
                            <li class="collection-item">
                                No hay tours agregados para este compañía
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

        </div>
    </div>

@endsection
