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
                <form class="form" id="formDokumen">
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
                                    <textarea class="form-control" name="abstrak" id="abstrak" rows="4" placeholder="Abstrak minimal 100 karakter"
                                        style="resize: none;" required></textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="keyword" class="form-label">Keyword</label>
                                    <input type="text" id="keyword" class="form-control"
                                        placeholder="Laravel, Prototyping, BPMN.." name="keyword" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="col-12">
                                <div class="form-group mandatory">
                                    <label for="penulis" class="form-label">Penulis</label>
                                    <input type="text" id="penulis" class="form-control"
                                        placeholder="Penulis, Pembimbing 1, Pembimbing 2/Penguji" name="penulis"
                                        required>
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
                            <div class="col-12">
                                <div class="mb-3 mandtory">
                                    <label for="file" class="form-label">File <span class="text-danger">*</span>
                                    </label>
                                    <input class="form-control" type="file" id="file" accept=".pdf" required>
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
                                <th>File</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                    </table>
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
                let url;
                let userRole = "{{ auth()->user()->role }}";

                if (userRole === 'admin') {
                    url = "{{ route('dokumens.getDocByUName') }}";
                } else {
                    url = "{{ route('dokumens.getAllDoc') }}";
                }

                let datatable = $('#datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: url,
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
                            data: 'nama_jenis',
                            name: 'nama_jenis',
                        },
                        {
                            data: 'file',
                            name: 'file',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
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
                                    if (response.errors) {
                                        var errorMsg = response.errors
                                        toast("#dc3545", "Failed", errorMsg)
                                    } else {
                                        refreshData(datatable)
                                        toast(undefined, undefined, response.success)
                                    }
                                },
                                error: function(xhr, status, error) {
                                    toast("#dc3545", "Failed", error)
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
                    //Clear error message
                    $('.invalid-feedback').remove()
                    $('.is-invalid').removeClass('is-invalid')
                    //Prepare input element
                    let judul = $('#judul'),
                        abstrak = $('#abstrak'),
                        keyword = $('#keyword'),
                        penulis = $('#penulis'),
                        tahun = $('#tahun'),
                        jenis = $('#jenis'),
                        file = $('#file')
                    //Data for sending to server  
                    var formData = new FormData()
                    formData.append('judul', judul.val())
                    formData.append('abstrak', abstrak.val())
                    formData.append('keyword', keyword.val())
                    formData.append('penulis', penulis.val())
                    formData.append('tahun', tahun.val())
                    formData.append('jenis', jenis.val())
                    formData.append('file', file[0].files[0])

                    $.ajax({
                        url: "{{ route('dokumens.store') }}",
                        type: "POST",
                        data: formData,
                        cache: false,
                        processData: false,
                        contentType: false,
                        success: (response) => {
                            if (response.success) {
                                //Clear input value
                                judul.val('')
                                abstrak.val('')
                                keyword.val('')
                                penulis.val('')
                                tahun.val('')
                                jenis.val('')
                                file.val('')

                                refreshData(datatable)
                                toast(undefined, undefined, response.success)
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;

                            if (errors.hasOwnProperty('judul')) {
                                judul.addClass('is-invalid')
                                judul.after(
                                    `<span class="invalid-feedback" role="alert">${errors.judul[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('abstrak')) {
                                abstrak.addClass('is-invalid')
                                abstrak.after(
                                    `<span class="invalid-feedback" role="alert">${errors.abstrak[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('keyword')) {
                                keyword.addClass('is-invalid')
                                keyword.after(
                                    `<span class="invalid-feedback" role="alert">${errors.keyword[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('penulis')) {
                                penulis.addClass('is-invalid')
                                penulis.after(
                                    `<span class="invalid-feedback" role="alert">${errors.penulis[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('jenis')) {
                                jenis.addClass('is-invalid')
                                jenis.after(
                                    `<span class="invalid-feedback" role="alert">${errors.jenis[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('file')) {
                                file.addClass('is-invalid')
                                file.after(
                                    `<span class="invalid-feedback" role="alert">${errors.file[0]}</span>`
                                )
                            }
                            toast("#dc3545", "Failed", "Gagal menambahkan dokumen")
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
