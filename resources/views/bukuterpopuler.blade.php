@extends('layouts.applanding')

@section('content')
    <div class="content__header content__boxed rounded-0">
        <div class="content__wrap">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="#">Buku Terpoluler</a></li>
            </ol>
        </div>
        <div class="content__wrap d-md-flex align-items-start justify-content-center mb-5">
            <div class="d-inline-flex align-items-center position-relative pt-xl-1">
                <div class="flex-grow-1 text-center">
                    <div class="display-3 mb-3">Buku Terpoluler</div>
                    <p class="lead">
                        Berikut adalah tampilan list buku yang diurutkan berdasarkan buku yang paling banyak dibaca
                    </p>
                </div>
            </div>
        </div>
    </div>


        <div class="row justify-content-center">
            <div class="col-12 col-md-9">
                <div class="content__wrap">

                    <div class="content__boxed">
                        <div class="content__wrap">
                            <div class="row">
          
                              @foreach ($buku as $data)                          
                               <div class="col-4 col-sm-3 col-md-3 col-lg-2">
                                    <a href="{{route('buku.detailbuku',['id'=>$data->id, 'slug'=>$data->slug])}}" style="text-decoration: none;">
                                      <div class="card mb-3">
                                            @if ($data->thumbnail)
                                                <img class="card-img-top" src="{{ Storage::url('imgs/thumbnail-buku/'.$data->thumbnail) }}" alt="{{ $data->judul }}" loading="lazy">
                                            @else
                                                <img class="card-img-top" src="{{ Storage::url('imgs/default-pict.png') }}" alt="thumbnail" loading="lazy">
                                            @endif
                                          <div class="card-body px-1 py-3">
                                            <h4 class="card-title">{{$data->judul}} ({{$data->tahun_terbit}})</h4>
                                          </div>
                                      </div>
                                    </a>
                              </div>
                              @endforeach
                              <div class="d-flex justify-content-between pt-xl-3">
                                  <div></div>
                                  {{$buku->withQueryString()->links()}}
                                  <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection
