@extends('layouts.apperrors')
@section('errtitle','Forbidden')
@section('errcode','403')
@section('errmsg','Anda tidak memiliki izin untuk mengakses halaman ini.')
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