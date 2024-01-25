@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('reader.index') }}">List Pembaca</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail</li>
    </ol>
@endsection

@section('pagetitle')
    <h4 class="mb-0 mt-2">Detail Pembaca</h4>
    <p class="lead">
        {{$reader->userable->nama}} (@if($reader->role == 'siswa'){{$reader->userable->nisn}}@else{{$reader->userable->nip}} @endif)
    </p>
@endsection

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <!-- Left toolbar -->
                                <div class="col-md-6 d-flex gap-1 align-items-center mb-3">
                                    <button class="btn btn-icon btn-outline-light">
                                        <i class="demo-pli-printer fs-5"></i>
                                    </button>
                                    <div class="btn-group">

                                        <div class="btn-group dropdown">
                                            <button class="btn btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false"><svg fill="none" stroke="currentColor"
                                                    stroke-width="1.5" width="18" height="18" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                                                    </path>
                                                </svg>
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                                <li><a class="dropdown-item" href="#">Excel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- END : Left toolbar -->
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Judul Buku</th>
                                                <th>Penulis</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($reader->baca()->orderBy('end_at','desc')->get()->unique('buku_id') as $read)
                                            <tr>
                                                <th class="text-center">{{$loop->iteration}}</th>
                                                <td>{{$read->buku->judul}}</td>
                                                <td>{{$read->buku->penulis}} ({{$read->buku->tahun_terbit}})</td>
                                                <td>
                                                    <div class="progress" style="border-radius: 0;">
                                                        <div class="progress-bar bg-success" role="progressbar" style="width: {{round(($read->progress/$read->buku->jumlah_halaman)*100)}}%; border-radius: 0;" aria-label="Progress Membaca" aria-valuenow="{{round(($read->progress/$read->buku->jumlah_halaman)*100)}}" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                    <div class="mt-1 d-flex justify-content-between">
                                                        <span class="text-muted" style="font-size: .65rem;">{{$read->progress.'/'.$read->buku->jumlah_halaman}} Halaman</span>
                                                        <span class="text-muted" style="font-size: .65rem;">{{round(($read->progress/$read->buku->jumlah_halaman)*100)}}%</span>
                                                    </div>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td align="center" colspan="7">Data tidak ditemukan</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
@vite('resources/assets/js/alert.js')
@endpush