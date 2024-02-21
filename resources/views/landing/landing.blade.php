@extends('layouts.app')

@section('content')
    <div class="container position-absolute bottom-25" style="top:40%">
        <div class="row justify-content-center gap-4">
            <div class="col-md-8">
                <h1 class="text-center pt-serif">AYO JANGAN MALU MENCARI</h1>
                @include('landing.searchbar')
            </div>

            <div class="d-flex justify-content-center gap-2">
                @foreach ($jenis as $jen)
                <div class="card p-2 shadow-sm">
                    <p class="m-0">{{ $jen->nama_jenis .': '. $jen->dokumens_count }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
