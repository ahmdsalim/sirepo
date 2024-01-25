@extends('layouts.app')
@section('title','Daftar')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card dgl-login">
                <header class="text-center">
                    <h1 class="dgl-title my-2">Daftar sebagai</h1>
                </header>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{route('register.sekolah')}}" class="btn btn-primary w-100 signin-btn">
                                Sekolah
                            </a>
                        </div>
                        <div class="col-md-12 mt-3">
                            <a href="{{route('register.siswa')}}" class="btn btn-primary w-100 signin-btn">
                                Siswa
                            </a>
                        </div>
                        <div class="col-md-12 mt-3">
                            <a href="{{route('register.guru')}}" class="btn btn-primary w-100 signin-btn">
                                Guru
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer footer-login text-center">
                    <span>Sudah punya akun? <a href="{{route('login')}}">Masuk</a></span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
