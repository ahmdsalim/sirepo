@extends('layouts.applanding')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="#">Detail Buku</a></li>
    </ol>
@endsection

@section('pagetitle')
    <p class="lead">

    </p>
@endsection

@php
    header('Cache-Control: no-cache, no-store, must-revalidate'); // HTTP 1.1.
    header('Pragma: no-cache'); // HTTP 1.0.
    header('Expires: 0 '); // Proxies.
@endphp

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-md-3 col-sm-12 mb-2">
                    <div class="card-detail">
                        <div class="card-body-detail">
                            <div class="d-flex flex-column">
                                <div class="d-flex justify-content-center">
                                    @if ($buku->thumbnail)
                                        <img src="{{ asset('storage/imgs/thumbnail-buku/' . $buku->thumbnail) }}" class="thumbnail">
                                    @else
                                        <img src="{{ asset('storage/imgs/default-pict.png') }}" class="thumbnail">
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-md-9 col-sm-12">
                    <div class="card-detail">
                        <div class="card-body-detail">
                            <div class="row">
                                <div class="col-md-12 mb-3 border-bottom">
                                    <div class="pb-1 d-flex align-items-center">
                                        <small class="">Kontributor: {{ $buku->user->nama }}</small>
                                        @if (isAuth())
                                            <div class="flex-grow g-2 ms-auto">
                                                <div class="d-flex flex-row gap-1 align-items-end">

                                                    <div>                                            
                                                        <a href="{{ route('read', ['id' => $buku->id, 'slug' => $buku->slug]) }}" class="btn btn-sm btn-dark">
                                                            <svg class="me-1" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" style="color: currentcolor;"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2zm20 0h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"></path></svg>
                                                            Baca
                                                        </a>
                                                    </div>
                                                    <div>
                                                        <button id="btnCollection" type="button" class="btn btn-sm btn-primary" data-id="{{ Crypt::encryptString($buku->id) }}" data-collected="{{ $buku->collectedBy(auth()->user()) ? 'true' : 'false' }}" data-baseurl="{{ url('') }}">
                                                            <svg id="collectionIcon" xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="{{ $buku->collectedBy(auth()->user()) ? 'currentcolor' : 'none' }}" viewBox="0 0 24 24" class="icon" style="color: currentcolor;"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 21-7-5-7 5V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16Z"></path></svg>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <h3 class="card-title-detail">{{ $buku->judul }}</h3>
                                </div>
                                <div class="col-md-12">
                                    <address class="mb-4 mb-md-0">
                                        <h4 class="mb-1">Deskripsi</h4>
                                        <div class="description">
                                            <p>
                                                @if($buku->deskripsi)
                                                    @if (strlen($buku->deskripsi) > 100)
                                                        <span id="shortDescription">{{ $desk_awal }}...</span>
                                                        <span id="fullDescription"
                                                            style="display: none;">{{ $deskripsi }}</span>
                                                        <a href="#" id="readMoreBtn">Baca Selengkapnya</a>
                                                    @else
                                                        {{ $buku->deskripsi }}
                                                    @endif
    
                                                    @if (strlen($buku->deskripsi) > 100)
                                                        <a href="#" id="readLessBtn" style="display: none;">Read
                                                            Less</a>
                                                    @endif
                                                @else 
                                                    Tidak ada deskripsi
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
                                                <h5 class="mb-1">No ISBN</h5>
                                                {{ $buku->no_isbn }}
                                            </address>
                                        </div>
                                        <div class="col-md-6 right">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Penulis</h5>
                                                {{ $buku->penulis }}
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
                                                <h5 class="mb-1">Jumlah Dibaca</h5>
                                                {{ $buku->jumlah_baca ?? 'Belum ada pembaca' }}<br>
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
                                        <div class="col-md-6">
                                            <address class="mb-4 mb-md-0">
                                                <h5 class="mb-1">Rating</h5>
                                                @if(isAuth())
                                                    @if (!$userHasRated)
                                                        <form id="ratingForm" action="{{ route('rating.store') }}"
                                                            method="POST" autocomplete="off">
                                                            @csrf
                                                            <input type="hidden" name="id"
                                                                value="{{ $buku->id }}">
                                                            <input type="hidden" name="slug"
                                                                value="{{ $buku->slug }}">
                                                            <p class="m-0 font-weight-bold ">Rate This Book</p>
                                                            <div class="form-group row">
                                                                <input type="hidden" name="booking_id">
                                                                <div class="col">
                                                                    <div class="rate">
                                                                        <input type="radio" checked id="star5"
                                                                            class="rate" name="score" value="5" />
                                                                        <label for="star5" title="text">5
                                                                            stars</label>
                                                                        <input type="radio" id="star4" class="rate"
                                                                            name="score" value="4" />
                                                                        <label for="star4" title="text">4
                                                                            stars</label>
                                                                        <input type="radio" id="star3" class="rate"
                                                                            name="score" value="3" />
                                                                        <label for="star3" title="text">3
                                                                            stars</label>
                                                                        <input type="radio" id="star2" class="rate"
                                                                            name="score" value="2">
                                                                        <label for="star2" title="text">2
                                                                            stars</label>
                                                                        <input type="radio" id="star1" class="rate"
                                                                            name="score" value="1" />
                                                                        <label for="star1" title="text">1
                                                                            star</label>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="col-12 d-grid">
                                                                <button id="sumbitRating"
                                                                    class="btn btn-sm btn-primary btn-block">Rated
                                                                </button>
                                                            </div>
                                                        </form>
                                                    @else
                                                        <div class="d-flex flex-row gap-1 align-items-center">
                                                            <i><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                    height="24" viewBox="0 0 24 24">
                                                                    <path fill="#ffc700"
                                                                        d="m5.825 22l1.625-7.025L2 10.25l7.2-.625L12 3l2.8 6.625l7.2.625l-5.45 4.725L18.175 22L12 18.275L5.825 22Z" />
                                                                </svg></i>
                                                            <label>{{round($avgRating,2,2)}} / {{ $countVoter }} Votes</label> <br>
                                                        </div>
                                                    @endif
                                                @else
                                                    <div class="d-flex flex-row gap-1 align-items-center">
                                                        <i><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24">
                                                                <path fill="#ffc700"
                                                                    d="m5.825 22l1.625-7.025L2 10.25l7.2-.625L12 3l2.8 6.625l7.2.625l-5.45 4.725L18.175 22L12 18.275L5.825 22Z" />
                                                            </svg></i>
                                                        <label>{{round($avgRating,2)}} / {{ $countVoter }} Votes</label> <br>
                                                    </div>
                                                @endif
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
    <!-- <script>
        $(document).ready(function() {
            $('#submitRating').click(function(e) {
                e.preventDefault();

                var formData = $('#ratingForm').serialize();
                var id = $('[name="id"]').val(); // Ambil nilai 'id'
                var slug = $('[name="slug"]').val(); // Ambil nilai 'slug'

                $.ajax({
                    type: 'POST',
                    url: "{{ route('rating.store') }}",
                    data: formData,
                    success: function(response) {
                        toastr.success('Rating Telah Di Masukan');
                    },
                    error: function(error) {
                        // Handle the error response here
                        alert('Error: ' + error.responseText);
                    }
                });
            });
        });
    </script> -->

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


@if (isAuth())
    @push('js')
        <script type="text/javascript">
            const btnCollection = document.getElementById('btnCollection')
            const collectionIcon = document.getElementById('collectionIcon')

            btnCollection.addEventListener('click', async () => {
                const bookId = btnCollection.getAttribute('data-id')
                const collected = btnCollection.getAttribute('data-collected') === 'true';
                const baseUrl = btnCollection.getAttribute('data-baseurl')
                const url = collected ? `${baseUrl}/api/collection/uncollect` : `${baseUrl}/api/collection/collect`
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

                try {
                    const response = await axios.post(url, {
                        id: bookId
                    }, {
                        headers: {
                            'X-CSRF-TOKEN': token
                        }
                    })

                    const data = response.data

                    if (data.message === 'collected' || data.message === 'uncollected') {
                        collectionIcon.style.fill = collected ? 'none' : 'currentcolor'
                        btnCollection.setAttribute('data-collected', collected ? 'false' : 'true')
                    }
                } catch (error) {
                    console.error('Error:', error)
                }
            })
        </script>
    @endpush
@endif
