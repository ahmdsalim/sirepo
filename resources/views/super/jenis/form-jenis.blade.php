<x-app-layout title="Kelola Jenis">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Jenis</h3>
                <p class="text-subtitle text-muted">Jenis dokumen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/jenis">Jenis</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Edit Data Jenis
                </h5>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('jenis.update', $jenis->id) }}" method="POST" id="formjenis">
                    @csrf
                    @method('PUT')
                    <div class="col-md-4 col-sm-12">
                        <div class="input-group">
                            <input class="form-control" type="text" name="nama_jenis" value="{{ $jenis->nama_jenis }}" required="true" id="namajenis" placeholder="Jenis dokumen">
                            <button class="btn btn-primary" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>