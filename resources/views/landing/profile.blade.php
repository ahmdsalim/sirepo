@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-12 mb-3 ">
            <button onclick="history.back()" class="btn icon btn-md icon-left "><svg xmlns="http://www.w3.org/2000/svg"
                    width="16" height="16" viewBox="0 0 1024 1024">
                    <path fill="currentColor"
                        d="M685.248 104.704a64 64 0 0 1 0 90.496L368.448 512l316.8 316.8a64 64 0 0 1-90.496 90.496L232.704 557.248a64 64 0 0 1 0-90.496l362.048-362.048a64 64 0 0 1 90.496 0" />
                </svg> Kembali</button>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h6>Detail Pengguna</h6>
                </div>
                <div class="card-body">
                    <div class="contaier">
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h6 class="mb-1">Nama Pengguna</h6>
                                        {{ $user->nama }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h6 class="mb-1">Username</h6>
                                        {{ $user->username }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h6 class="mb-1">Email</h6>
                                        {{ $user->email }}
                                    </address>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header">
                    <h6>Data Mahasiswa</h6>
                </div>
                <div class="card-body">
                    <div class="contaier">
                        <div class="d-flex flex-column gap-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h6 class="mb-1">NPM</h6>
                                        {{ $user->mahasiswa->npm }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h6 class="mb-1">Nama Mahasiswa</h6>
                                        {{ $user->mahasiswa->nama_mahasiswa }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h6 class="mb-1">Program Studi</h6>
                                        {{ $user->mahasiswa->prodi->nama_prodi }}
                                    </address>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <address class="mb-4 mb-md-0">
                                        <h6 class="mb-1">Status</h6>
                                        {{ $user->mahasiswa->is_active ? 'Aktif' : 'Tidak Aktif' }}
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
