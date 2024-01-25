@extends('layouts.apperrors')
@section('errtitle','Layanan Tidak Tersedia')
@section('errcode','503')
@section('errmsg','Server untuk sementara tidak dapat melayani permintaan Anda karena waktu henti pemeliharaan atau masalah kapasitas.')
@section('content')
			<div class="content__boxed">
                <div class="content__wrap">

                    <!-- Action buttons -->
                    <div class="text-center fs-5">
                        Mohon coba lagi nanti.
                    </div>
                    <!-- END : Action buttons -->

                </div>
            </div>
@endsection