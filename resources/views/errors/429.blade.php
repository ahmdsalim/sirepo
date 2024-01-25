@extends('layouts.apperrors')
@section('errtitle','Terlalu Banyak Permintaan')
@section('errcode','419')
@section('errmsg','Anda telah mengirim terlalu banyak permintaan dalam jangka waktu tertentu.')
@section('content')
			<div class="content__boxed">
                <div class="content__wrap">
                	<div class="text-center fs-5">
                        Mohon coba lagi nanti.
                    </div>
                </div>
            </div>
@endsection
