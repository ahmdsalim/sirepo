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
                <form class="form" action="{{ route('dokumens.update', $dokumen->hash_id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" id="judul"
                                        class="form-control @error('judul') is-invalid @enderror"
                                        value="{{ old('judul', $dokumen->judul ?? '') }}" placeholder="Judul dokumen"
                                        name="judul" required>
                                    @error('judul')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="abstrak" class="form-label">Abstrak</label>
                                    <textarea class="form-control @error('abstrak') is-invalid @enderror" name="abstrak" id="abstrak" rows="4"
                                        placeholder="Abstrak minimal 100 karakter" style="resize: none;" required>{{ old('abstrak', $dokumen->abstrak ?? '') }}</textarea>
                                    @error('abstrak')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="keyword" class="form-label">Keyword</label>
                                    <input type="text" id="keyword"
                                        class="form-control @error('keyword') is-invalid @enderror"
                                        value="{{ old('keyword', $dokumen->keyword ?? '') }}"
                                        placeholder="Laravel, Prototyping, BPMN.." name="keyword" required>
                                    @error('keyword')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="jenis" class="form-label">Jenis Dokumen</label>
                                    <select id="jenis" class="form-select @error('tahun') is-invalid @enderror"
                                        name="jenis" required>
                                        <option value="">Pilih</option>
                                        @foreach ($jenis as $row)
                                            <option value="{{ $row->hash_id }}" @selected(old('jenis', $dokumen->hash_jenis_id ?? '') == $row->hash_id)>
                                                {{ $row->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                    @error('jenis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" id="penulis"
                                        class="form-control @error('penulis') is-invalid @enderror"
                                        value="{{ old('penulis', $dokumen->penulis ?? '') }}" placeholder="Penulis"
                                        name="penulis" required>
                                    @error('penulis')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="pembimbing" class="form-label">Pembimbing</label>
                                    <input type="text" id="pembimbing"
                                        class="form-control @error('pembimbing') is-invalid @enderror"
                                        value="{{ old('pembimbing', $dokumen->pembimbing ?? '') }}"
                                        placeholder="Pembimbing 1, Pembimbing 2" name="pembimbing" required>
                                    @error('pembimbing')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="penguji" class="form-label">Penguji</label>
                                    <input type="text" id="penguji"
                                        class="form-control @error('penguji') is-invalid @enderror"
                                        value="{{ old('penguji', $dokumen->penguji ?? '') }}" placeholder="Penguji"
                                        name="penguji" required>
                                    @error('penguji')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" id="tahun"
                                        class="form-control @error('tahun') is-invalid @enderror"
                                        value="{{ old('tahun', $dokumen->tahun ?? '') }}" min="2000"
                                        max="{{ now() }}" placeholder="Tahun" name="tahun" required>
                                    @error('tahun')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <div class="text-muted mt-2 fst-italic">File saat ini:</div>
                                    <ul class="ps-0" style="list-style: none;">
                                        @forelse ($dokumen->file as $i => $value)
                                            <li>
                                                <a href="{{ route('file.get', $value) }}"
                                                    target="_blank">{{ $value }}</a>
                                                <button type="button"
                                                    class="border-0 text-danger fw-bold delete-button"
                                                    data-id="{{ $dokumen->hash_id }}"
                                                    data-fileid="{{ (new App\Services\HashIdService())->encode($i) }}"
                                                    style="background: none;">x</button>
                                            </li>
                                        @empty
                                            <li>-- Tidak ada file --</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="files" class="form-label">File <span
                                            class="text-muted small">Unggah file sampai dengan 10MB dalam format
                                            PDF.</span></label>
                                    <input class="form-control @error('files') is-invalid @enderror" name="files[]"
                                        type="file" multiple accept=".pdf" id="files">
                                    @error('files')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                    @error('filenames')
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
        <div class="toast-container position-fixed top-0 end-0 p-3">
            <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <svg class="bd-placeholder-img rounded me-2" width="20" height="20"
                        xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice"
                        focusable="false">
                        <rect width="100%" height="100%" fill="#198754" id="toastRect"></rect>
                    </svg>
                    <strong class="me-auto" id="toastType">Success</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body" id="toastMessage">
                    Berhasil mengupdate data dokumen.
                </div>
            </div>
        </div>
    </section>
    @push('scripts')
        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                $('.delete-button').on('click', function() {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "File dokumen yang dipilih akan dihapus",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#233446',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.value) {
                            const fileid = $(this).data('fileid')
                            const dataid = $(this).data('id')
                            const data = {
                                fileid: fileid
                            }
                            const url = "{{ route('dokumens.destroyFile', ['id' => ':data']) }}"
                            const bindUrl = url.replace(':data', dataid)
                            $.ajax({
                                url: bindUrl,
                                type: "DELETE",
                                data: JSON.stringify(data),
                                dataType: "JSON",
                                proccessData: false,
                                contentType: "application/json",
                                success: (response) => {
                                    $(this).closest('li').remove()
                                    toast(undefined, undefined, response.success)
                                },
                                error: function(xhr, status, error) {
                                    var errors = xhr.responseJSON.errors
                                    toast("#dc3545", "Failed", errors)
                                }
                            })
                        }
                    })
                })

                $('#files').on('change', function(e) {
                        var files = e.target.files
                        var filenames = []

                        for (var i = 0; i < files.length; i++) {
                            // Meminta pengguna memberikan nama untuk setiap file yang dipilih
                            var name = prompt('Masukkan nama untuk file ' + files[i].name + ':')
                            if (name === '' || name === null) {
                                // Jika pengguna membatalkan input, hentikan proses
                                $('#files').val('')
                                alert('Nama file harus diisi')
                                return
                            }

                            // Validasi nama file
                            var regex = /^[a-zA-Z0-9_\-\s]+$/;
                            if (!regex.test(name)) {
                                $('#files').val('').removeAttr('data-filenames')
                                alert( <<
                                        << << <
                                        HEAD 'Nama file hanya boleh mengandung huruf, angka, spasi, _ (underscore), dan - (dash)'
                                    ) ===
                                    === =
                                    'Nama file hanya boleh mengandung huruf, angka, spasi, _ (underscore), dan - (dash)'
                                ) >>>
                            >>> > fd4161ef46cd5b745a3d5ba8847a374e8b159051
                            return
                        }

                        filenames.push(name)
                    }

                    if ($(this)[0].files.length === 0) {
                        $('.file-name').remove()
                    }

                    // Buat elemen input teks setelah elemen input file
                    var elInput = $(this)
                    for (var j = 0; j < filenames.length; j++) {
                        var inputText =
                            `<input class="file-name" type="hidden" name="filenames[${j}]" value="${filenames[j]}">`
                        elInput.after(inputText)
                    }
                })


            function toast(color = "#198754", type = "Success", message = "Berhasil mengupdate data") {
                $("#toastRect").attr("fill", color)
                $("#toastType").text(type)
                $("#toastMessage").text(message)
                const toastContainer = $("#liveToast")
                const toast = new bootstrap.Toast(toastContainer)
                toast.show()
            }
            })
        </script>
    @endpush
</x-app-layout>
