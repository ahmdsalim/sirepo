@extends('layouts.apperrors')
@section('errtitle','Halaman tidak ditemukan!')
@section('errcode','404')
@section('errmsg','Halaman yang Anda cari tidak ditemukan.')
@section('content')
			<div class="content__boxed">
                <div class="content__wrap">

                    <!-- Action buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" onclick="window.history.back()" class="btn btn-light">Kembali</button>
                        <a href="/" class="btn btn-primary">Ke Beranda</a>
                    </div>
                    <!-- END : Action buttons -->

                </div>
            </div>
@endsection