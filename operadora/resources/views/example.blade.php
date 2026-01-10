@extends('layouts.app')

@section('title','Example Page')

@section('content')

  <div class="section">
    <div class="container">
      <h2>Here it's my section</h2>

      @foreach ($tasks as $task)
        <h4>{{ $task }}</h4>
      @endforeach

      <h5>{{ $foo }}</h5> 
    </div>
  </div>

@endsection
