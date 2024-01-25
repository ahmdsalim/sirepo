@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
@endsection

@section('pagetitle')
    <h2 class="page-title mb-0 mt-2">{{auth()->user()->nama}}</h2>
    <p class="lead mb-0">
        {{auth()->user()->role}}
    </p>
    <p class="small">{{auth()->user()->email}}</p>
@endsection

@section('content')
@if(auth()->user()->role == 'sekolah')
<div class="content__boxed">
       <div class="content__wrap">
        <div class="card p-4">
          <div class="row">
            <div class="col-12 col-md-8">
              <div class="row g-3">
                <h5 class="mb-1">Informasi Sekolah</h5>
                <div class="col-6">
                  <label class="mb-1">Nama Sekolah</label>
                  <div class="fw-bold text-dark">{{auth()->user()->userable->nama}}</div>
                </div>
                <div class="col-6">
                  <label class="mb-1">NPSN</label>
                  <div class="fw-bold text-dark">{{auth()->user()->userable->npsn}}</div>
                </div>
                <div class="col-6">
                  <label class="mb-1">Jenjang</label>
                  <div class="fw-bold text-dark">{{strtoupper(auth()->user()->userable->jenjang)}}/Sederajat</div>
                </div>
                <div class="col-6">
                  <label class="mb-1">Alamat</label>
                  <div class="fw-bold text-dark">{{auth()->user()->userable->alamat}}</div>
                </div>
                <div class="col-6">
                  <label class="mb-1">Kel/Desa</label>
                  <div class="fw-bold text-dark">{{explode('-',auth()->user()->userable->kelurahan)[1]}}</div>
                </div>
                <div class="col-6">
                  <label class="mb-1">Kecamatan</label>
                  <div class="fw-bold text-dark">{{explode('-',auth()->user()->userable->kecamatan)[1]}}</div>
                </div>
                <div class="col-6">
                  <label class="mb-1">Kab/Kota</label>
                  <div class="fw-bold text-dark">{{explode('-',auth()->user()->userable->kota)[1]}}</div>
                </div>
                <div class="col-6">
                  <label class="mb-1">Provinsi</label>
                  <div class="fw-bold text-dark">{{explode('-',auth()->user()->userable->provinsi)[1]}}</div>
                </div>
              </div>
            </div>
          </div>          
        </div>
       </div>
    </div>
@endif
@endsection