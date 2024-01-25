@extends('layouts.appnifty')

@push('css')
<style>
    input[type="number"]::-webkit-inner-spin-button,
    input[type="number"]::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    input[type="number"] {
        -moz-appearance: textfield;
    }
</style>
@endpush

@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sekolah.siswa.index') }}">Siswa</a></li>
        <li class="breadcrumb-item active" aria-current="page">@if(isset($siswa)) Edit @else Tambah @endif Siswa</li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">Siswa</h1>
    <p class="lead">
        Manajemen Siswa
    </p>
@endsection

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <section>
                <div class="row">
                    <div class="col-md-12 mb-3">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">@if(isset($siswa)) Edit @else Tambah @endif Siswa</h5>
                                <!-- Block styled form -->
                                @if (isset($siswa))
                                <form class="row g-3" method="post" action="{{ route('sekolah.siswa.update', $siswa->nisn) }}">
                                @method('PUT')
                                @else
                                <form class="row g-3" method="post" action="{{ route('sekolah.siswa.store') }}">
                                @endif
                                @csrf
                                   <div class="col-md-6">
                                      <label class="form-label">NISN</label>
                                      <input type="text" class="form-control @error('nisn') is-invalid @enderror" name="nisn" value="{{ old('nisn', $siswa->nisn ?? '') }}" required="">
                                      @error('nisn')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Nama</label>
                                      <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $siswa->nama ?? '') }}" required="">
                                      @error('nama')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Jenis Kelamin</label>
                                      <select class="form-select @error('jk') is-invalid @enderror" name="jk" required="">
                                         <option value="">Pilih</option>
                                         <option value="L" @selected(old('jk', $siswa->jk ?? '') == 'L')>Laki-laki</option>
                                         <option value="P" @selected(old('jk', $siswa->jk ?? '') == 'P')>Perempuan</option>
                                      </select>
                                      @error('jk')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Nomor Telepon</label>
                                      <input type="number" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $siswa->telepon ?? '') }}" required="">
                                      @error('telepon')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-12"> 
                                      <button type="submit" class="btn btn-primary">Submit</button>
                                   </div>
                                </form>
                                <!-- END : Block styled form -->
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection