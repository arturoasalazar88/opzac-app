@extends('layouts.app')

@section('content')
<div class="section">
  <div class="container">
    <div class="row" id="form-login-container">

      <span>Bienvenido, logeate primero</span>

      <form class="col s12 m6 offset-m3" method="POST" action="{{ route('login') }}">
          @csrf

          {{-- <div class="row">
              <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

              <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>

              </div>
          </div> --}}
          <div class="row">
              <label for="username" class="col-md-4 col-form-label text-md-right">Username</label>

              <div class="col-md-6">
                  <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" autofocus>

              </div>
          </div>

          <div class="row">
              <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

              <div class="col-md-6">
                  <input id="password" type="password" class="form-control" name="password">

              </div>
          </div>

          {{-- <div class="row">
              <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                      <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                      <label class="form-check-label" for="remember">
                          {{ __('Remember Me') }}
                      </label>
                  </div>
              </div>
          </div> --}}

          <div class="row mb-0">
              <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn">
                      {{ __('Login') }}
                  </button>
                  <!--
                  @if (Route::has('password.request'))
                      <a class="btn btn-link" href="{{ route('password.request') }}">
                          {{ __('Forgot Your Password?') }}
                      </a>
                  @endif-->
              </div>
          </div>
      </form>

      @include('layouts.errors')

    </div>
  </div>
</div>
@endsection
