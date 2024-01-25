@extends('layouts.apperrors')
@section('errtitle','Server Error')
@section('errcode','500')
@section('errmsg','Server mengalami kesalahan internal atau kesalahan konfigurasi dan tidak dapat menyelesaikan permintaan Anda.')
@section('content')
			<div class="content__boxed">
                <div class="content__wrap">
                    <div class="text-center fs-5">
                        Mohon kembali dan coba lagi.
                    </div>
                </div>
            </div>
@endsection