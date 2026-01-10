@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">
      <h2>Hello From Projects</h2>

      <ul>
        @foreach ($projects as $key => $project)
        <li>
          <a href="projects/{{ $project->id }}">
            {{ $key }} - {{ $project->title }}
          </a>
        </li>
        @endforeach
      </ul>

      <a href="{{ route('create_project') }}" class="btn blue">Create a New One</a>
    </div>
  </div>

@endsection
