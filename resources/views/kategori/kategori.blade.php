@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('kategori.index') }}">Kategori</a></li>
    </ol>
@endsection

@section('pagetitle')
    <h1 class="page-title mb-0 mt-2">{{ $tittle }}</h1>
    {{-- <p class="lead">
        A widget is an element of a graphical user interface that displays information or provides a specific way for a user
        to interact.
    </p> --}}
@endsection

@section('content')
    <div class="content__boxed">
        <div class="content__wrap">
            <div class="row">
                <div class="col-xl-12 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-3">{{ $header }}</h5>
                            <div class="row">
                                <!-- Left toolbar -->
                                <div class="col-md-6 d-flex gap-1 align-items-center mb-3">
                                    <a href="{{ route('kategori.create') }}"
                                        class="btn btn-primary hstack gap-2 align-self-center">
                                        <i class="demo-psi-add fs-5"></i>
                                        <span class="vr"></span>
                                        Tambah Data
                                    </a>
                                </div>
                                <!-- END : Left toolbar -->

                                <!-- Right Toolbar -->
                                <div class="col-md-6 d-flex gap-1 align-items-center justify-content-md-end mb-3">
                                    <div class="">
                                        <!-- Searchbox input -->
                                        <form class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                                            <input id="header-search-input" class="searchbox__input form-control "
                                                type="search" placeholder="Cari.." aria-label="Search">
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
                                                <th>Kategori</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($data->isEmpty())
                                                <tr>
                                                    <td colspan="9">
                                                        <div class="col-sm-12 col-md-12 text-center">
                                                            {{ $kosong }}
                                                        </div>
                                                    </td>
                                                </tr>
                                            @else
                                                @foreach ($data as $index => $kategori)
                                                    <tr class="align-middle">
                                                        <th class="text-center">{{ $index + $data->firstItem() }}</th>
                                                        <td>{{ $kategori->kategori }}</td>
                                                        <td>
                                                            <div class="text-nowrap text-center">
                                                                <a href="{{ route('kategori.edit', $kategori->id) }}"
                                                                    class="btn btn-icon btn-sm btn-light"><svg
                                                                        fill="none" stroke="currentColor"
                                                                        stroke-width="1.5" width="18" height="18"
                                                                        viewBox="0 0 24 24"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        aria-hidden="true">
                                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10">
                                                                        </path>
                                                                    </svg></a>
                                                                    <form class="d-inline-block"
                                                                        action="{{ route('kategori.destroy', $kategori->id) }}"
                                                                        method="POST">
                                                                        @method('delete')
                                                                        @csrf
                                                                        <button type="button"
                                                                            class="btn btn-icon btn-sm btn-light"
                                                                            onclick="confirmOnDel(this)"><svg
                                                                                fill="none" stroke="currentColor"
                                                                                stroke-width="1.5" width="18"
                                                                                height="18" viewBox="0 0 24 24"
                                                                                xmlns="http://www.w3.org/2000/svg"
                                                                                aria-hidden="true">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0">
                                                                                </path>
                                                                            </svg></button>
                                                                    </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="card-footer">
                                {{ $data->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        @vite('resources/assets/js/alert.js')
    @endpush
@endsection
