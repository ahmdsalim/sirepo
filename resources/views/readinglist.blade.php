@extends('layouts.applanding')

@section('content') 
<div class="content__header content__boxed rounded-0">
  <div class="content__wrap">
        <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Daftar Bacaan</a></li>
    </ol>
  </div>
                <div class="content__wrap d-md-flex align-items-start justify-content-center mb-5">
                        <div class="d-inline-flex align-items-center position-relative pt-xl-1">
                            <div class="flex-grow-1 text-center">
                              <div class="display-3 mb-3">Daftar Bacaan</div>
    <p class="lead">
      Berikut adalah tampilan list semua buku yang Anda baca
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
          <h1>List</h1>
          <div class="my-auto">
            <div class="d-flex">
              <div class="my-auto px-2">
                Tampilan:
              </div>
              <select id="orderby" class="form-select" aria-describedby="Tampilan">
                <option value="all" @selected($orderby == 'all')>Semua</option>
                <option value="ongoing" @selected($orderby == 'ongoing')>Sedang Dibaca</option>
                <option value="completed" @selected($orderby == 'completed')>Selesai Dibaca</option>
              </select>
            </div>
          </div>    
        </div>
        @forelse ($readinglist as $data)
           <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                <a href="{{route('buku.detailbuku',['id'=>$data->id, 'slug'=>$data->slug])}}" style="text-decoration: none;">
                  <div class="card mb-3">
                    @if ($data->thumbnail)
                        <img class="card-img-top" src="{{ Storage::url('imgs/thumbnail-buku/'.$data->thumbnail) }}" alt="{{ $data->judul }}" loading="lazy">
                    @else
                        <img class="card-img-top" src="{{ Storage::url('imgs/default-pict.png') }}" alt="thumbnail" loading="lazy">
                    @endif
                    <div class="progress progress-md" style="border-radius: 0;">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: {{round(($data->readBy(auth()->user())->progress/$data->jumlah_halaman)*100)}}%; border-radius: 0;" aria-label="Progress Membaca" aria-valuenow="{{round(($data->readBy(auth()->user())->progress/$data->jumlah_halaman)*100)}}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                      <div class="card-body">
                        <h4 class="card-title">{{$data->judul}} ({{$data->tahun_terbit}})</h4>
                      </div>
                  </div>
                </a>
          </div>
        @empty
        <div class="content__boxed">
        <div class="alert alert-primary fw-bold text-center" role="alert">
         Anda Belum Memiliki Data Buku Pada Sesi Ini, <a href="/" style="text-decoration: none;" class="pe-auto">Ayo Membaca...</a>
        </div></div>
        @endforelse

        <div class="d-flex justify-content-center mt-2">
          {{ $readinglist->links() }}
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
<script type="text/javascript">
  document.getElementById('orderby').addEventListener('change', function () {
    var selectedVal =  this.value

    window.location.href = `${window.location.pathname}?orderby=${selectedVal}`
  })
</script>
@endpush