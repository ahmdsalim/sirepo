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
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
        <li class="breadcrumb-item"><a href="{{ route('owner.guru.index',$guru->npsn) }}">Guru</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Guru</li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">Guru</h1>
    <p class="lead">
        {{$guru->sekolah->nama}}
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
                                <h5 class="card-title">Edit Guru</h5>
                                <!-- Block styled form -->
                                <form class="row g-3" method="post" action="{{ route('owner.guru.update', $guru->id) }}">
                                @method('PUT')
                                @csrf
                                   <div class="col-md-6">
                                      <label class="form-label">Nama</label>
                                      <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $guru->nama ?? '') }}" required="">
                                      @error('nama')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">NISN</label>
                                      <input type="text" class="form-control @error('nip') is-invalid @enderror" name="nip" value="{{ old('nip', $guru->nip ?? '') }}" required="">
                                      @error('nip')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Jenis Kelamin</label>
                                      <select class="form-select @error('jk') is-invalid @enderror" name="jk" required="">
                                         <option value="L" @selected(old('jk', $guru->jk ?? '') == 'L')>Laki-laki</option>
                                         <option value="P" @selected(old('jk', $guru->jk ?? '') == 'P')>Perempuan</option>
                                      </select>
                                      @error('jk')
                                      <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                      </span>
                                      @enderror                    
                                   </div>
                                   <div class="col-md-6">
                                      <label class="form-label">Nomor Telepon</label>
                                      <input type="number" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $guru->telepon ?? '') }}" required="">
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