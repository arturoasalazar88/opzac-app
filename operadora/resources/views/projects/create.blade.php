@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">
      <h4>Create a Project</h4>
      <div class="row">
        <form class="col s12" action="{{ route('projects_store') }}" method="POST">
          {{ csrf_field() }}
          <div class="row">
            <div class="input-field col s12">
              <input type="text" name="title" class="{{ $errors->has('title') ? 'invalid' : '' }}" value="{{ old('title') }}">
              <label for="title">Title</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea name="description" rows="8" cols="80" class="materialize-textarea"></textarea>
              <label for="description">Description</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <button type="submit" class="btn" name="button">Create</button>
            </div>
          </div>
        </form>

        @include('layouts.errors')

      </div>
    </div>
  </div>

@endsection
