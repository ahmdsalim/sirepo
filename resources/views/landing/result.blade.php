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
                <form id="">
                    @csrf
                    <input class="form-control py-3 px-4 shadow-sm" type="search" name="search"
                        placeholder="Judul,Author,Proyek1,Proyek2,....">
                </form>
                <h5 class="mx-3"><a href="">200</a> Hasil Pencarian dengan kata kunci "Tugas Akhir"</h5>
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
                        @for ($i = 0; $i < 3; $i++)
                            <div class="row mx-2 ">
                                <div class="col-12">
                                    <h4 class="pt-serif"><a href="{{ route('landing.detail') }}">Sistem Informasi Inventarisasi Barang Prodi D3
                                            SI</a></h4>
                                    <p class="m-0">Viki Eka Pratama, Mubassiran St.MT, Ibnu Choldun. St</p>
                                    <p>2024 | Tugas Akhir</p>
                                    <hr class="my-2">
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
