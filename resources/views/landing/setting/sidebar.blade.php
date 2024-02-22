@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 mb-3 ">
            <button onclick="history.back()" class="btn icon btn-md icon-left bg-white"><svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" viewBox="0 0 1024 1024">
                    <path fill="currentColor"
                        d="M685.248 104.704a64 64 0 0 1 0 90.496L368.448 512l316.8 316.8a64 64 0 0 1-90.496 90.496L232.704 557.248a64 64 0 0 1 0-90.496l362.048-362.048a64 64 0 0 1 90.496 0" />
                </svg> Kembali</button>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Settting</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><a href="{{ route('landing.setting') }}"
                                class="nav-link {{ str_contains(Route::current()->getName(), 'profil') ? 'active' : '' }}">Profil</a>
                        </li>
                        <li class="nav-item"><a href="{{ route('landing.keamanan') }}"
                                class="nav-link {{ str_contains(Route::current()->getName(), 'keamanan') ? 'active' : '' }}">Keamanan</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @yield('setting')
        </div>
    </div>
@endsection
