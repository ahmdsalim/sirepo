@extends('layouts.apperrors')
@section('errtitle','Halaman Kedaluwarsa')
@section('errcode','419')
@section('errmsg','Mohon maaf, sesi Anda telah kedaluwarsa. Silahkan refresh dan coba lagi.')
@section('content')
			<div class="content__boxed">
                <div class="content__wrap">

                    <!-- Action buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <a href="/" class="btn btn-primary">Ke Beranda</a>
                    </div>
                    <!-- END : Action buttons -->

                </div>
            </div>
@endsection
