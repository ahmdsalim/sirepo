<x-app-layout title="Kelola Jenis">
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
                <form class="form">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" class="form-control" placeholder="Email pengguna" name="email">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" id="username" class="form-control" placeholder="Username" name="username">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="password" class="form-label">Password</label>
                                <input type="text" id="password" class="form-control" name="password" placeholder="Password">
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mandatory">
                                <label for="role" class="form-label">Role</label>
                                <select class="choices form-select" name="role" required>
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
                <h5 class="card-title">
                    Data Pengguna
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
        @vite(['resources/assets/compiled/css/table-datatable-jquery.css','resources/assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css','resources/assets/extensions/choices.js/public/assets/styles/choices.css'])
    @endpush

    @push('scripts')
        <script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>
        <script src="{{asset('assets/extensions/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>
        <script src="{{asset('assets/extensions/choices.js/public/assets/scripts/choices.js')}}"></script>
        <script src="{{asset('assets/static/js/pages/form-element-select.js')}}"></script>
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
                        type: "POST",
                        data: function (data) {
                            data.search = $('input[type="search"]').val();
                        }
                    },
                    order: ['1', 'DESC'],
                    pageLength: 10,
                    searching: true,
                    aoColumns: [
                        {
                            data: 'username',
                        },
                        {
                            data: 'nama',
                        },
                        {
                            data: 'email',
                        },
                        {
                            data: 'role',
                        },
                        {
                            data: 'username',
                            width: "20%",
                            orderable: false,
                            render: function(data, type, row) {
                                const editUrl = `{{ route('users.edit',['user' => ':data']) }}`
                                const bindEditUrl = editUrl.replace(':data', data)
                                return `<a class="btn btn-primary btn-sm" href="${bindEditUrl}">Edit</a>
                                    <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="${data}" id="btnDelete">
                                        Hapus
                                    </button>`;
                            }
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

                // const formJenis = document.getElementById('formJenis')
                // formJenis.addEventListener("submit", (event) => {
                //     let namajenis = $('#namajenis')
                //     event.preventDefault()
                //     let data = {
                //         nama_jenis: namajenis.val()
                //     }
                //     $.ajax({
                //         url: "{{ route('jenis.store') }}",
                //         type: "POST",
                //         data: JSON.stringify(data),
                //         dataType: "JSON",
                //         proccessData: false,
                //         contentType: "application/json",
                //         success: (response) => {
                //             if(response.errors) {
                //                 var errorMsg = ''
                //                 $.each(response.errors, (field, errors) => {
                //                     $.each(errors, (index, error) => {
                //                         errorMsg += error + '<br>'
                //                     })
                //                 })
                //                 toast("#dc3545","Failed",errorMsg)
                //             }else{
                //                 refreshData(datatable)
                //                 toast()
                //             }
                //         },
                //         error: function(xhr, status, error) {
                //             toast("#dc3545","Failed",error)
                //         }

                //     })
                //     namajenis.val('')
                // })

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
                            const url = "{{ route('jenis.destroy', ['id'=>':data']) }}"
                            const bindUrl = url.replace(':data', dataId)
                            $.ajax({
                                url: bindUrl,
                                type: "DELETE",
                                data: JSON.stringify(data),
                                dataType: "JSON",
                                proccessData: false,
                                contentType: "application/json",
                                success: (response) => {
                                    if(response.errors){
                                        var errorMsg = response.errors
                                        toast("#dc3545","Failed",errorMsg)
                                    }else{
                                        refreshData(datatable)
                                        toast(undefined,undefined,response.success)
                                    }
                                },
                                error: function(xhr, status, error) {
                                    toast("#dc3545","Failed",error)
                                }
                            })
                        }
                    })
                });

                const toggleContainer = document.getElementById('toggleContainer')
                $('#toggleContainer').click(function() {
                    console.log('ibasdisad')
                    const formContainer = $('#formContainer')
                    const toggleText = $('#toggleText')
                    const toggleIcon = $('#toggleIcon')

                    if (formContainer.is(':visible')) {
                        formContainer.hide()
                        toggleText.text('Tambah')
                        toggleIcon.removeClass('bi bi-chevron-compact-down')
                        toggleIcon.addClass('bi bi-chevron-compact-right')
                    } else {
                        formContainer.show()
                        toggleText.text('Sembunyikan')
                        toggleIcon.removeClass('bi bi-chevron-compact-right')
                        toggleIcon.addClass('bi bi-chevron-compact-down')
                    }
                })
                
                function toast(color = "#198754", type = "Success", message = "Berhasil menambahkan data jenis") {
                    $("#toastRect").attr("fill",color)
                    $("#toastType").text(type)
                    $("#toastMessage").text(message) 
                    const toastContainer = $("#liveToast")
                    const toast = new bootstrap.Toast(toastContainer)
                    toast.show()
                }

                function refreshData(table) {
                    table.ajax.reload()
                }
            });

        </script>
    @endpush
</x-app-layout>