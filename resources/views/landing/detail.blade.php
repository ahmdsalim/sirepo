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

    <div class="row mb-4">
        <div class="col-md-7 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="d-flex flex-wrap justify-content-between mb-2">
                            <h4 class="pt-serif my-auto">{{ $dokumen->judul }}</h4>
                            @if (auth()->check() && auth()->user()->role == 'user')
                                <button onclick="toggleCollect(this)" type="button" class="btn btn-lg"
                                    data-id="{{ Crypt::encryptString($dokumen->id) }}"
                                    data-collected="{{ $dokumen->collectedBy(auth()->user()) ? 'true' : 'false' }}"
                                    data-baseurl="{{ url('') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32"
                                        fill="{{ $dokumen->collectedBy(auth()->user()) ? '#face15' : 'none' }}"
                                        viewBox="0 0 24 24" class="icon" style="color: #face15;">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 21-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16Z"></path>
                                    </svg>
                                </button>
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
                                    @if (strlen($dokumen->abstrak) > 100)
                                        <span id="shortDescription">{{ $desk_awal }}...</span>
                                        <span id="fullDescription" style="display: none;">{{ $dokumen->abstrak }}</span>
                                        <a href="#" id="readMoreBtn">Tampilkan</a>
                                    @else
                                        {{ $dokumen->abstrak }}
                                    @endif

                                    @if (strlen($dokumen->abstrak) > 100)
                                        <a href="#" id="readLessBtn" style="display: none;">Sembunyikan</a>
                                    @endif
                                </p>
                                <h6>Kata Kunci/Keyword : {{ $dokumen->keyword }}</h6>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="list-group">
                                    @if (auth()->check())
                                        @foreach ($dokumen->file as $file)
                                            <a href="{{ route('file.get', $file) }}?download=true"
                                                data-file-id="{{ $file }}" download="{{ $file }}"
                                                class="download-link list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1">{{ $file }}</p>
                                                    <small>Download</small>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <p>Silahkan login atau buat akun terlebih dahulu.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5 col-sm-12 ">
            <div class="card">
                <div class="card-body" id="dokInfo">
                    <h5>Informasi Dokumen</h5>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Penulis
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataPenulis">
                            {{ $dokumen->penulis }}
                        </div>
                    </div>
                    <div class="row" id="dataPembimbing">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Pebimbing
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12">
                            {{ $dokumen->pembimbing }}
                        </div>
                    </div>
                    <div class="row" id="dataPembimbing1">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Pebimbing 1
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12">
                            {{ $pembimbing1 }}
                        </div>
                    </div>
                    <div class="row "id="dataPembimbing2">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Pebimbing 2
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12">
                            {{ $pembimbing2 }}
                        </div>
                    </div>

                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Penguji
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataPenguji">
                            {{ $dokumen->penguji }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Publish
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataTahun">
                            {{ $dokumen->tahun }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Jenis Dokumen
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataJenis">
                            {{ $dokumen->jenis->nama_jenis }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Diunduh
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataJenis">
                            {{ $dokumen->downloads->sum('total') }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Staf Input/Edit
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataJenis">
                            {{ $dokumen->user->nama }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Tanggal Input
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataJenis">
                            {{ $dokumen->created_at->format('d M Y') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script>
        document.getElementById("readMoreBtn").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("shortDescription").style.display = "none";
            document.getElementById("fullDescription").style.display = "inline";
            document.getElementById("readMoreBtn").style.display = "none";
            document.getElementById("readLessBtn").style.display = "inline";
        });

        document.getElementById("readLessBtn").addEventListener("click", function(event) {
            event.preventDefault();
            document.getElementById("shortDescription").style.display = "inline";
            document.getElementById("fullDescription").style.display = "none";
            document.getElementById("readMoreBtn").style.display = "inline";
            document.getElementById("readLessBtn").style.display = "none";
        });
    </script>
    <script>
        $(document).ready(function() {
            var jenisDokumen =
                "{{ $dokumen->jenis->nama_jenis }}"; // Assuming you have a variable containing the document type

            if (jenisDokumen === "Tugas Akhir") {
                $("#dataPembimbing").hide();
                $("#dataPembimbing1").show();
                $("#dataPembimbing2").show();
            } else {
                $("#dataPembimbing").show();
                $("#dataPembimbing1").hide();
                $("#dataPembimbing2").hide();
            }
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
