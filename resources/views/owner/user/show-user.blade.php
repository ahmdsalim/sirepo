@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item"><a href="{{ route('users.index') }}">User</a></li>
        <li class="breadcrumb-item active" aria-current="page">Show</li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">@if($user->role == 'owner'){{$user->nama}}@else {{ $user->userable->nama }} @endif</h1>
    <p class="lead">
        @if($user->role == 'owner' || $user->role == 'sekolah')
        {{ ucfirst($user->role) }}
        @else
        {{ $user->userable->sekolah->nama }} ({{ $user->userable->sekolah->npsn }})
        @endif
    </p>
@endsection

@section('content')
    <div class="content__boxed">
       <div class="content__wrap">
          <div class="row">
             <div class="col-md-6 mb-3">
                <div class="card h-100">
                   <div class="card-body">
                      <h5 class="card-title">Informasi {{ucfirst($user->role)}}</h5>
                      <!-- Custom content -->
                      <div class="list-group">
                         <a href="javascript:void();" class="list-group-item list-group-item-action active" aria-current="true">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">@if($user->role == 'sekolah') NPSN @elseif($user->role == 'siswa') NISN @elseif($user->role == 'owner') E-mail @else NIP @endif</h5>
                            </div>
                            <p class="mb-1">@if($user->role == 'sekolah') {{$user->userable->npsn}} @elseif($user->role == 'siswa') {{$user->userable->nisn}} @elseif($user->role == 'owner') {{$user->email}} @else {{$user->userable->nip}} @endif</p>
                         </a>
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Nama</h5>
                            </div>
                            <p class="mb-1">@if($user->role !== 'owner'){{ucwords($user->userable->nama)}} @else {{$user->nama}} @endif</p>
                         </a>

                         @if($user->role == 'siswa' || $user->role == 'guru')
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Jenis Kelamin</h5>
                            </div>
                            <p class="mb-1">@if($user->userable->jk == 'L') Laki-laki @else Perempuan @endif</p>
                         </a>
                         @endif

                         @if($user->role == 'sekolah')
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Jenjang</h5>
                            </div>
                            <p class="mb-1">{{strtoupper($user->userable->jenjang)}}</p>
                         </a>
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Alamat</h5>
                            </div>
                            <p class="mb-1">{{$user->userable->alamat}}, {{$user->userable->kelurahan}}, {{$user->userable->kecamatan}}, {{$user->userable->kota}}, {{$user->userable->provinsi}}</p>
                         </a>
                         @endif

                         @if($user->role != 'owner')
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">E-mail</h5>
                            </div>
                            <p class="mb-1">{{$user->email}}</p>
                         </a>
                         <a href="javascript:void();" class="list-group-item list-group-item-action">
                            <div class="d-flex w-100 justify-content-between">
                               <h5 class="mb-1">Nomor Telepon</h5>
                            </div>
                            <p class="mb-1">{{$user->userable->telepon}}</p>
                         </a>
                         @endif
                      </div>
                      <!-- END : Custom content -->
                   </div>
                </div>
             </div>
          </div>
       </div>
    </div>
@endsection