<x-app-layout title="Dokumen|REPMI">
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
            <div class="card-body">
                <form class="row" id="formDokumen">
                    <div class="col-md-5 col-sm-12">
                        <div class="input-group" id="jenisGroup">
                            <input class="form-control" type="text" name="nama_jenis" required="true" id="namajenis"
                                placeholder="Jenis dokumen">
                            <button class="btn btn-primary" type="submit">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h5 class="card-title d-flex align-items-center">
                    Data Jenis
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
                    Berhasil menambahkan data jenis.
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
                        url: "{{ route('dokumens.getDocByUName') }}",
                        type: "POST",
                        data: function(data) {
                            data.search = $('input[type="search"]').val();
                        }
                    },
                    order: ['1', 'DESC'],
                    pageLength: 10,
                    searching: true,
                    aoColumns: [{
                            data: 'judul',
                        },
                        {
                            data: 'penulis',
                        },
                        {
                            data: 'tahun',
                        },
                        {
                            data: 'nama_jenis',
                        },
                        {
                            data: 'id',
                            orderable: false,
                            width: "20%",
                            render: function(data, type, row) {
                                const editUrl = `{{ route('dokumens.edit', ['id' => ':data']) }}`;
                                const showUrl = `{{ route('dokumens.show', ['id' => ':data']) }}`;
                                const bindEditUrl = editUrl.replace(':data', data);
                                const bindShowUrl = showUrl.replace(':data', data);

                                return `<a class="btn btn-primary btn-sm" href="${bindEditUrl}">Edit</a> 
            <button type="button" class="btn btn-danger text-white btn-sm delete-button" data-id="${data}" id="btnDelete">
                Hapus
            </button>
            <a class="btn btn-secondary btn-sm" href="${bindShowUrl}">Detail</a>`;
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

                const formDokumen = document.getElementById('formDokumen')
                formDokumen.addEventListener("submit", (event) => {
                    event.preventDefault()
                    //Clear error message
                    $('.invalid-feedback').remove()
                    $('.is-invalid').removeClass('is-invalid')

                    let namajenis = $('#namajenis')
                    let data = {
                        nama_jenis: namajenis.val()
                    }
                    $.ajax({
                        url: "{{ route('dokumens.store') }}",
                        type: "POST",
                        data: JSON.stringify(data),
                        dataType: "JSON",
                        proccessData: false,
                        contentType: "application/json",
                        success: (response) => {
                            namajenis.val('')
                            refreshData(datatable)
                            toast()
                        },
                        error: function(xhr, status, error) {
                            var errors = xhr.responseJSON.errors
                            if (errors.hasOwnProperty('nama_jenis')) {
                                namajenis.addClass('is-invalid')
                                $('#jenisGroup').append(
                                    `<span class="invalid-feedback" role="alert">${errors.nama_jenis[0]}</span>`
                                )
                            }
                            toast("#dc3545", "Failed", "Gagal menambahkan data")
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
