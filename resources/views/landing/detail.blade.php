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
                        <div class="d-flex flex-wrap justify-content-between">
                            <h4 class="pt-serif">{{ $dokumen->judul }}</h4>
                            @if (auth()->check())
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
                                    {{ $dokumen->abstrak }}</p>
                                <h6>Kata Kunci/Keyword : {{ $dokumen->keyword }}</h6>

                            </div>
                            @if (auth()->check())
                                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="list-group">
                                        <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <p class="mb-1" id="dataUploader"></p>
                                                <small>Download</small>
                                            </div>

                                        </a>
                                        {{-- <a href="#" class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <p class="mb-1">{{ $dokumen->file }}</p>
                                                <small>Download</small>
                                            </div>
                                        </a> --}}
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
                <div class="card-body" id="dokInfo">
                    <h5>Informasi Dokumen</h5>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Nama
                        </div>
                        <div class="col-md-8 col-sm-12" id="dataPenulis">

                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Pebimbing
                        </div>
                        <div class="col-md-8 col-sm-12" id="dataPebimbing">
                            Mubassiran St.MT
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Penguji
                        </div>
                        <div class="col-md-8 col-sm-12" id="dataPenguji">
                            Ibnu Choldun. St
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Publish
                        </div>
                        <div class="col-md-8 col-sm-12" id="dataTahun">

                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            Jenis Dokumen
                        </div>
                        <div class="col-md-8 col-sm-12" id="dataJenis">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
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
