@extends('layouts.app')
@push('styles')
    <style>
        .field-icon {
            float: right;
            margin-left: -30px;
            margin-right: 10px;
            margin-top: -27px;
            cursor: pointer;
            position: relative;
            z-index: 2;
        }
    </style>
@endpush
@section('content')
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Daftar Akun</h5>
                        <p class="text-muted">Silahkan isi form dibawah ini untuk membuat akun</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('register') }}" method="post" class="needs-validation" novalidate
                            enctype="multipart/form-data">
                            @csrf

                            <div class="col-md-12 mb-2">
                                <label for="npm" class="form-label">NPM</label>
                                <input id="npm" type="text" class="form-control @error('npm') is-invalid @enderror"
                                    name="npm" value="{{ old('npm') }}" required autocomplete="npm" autofocus>

                                @error('npm')
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
@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
@endpush
