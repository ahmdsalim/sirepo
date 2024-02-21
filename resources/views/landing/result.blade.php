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
        <div class="col-12 my-3">
            <div class="d-flex flex-column gap-4">
                <form id="filterForm" action="{{ route('landing.search') }}" method="get">
                    <input class="form-control py-3 px-4 shadow-sm mb-3" type="search" id="searchInput" name="search"
                        placeholder="Judul, Author...." value="{{ session('searchKeyword') }}">
                    <h5 class="mx-3 mb-1"><a href="">{{ count($dokumen) }}</a> Hasil Pencarian dengan kata kunci
                        {{ $keyword }}</h5>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 text-center">Cari berdasarkan Jenis</h6>
                    <hr>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($jenis as $jen)
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="filter[]"
                                    id="jenis_{{ $jen->id }}" value="{{ $jen->id }}"
                                    @if (is_array($filters) && in_array($jen->id, $filters)) checked @endif>
                                <label class="form-check-label"
                                    for="jenis_{{ $jen->id }}">{{ $jen->nama_jenis }}</label>
                            </div>
                        @endforeach
                    </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-2">Hasil Pencarian</h6>
                    <hr class="mb-0">
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
@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.filter-checkbox').on('change', function() {
                $('#filterForm').submit(); // Submit formulir ketika checkbox berubah
            });
        });
    </script>
@endpush
