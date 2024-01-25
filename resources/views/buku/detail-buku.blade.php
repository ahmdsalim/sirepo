@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('buku.index') }}">Buku</a></li>
        <li class="breadcrumb-item"><a href="#">Detail Buku</a></li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">{{ $header }}</h1>
    <p class="lead">

    </p>
@endsection
@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-4 col-sm-12 ">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex flex-column ">
                                <div class="d-flex justify-content-center">
                                    @if ($buku->thumbnail)
                                        <img src="{{ asset('storage/imgs/thumbnail-buku/' . $buku->thumbnail) }}"
                                            alt="{{ $buku->judul }}" class="img-thumbnail" style="width: 230px; height:300px;">
                                    @else
                                        <img src="{{ asset('storage/imgs/default-pict.png') }}" class="img-thumbnail"
                                            alt="Digilib" style="width: 230px; height:300px;">
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-8 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <address class="mb-4 mb-md-0">
                                        <h4 class="mb-1">Deskripsi</h4>
                                        <div class="description">
                                            <p>
                                                @if (strlen($buku->deskripsi) > 100)
                                                    <span id="shortDescription">{{ $desk_awal }}...</span>
                                                    <span id="fullDescription"
                                                        style="display: none;">{{ $deskripsi }}</span>
                                                    <a href="#" id="readMoreBtn">Baca Selengkapnya</a>
                                                @else
                                                    {{ $buku->deskripsi }}
                                                @endif

                                                @if (strlen($buku->deskripsi) > 100)
                                                    <a href="#" id="readLessBtn" style="display: none;">Read Less</a>
                                                @endif
                                            </p>
                                        </div>
                                    </address>
                                </div>
                            </div>
                            <div class="contaier">
                                <h4>Detail</h4>
                                <div class="d-flex flex-column gap-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Judul</h5>
                                                {{ $buku->judul }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 right">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Pengarang</h5>
                                                {{ $buku->penulis }}<br>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Kategori</h5>
                                                {{ $buku->kategori->kategori }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 right">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Penerbit</h5>
                                                {{ $buku->penerbit }}<br>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Jumlah Halaman</h5>
                                                {{ $buku->jumlah_halaman }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 right">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Rating</h5>
                                                <div class="d-flex flex-row gap-1 align-items-center">
                                                    <i><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                            viewBox="0 0 24 24">
                                                            <path fill="#ffc700"
                                                                d="m5.825 22l1.625-7.025L2 10.25l7.2-.625L12 3l2.8 6.625l7.2.625l-5.45 4.725L18.175 22L12 18.275L5.825 22Z" />
                                                        </svg></i>
                                                    <label>{{ round($avgRating, 2) }} / {{ $countVoter }} Votes</label>
                                                    <br>
                                                </div><br>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Tahun terbit</h5>
                                                {{ $buku->tahun_terbit }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 right">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Pemilik</h5>
                                                {{ $buku->user->nama }} <br>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Jumlah Dibaca</h5>
                                                {{ $buku->jumlah_baca ?? 'Belum ada pembaca' }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 right">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Status</h5>
                                                <div class="col-md-4">
                                                    @if ($buku->status == 'publish')
                                                        <div class="badge d-block bg-success">Publish</div>
                                                    @elseif ($buku->status == 'rejected')
                                                        <div class="badge d-block bg-danger">Rejected</div>
                                                    @else
                                                        <div class="badge d-block bg-secondary">Pending</div>
                                                    @endif <br>
                                                </div>
                                            </address>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">No ISBN</h5>
                                                {{ $buku->no_isbn }}<br>
                                            </address>
                                        </div>
                                        <div class="col-md-6 right">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1"></h5>
                                                <div class="col-md-4">

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
            <!-- END : Basic card -->
        </div>
    </div>
@endsection
@push('js')
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
@endpush
