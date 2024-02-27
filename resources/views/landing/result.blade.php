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
                        placeholder="Judul,Penulis,Pebimbing,Penguji....." value="{{ session('searchKeyword') }}">
                    <h5 class="mx-3 mb-1"><a href="">{{ count($dokumen) }}</a> Hasil Pencarian dengan kata kunci
                        {{ $keyword }}</h5>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3 col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                    <h6 class="mb-2 text-center">Filter Berdasarkan Jenis</h6>
                    <hr>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($jenis as $jen)
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="filter[]"
                                    id="{{ $jen->id }}" value="{{ $jen->id }}"
                                    @if (is_array($filters) && in_array($jen->id, $filters)) checked @endif>
                                <label class="form-check-label" for="{{ $jen->id }}">{{ $jen->nama_jenis }}</label>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h6 class="mb-2 text-center">Filter Berdasarkan Tahun</h6>
                    <hr>
                    <div class="d-flex flex-column gap-2">
                        @foreach ($tahun as $thn)
                            <div class="form-check">
                                <input class="form-check-input filter-checkbox" type="checkbox" name="tahun[]"
                                    id="{{ $thn }}" value="{{ $thn }}"
                                    @if (is_array($years) && in_array($thn, $years)) checked @endif>
                                <label class="form-check-label" for="{{ $thn }}">{{ $thn }}</label>
                            </div>
                        @endforeach
                    </div>
                    </form>

                </div>
            </div>

        </div>
        <div class="col-md-9 col-sm-12">
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
                                                    href="{{ route('landing.detail', ['id' => $dok->hash_id, 'slug' => Str::slug($dok->judul)]) }}">{{ $dok->judul }}</a>
                                            </h4>
                                        </div>
                                        <div class="col-1">
                                            @if (auth()->check() && auth()->user()->role == 'user')
                                                <button onclick="toggleCollect(this)" type="button" class="btn btn-lg"
                                                    data-id="{{ Crypt::encryptString($dok->id) }}"
                                                    data-collected="{{ $dok->collectedBy(auth()->user()) ? 'true' : 'false' }}"
                                                    data-baseurl="{{ url('') }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                                        fill="{{ $dok->collectedBy(auth()->user()) ? '#face15' : 'none' }}"
                                                        viewBox="0 0 24 24" class="icon" style="color: #face15;">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m19 21-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16Z"></path>
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="m-0">{{ $dok->penulis .' | '. $dok->pembimbing .' | '. $dok->penguji}}</p>
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
            <div class="col-md-12 d-flex justify-content-center ">
                {{ $dokumen->links() }}
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

    <script type="text/javascript">
        async function toggleCollect(el) {
            var btn = el
            const collectionIcon = btn.childNodes
            const docId = btn.getAttribute('data-id')
            const baseUrl = btn.getAttribute('data-baseurl')
            const collected = btn.getAttribute('data-collected') === 'true'

            const url = collected ? `${baseUrl}/api/collection/uncollect` : `${baseUrl}/api/collection/collect`;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            try {
                const response = await axios.post(url, {
                    id: docId
                }, {
                    headers: {
                        'X-CSRF-TOKEN': token
                    }
                });

                const data = response.data;

                if (data.message === 'collected' || data.message === 'uncollected') {
                    collectionIcon[1].style.fill = collected ? 'none' :
                        '#face15' // Menggunakan css() untuk mengatur fill
                    btn.setAttribute('data-collected', collected ? 'false' :
                        'true') // Menggunakan $(this) untuk mengakses tombol
                }
            } catch (error) {
                console.error('Error:', error);
            }
        }
    </script>
@endpush
