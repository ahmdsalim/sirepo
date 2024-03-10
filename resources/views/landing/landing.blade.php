@extends('layouts.app')

@section('content')
    <div class="container-fluid position-fixed bottom-25" style="top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <div class="row justify-content-center gap-4">
            <div class="col-md-8">
                <h1 class="text-center pt-serif d-block d-lg-none">Repository MI</h1>
                @include('landing.searchbar')
                <div class="d-flex justify-content-center mt-3">
                    <a href="{{ route('landing.dokumen') }}"><u>Cari selengkapnya</u></a>
                </div>
            </div>
            <div class="d-flex justify-content-center gap-4">
                @foreach ($jenis as $jen)
                    <div class="">
                        <h5 class="text-center text-primary  m-0">{{ $jen->dokumens_count }}</h5>
                        <p class="m-0">{{ $jen->nama_jenis }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
