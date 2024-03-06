<x-app-layout title="Kelola Mahasiswa">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Mahasiswa</h3>
                <p class="text-subtitle text-muted">Mahasiswa</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('mahasiswas.index') }}">Mahasiswa</a></li>
                        <li class="breadcrumb-item" aria-current="page">Edit</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">
                    Edit Data Mahasiswa
                </h5>
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('mahasiswas.update', $mhs->npm) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="npm" class="form-label">NPM</label>
                            <input type="text" id="npm" class="form-control @error('npm') is-invalid @enderror"
                                placeholder="npm pengguna" value="{{ old('npm', $mhs->npm ?? '') }}" name="npm"
                                required>
                            @error('npm')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="nama_mahasiswa" class="form-label">Nama</label>
                            <input type="text" id="nama_mahasiswa"
                                class="form-control @error('nama_mahasiswa') is-invalid @enderror"
                                placeholder="nama_mahasiswa"
                                value="{{ old('nama_mahasiswa', $mhs->nama_mahasiswa ?? '') }}" name="nama_mahasiswa"
                                required>
                            @error('nama_mahasiswa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email"
                                class="form-control @error('email') is-invalid @enderror" placeholder="Email pengguna"
                                value="{{ old('email', $mhs->email ?? '') }}" name="email" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-12 ">
                        <div class="form-group mandatory">
                            <label for="prodi_id" class="form-label">Program Studi</label>
                            <select id="prodi_id" class="form-select @error('tahun') is-invalid @enderror"
                                name="prodi_id" required>
                                <option value="">Pilih</option>
                                @foreach ($prodi as $row)
                                    <option value="{{ $row->id }}" @selected(old('prodi', $mhs->prodi_id ?? '') == $row->id)>
                                        {{ $row->nama_prodi }}</option>
                                @endforeach
                            </select>
                            @error('prodi')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="form-group mandatory">
                            <fieldset>
                                <label class="form-label">Status</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_active"
                                            value="1" id="flexRadioDefault1"
                                            data-parsley-multiple="flexRadioDefault"
                                            {{ $mhs->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label form-label" for="flexRadioDefault1">
                                            Aktif
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_active"
                                            value="0" id="flexRadioDefault2"
                                            data-parsley-multiple="flexRadioDefault"
                                            {{ !$mhs->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label form-label" for="flexRadioDefault2">
                                            Non Aktif
                                        </label>
                                    </div>
                            </fieldset>
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
