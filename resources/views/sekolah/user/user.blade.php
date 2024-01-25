@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('users.index') }}">User</a></li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">User</h1>
    <p class="lead">
        Manajemen User
    </p>
@endsection

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <!-- <h5 class="card-title mb-3">Data User</h5> -->
                            <div class="row">
                                <!-- Left toolbar -->
                                <div class="col-md-6 d-flex gap-1 align-items-center mb-3">
                                    <button class="btn btn-icon btn-outline-light">
                                        <i class="demo-pli-printer fs-5"></i>
                                    </button>
                                    <div class="btn-group">

                                        <div class="btn-group dropdown">
                                            <button class="btn btn-icon btn-outline-light" data-bs-toggle="dropdown"
                                                aria-expanded="false"><svg fill="none" stroke="currentColor"
                                                    stroke-width="1.5" width="18" height="18" viewBox="0 0 24 24"
                                                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m.75 12l3 3m0 0l3-3m-3 3v-6m-1.5-9H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z">
                                                    </path>
                                                </svg>
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li><a class="dropdown-item" href="#">PDF</a></li>
                                                <li><a class="dropdown-item" href="{{ route('users.export') }}">Excel</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <!-- END : Left toolbar -->

                                <!-- Right Toolbar -->
                                <div class="col-md-6 d-flex gap-1 align-items-center justify-content-md-end mb-3">
                                    <div class="">
                                        <!-- Searchbox input -->
                                        <form class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                                            <input id="header-search-input" class="searchbox__input form-control "
                                                type="search" name="search" placeholder="Cari.." value="{{$search}}" aria-label="Search">
                                            <div class="searchbox__backdrop">
                                                <button
                                                    class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm"
                                                    type="sumbit" id="button-addon2">
                                                    <i class="demo-pli-magnifi-glass"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- END : Right Toolbar -->

                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-md-12 mb-3">
                                <div class="table-responsive text-wrap">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>ID (NISN/NIP)</th>
                                                <th>Status</th>
                                                <th>Akses</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $startIndex = ($users->currentPage() - 1) * $users->perPage() + 1;
                                            @endphp
                                            @forelse($users as $user)
                                            <tr>
                                                <th class="text-center">{{$startIndex++}}</th>
                                                <td>{{$user->nama}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->role == 'siswa' ? $user->userable->nisn : $user->userable->nip}}</td>
                                                <td class="fs-5">
                                                    <div class="badge {{$user->active ? 'bg-success' : 'bg-danger'}}">{{$user->active ? 'Active' : 'Inactive'}}</div>
                                                </td>
                                                <td>{{ucfirst($user->role)}}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td align="center" colspan="6">Data tidak ditemukan</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>

                                    <div class="d-flex justify-content-center">
                                        {!! $users->links() !!}
                                    </div>
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
@vite('resources/assets/js/alert.js')
@endpush