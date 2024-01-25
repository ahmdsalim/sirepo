@extends('layouts.appnifty')

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <!-- Tiles -->
            <div class="row justify-content-center">
                <div class="col-sm-6 col-lg-3">

                    <!-- Stat widget -->
                    <div class="card bg-cyan text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 32 32">
                                    <path fill="currentColor"
                                        d="M23 24c-3.6 0-5.03-4.176-6.413-8.214C15.277 11.958 13.92 8 11 8a3.44 3.44 0 0 0-3.053 2.321L6.05 9.684C6.101 9.534 7.321 6 11 6c4.35 0 6.012 4.855 7.48 9.138C19.689 18.667 20.83 22 23 22a3.44 3.44 0 0 0 3.053-2.321l1.896.637C27.899 20.466 26.679 24 23 24Z" />
                                    <path fill="currentColor" d="M4 28V17h2v-2H4V2H2v26a2 2 0 0 0 2 2h26v-2Z" />
                                    <path fill="currentColor"
                                        d="M8 15h2v2H8zm4 0h2v2h-2zm8 0h2v2h-2zm4 0h2v2h-2zm4 0h2v2h-2z" />
                                </svg>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">
                                    @if ($total_pengguna != 0)
                                        {{ round(($total_pembaca / $total_pengguna) * 100) . '%' }}
                                    @else
                                        {{ 0 . '%' }}
                                    @endif
                                    <span class="fs-5">({{ $total_pembaca . '/' . $total_pengguna }})</span>
                                </h5>
                                <p class="mb-0">Indeks Membaca</p>
                            </div>
                        </div>
                    </div>
                    <!-- END : Stat widget -->

                </div>
                <div class="col-sm-6 col-lg-3">

                    <!-- Stat widget -->
                    <div class="card bg-purple text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 256 256">
                                    <path fill="currentColor"
                                        d="M128 40a96 96 0 1 0 96 96a96.11 96.11 0 0 0-96-96Zm0 176a80 80 0 1 1 80-80a80.09 80.09 0 0 1-80 80Zm45.66-125.66a8 8 0 0 1 0 11.36l-40 40a8 8 0 0 1-11.36-11.36l40-40a8 8 0 0 1 11.36 0ZM96 16a8 8 0 0 1 8-8h48a8 8 0 0 1 0 16h-48a8 8 0 0 1-8-8Z" />
                                </svg>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">{{ round($avg_waktubaca_perhari, 2) }}<span class="fs-5">Menit</span>
                                </h5>
                                <p class="mb-0">Rata<sup>2</sup> Waktu Baca (Perhari)</p>
                            </div>
                        </div>
                    </div>
                    <!-- END : Stat widget -->

                </div>
                <div class="col-sm-6 col-lg-3 mb-3 mb-xl-3">

                    <!-- Stat widget -->
                    <div class=" card rounded-top bg-orange text-white">
                        <a href="{{ route('users.index') }}" class="text-decoration-none text-white">
                            <div class="card-body py-3 d-flex align-items-stretch">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                    <svg fill="none" stroke="currentColor" stroke-width="1.5" width="36"
                                        height="36" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true" style="margin-right: 4px;">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="h2 mb-0">{{ $total_pengguna }}</h5>
                                    <p class="mb-0">Pengguna</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- END : Stat widget -->

                </div>
                <div class="col-sm-6 col-lg-3">

                    <!-- Stat widget -->
                    <div class="card bg-pink text-white mb-3 mb-xl-3">
                        <a href="{{ route('buku.index') }}" class="text-decoration-none text-white">
                            <div class="card-body py-3 d-flex align-items-stretch">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                        viewBox="0 0 256 256">
                                        <path fill="currentColor"
                                            d="M208 24H72a32 32 0 0 0-32 32v168a8 8 0 0 0 8 8h144a8 8 0 0 0 0-16H56a16 16 0 0 1 16-16h136a8 8 0 0 0 8-8V32a8 8 0 0 0-8-8Zm-8 160H72a31.82 31.82 0 0 0-16 4.29V56a16 16 0 0 1 16-16h128Z" />
                                    </svg>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="h2 mb-0">{{ $total_buku }}</h5>
                                    <p class="mb-0">Buku</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- END : Stat widget -->

                </div>

                <div class="col-sm-6 col-lg-3">

                    <!-- Stat widget -->
                    <div class="card bg-pink text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <svg fill="none" stroke="currentColor" stroke-width="1.5" width="36" height="36"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                                    </path>
                                </svg>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">{{ round($avg_haldibaca, 2) }}</h5>
                                <p class="mb-0">Rata<sup>2</sup> Halaman Dibaca</p>
                            </div>
                        </div>
                    </div>
                    <!-- END : Stat widget -->

                </div>

                <div class="col-sm-6 col-lg-3">

                    <!-- Stat widget -->
                    <div class="card bg-purple text-white mb-3 mb-xl-3">
                        <div class="card-body py-3 d-flex align-items-stretch">
                            <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 16 16">
                                    <path fill="currentColor"
                                        d="M1 2.828c.885-.37 2.154-.769 3.388-.893c1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493c-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752c1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81c-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02c1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877c1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z" />
                                </svg>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="h2 mb-0">{{ $total_buku_dibaca }}</h5>
                                <p class="mb-0">Buku yang Dibaca</p>
                            </div>
                        </div>
                    </div>
                    <!-- END : Stat widget -->

                </div>

                <div class="col-sm-6 col-lg-3">
                    <!-- Stat widget -->
                    <div class="card bg-purple text-white mb-3 mb-xl-3">
                        <a href="{{ route('sekolah.guru.index') }}" class="text-decoration-none text-white">
                            <div class="card-body py-3 d-flex align-items-stretch">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                        viewBox="0 0 512 512" style="margin-right: 4px;">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="32"
                                            d="M32 192L256 64l224 128l-224 128L32 192z" />
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="32"
                                            d="M112 240v128l144 80l144-80V240m80 128V192M256 320v128" />
                                    </svg>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="h2 mb-0">{{ $total_guru }}</h5>
                                    <p class="mb-0">Guru</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- END : Stat widget -->
                </div>

                <div class="col-sm-6 col-lg-3">
                    <!-- Stat widget -->
                    <div class="card bg-purple text-white mb-3 mb-xl-3">
                        <a href="{{ route('sekolah.siswa.index') }}" class="text-decoration-none text-white">
                            <div class="card-body py-3 d-flex align-items-stretch">
                                <div class="d-flex align-items-center justify-content-center flex-shrink-0 rounded-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36"
                                        viewBox="0 0 512 512" style="margin-right: 4px;">
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="32"
                                            d="M32 192L256 64l224 128l-224 128L32 192z" />
                                        <path fill="none" stroke="currentColor" stroke-linecap="round"
                                            stroke-linejoin="round" stroke-width="32"
                                            d="M112 240v128l144 80l144-80V240m80 128V192M256 320v128" />
                                    </svg>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h5 class="h2 mb-0">{{ $total_siswa }}</h5>
                                    <p class="mb-0">Siswa</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <!-- END : Stat widget -->
                </div>
            </div>
            <!-- END : Tiles -->

            <div class="row">
                <div class="col-md-6 mb-3">

                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Top 10 Buku</h5>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>Foto</th>
                                            <th>Judul</th>
                                            <th class="text-center">Kategori</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topBuku as $buku)
                                            <tr>
                                                <th class="text-center">{{ $loop->iteration }}</th>
                                                <td>
                                                    @if ($buku->thumbnail)
                                                        <img class=""
                                                            src="{{ asset('storage/imgs/thumbnail-buku/' . $buku->thumbnail) }}"
                                                            alt="{{ $buku->thumbnail }}" style="width: 50px;">
                                                    @else
                                                        <img class=""
                                                            src="{{ asset('img/default-pict.png') }}" alt="Foto Default">
                                                    @endif
                                                </td>
                                                <td>{{ $buku->judul }}</td>
                                                <td>{{ $buku->kategori->kategori }}</td>
                                                {{-- <td class="text-center">{{ $buku->total_buku }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="col-md-6 mb-3">

                    <!-- Top Users table -->
                    <div class="card">
                        <div class="card-body">

                            <h5 class="card-title">Top 10 Pembaca</h5>

                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th>NISN</th>
                                            <th>Nama</th>
                                            <th class="text-center">Jumlah Buku Dibaca</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($readers as $topPembaca)
                                            <tr>
                                                <th class="text-center">{{ $loop->iteration }}</th>
                                                <td>{{$topPembaca->userable->nisn}}</td>
                                                <td>{{strtoupper($topPembaca->userable->nama)}}</td>
                                                <td class="text-center fw-bold">{{$topPembaca->baca()->get()->unique('buku_id')->count()}}</td>

                                                {{-- <td class="text-center">{{ $pembaca->total_buku }}</td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <!-- END : Top Users table -->

                </div>
            </div>

        </div>
    </div>
@endsection
