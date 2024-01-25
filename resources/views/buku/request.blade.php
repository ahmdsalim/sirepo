@extends('layouts.appnifty')
@section('breadcrumb')
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item"><a href="{{ route('sekolah.index') }}">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page"><a href="{{ route('buku.index') }}">Buku</a></li>
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
                                    <button class="btn btn-icon btn-outline-light">
                                        <i class="demo-pli-printer fs-5"></i>
                                    </button>

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
                                                <th>Foto</th>
                                                <th>Judul</th>
                                                <th>Kategori</th>
                                                <th>Pengarang</th>
                                                <th>Penerbit</th>
                                                <th>No ISBN</th>
                                                <th>Pemilik</th>
                                                <th class="text-center">Status</th>
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
                                                @foreach ($data as $index => $buku)
                                                    <tr class="align-middle">
                                                        <th scope="row">{{ $index + $data->firstItem() }}</th>
                                                        <td>
                                                            @if ($buku->thumbnail)
                                                            <img src="{{ asset('storage/imgs/thumbnail-buku/' . $buku->thumbnail) }}"
                                                                alt="{{ $buku->judul }}" style="width: 50px;">
                                                        @else
                                                            <img src="{{ asset('storage/imgs/default-pict.png') }}"
                                                                alt="Foto Default" style="width: 50px;">
                                                        @endif
                                                        </td>
                                                        <td>{{ $buku->judul }}</td>
                                                        <td>{{ $buku->kategori->kategori }}</td>
                                                        <td>{{ $buku->penulis }}</td>
                                                        <td>{{ $buku->penerbit }}</td>
                                                        <td>{{ $buku->no_isbn }}</td>
                                                        <td>{{ $buku->user->nama }}</td>
                                                        <td class="fs-5">
                                                            @if ($buku->publish == 1)
                                                                <div class="badge d-block bg-success">Publish</div>
                                                            @else
                                                                <div class="badge d-block bg-secondary">Pending</div>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex gap-2 justify-content-center">
                                                                <form action="{{ route('buku.requestUpdate', $buku->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT') {{-- Tambahkan ini untuk menggunakan method PUT --}}
                                                                    <input type="hidden" name="action" value="terima">
                                                                    {{-- Nilai "terima" untuk tombol Terima --}}
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-primary">Terima</button>
                                                                </form>
                                                                <form action="{{ route('buku.requestUpdate', $buku->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT') {{-- Tambahkan ini untuk menggunakan method PUT --}}
                                                                    <input type="hidden" name="action" value="tolak">
                                                                    {{-- Nilai "tolak" untuk tombol Tolak --}}
                                                                    <button type="submit"
                                                                        class="btn btn-sm btn-danger">Tolak</button>
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
@endsection
