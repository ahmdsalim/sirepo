<x-app-layout title="Edit Dokumen">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Dokumen</h3>
                <p class="text-subtitle text-muted">Dokumen</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="/home">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="/dokumens">Dokumen</a></li>
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
                    Edit Data Dokumen
                </h5>
            </div>
            <div class="card-body">
                <form class="form" action="{{ route('dokumens.update', $dokumen->hash_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" id="judul" class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $dokumen->judul ?? '') }}" placeholder="Judul dokumen" name="judul" required>
                                    @error('judul')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="abstrak" class="form-label">Abstrak</label>
                                    <textarea class="form-control @error('abstrak') is-invalid @enderror" name="abstrak" id="abstrak" rows="4" placeholder="Abstrak minimal 100 karakter" style="resize: none;" required>{{ old('abstrak', $dokumen->abstrak ?? '') }}</textarea>
                                    @error('abstrak')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="keyword" class="form-label">Keyword</label>
                                    <input type="text" id="keyword" class="form-control @error('keyword') is-invalid @enderror" value="{{ old('keyword', $dokumen->keyword ?? '') }}" placeholder="Laravel, Prototyping, BPMN.." name="keyword" required>
                                    @error('keyword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" id="penulis" class="form-control @error('penulis') is-invalid @enderror" value="{{ old('penulis', $dokumen->penulis ?? '') }}" placeholder="Penulis, Pembimbing 1, Pembimbing 2/Penguji" name="penulis" required>
                                    @error('penulis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" id="tahun" class="form-control @error('tahun') is-invalid @enderror" value="{{ old('tahun', $dokumen->tahun ?? '') }}" min="2000" max="{{ now() }}" placeholder="Tahun" name="tahun" required>
                                    @error('tahun')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="jenis" class="form-label">Jenis Dokumen</label>
                                    <select id="jenis" class="form-select @error('tahun') is-invalid @enderror" name="jenis" required>
                                        <option value="">Pilih</option>
                                        @foreach($jenis as $row)
                                        <option value="{{ $row->hash_id }}" @selected(old('jenis', $dokumen->hash_jenis_id ?? '') == $row->hash_id)>{{ $row->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <span class="text-muted mt-2 fst-italic">File saat ini: <a href="{{ Storage::url('file-dokumen/'.$dokumen->file) }}" target="_blank"><i class="bi bi-file-earmark-pdf-fill"></i> {{ $dokumen->file }}'</a></span>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="file" class="form-label">File <span class="text-muted small">Unggah file sampai dengan 10MB dalam format PDF.</span></label>
                                    <input class="form-control @error('file') is-invalid @enderror" name="file" type="file" id="file">
                                    @error('file')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>