@if ($errors->any())
  <div class="col s12 m8 offset-m2">
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $key => $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  </div>
@endif
