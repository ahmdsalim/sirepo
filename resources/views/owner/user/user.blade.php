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
        Manjemen User
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
                                @if(auth()->user()->role !== 'sekolah')                                    
                                    <a href="{{ route('users.create') }}"
                                        class="btn btn-primary hstack gap-2 align-self-center">
                                        <i class="demo-psi-add fs-5"></i>
                                        <span class="vr"></span>
                                        Tambah Data
                                    </a>
                                    @endif
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
                                                <li><a class="dropdown-item" href="{{route ('user.cetak.pdf') }}">PDF</a></li>
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
                                                <th>Status</th>
                                                <th>Akses</th>
                                                <th class="text-center">Aksi</th>
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
                                                <td class="fs-5">
                                                    <div class="badge {{$user->active ? 'bg-success' : 'bg-danger'}}">{{$user->active ? 'Active' : 'Inactive'}}</div>
                                                </td>
                                                <td>{{ucfirst($user->role)}}</td>
                                                <td>
                                                    <div class="text-nowrap text-center">
                                                        <a href="{{route('users.show',$user->id)}}" class="btn btn-icon btn-sm btn-light"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 256 256">
                                                                <path fill="currentColor" d="M247.31 124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57 61.26 162.88 48 128 48S61.43 61.26 36.34 86.35C17.51 105.18 9 124 8.69 124.76a8 8 0 0 0 0 6.5c.35.79 8.82 19.57 27.65 38.4C61.43 194.74 93.12 208 128 208s66.57-13.26 91.66-38.34c18.83-18.83 27.3-37.61 27.65-38.4a8 8 0 0 0 0-6.5ZM128 192c-30.78 0-57.67-11.19-79.93-33.25A133.47 133.47 0 0 1 25 128a133.33 133.33 0 0 1 23.07-30.75C70.33 75.19 97.22 64 128 64s57.67 11.19 79.93 33.25A133.46 133.46 0 0 1 231.05 128c-7.21 13.46-38.62 64-103.05 64Zm0-112a48 48 0 1 0 48 48a48.05 48.05 0 0 0-48-48Zm0 80a32 32 0 1 1 32-32a32 32 0 0 1-32 32Z"></path>
                                                            </svg></a>
                                                        <a href="{{route('users.edit',$user->id)}}" class="btn btn-icon btn-sm btn-light"><svg
                                                                fill="none" stroke="currentColor" stroke-width="1.5"
                                                                width="18" height="18" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
                                                                </path>
                                                            </svg></a>
                                                        <form class="d-inline-block" action="{{route('users.destroy',$user->id)}}" method="POST">
                                                        @method('delete')
                                                        @csrf    
                                                        <button type="button" class="btn btn-icon btn-sm btn-light" onclick="confirmOnDel(this)"><svg
                                                                fill="none" stroke="currentColor" stroke-width="1.5"
                                                                width="18" height="18" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
                                                                </path>
                                                            </svg></button>
                                                        </form>
                                                    </div>
                                                </td>
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