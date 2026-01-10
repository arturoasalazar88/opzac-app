@extends('layouts.app')

@section('content')

  <div class="section">
    <div class="container">

      <div class="row">
        <div class="col s12">
          <h4>Show a project</h4>
        </div>
      </div>

      <div class="row">
        <div class="col s12">
          <h4>{{ $project->title }}</h4>
        </div>
        <div class="col s12">
          <p>
            {{ $project->description }}
          </p>
        </div>
        <div class="col s12">
          <a href="{{ $project->id }}/edit" class="btn red">Edit</a>
        </div>
        @if ($project->tasks->count())
          <div class="col s12">
            <div class="collection">
              @foreach ($project->tasks as $key => $task)
                <div class="collection-item">
                  <form method="POST" action="{{ route('tasks_update',['user'=>$task->id]) }}">
                    @method('PATCH')
                    @csrf
                    <p>
                      <label>
                        <input type="checkbox" name="completed" onchange="this.form.submit()" {{ $task->completed ? 'checked' : ''}}/>
                        <span class="{{ $task->completed ? 'is-completed' : ''}}">{{ $task->description }}</span>
                      </label>
                    </p>
                  </form>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      </div>

      <div class="row">

        @include('layouts.errors')
        <!--<form action="/laravel/operadora/public/projects/{{$project->id}}/task" method="post" class="col s12 card blue-grey darken-3" style="padding: 15px 20px;">-->
        <form action="{{route('tasks_store',['project'=>$project->id]) }}" method="post" class="col s12 card blue-grey darken-3" style="padding: 15px 20px;">
          @csrf
          <div class="row">
            <div class="input-field col s12">
              <input type="text" name="task" placeholder="New Task">
              <label for="title">New Task</label>
            </div>
          </div>
          <div class="row">
            <div class="input-field col s12">
              <input type="submit" name="submit" class="btn btn-success" value="Create Task">
            </div>
          </div>
        </form>
      </div>

    </div>
  </div>
@endsection
