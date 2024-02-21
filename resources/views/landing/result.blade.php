@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-sm-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a class="text-decoration-none" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Hasil Pencarian</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-12 my-3 ">
            <div class="d-flex flex-column gap-4">
                @include('landing.searchbar')
                <h5 class="mx-3"><a href="">{{ count($dokumen) }}</a> Hasil Pencarian dengan kata kunci
                    {{ $keyword }}</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 text-center">Cari berdasarakan Jenis</h6>
                    <hr>
                    <div class="d-flex flex-column gap-2 ">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="filter" id="proyek1"
                                {{ old('filter') ? 'checked' : '' }}>

                            <label class="form-check-label" for="proyek1">
                                Proyek1
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="filter" id="proyek2"
                                {{ old('filter') ? 'checked' : '' }}>

                            <label class="form-check-label" for="proyek2">
                                Proyek2
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="filter" id="pkl"
                                {{ old('filter') ? 'checked' : '' }}>

                            <label class="form-check-label" for="pkl">
                                PKL
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="filter" id="ta"
                                {{ old('filter') ? 'checked' : '' }}>

                            <label class="form-check-label" for="ta">
                                Tugas Akhir
                            </label>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h6>Thesis</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">

                        @forelse ($dokumen as $dok)
                            <div class="row mx-2 ">
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-11">
                                            <h4 class="pt-serif"><a
                                                    href="{{ route('landing.detail', $dok->judul) }}">{{ $dok->judul }}</a>
                                            </h4>
                                        </div>
                                        <div class="col-1">
                                            @if (auth()->check())
                                                <button class="btn align-self-start"><i
                                                        class="bi bi-bookmarks"></i></button>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="m-0">{{ $dok->penulis }}</p>
                                    <p>{{ $dok->tahun . ' | ' . $dok->jenis->nama_jenis }}</p>
                                    <hr class="my-2">
                                </div>
                            </div>
                        @empty
                            <p>Data Tidak Ditemukan</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
