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
                        <li class="breadcrumb-item text-decoration-none"><a class="text-decoration-none" href="home">Dashboard</a></li>
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
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" id="nama" class="form-control" placeholder="Nama pengguna" name="nama" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" placeholder="Email pengguna" name="email" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" class="form-control" placeholder="Username" name="username" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" id="password" class="form-control" name="password" placeholder="Password" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="role" class="form-label">Role</label>
                                <select id="role" class="form-select" name="role" required>
                                    <option value="">Pilih</option>
                                    <option value="super">Super</option>
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
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
                                <th>Role</th>
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
                    <svg class="bd-placeholder-img rounded me-2" width="20" height="20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false"><rect width="100%" height="100%" fill="#198754" id="toastRect"></rect></svg>
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
        @vite(['resources/assets/compiled/css/table-datatable-jquery.css','resources/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css'])
    @endpush

    @push('scripts')
        <script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
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
                    columns: [
                        {
                            data: 'username', name: 'username',
                        },
                        {
                            data: 'nama', name: 'nama',
                        },
                        {
                            data: 'email', name: 'email',
                        },
                        {
                            data: 'role', name: 'role',
                        },
                        {
                            data: 'action',
                            name: 'action',
                            width: "20%",
                            orderable: false,
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

                const formUser = document.getElementById('formUser')
                formUser.addEventListener("submit", (event) => {
                    event.preventDefault()
                    //Clear error message
                    $('.invalid-feedback').remove()
                    $('.is-invalid').removeClass('is-invalid')
                    //Prepare input element
                    let nama = $('#nama'),
                        email = $('#email'),
                        username = $('#username'),
                        password = $('#password'),
                        role = $('#role')
                    //Data for sending to server    
                    let data = {
                        nama: nama.val(),
                        email: email.val(),
                        username: username.val(),
                        password: password.val(),
                        role: role.val()
                    }
                    $.ajax({
                        url: "{{ route('users.store') }}",
                        type: "POST",
                        data: JSON.stringify(data),
                        dataType: "JSON",
                        proccessData: false,
                        contentType: "application/json",
                        success: (response) => {
                            if(response.success){
                                //Clear input value
                                nama.val('')
                                email.val('')
                                username.val('')
                                password.val('')
                                role.val('')

                                refreshData(datatable)
                                toast(undefined,undefined,response.success)
                            }
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors;

                            if (errors.hasOwnProperty('nama')) {
                                nama.addClass('is-invalid')
                                nama.after(`<span class="invalid-feedback" role="alert">${errors.nama[0]}</span>`)
                            }
                            if (errors.hasOwnProperty('email')) {
                                email.addClass('is-invalid')
                                email.after(`<span class="invalid-feedback" role="alert">${errors.email[0]}</span>`)
                            }
                            if (errors.hasOwnProperty('username')) {
                                username.addClass('is-invalid')
                                username.after(`<span class="invalid-feedback" role="alert">${errors.username[0]}</span>`)
                            }
                            if (errors.hasOwnProperty('password')) {
                                password.addClass('is-invalid')
                                password.after(`<span class="invalid-feedback" role="alert">${errors.password[0]}</span>`)
                            }
                            if (errors.hasOwnProperty('role')) {
                                role.addClass('is-invalid')
                                role.after(`<span class="invalid-feedback" role="alert">${errors.role[0]}</span>`)
                            }
                            toast("#dc3545","Failed","Gagal menambahkan pengguna")
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
                            const url = "{{ route('users.destroy', ['user'=>':data']) }}"
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
                                        toast(undefined,undefined,response.success)
                                },
                                error: function(xhr, status, error) {
                                    const errors = `${status} : ${error}`
                                    toast("#dc3545","Failed",errors)
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
                    $('#refreshData').attr('disabled',true)
                    await refreshData(datatable)
                    $('#refreshData').attr('disabled',false)
                })
                
                function toast(color = "#198754", type = "Success", message = "Berhasil menambahkan data jenis") {
                    $("#toastRect").attr("fill",color)
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