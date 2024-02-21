@extends('layouts.app')

@push('styles')
    <style>
        .text-justify {
            text-align: justify;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-sm-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a class="text-decoration-none" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a class="text-decoration-none" href="#"
                            onclick="history.back()">Hasil Pencarian</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $dokumen->judul }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex justify-content-between">
                            <h4 class="pt-serif">{{ $dokumen->judul }}</h4>
                            @if (auth()->check())
                                <button class="btn align-self-start"><i class="bi bi-bookmarks"></i></button>
                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a class="nav-link active" id="home-tab" data-bs-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">Abstrak</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="profile-tab" data-bs-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false" tabindex="-1">PDF</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="home" role="tabpanel"
                                aria-labelledby="home-tab">
                                <p class="my-2 text-justify">
                                    {{ $dokumen->abstrak }}</p>
                                <h6>Kata Kunci/Keyword : {{ $dokumen->keyword }}</h6>

                            </div>
                            @if (auth()->check())
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <p class="mb-1">{{ $dokumen->file }}</p>
                                                <small>Download</small>
                                            </div>

                                        </a>
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <p class="mb-1">{{ $dokumen->file }}</p>
                                                <small>Download</small>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @else
                                <p>Silahkan login atau Buat akun terlebih dahulu.</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <h5>Informasi Dokumen</h5>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Nama
                        </div>
                        <div class="col-md-8 col-sm-12">
                            {{ $dokumen->penulis }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Pebimbing
                        </div>
                        <div class="col-md-8 col-sm-12">
                            Mubassiran St.MT
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Penguji
                        </div>
                        <div class="col-md-8 col-sm-12">
                            Ibnu Choldun. St
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Publish
                        </div>
                        <div class="col-md-8 col-sm-12">
                            {{ $dokumen->tahun }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Jenis Dokumen
                        </div>
                        <div class="col-md-8 col-sm-12">
                            {{ $dokumen->jenis->nama_jenis }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
