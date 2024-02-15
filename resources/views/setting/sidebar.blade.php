@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Settting</h4>
                </div>
                <div class="card-body">
                    <ul class="nav nav-pills flex-column">
                        <li class="nav-item"><a href="{{ route('user.settingLanding') }}" class="nav-link {{ str_contains(Route::current()->getName(), 'profil') ? 'active' : '' }}">Profil</a></li>
                        <li class="nav-item"><a href="{{ route('user.keamananLanding') }}" class="nav-link {{ str_contains(Route::current()->getName(), 'keamanan') ? 'active' : '' }}">Keamanan</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <form id="setting-form">
                @yield('setting')
            </form>
        </div>
    </div>
@endsection
