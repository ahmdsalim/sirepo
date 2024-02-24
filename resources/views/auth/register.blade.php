@extends('layouts.app')
@section('content')
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Daftar Akun</h5>
                        <p class="text-muted">Silahkan isi form untuk membuat akun</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="post" class="needs-validation" novalidate
                            enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-12 mb-2">
                                <label for="nama" class="form-label">Nama</label>
                                <input id="nama" type="text"
                                    class="form-control @error('nama') is-invalid @enderror" name="nama"
                                    value="{{ old('nama') }}" required autocomplete="nama" autofocus>

                                @error('nama')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input id="username" type="username"
                                    class="form-control @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mb-2">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password" required>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="ktm" class="form-label">Upload KTM</label>
                                <input id="ktm" type="file" class="form-control @error('ktm') is-invalid @enderror"
                                    name="ktm" required>

                                @error('ktm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    Daftar
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center pt-0 border-0">
                        <span>Sudah punya akun? <a href="{{ route('login') }}">Masuk</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
