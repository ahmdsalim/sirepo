@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>{{ __('Login') }}</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="username" class="col-md-4 col-form-label text-md-end">Username</label>

                                <div class="col-md-6">
                                    <input id="username" type="text"
                                        class="form-control @error('username') is-invalid @enderror" name="username"
                                        value="{{ old('username') }}" required autocomplete="username" autofocus>

                                    @error('username')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-0  ">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary btn-block mb-2">
                                        {{ __('Login') }}
                                    </button>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <p class="text-center m-0">Belum punya akun?<a href="{{ route('register') }}"
                                            class="text-decoration-none"> Daftar</a></p>
                                </div>
                                <div class="col-md-6 offset-md-4">
                                    <p class="text-center">
                                        @if (Route::has('password.request'))
                                            <a class="btn btn-link text-decoration-none text-center"
                                                href="{{ route('password.request') }}">
                                                {{ __('Lupa password?') }}
                                            </a>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection