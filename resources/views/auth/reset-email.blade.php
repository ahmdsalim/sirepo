@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card px-4 py-2">
                <div class="card-body">
                    <h4 class="mb-3">Reset Email</h4>
                    @if(session('reset'))
                    <div class="alert alert-info" role="alert">
                        Link aktivasi telah dikirim ke alamat email baru Anda.
                    </div>
                    @endif
                    @if(Session::has('message'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <form class="row g-3" method="POST" action="{{route('reset.email.post')}}">
                        @csrf
                        <div class="col-md-12">
                            <label class="form-label">Email Lama</label>
                            <input  type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Masukkan email lama Anda">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Email Baru</label>
                            <input  type="email" class="form-control @error('new_email') is-invalid @enderror" name="new_email" value="{{ old('new_email') }}" required placeholder="Masukkan email baru Anda">

                            @error('new_email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Password</label>
                            <input  type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" required placeholder="Masukkan password akun Anda">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary w-100">
                                Reset
                            </button>
                        </div>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection