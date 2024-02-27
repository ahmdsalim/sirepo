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
        
        <div class="col-12 col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="contaier">
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h5 class="mb-1">Nama</h5>
                                        {{ $user->nama }}
                                    </address>
                                </div>
                                <div class="col-md-6 right">
                                    <address class="mb-4 mb-md-0">

                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h5 class="mb-1">Username</h5>
                                        {{ $user->username }}
                                    </address>
                                </div>
                                <div class="col-md-6 right">
                                    <address class="mb-4 mb-md-0">

                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h5 class="mb-1">Email</h5>
                                        {{ $user->email }}
                                    </address>
                                </div>
                                <div class="col-md-6 right">
                                    <address class="mb-4 mb-md-0">

                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h5 class="mb-1">Dibuat Pada</h5>
                                        {{ $user->created_at->format('d M Y') }}<br>
                                    </address>
                                </div>
                                <div class="col-md-6 right">
                                    <address class="mb-4 mb-md-0">

                                    </address>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">

                                    </address>
                                </div>
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">

                                </div>
                                </address>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
