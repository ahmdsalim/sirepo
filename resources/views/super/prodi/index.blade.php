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
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none"
                                href="home">Dashboard</a></li>
                        <li class="breadcrumb-item  active" aria-current="page"><a href="">Prodi</a></li>
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
                <form class="form" id="formProdi">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="kode_prodi" class="form-label">Kode Prodi</label>
                                <input type="text" id="kode_prodi" class="form-control"
                                    placeholder="Masukkan kombinasi huruf dan angka" name="kode_prodi" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="nama_prodi" class="form-label">Nama Prodi</label>
                                <input type="text" id="nama_prodi" class="form-control"
                                    placeholder="Masukkan nama prodi" name="nama_prodi" required>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1" id="btnSubmit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title d-flex align-items-center">
                    Data Prodi
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
                                <th>Kode Prodi</th>
                                <th>Nama Prodi</th>
                                <th>Aksi</th>
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
                    Berhasil menambahkan data user.
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
                        url: "{{ route('prodi.getProdi') }}",
                        type: "POST"
                    },
                    order: ['1', 'DESC'],
                    pageLength: 10,
                    searching: true,
                    columns: [{
                            data: 'kode_prodi',
                            name: 'kode_prodi',
                        },
                        {
                            data: 'nama_prodi',
                            name: 'nama_prodi',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            width: "20%",
                            orderable: false,
                            searchable: false,
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

                const formProdi = document.getElementById('formProdi')
                formProdi.addEventListener("submit", (event) => {
                    event.preventDefault()
                    $.ajax({
                        url: "{{ route('prodi.store') }}",
                        type: "POST",
                        data: new FormData($('#formProdi')[0]),
                        dataType: "JSON",
                        processData: false,
                        contentType: false,
                        beforeSend: () => {
                            //Clear error message
                            $('.invalid-feedback').remove()
                            $('.is-invalid').removeClass('is-invalid')
                            $('#btnSubmit').attr('disabled', true).html(
                                '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                            )
                        },
                        success: (response) => {
                            if (response.success) {
                                //Clear input value
                                $('#formProdi')[0].reset()
                                $('#btnSubmit').removeAttr('disabled').text('Submit')
                                refreshData(datatable)
                                toast(undefined, undefined, response.success)
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            $('#btnSubmit').removeAttr('disabled').text('Submit')
                            $.each(errors, function(key, value) {
                                $('#' + key).addClass('is-invalid').after(
                                    '<span class="invalid-feedback">' + value[0] +
                                    '</span>');
                            });
                            toast("#dc3545", "Failed", "Gagal menambahkan prodi")
                        }

                    })
                })

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
                            const url = "{{ route('prodi.destroy', ['prodi' => ':data']) }}"
                            const bindUrl = url.replace(':data', dataId)
                            var btn = $(this)
                            $.ajax({
                                url: bindUrl,
                                type: "DELETE",
                                dataType: "JSON",
                                proccessData: false,
                                contentType: "application/json",
                                beforeSend: () => {
                                    btn.attr('disabled', true).html(
                                        '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                                    )
                                },
                                success: (response) => {
                                    refreshData(datatable)
                                    toast(undefined, undefined, response.success)
                                },
                                error: function(xhr, status, error) {
                                    var errors = xhr.responseJSON.errors;
                                    btn.removeAttr('disabled').text('Hapus')
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

                $('#refreshData').on('click', async () => {
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
