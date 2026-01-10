@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">

      <div class="row">
        <div class="col s12">
          <h4>Edit a Project</h4>
        </div>
      </div>

      <div class="row">
        <form class="col s12" action="/laravel/operadora/public/projects/{{ $project->id }}" method="post">
          @method('PATCH')
          @csrf

          <div class="row">
            <div class="input-field col s12">
              <input type="text" name="title" placeholder="Title" value="{{ $project->title }}">
              <label for="title">Title</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <textarea id="description" name="description" rows="8" cols="80" class="materialize-textarea">{{ $project->description }}</textarea>
              <label for="description">Description</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="submit" class="btn" name="submit" value="Update Project">
            </div>
          </div>
        </form>
      </div>

      <div class="row">
        <form class="col s12" action="/laravel/operadora/public/projects/{{ $project->id }}" method="post">
          @method('DELETE')
          @csrf
          <div class="row">
            <div class="input-field col s12">
              <input type="submit" class="btn deep-orange" name="submit" value="Delete Project">
            </div>
          </div>
        </form>
      </div>

    </div><!-- end container !-->
  </div><!--end section -->

@endsection
