@push('styles')
    <style>
        .field-icon {
            float: right;
            margin-left: -30px;
            margin-right: 10px;
            margin-top: -27px;
            cursor: pointer;
            position: relative;
            z-index: 2;
        }

        html[data-bs-theme=dark] .select2-results__options {
            padding-left: 0 !important;
        }

        html[data-bs-theme=dark] .select2-search__field {
            background: white;
            color: #000;
        }
    </style>
@endpush
<x-app-layout title="Kelola Pengguna">
    <x-slot name="header">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3>Kelola Pengguna</h3>
                <p class="text-subtitle text-muted">Pengguna</p>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none"
                                href="home">Dashboard</a></li>
                        <li class="breadcrumb-item  active" aria-current="page"><a href="">Pengguna</a></li>
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
                <form class="form" id="formUser">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="role" class="form-label">Role <span id="roleState"
                                        class="mt-1"></span></label>
                                <select id="role" class="select2" name="role" required>
                                    <option value="">Pilih</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12 d-none" id="containerMhs">
                            <div class="form-group mandatory">
                                <label for="mahasiswa" class="form-label">Sinkronisasi Data Mahasiswa</label>
                                <select id="mahasiswa" class="select2" name="mahasiswa">
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12" id="containerNama">
                            <div class="form-group mandatory">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" id="nama" class="form-control" placeholder="Nama pengguna"
                                    name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12" id="containerEmail">
                            <div class="form-group mandatory">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" placeholder="Email pengguna"
                                    name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12" id="containerProdi">
                            <div class="form-group mandatory">
                                <label for="prodi" class="form-label">Prodi</label>
                                <select id="prodi" class="form-select" name="prodi" required>
                                    <option value="">Pilih</option>
                                    @foreach ($prodis as $prodi)
                                        <option value="{{ $prodi->kode_prodi }}">{{ $prodi->nama_prodi }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 col-12" id="containerUsername">
                            <div class="form-group mandatory">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" class="form-control" placeholder="Username"
                                    name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password"
                                    placeholder="Password" required>
                                <span toggle="#password"
                                    class="fa fa-fw fa-eye-slash field-icon toggle-password"></span>
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
                    Data Pengguna
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
                                <th>Username</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Prodi</th>
                                <th>Role</th>
                                <th>Dibuat pada</th>
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
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @endpush

    @push('scripts')
        <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js') }}"></script>
        <script>
            $(".toggle-password").click(function() {

                $(this).toggleClass("fa-eye fa-eye-slash");
                var input = $($(this).attr("toggle"));
                if (input.attr("type") == "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
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
                        url: "{{ route('users.getUsers') }}",
                        type: "POST"
                    },
                    order: ['1', 'DESC'],
                    pageLength: 10,
                    searching: true,
                    columns: [{
                            data: 'username',
                            name: 'username',
                        },
                        {
                            data: 'nama',
                            name: 'nama',
                        },
                        {
                            data: 'email',
                            name: 'email',
                        },
                        {
                            data: 'kode_prodi',
                            name: 'kode_prodi',
                            render: function(data, type, row) {
                                var show = '<span class="small text-muted">Null</span>'
                                if (row.role == 'admin' || row.role == 'super' && data) {
                                    show = data
                                } else if (row.role == 'user') {
                                    show = row.mahasiswa.kode_prodi
                                }
                                return show
                            }
                        },
                        {
                            data: 'role',
                            name: 'role',
                            render: function(data, type, row) {
                                return `<span class="badge bg-success">${data}</span>`
                            }
                        },
                        {
                            data: 'created_at',
                            name: 'created_at',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            width: "25%",
                            orderable: false,
                            searchable: false,
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
                    $.ajax({
                        url: "{{ route('users.store') }}",
                        type: "POST",
                        data: new FormData($('#formUser')[0]),
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
                                $('#formUser')[0].reset()
                                $('#role').val('').trigger('change')
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
                            const url = "{{ route('users.destroy', ['user' => ':data']) }}"
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

                $('.select2').select2({
                    width: '100%'
                });

                $('#role').on('change', (event) => {
                    let role = event.target.value
                    if (role === 'user') {
                        $('#containerEmail').addClass('d-none')
                        $('#email').removeAttr('required').val('').attr('disabled', true)
                        $('#containerUsername').addClass('d-none')
                        $('#username').removeAttr('required').val('').attr('disabled', true)
                        $('#containerNama').addClass('d-none')
                        $('#nama').removeAttr('required').val('').attr('disabled', true)
                        $('#containerProdi').addClass('d-none')
                        $('#prodi').removeAttr('required').val('').attr('disabled', true)
                        $.ajax({
                            url: "{{ route('getUnsyncMhs') }}",
                            type: 'GET',
                            dataType: 'json',
                            beforeSend: () => {
                                $('#roleState').html(
                                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>'
                                )
                            },
                            success: function(response) {
                                var data = response.data
                                var firstOpt = $('<option>')
                                firstOpt.val('')
                                firstOptText = data.length > 0 ? 'Pilih' : 'Data tidak ditemukan'
                                firstOpt.text(firstOptText)
                                $('#mahasiswa').append(firstOpt)
                                if (data.length > 0) {
                                    data.forEach(function(item) {
                                        var elmOption = $('<option>')
                                        elmOption.val(item.npm).text(
                                            `${item.npm} - ${item.nama_mahasiswa}`)
                                        $('#mahasiswa').append(elmOption)
                                    })
                                }
                                $('#mahasiswa').attr('required', true)
                                $('#containerMhs').removeClass('d-none')
                            },
                            error: function(xhr, status, error) {
                                var errors = xhr.responseJSON.errors;
                                toast("#dc3545", "Failed", errors)
                                $('#role').val('')
                            },
                            complete: () => {
                                $('#roleState').empty()
                            }
                        })

                    } else {
                        $('#mahasiswa').removeAttr('required').empty()
                        $('#containerEmail').removeClass('d-none')
                        $('#email').attr('required', true).val('').removeAttr('disabled')
                        $('#containerUsername').removeClass('d-none')
                        $('#username').attr('required', true).val('').removeAttr('disabled')
                        $('#containerNama').removeClass('d-none')
                        $('#nama').attr('required', true).val('').removeAttr('disabled')
                        $('#containerProdi').removeClass('d-none')
                        $('#prodi').attr('required', true).val('').removeAttr('disabled')
                        $('#containerMhs').addClass('d-none')
                    }
                })

                $('#datatable').on('click', '.activate-button', function() {
                    Swal.fire({
                        title: 'Yakin ingin mengupdate status?',
                        text: "Data pengguna yang dipilih akan diupdate",
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#233446',
                        cancelButtonColor: '#8592a3',
                        confirmButtonText: 'Update',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.value) {
                            const dataId = $(this).data('id')
                            const data = {
                                id: dataId
                            }
                            var btn = $(this)
                            var prevText = btn.text()
                            $.ajax({
                                url: "{{ route('updateUserActiveStatus') }}",
                                type: "PUT",
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
                                    if (response.updatedstatus) {
                                        btn.removeClass('btn-success').addClass(
                                            'btn-secondary').text('Nonaktifkan')
                                    } else {
                                        btn.removeClass('btn-secondary').addClass(
                                            'btn-success').text('Aktifkan')
                                    }
                                    toast(undefined, undefined, response.success)
                                },
                                error: function(xhr, status, errors) {
                                    var errors = xhr.responseJSON.errors;
                                    btn.removeAttr('disabled').text(prevText)
                                    toast("#dc3545", "Failed", errors)
                                }
                            })
                        }
                    })
                });

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
