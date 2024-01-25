@extends('layouts.app')
@section('title','Kirim Ulang E-mail')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card px-4 py-2">
                <div class="card-body">
                    <h4 class="mb-3">Kirim Ulang Email Aktivasi</h4>
                    @if(session('resend'))
                    <div class="alert alert-info" role="alert">
                        Link aktivasi baru telah dikirim ke alamat email Anda.
                    </div>
                    @endif
                    @if(Session::has('message'))
                    <div class="alert alert-danger" role="alert">
                        {{Session::get('message')}}
                    </div>
                    @endif
                    <form class="row g-3" method="POST" action="{{route('register.verify.resend')}}">
                        @csrf
                        <div class="col-md-12">
                            <input  type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Masukkan email Anda">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-primary w-100">
                                Kirim
                            </button>
                        </div>
                    </form>                   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection