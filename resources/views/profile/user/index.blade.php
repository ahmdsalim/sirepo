@extends('layouts.applanding')
@section('breadcrumb') 
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('landing') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="#">Profile</a></li>
    </ol> 
@endsection

@section('pagetitle')
     <div class="page-title mb-0 mt-2 text-center mb-4">
        <figure class="m-0">
           <div class="d-inline-flex position-relative pt-xl-3 mb-3">
              <div class="flex-shrink-0">   
                <h1 class="mb-2">Profile</h1>
                 <img class="img-xl rounded-circle" src="{{asset('assets/img/profile-photos/1.png')}}" alt="Profile Picture" loading="lazy">
              </div>
            </div>
              <div class="flex-grow-1">
                 <h5 class="text-muted m-0">{{auth()->user()->role}}</h5>
                 <h5 class="text-muted m-0">{{auth()->user()->email}}</h5>
              </div>
        </figure>
     </div>
@endsection

@section('content')
  @if(auth()->user()->role == 'siswa')
  <div class="content__boxed">
     <div class="content__wrap">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
        <div class="card bg-white p-4">
          <div class="card-body justify-content-center">
                <div class="col-12">
                   <div class="row g-3 justify-content-center">
                      <div class="col-6">
                         <label class="mb-1">Nama Siswa</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->nama}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">NISN</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->nisn}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">NPSN</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->npsn}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">No Telepon</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->telepon}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">Asal Sekolah</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->sekolah->nama}}</div>
                      </div>
                      <div class="col-6">
                      </div>
                   </div>
                </div>
             </div>
            
          </div>
        </div>
     </div>
  </div>
  @elseif(auth()->user()->role == 'guru')
  <div class="content__boxed">
     <div class="content__wrap">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-5">
        <div class="card bg-white p-4">
          <div class="card-body justify-content-center">
                <div class="col-12">
                   <div class="row g-3 justify-content-center">
                      <div class="col-6">
                         <label class="mb-1">Nama Guru</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->nama}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">NIP</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->nip}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">NPSN</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->npsn}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">No Telepon</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->telepon}}</div>
                      </div>
                      <div class="col-6">
                         <label class="mb-1">Asal Sekolah</label>
                         <div class="fw-bold text-dark">{{auth()->user()->userable->sekolah->nama}}</div>
                      </div>
                      <div class="col-6">
                      </div>
                   </div>
                </div>
             </div>
            
          </div>
        </div>
     </div>
  </div>
  @endif
@endsection