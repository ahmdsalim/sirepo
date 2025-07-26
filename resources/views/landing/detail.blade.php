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
                    <li class="breadcrumb-item active"><a class="text-decoration-none"
                            href="{{ url('/') }}">{{ __('landing.home') }}</a></li>
                    <li class="breadcrumb-item active"><a class="text-decoration-none" href="#"
                            onclick="history.back()">{{ __('landing.search-result') }}</a></li>
                    <li class="breadcrumb-item text-break " aria-current="page">{{ $dokumen->judul }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-7 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-11">
                            <h4 class="pt-serif my-auto">{{ $dokumen->judul }}</h4>
                        </div>
                        <div class="col-1 p-0">
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
                                <a class="nav-link active" id="abstract-tab" data-bs-toggle="tab" href="#abstract"
                                    role="tab" aria-controls="abstract"
                                    aria-selected="true">{{ __('landing.abstract') }}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a class="nav-link" id="pdf-tab" data-bs-toggle="tab" href="#pdf" role="tab"
                                    aria-controls="pdf" aria-selected="false" tabindex="-1">PDF</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="abstract" role="tabpanel"
                                aria-labelledby="abstract-tab">
                                <p class="my-2 text-justify">
                                    @if (strlen($dokumen->abstrak) > 150)
                                        <span id="shortDescription">{{ $desk_awal }}...</span>
                                        <span id="fullDescription" style="display: none;">{{ $dokumen->abstrak }}</span>
                                        <a href="#" id="readMoreBtn">{{ __('landing.show') }}</a>
                                    @else
                                        {{ $dokumen->abstrak }}
                                    @endif

                                    @if (strlen($dokumen->abstrak) > 150)
                                        <a href="#" id="readLessBtn"
                                            style="display: none;">{{ __('landing.hide') }}</a>
                                    @endif
                                </p>
                                <h6>{{ __('landing.keyword') }} : {{ $dokumen->keyword }}</h6>

                            </div>
                            <div class="tab-pane fade" id="pdf" role="tabpanel" aria-labelledby="pdf-tab">
                                <div class="list-group">
                                    @if (auth()->check())
                                        @foreach ($dokumen->file as $file)
                                            <a href="{{ route('file.public.download', $file) }}"
                                                class="download-link list-group-item list-group-item-action">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <p class="mb-1  text-break">{{ $file }}</p>
                                                    <small class="align-self-center">{{ __('landing.download') }}</small>
                                                </div>
                                            </a>
                                        @endforeach
                                    @else
                                        <p>{{ __('landing.must-login') }}</p>
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
                    <h5>{{ __('landing.document-info') }}</h5>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.author') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataPenulis">
                            {{ $dokumen->penulis }}
                        </div>
                    </div>
                    <div class="row" id="dataPembimbing">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.mentor') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12">
                            {{ $dokumen->pembimbing }}
                        </div>
                    </div>
                    <div class="row" id="dataPembimbing1">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.mentor1') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12">
                            {{ $pembimbing1 }}
                        </div>
                    </div>
                    <div class="row "id="dataPembimbing2">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.mentor2') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12">
                            {{ $pembimbing2 }}
                        </div>
                    </div>

                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.assessor') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataPenguji">
                            {{ $dokumen->penguji }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.publish') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataTahun">
                            {{ $dokumen->tahun }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.document-type') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataJenis">
                            {{ $dokumen->jenis->nama_jenis }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.downloaded') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataJenis">
                            {{ $dokumen->downloads->sum('total') }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.staff-input') }}
                        </div>
                        <div class="col-md-1 d-none d-md-block">:</div>
                        <div class="col-md-7 col-sm-12" id="dataJenis">
                            {{ $dokumen->user->nama }}
                        </div>
                    </div>
                    <div class="row">
                        <hr class="my-2">
                        <div class="col-md-4 col-sm-12">
                            {{ __('landing.input-date') }}
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
