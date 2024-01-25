@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Sekolah</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show</li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">{{ $sekolah->nama }}</h1>
    <p class="lead">
        ({{ $sekolah->npsn }})
    </p>
@endsection

@section('content')
    <div class="content__boxed">
       <div class="content__wrap">
          <div class="row">
             <div class="col-md-6 mb-3">
                <div class="card h-100">
                   <div class="card-body">
                      <h5 class="card-title">Informasi Sekolah</h5>
                      <!-- Custom content -->
                      <div class="list-group">
                         <a href="javascript:void();" class="list-group-item list-group-item-action active" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">NPSN</h5>
                            </div>
                            <p class="mb-1">{{$sekolah->npsn}}</p>
                         </a>
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Nama Sekolah</h5>
                            </div>
                            <p class="mb-1">{{$sekolah->nama}}</p>
                         </a>

                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Jenjang</h5>
                            </div>
                            <p class="mb-1">{{strtoupper($sekolah->jenjang)}}</p>
                         </a>
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Alamat</h5>
                            </div>
                            <p class="mb-1">{{$sekolah->alamat}}, Kel. {{explode('-',$sekolah->kelurahan)[1]}}, Kec. {{explode('-',$sekolah->kecamatan)[1]}}, {{explode('-',$sekolah->kota)[1]}}, {{explode('-',$sekolah->provinsi)[1]}}</p>
                         </a>

                         @if(isset($sekolah->user))
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">E-mail</h5>
                            </div>
                            <p class="mb-1">{{$sekolah->user->email}}</p>
                         </a>
                         @endif

                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Nomor Telepon</h5>
                            </div>
                            <p class="mb-1">{{$sekolah->telepon}}</p>
                         </a>

                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Status</h5>
                            </div>
                            <p class="mb-1">
                              <div class="badge {{isset($sekolah->user) && $sekolah->user->active ? 'bg-success' : 'bg-danger'}}">{{isset($sekolah->user) && $sekolah->user->active ? 'Member' : 'Non-member'}}</div>
                            </p>
                         </a>
                      </div>
                      <!-- END : Custom content -->
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
@endsection