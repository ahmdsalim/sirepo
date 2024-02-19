@extends('layouts.app')

@section('content')
    <div class="container position-absolute bottom-25" style="top:40%">
        <div class="row justify-content-center gap-4">
            <div class="col-md-8">
                <h1 class="text-center pt-serif">AYO JANGAN MALU MENCARI</h1>
                <form id="">
                    @csrf
                    <input class="form-control py-3 px-4 shadow-sm" type="search" name="search"
                        placeholder="Judul,Author,Proyek1,Proyek2,....">
                </form>
            </div>
            <div class="d-flex justify-content-center gap-2">
                <div class="card p-2 shadow-sm">
                    <p class="m-0">Proyek 1: 20000</p>
                </div>
                <div class="card p-2 shadow-sm">
                    <p class="m-0">Proyek 2: 20000</p>
                </div>
                <div class="card p-2 shadow-sm">
                    <p class="m-0">PKL: 20000</p>
                </div>
                <div class="card p-2 shadow-sm">
                    <p class="m-0">Tugas Akhir: 20000</p>
                </div>
                <div class="card p-2 shadow-sm">
                    <p class="m-0">E-Jurnal: 20000</p>
                </div>
            </div>
        </div>
    </div>
@endsection
