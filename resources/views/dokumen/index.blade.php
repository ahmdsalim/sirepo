<x-app-layout title="Kelola Dokumen">
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
                        <li class="breadcrumb-item active" aria-current="page">Dokumen</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card">
            <div class="card-header">
                <div class="d-inline-block user-select-none" id="toggleContainer" style="cursor: pointer;">
                    <span id="toggleText">Tambah</span>
                    <i class="bi bi-chevron-compact-right" id="toggleIcon"></i>
                </div>
            </div>
            <div class="card-body" id="formContainer" style="display: none;">
                <form class="form" id="formDokumen" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="judul" class="form-label">Judul</label>
                                    <input type="text" id="judul" class="form-control"
                                        placeholder="Judul dokumen" name="judul" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="abstrak" class="form-label">Abstrak</label>
                                    <textarea class="form-control" name="abstrak" id="abstrak" rows="4" required
                                        placeholder="Abstrak minimal 100 karakter" style="resize: none;"></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="keyword" class="form-label">Keyword</label>
                                    <input type="text" id="keyword" class="form-control"
                                        placeholder="Laravel, Prototyping, BPMN.." name="keyword" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="jenis" class="form-label">Jenis Dokumen</label>
                                    <select id="jenis" class="form-select" name="jenis" required>
                                        <option value="">Pilih</option>
                                        @foreach ($jenis as $row)
                                            <option value="{{ $row->hash_id }}">{{ $row->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" id="penulis" class="form-control" placeholder="Penulis"
                                        name="penulis" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="pembimbing" class="form-label">Pembimbing</label>
                                    <input type="text" id="pembimbing" class="form-control"
                                        placeholder="Pembimbing" name="pembimbing" required>
                                    <small id="small-tag" style="display: none;">Format: Pembimbing 1/Pebimbing
                                        2</small>

                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="penguji" class="form-label">Penguji</label>
                                    <input type="text" id="penguji" class="form-control" placeholder="Penguji"
                                        name="penguji" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="tahun" class="form-label">Tahun</label>
                                    <input type="number" id="tahun" class="form-control" min="2000"
                                        max="{{ now() }}" onKeyPress="if(this.value.length==4) return false;"
                                        placeholder="Tahun" name="tahun" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-3 mandtory">
                                    <label for="file" class="form-label">File <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="file" name="files[]" id="files"
                                        accept=".pdf" multiple required>
                                    <small><span class="text-muted small">Unggah file sampai dengan 10MB dalam format
                                            PDF.</span></small>
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
        <div class="card">
            <div class="card-header">
                <h5 class="card-title d-flex align-items-center">
                    Data Dokumen
                    <button class="btn p-0 ms-1 border-0" id="refreshData">
                        <i class="bi bi-arrow-clockwise" style="cursor: pointer; font-size: 15px;"></i>
                    </button>
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table" id="datatable" style="width:100%">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Penulis</th>
                                <th>Tahun</th>
                                <th>Jenis Dokumen</th>
                                <th>Uploader</th>
                                <th>File</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="modal fade text-left" id="detailDokumen" tabindex="-1" aria-labelledby="myModalLabel1"
            style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Detail Dok. Penelitian</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                            aria-label="Close">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                                <line x1="18" y1="6" x2="6" y2="18"></line>
                                <line x1="6" y1="6" x2="18" y2="18"></line>
                            </svg>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <label class="small text-muted">Judul</label>
                                <div class="mb-2 modal-data" id="dataJudul">SIBAL Sistem Informasi Ilmu Kebal</div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Abstrak</label>
                                <p class="mb-2 modal-data" id="dataAbstrak"></p>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Penulis</label>
                                <div class="mb-2 modal-data" id="dataPenulis"></div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Pembimbing</label>
                                <div class="mb-2 modal-data" id="dataPembimbing"></div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Penguji</label>
                                <div class="mb-2 modal-data" id="dataPenguji"></div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Jenis Dok. Penelitian</label>
                                <div class="mb-2 modal-data" id="dataJenis"></div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Tahun</label>
                                <div class="mb-2 modal-data" id="dataTahun"></div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Keyword</label>
                                <div class="mb-2 modal-data" id="dataKeyword"></div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">Uploader</label>
                                <div class="mb-2 modal-data" id="dataUploader"></div>
                            </div>
                            <div class="col-12">
                                <label class="small text-muted">File</label>
                                <ul class="modal-data p-0" style="list-style: none;" id="dataFile">
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
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
                    Berhasil menambahkan data dokumen.
                </div>
            </div>
        </div>
    </section>

    @push('styles')
        @vite(['resources/assets/compiled/css/table-datatable-jquery.css', 'resources/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('#jenis').change(function() {
                    var selectedOption = $(this).find(':selected');
                    var namaJenis = selectedOption.text();

                    if (namaJenis === "Tugas Akhir") {
                        $('#small-tag').show();
                    } else {
                        $('#small-tag').hide();
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var input = document.getElementById('tahun');

                // Menonaktifkan tombol minus
                input.addEventListener('keydown', function(e) {
                    if (e.key === '-' || e.key === 'e' || e.key === '.') {
                        e.preventDefault();
                    }
                });
            });
        </script>
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).ready(function() {
                let datatable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('dokumens.getDocuments') }}",
                        type: "POST"
                    },
                    order: ['1', 'DESC'],
                    pageLength: 10,
                    searching: true,
                    columns: [{
                            data: 'judul',
                            name: 'judul',
                        },
                        {
                            data: 'penulis',
                            name: 'penulis',
                        },
                        {
                            data: 'tahun',
                            name: 'tahun',
                        },
                        {
                            data: 'jenis.nama_jenis',
                            name: 'jenis.nama_jenis',
                        },
                        {
                            data: 'user.nama',
                            name: 'user.nama',
                        },
                        {
                            data: 'file',
                            name: 'file',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                            width: "20%",
                        }
                    ]
                });

                const setTableColor = () => {
                    document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                        dt.classList.add('pagination-primary')
                    })
                }
                setTableColor()
                datatable.on('draw', setTableColor)

                $('#datatable').on('click', '.delete-button', function() {
                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Semua data yang berkaitan akan ikut terhapus",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#233446',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Hapus',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.value) {
                            const dataId = $(this).data('id')
                            const data = {
                                id: dataId
                            }
                            const url = "{{ route('dokumens.destroy', ['id' => ':data']) }}"
                            const bindUrl = url.replace(':data', dataId)
                            $.ajax({
                                url: bindUrl,
                                type: "DELETE",
                                data: JSON.stringify(data),
                                dataType: "JSON",
                                proccessData: false,
                                contentType: "application/json",
                                success: (response) => {
                                    refreshData(datatable)
                                    toast(undefined, undefined, response.success)
                                },
                                error: function(xhr, status, error) {
                                    var errors = xhr.responseJSON.errors;
                                    toast("#dc3545", "Failed", errors)
                                }
                            })
                        }
                    })
                });

                const toggleContainer = document.getElementById('toggleContainer')
                $('#toggleContainer').click(function() {
                    const formContainer = $('#formContainer')
                    const toggleText = $('#toggleText')
                    const toggleIcon = $('#toggleIcon')

                    if (formContainer.is(':visible')) {
                        formContainer.hide(200)
                        toggleText.text('Tambah')
                        toggleIcon.removeClass('bi bi-chevron-compact-down')
                        toggleIcon.addClass('bi bi-chevron-compact-right')
                    } else {
                        formContainer.show(200)
                        toggleText.text('Sembunyikan')
                        toggleIcon.removeClass('bi bi-chevron-compact-right')
                        toggleIcon.addClass('bi bi-chevron-compact-down')
                    }
                })

                const formDokumen = document.getElementById('formDokumen')
                formDokumen.addEventListener('submit', (event) => {
                    event.preventDefault()

                    //Data for sending to server  
                    var formData = new FormData($('#formDokumen')[0])
                    let totalUploaded = $('#files')[0].files.length
                    let fileName = JSON.parse($('#files').attr('data-filenames'))
                    for (let i = 0; i < fileName.length; i++) {
                        formData.append(`filenames[]`, fileName[i])
                    }
                    formData.append('totalUploaded', totalUploaded)
                    $.ajax({
                        url: "{{ route('dokumens.store') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: () => {
                            //Clear error message
                            $('.invalid-feedback').remove()
                            $('.is-invalid').removeClass('is-invalid')
                        },
                        success: (response) => {
                            if (response.success) {
                                $('#files').removeAttr('data-filenames')
                                $('#formDokumen')[0].reset()

                                refreshData(datatable)
                                toast(undefined, undefined, response.success)
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                if (key.includes('files') || key.includes('filenames')) {
                                    key = 'files'
                                }
                                $('#' + key).addClass('is-invalid').after(
                                    '<span class="invalid-feedback">' + value[0] +
                                    '</span>');
                            });
                            toast("#dc3545", "Failed", "Gagal menambahkan dokumen")
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
                            $('#files').val('').removeAttr('data-filenames')
                            alert('Nama file harus diisi')
                            return
                        }
                        filenames.push(name)
                    }

                    // Simpan nama-nama file yang diberikan dalam atribut data
                    this.setAttribute('data-filenames', JSON.stringify(filenames))

                    if ($(this)[0].files.length === 0) {
                        $(this).removeAttr('data-filenames')
                    }
                })

                $('#datatable').on('click', '#btnShow', function() {
                    const dataId = $('#btnShow').data('id')
                    formData = new FormData()
                    formData.append('id', dataId)
                    $.ajax({
                        url: "{{ route('dokumens.getDocumentById') }}",
                        type: "POST",
                        data: formData,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: () => {
                            //Clear data
                            $('.modal-data').empty()
                            $(this).attr('disabled', true).html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                            )
                        },
                        success: (response) => {
                            $(this).removeAttr('disabled').text('Lihat')
                            var myModal = new bootstrap.Modal($('#detailDokumen'), {})
                            $('#dataJudul').text(response.data.judul)
                            $('#dataAbstrak').text(response.data.abstrak)
                            $('#dataPenulis').text(response.data.penulis)
                            $('#dataPembimbing').text(response.data.pembimbing)
                            $('#dataPenguji').text(response.data.penguji)
                            $('#dataJenis').text(response.data.jenis.nama_jenis)
                            $('#dataTahun').text(response.data.tahun)
                            $('#dataKeyword').text(response.data.keyword)
                            $('#dataUploader').text(response.data.user.nama)
                            $.each(response.data.file, (key, val) => {
                                var elmLi = $('<li>')
                                let url =
                                    "{{ route('file.get', ['filename' => ':data']) }}"
                                let bindUrl = url.replace(':data', val)
                                var elmA = $('<a>').attr('href', bindUrl).attr('target',
                                    '_blank').text(val)

                                elmLi.append(elmA)
                                $('#dataFile').append(elmLi)
                            })
                            myModal.show()
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            toast("#dc3545", "Failed", errors)
                        }

                    })
                })

                $('#refreshData').click(async () => {
                    $('#refreshData').attr('disabled', true)
                    await refreshData(datatable)
                    $('#refreshData').attr('disabled', false)
                })

                function toast(color = "#198754", type = "Success", message = "Berhasil menambahkan data jenis") {
                    $("#toastRect").attr("fill", color)
                    $("#toastType").text(type)
                    $("#toastMessage").text(message)
                    const toastContainer = $("#liveToast")
                    const toast = new bootstrap.Toast(toastContainer)
                    toast.show()
                }

                async function refreshData(table) {
                    await new Promise((resolve) => {
                        table.ajax.reload(resolve)
                    })
                }
            });
        </script>
    @endpush
</x-app-layout>
