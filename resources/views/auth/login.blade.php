@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Login</h5>
                        <p class="text-muted">Silahkan login ke akun Anda</p>
                    </div>
                    <div class="card-body">
                        <form class="row g-3" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="col-md-12">
                                <label for="username" class="form-label">Username</label>
                                <input id="username" type="text"
                                    class="form-control input-login @error('username') is-invalid @enderror" name="username"
                                    value="{{ old('username') }}" required autocomplete="username" autofocus>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-12">
                                <label for="password" class="form-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control input-login @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                            <div class="col-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                        {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                            <div class="col-6 text-end">
                                <a href="{{ route('password.request') }}">
                                    Lupa Password?
                                </a>
                            </div>
                            <div class="col-md-12 mt-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    Masuk
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer text-center pt-0 border-0">
                        <span>Belum punya akun? <a href="{{ route('register') }}">Daftar</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="toast-container position-fixed top-0 end-0 p-3">
        <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header">
                <svg class="bd-placeholder-img rounded me-2" width="20" height="20"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice"
                    focusable="false">
                    <rect width="100%" height="100%" fill="#198754" id="toastRect"></rect>
                </svg>
                <strong class="me-auto" id="toastType">Success</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body" id="toastMessage">
                Berhasil membuat akun.
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script>
        function toast(color = "#198754", type = "Success", message =
            "Berhasil membuat akun, tunggu konfirmasi dari admin") {
            $("#toastRect").attr("fill", color)
            $("#toastType").text(type)
            $("#toastMessage").text(message)
            const toastContainer = $("#liveToast")
            const toast = new bootstrap.Toast(toastContainer)
            toast.show()
        }
        @if (session('success'))
            toast(undefined, undefined, undefined)
        @endif
    </script>
@endpush
