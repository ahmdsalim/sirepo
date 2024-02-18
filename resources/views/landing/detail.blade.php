@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-12">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-sm-start">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a class="text-decoration-none" href="{{ url('/') }}">Home</a></li>
                    <li class="breadcrumb-item active"><a class="text-decoration-none" href="#"
                            onclick="history.back()">Hasil Pencarian</a></li>
                    <li class="breadcrumb-item" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-9 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h4 class="pt-serif"><a href="{{ route('landing.detail') }}">Sistem Informasi Inventarisasi Barang
                                Prodi
                                D3
                                SI</a></h4>
                        <p class="m-0">Viki Eka Pratama, Mubassiran St.MT, Ibnu Choldun. St</p>
                        <p>2024 | Tugas Akhir</p>
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
                                <p class="my-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla ut nulla
                                    neque. Ut hendrerit nulla a euismod pretium.
                                    Fusce venenatis sagittis ex efficitur suscipit. In tempor mattis fringilla. Sed id
                                    tincidunt orci, et volutpat ligula.
                                    Aliquam sollicitudin sagittis ex, a rhoncus nisl feugiat quis. Lorem ipsum dolor sit
                                    amet, consectetur adipiscing elit.
                                    Nunc ultricies ligula a tempor vulputate. Suspendisse pretium mollis ultrices.</p>
                                <h6>Kata Kunci/Keyword : Laravel, BPMN</h6>

                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1">Laporan Siiba.pdf</p>
                                            <small>Download</small>
                                        </div>

                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <div class="d-flex w-100 justify-content-between">
                                            <p class="mb-1">DPL Siiba.pdf</p>
                                            <small>Download</small>
                                        </div>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-12 ">
            <div class="card">
                <div class="card-body">
                    <h6>Informasi Dokumen</h6>
                    <hr>
                    
                </div>
            </div>
        </div>
    </div>
@endsection
