@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-center align-items-center flex-column">
                        <div class="avatar avatar-2xl">
                            <img src="./assets/compiled/jpg/2.jpg" alt="Avatar">
                        </div>

                        <h3 class="mt-3">{{ $user->nama }}</h3>
                        <p class="text-small">{{ $user->username }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-8">
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
                                        {{ $user->created_at }}<br>
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
