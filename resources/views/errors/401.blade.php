@extends('layouts.apperrors')
@section('errtitle','Akses Tidak Sah')
@section('errcode','401')
@section('errmsg','Permintaan Anda tidak dapat diproses.')
@section('content')
			<div class="content__boxed">
                <div class="content__wrap">

                    <!-- Action buttons -->
                    <div class="d-flex justify-content-center gap-3">
                        <button type="button" onclick="window.history.back()" class="btn btn-light">Kembali</button>
                    </div>
                    <!-- END : Action buttons -->

                </div>
            </div>
@endsection