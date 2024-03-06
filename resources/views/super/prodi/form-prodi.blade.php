<x-app-layout title="Kelola Prodi">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Prodi</h3>
                <p class="text-subtitle text-muted">Prodi</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/users">Prodi</a></li>
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
                    Edit Data Prodi
                </h5>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('prodi.update', $prodi->kode_prodi) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="kode_prodi" class="form-label">Kode Prodi</label>
                            <input type="text" id="kode_prodi"
                                class="form-control @error('kode_prodi') is-invalid @enderror"
                                placeholder="Masukkan kombinasi huruf dan angka"
                                value="{{ old('kode_prodi', $prodi->kode_prodi ?? '') }}" name="kode_prodi" required>
                            @error('kode_prodi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="nama_prodi" class="form-label">Nama Prodi</label>
                            <input type="text" id="nama_prodi"
                                class="form-control @error('nama_prodi') is-invalid @enderror"
                                placeholder="Masukkan nama prodi"
                                value="{{ old('nama_prodi', $prodi->nama_prodi ?? '') }}" name="nama_prodi" required>
                            @error('nama_prodi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12 d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>
