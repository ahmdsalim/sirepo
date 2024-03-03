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
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none"
                                href="home">Dashboard</a></li>
                        <li class="breadcrumb-item" aria-current="page">Mahasiswa</li>
                    </ol>
                </nav>
            </div>
        </div>
    </x-slot>

    <section class="section">
        <div class="card mb-1 ">
            <div class="card-header">
                <div class="d-inline-block user-select-none" id="toggleContainerImportCSV" style="cursor: pointer;">
                    <span id="toggleTextImportCSV">Import Excel</span>
                    <i class="bi bi-chevron-compact-right" id="toggleIconImportCSV"></i>
                </div>
            </div>
            <div class="card-body" id="formContainerImportCSV" style="display: none;">
                <form id="importForm" action="{{route('mahasiswas.import')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-2">
                        <input class="form-control mb-2" type="file" id="fileInput" required name="file" accept=".xlsx">
                        <small>Belum punya template mahasiswa? <a href="#">Download</a></small>
                    </div>
                    <div class="col-12 d-flex justify-content-end ">
                        <button type="sumbit" class="btn btn-primary">Import</button>
                    </div>

                </form>
            </div>

        </div>

        <div class="card">
            <div class="card-header">
                <div class="d-inline-block user-select-none" id="toggleContainer" style="cursor: pointer;">
                    <span id="toggleText">Tambah</span>
                    <i class="bi bi-chevron-compact-right" id="toggleIcon"></i>
                </div>
            </div>
            <div class="card-body" id="formContainer" style="display: none;">
                <form class="form" id="formUser">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="npm" class="form-label">NPM</label>
                                <input type="text" id="npm" class="form-control" placeholder="Npm mahasiswa"
                                    name="npm" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="nama_mahasiswa" class="form-label">Nama</label>
                                <input type="text" id="nama_mahasiswa" class="form-control"
                                    placeholder="Nama mahasiswa" name="nama_mahasiswa" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" placeholder="Email pengguna"
                                    name="email" required>
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
                    Data Mahasiswa
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
                                <th>NPM</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Status</th>
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
                    Berhasil menambahkan data mahasiswa.
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
                        url: "{{ route('mahasiswas.getMahasiswa') }}",
                        type: "POST"
                    },
                    order: ['1', 'DESC'],
                    pageLength: 10,
                    searching: true,
                    dom: '<"row"<"col-md-6 col-sm-6"l><"col-md-6 col-sm-6"fB>>' + // Customize the layout
                        '<"row"<"col-md-12"tr>>' +
                        '<"row"<"col-md-5 col-sm-5"i><"col-md-7 col-sm-7"p>>',
                    columns: [{
                            data: 'npm',
                            name: 'npm',
                        },
                        {
                            data: 'nama_mahasiswa',
                            name: 'nama_mahasiswa',
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'is_active',
                            name: 'is_active',
                            render: function(data, type, row) {
                                if (row.is_active === 1) {
                                    return '<span class="badge bg-success">Aktif</span>';
                                } else {
                                    return '<span class="badge bg-danger">Non-Aktif</span>';
                                }
                            },
                        },
                        {
                            data: 'action',
                            name: 'action',
                            width: "20%",
                            orderable: false,
                        }
                    ],
                    order: [
                        [0, "asc"]
                    ]
                });

                const setTableColor = () => {
                    document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                        dt.classList.add('pagination-primary')
                    })
                }
                setTableColor()
                datatable.on('draw', setTableColor)

                const formUser = document.getElementById('formUser')
                formUser.addEventListener("submit", (event) => {
                    event.preventDefault()
                    //Prepare input element
                    let npm = $('#npm'),
                        nama_mahasiswa = $('#nama_mahasiswa'),
                        email = $('#email')

                    //Data for sending to server    
                    let data = {
                        npm: npm.val(),
                        nama_mahasiswa: nama_mahasiswa.val(),
                        email: email.val(),
                    }
                    $.ajax({
                        url: "{{ route('mahasiswas.store') }}",
                        type: "POST",
                        data: JSON.stringify(data),
                        dataType: "JSON",
                        proccessData: false,
                        contentType: "application/json",
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
                                npm.val('')
                                nama_mahasiswa.val('')
                                email.val('')
                                $('#btnSubmit').removeAttr('disabled').text('Submit')
                                refreshData(datatable)
                                toast(undefined, undefined, response.success)
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;
                            $('#btnSubmit').removeAttr('disabled').text('Submit')
                            if (errors.hasOwnProperty('npm')) {
                                npm.addClass('is-invalid')
                                npm.after(
                                    `<span class="invalid-feedback" role="alert">${errors.npm[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('nama_mahasiswa')) {
                                nama_mahasiswa.addClass('is-invalid')
                                nama_mahasiswa.after(
                                    `<span class="invalid-feedback" role="alert">${errors.nama_mahasiswa[0]}</span>`
                                )
                            }
                            if (errors.hasOwnProperty('email')) {
                                email.addClass('is-invalid')
                                email.after(
                                    `<span class="invalid-feedback" role="alert">${errors.email[0]}</span>`
                                )
                            }

                            toast("#dc3545", "Failed", "Gagal menambahkan pengguna")
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
                            const data = {
                                id: dataId
                            }
                            const url = "{{ route('mahasiswas.destroy', ['mahasiswa' => ':data']) }}"
                            const bindUrl = url.replace(':data', dataId)
                            var btn = $(this)
                            $.ajax({
                                url: bindUrl,
                                type: "DELETE",
                                data: JSON.stringify(data),
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

                const toggleContainerImportCSV = document.getElementById('toggleContainerImportCSV')
                $('#toggleContainerImportCSV').click(function() {
                    const formContainerImportCSV = $('#formContainerImportCSV')
                    const toggleText = $('#toggleText')
                    const toggleIcon = $('#toggleIcon')

                    if (formContainerImportCSV.is(':visible')) {
                        formContainerImportCSV.hide(200)
                        toggleText.text('Tambah')
                        toggleIcon.removeClass('bi bi-chevron-compact-down')
                        toggleIcon.addClass('bi bi-chevron-compact-right')
                    } else {
                        formContainerImportCSV.show(200)
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

                function toast(color = "#198754", type = "Success", message = "Berhasil menambahkan data mahasiswa") {
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