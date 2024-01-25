@extends('layouts.applanding')

@section('content') 
<div class="content__header content__boxed rounded-0">
  <div class="content__wrap">
        <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Riwayat Dibaca</a></li>
    </ol>
  </div>
                <div class="content__wrap d-md-flex align-items-start justify-content-center mb-5">
                        <div class="d-inline-flex align-items-center position-relative pt-xl-1">
                            <div class="flex-grow-1 text-center">
                              <div class="display-3 mb-3">Riwayat Dibaca</div>
    <p class="lead">
      Berikut adalah tampilan list buku berdasarkan riwayat baca anda
    </p>
</div>
</div> 
</div>
</div>

<div class="content__boxed">
  <div class="row justify-content-center">
    <div class="col-12 col-md-9">
      <div class="content__wrap">

    <div class="content__boxed">
      <div class="content__wrap">
        <div class="row">

        <div class="d-flex justify-content-between mb-2">
          <h1>Lanjut Membaca</h1>
          <div class="my-auto">
            <a href="{{route('daftarbacaan')}}">Lihat Semua</a>
          </div>    
        </div>

        @forelse ($lanjutbaca as $data)
           <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                <a href="{{route('buku.detailbuku',['id'=>$data->buku->id, 'slug'=>$data->buku->slug])}}" style="text-decoration: none;">
                  <div class="card mb-3">
                    <img class="card-img-top" alt="{{$data->buku->judul}}" src="{{asset('storage/imgs/thumbnail-buku/'.$data->buku->thumbnail)}}">
                    <div class="progress progress-md" style="border-radius: 0;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: {{round(($data->progress/$data->buku->jumlah_halaman)*100)}}%; border-radius: 0;" aria-label="Progress Membaca" aria-valuenow="{{round(($data->progress/$data->buku->jumlah_halaman)*100)}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                      <div class="card-body px-1 py-3">
                        <h4 class="card-title">{{$data->buku->judul}} ({{$data->buku->tahun_terbit}})</h4>
                      </div>
                  </div>
                </a>
          </div>
        @empty
        <div class="content__boxed">
        <div class="alert alert-primary fw-bold text-center" role="alert">
         DIGILIB Memiliki Banyak Buku Yang Menarik Lohh, <a href="/" style="text-decoration: none;" class="pe-auto">Ayo Mulai Membaca...</a>
        </div></div>
        @endforelse       

<div class="mb-3"></div>

        <div class="d-flex justify-content-between mb-2">
          <h1>Selesai Dibaca</h1>
          <div class="my-auto">
            <a href="{{route('daftarbacaan')}}">Lihat Semua</a>
          </div>    
        </div>

        @forelse ($selesaibaca as $data)                          
           <div class="col-4 col-sm-3 col-md-3 col-lg-2">
          <a href="{{route('buku.detailbuku',['id'=>$data->buku->id, 'slug'=>$data->buku->slug])}}" style="text-decoration: none;">
            <div class="card mb-3">
              <img class="card-img-top" alt="{{$data->buku->judul}}" src="{{asset('storage/imgs/thumbnail-buku/'.$data->buku->thumbnail)}}">
                <div class="card-body px-1 py-3">
                  <h4 class="card-title">{{$data->buku->judul}} ({{$data->buku->tahun_terbit}})</h4>
                </div>
            </div>
          </a>
        </div>
        @empty
        <div class="content__boxed">
        <div class="alert alert-primary fw-bold text-center" role="alert">
         DIGILIB Memiliki Banyak Buku Yang Menarik Lohh, <a href="/" style="text-decoration: none;" class="pe-auto">Ayo Mulai Membaca...</a>
        </div></div>
        @endforelse        
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

@endsection
